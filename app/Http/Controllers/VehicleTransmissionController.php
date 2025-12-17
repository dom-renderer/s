<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleTransmission;
use Illuminate\Support\Facades\DB;

class VehicleTransmissionController extends Controller
{
    protected $title = 'Vehicle Transmissions';
    protected $view = 'vehicle-transmissions.';

    public function __construct()
    {
        $this->middleware('permission:vehicle-transmissions.index')->only(['index', 'ajax']);
        $this->middleware('permission:vehicle-transmissions.create')->only(['create']);
        $this->middleware('permission:vehicle-transmissions.store')->only(['store']);
        $this->middleware('permission:vehicle-transmissions.edit')->only(['edit']);
        $this->middleware('permission:vehicle-transmissions.update')->only(['update']);
        $this->middleware('permission:vehicle-transmissions.show')->only(['show']);
        $this->middleware('permission:vehicle-transmissions.destroy')->only(['destroy']);
        // checkDuplicate doesn't need permission check as it's just for validation
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
        $subTitle = 'Manage vehicle transmissions here';

        $all = VehicleTransmission::count();
        $active = VehicleTransmission::active()->count();
        $inactive = VehicleTransmission::inactive()->count();

        return view($this->view . 'index', compact('title', 'subTitle', 'all', 'active', 'inactive'));
    }

    /**
     * return the json resource.
     */
    public function ajax()
    {
        $query = VehicleTransmission::query();

        // Apply filters
        if (request()->has('filter_status') && request()->filter_status != '') {
            $query->where('status', request()->filter_status);
        }

        if (request()->has('filter_name') && request()->filter_name != '') {
            $query->where('title', 'like', '%' . request()->filter_name . '%');
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('status', function ($row) {
                if ($row->status) {
                    return '<span class="badge badge-c2">Active</span>';
                } else {
                    return '<span class="badge badge-c4">Inactive</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $html = '';

                if (auth()->user()->can('vehicle-transmissions.edit')) {
                    $html .= '<a href="' . route('vehicle-transmissions.edit', encrypt($row->id)) . '" class="btn btn-sm btn-primary"> <i class="fa fa-edit"> </i> </a>&nbsp;';
                }

                if (auth()->user()->can('vehicle-transmissions.destroy')) {
                    $html .= '<button type="button" class="btn btn-sm btn-danger" id="deleteRow" data-row-route="' . route('vehicle-transmissions.destroy', $row->id) . '"> <i class="fa fa-trash"> </i> </button>&nbsp;';
                }

                if (auth()->user()->can('vehicle-transmissions.show')) {
                    $html .= '<a href="' . route('vehicle-transmissions.show', encrypt($row->id)) . '" class="btn btn-sm btn-secondary"> <i class="fa fa-eye"> </i> </a>';
                }

                return $html;
            })
            ->rawColumns(['status', 'action'])
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = $this->title;
        $subTitle = 'Add New Vehicle Transmission';

        return view($this->view . 'create', compact('title', 'subTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:vehicle_transmissions,title',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|boolean',
        ], [
            'title.required' => 'The title field is required.',
            'title.unique' => 'This vehicle transmission title already exists.',
            'status.required' => 'The status field is required.',
        ]);

        DB::beginTransaction();

        try {
            VehicleTransmission::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('vehicle-transmissions.index')->with('success', 'Vehicle transmission created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vehicle-transmissions.index')->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vehicleTransmission = VehicleTransmission::findOrFail(decrypt($id));
        $title = $this->title;
        $subTitle = 'View Vehicle Transmission';

        return view($this->view . 'view', compact('title', 'subTitle', 'vehicleTransmission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vehicleTransmission = VehicleTransmission::findOrFail(decrypt($id));
        $title = $this->title;
        $subTitle = 'Edit Vehicle Transmission';

        return view($this->view . 'edit', compact('title', 'subTitle', 'vehicleTransmission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vehicleTransmission = VehicleTransmission::findOrFail(decrypt($id));

        $request->validate([
            'title' => 'required|string|max:255|unique:vehicle_transmissions,title,' . $vehicleTransmission->id,
            'description' => 'nullable|string|max:1000',
            'status' => 'required|boolean',
        ], [
            'title.required' => 'The title field is required.',
            'title.unique' => 'This vehicle transmission title already exists.',
            'status.required' => 'The status field is required.',
        ]);

        DB::beginTransaction();

        try {
            $vehicleTransmission->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('vehicle-transmissions.index')->with('success', 'Vehicle transmission updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vehicle-transmissions.index')->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicleTransmission = VehicleTransmission::findOrFail($id);
        $vehicleTransmission->delete();
        return response()->json(['success' => 'Vehicle transmission deleted successfully.']);
    }

    /**
     * Check if title already exists
     */
    public function checkDuplicate(Request $request)
    {
        $title = $request->input('title');
        $id = $request->input('id');

        $query = VehicleTransmission::where('title', $title);
        
        if ($id) {
            $query->where('id', '!=', $id);
        }

        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }
}

