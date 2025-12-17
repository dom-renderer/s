<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Parish;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    protected $title = 'Locations';
    protected $view = 'locations.';

    public function __construct()
    {
        $this->middleware('permission:locations.index')->only(['index', 'ajax']);
        $this->middleware('permission:locations.create')->only(['create']);
        $this->middleware('permission:locations.store')->only(['store']);
        $this->middleware('permission:locations.edit')->only(['edit']);
        $this->middleware('permission:locations.update')->only(['update']);
        $this->middleware('permission:locations.show')->only(['show']);
        $this->middleware('permission:locations.destroy')->only(['destroy']);
        // checkDuplicate and getParishes don't need permission check as they're just for validation/select2
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return $this->ajax();
        }

        $title = $this->title;
        $subTitle = 'Manage locations here';

        $all = Location::count();
        $active = Location::count(); // You can add status field later if needed

        return view($this->view . 'index', compact('title', 'subTitle', 'all', 'active'));
    }

    /**
     * return the json resource.
     */
    public function ajax()
    {
        $query = Location::with('parish');

        // Apply filters
        if (request()->has('filter_name') && request()->filter_name != '') {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . request()->filter_name . '%')
                  ->orWhere('code', 'like', '%' . request()->filter_name . '%');
            });
        }

        if (request()->has('filter_parish') && request()->filter_parish != '') {
            $query->where('parish_id', request()->filter_parish);
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('parish_name', function ($row) {
                return $row->parish ? $row->parish->name : 'N/A';
            })
            ->addColumn('action', function ($row) {
                $html = '';

                if (auth()->user()->can('locations.edit')) {
                    $html .= '<a href="' . route('locations.edit', encrypt($row->id)) . '" class="btn btn-sm btn-primary"> <i class="fa fa-edit"> </i> </a>&nbsp;';
                }

                if (auth()->user()->can('locations.destroy')) {
                    $html .= '<button type="button" class="btn btn-sm btn-danger" id="deleteRow" data-row-route="' . route('locations.destroy', $row->id) . '"> <i class="fa fa-trash"> </i> </button>&nbsp;';
                }

                if (auth()->user()->can('locations.show')) {
                    $html .= '<a href="' . route('locations.show', encrypt($row->id)) . '" class="btn btn-sm btn-secondary"> <i class="fa fa-eye"> </i> </a>';
                }

                return $html;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = $this->title;
        $subTitle = 'Add New Location';
        $parishes = Parish::active()->pluck('name', 'id');

        return view($this->view . 'create', compact('title', 'subTitle', 'parishes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:locations,code',
            'title' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'parish_id' => 'nullable|exists:parishes,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ], [
            'code.required' => 'The code field is required.',
            'code.unique' => 'This location code already exists.',
            'title.required' => 'The title field is required.',
            'address_line_1.required' => 'The address line 1 field is required.',
            'parish_id.exists' => 'The selected parish is invalid.',
            'latitude.numeric' => 'The latitude must be a valid number.',
            'longitude.numeric' => 'The longitude must be a valid number.',
        ]);

        DB::beginTransaction();

        try {
            Location::create([
                'code' => $request->code,
                'title' => $request->title,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'parish_id' => $request->parish_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            DB::commit();
            return redirect()->route('locations.index')->with('success', 'Location created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('locations.index')->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $location = Location::with('parish')->findOrFail(decrypt($id));
        $title = $this->title;
        $subTitle = 'View Location';

        return view($this->view . 'view', compact('title', 'subTitle', 'location'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $location = Location::findOrFail(decrypt($id));
        $title = $this->title;
        $subTitle = 'Edit Location';
        $parishes = Parish::active()->pluck('name', 'id');

        return view($this->view . 'edit', compact('title', 'subTitle', 'location', 'parishes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $location = Location::findOrFail(decrypt($id));

        $request->validate([
            'code' => 'required|string|max:255|unique:locations,code,' . $location->id,
            'title' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'parish_id' => 'nullable|exists:parishes,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ], [
            'code.required' => 'The code field is required.',
            'code.unique' => 'This location code already exists.',
            'title.required' => 'The title field is required.',
            'address_line_1.required' => 'The address line 1 field is required.',
            'parish_id.exists' => 'The selected parish is invalid.',
            'latitude.numeric' => 'The latitude must be a valid number.',
            'longitude.numeric' => 'The longitude must be a valid number.',
        ]);

        DB::beginTransaction();

        try {
            $location->update([
                'code' => $request->code,
                'title' => $request->title,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'parish_id' => $request->parish_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            DB::commit();
            return redirect()->route('locations.index')->with('success', 'Location updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('locations.index')->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
        return response()->json(['success' => 'Location deleted successfully.']);
    }

    /**
     * Check if code already exists
     */
    public function checkDuplicate(Request $request)
    {
        $code = $request->input('code');
        $id = $request->input('id');

        $query = Location::where('code', $code);
        
        if ($id) {
            $query->where('id', '!=', $id);
        }

        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }

    /**
     * Get parishes list for select2
     */
    public function getParishes(Request $request)
    {
        $parishes = Parish::active()
            ->where('name', 'like', '%' . $request->term . '%')
            ->select('id', 'name as text')
            ->limit(20)
            ->get();

        return response()->json(['results' => $parishes]);
    }
}

