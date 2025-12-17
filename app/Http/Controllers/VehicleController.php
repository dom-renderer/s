<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\VehicleClass;
use App\Models\VehicleTransmission;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    protected $title = 'Vehicles';
    protected $view = 'vehicles.';

    public function __construct()
    {
        $this->middleware('permission:vehicles.index')->only(['index', 'ajax']);
        $this->middleware('permission:vehicles.create')->only(['create']);
        $this->middleware('permission:vehicles.store')->only(['store']);
        $this->middleware('permission:vehicles.edit')->only(['edit']);
        $this->middleware('permission:vehicles.update')->only(['update']);
        $this->middleware('permission:vehicles.show')->only(['show']);
        $this->middleware('permission:vehicles.destroy')->only(['destroy']);
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
        $subTitle = 'Manage vehicles here';

        $all = Vehicle::count();
        $active = Vehicle::active()->count();
        $inactive = Vehicle::inactive()->count();

        return view($this->view . 'index', compact('title', 'subTitle', 'all', 'active', 'inactive'));
    }

    /**
     * return the json resource.
     */
    public function ajax()
    {
        $query = Vehicle::with(['vehicleClass', 'transmission', 'primaryPickupLocation']);

        // Apply filters
        if (request()->has('filter_status') && request()->filter_status != '') {
            $query->where('status', request()->filter_status);
        }

        if (request()->has('filter_name') && request()->filter_name != '') {
            $query->where(function($q) {
                $q->where('vehicle_name', 'like', '%' . request()->filter_name . '%')
                  ->orWhere('make', 'like', '%' . request()->filter_name . '%')
                  ->orWhere('model', 'like', '%' . request()->filter_name . '%');
            });
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('vehicle_class', function ($row) {
                return $row->vehicleClass ? $row->vehicleClass->title : '-';
            })
            ->addColumn('transmission', function ($row) {
                return $row->transmission ? $row->transmission->title : '-';
            })
            ->addColumn('status', function ($row) {
                if ($row->status) {
                    return '<span class="badge badge-c2">Active</span>';
                } else {
                    return '<span class="badge badge-c4">Inactive</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $html = '';

                if (auth()->user()->can('vehicles.edit')) {
                    $html .= '<a href="' . route('vehicles.edit', encrypt($row->id)) . '" class="btn btn-sm btn-primary"> <i class="fa fa-edit"> </i> </a>&nbsp;';
                }

                if (auth()->user()->can('vehicles.destroy')) {
                    $html .= '<button type="button" class="btn btn-sm btn-danger" id="deleteRow" data-row-route="' . route('vehicles.destroy', $row->id) . '"> <i class="fa fa-trash"> </i> </button>&nbsp;';
                }

                if (auth()->user()->can('vehicles.show')) {
                    $html .= '<a href="' . route('vehicles.show', encrypt($row->id)) . '" class="btn btn-sm btn-secondary"> <i class="fa fa-eye"> </i> </a>';
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
        $subTitle = 'Add New Vehicle';
        $vehicleClasses = VehicleClass::active()->get();
        $transmissions = VehicleTransmission::active()->get();
        $locations = Location::all();

        // Get unique makes, years, fuel types, seats, doors from existing vehicles
        $makes = Vehicle::distinct()->whereNotNull('make')->pluck('make')->sort()->values();
        $years = range(date('Y'), 1900);
        $fuelTypes = Vehicle::distinct()->whereNotNull('fuel_type')->pluck('fuel_type')->sort()->values();
        $seats = Vehicle::distinct()->whereNotNull('seats')->pluck('seats')->sort()->values();
        $doors = Vehicle::distinct()->whereNotNull('doors')->pluck('doors')->sort()->values();

        return view($this->view . 'create', compact('title', 'subTitle', 'vehicleClasses', 'transmissions', 'locations', 'makes', 'years', 'fuelTypes', 'seats', 'doors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_name' => 'required|string|max:255',
            'make' => 'nullable|string|max:255',
            'make_new' => 'nullable|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'vehicle_class_id' => 'nullable|exists:vehicle_classes,id',
            'transmission_id' => 'nullable|exists:vehicle_transmissions,id',
            'fuel_type' => 'nullable|string|max:255',
            'fuel_type_new' => 'nullable|string|max:255',
            'seats' => 'nullable|integer|min:1',
            'doors' => 'nullable|integer|min:1',
            'passengers' => 'nullable|integer|min:1',
            'luggage_capacity' => 'nullable|string|max:255',
            'other' => 'nullable|string',
            'base_cost_per_day' => 'required|numeric|min:0',
            'vat_percentage' => 'required|numeric|min:0|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_pickup_location_id' => 'nullable|exists:locations,id',
            'alternate_pickup_location' => 'nullable|string|max:255',
        ], [
            'vehicle_name.required' => 'The vehicle name field is required.',
            'model.required' => 'The model field is required.',
            'year.required' => 'The year field is required.',
            'base_cost_per_day.required' => 'The base cost per day field is required.',
            'vat_percentage.required' => 'The VAT percentage field is required.',
        ]);

        // Validate that either make or make_new is provided
        if (empty($request->make) && empty($request->make_new)) {
            return redirect()->back()->withInput()->withErrors(['make' => 'The make field is required.']);
        }

        // Handle make (use make_new if make is empty)
        $make = $request->make ?: $request->make_new;

        // Check for duplicate vehicle
        $duplicate = Vehicle::where('vehicle_name', $request->vehicle_name)
            ->where('make', $make)
            ->where('model', $request->model)
            ->where('year', $request->year)
            ->exists();

        if ($duplicate) {
            return redirect()->back()->withInput()->with('error', 'A vehicle with the same name, make, model, and year already exists.');
        }

        DB::beginTransaction();

        try {
            $images = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('vehicles', 'public');
                    $images[] = $path;
                }
            }

            // Handle fuel_type (use fuel_type_new if fuel_type is empty)
            $fuelType = $request->fuel_type ?: $request->fuel_type_new;

            Vehicle::create([
                'vehicle_name' => $request->vehicle_name,
                'make' => $make,
                'model' => $request->model,
                'year' => $request->year,
                'vehicle_class_id' => $request->vehicle_class_id,
                'transmission_id' => $request->transmission_id,
                'fuel_type' => $request->fuel_type,
                'seats' => $request->seats,
                'doors' => $request->doors,
                'passengers' => $request->passengers,
                'luggage_capacity' => $request->luggage_capacity,
                'other' => $request->other,
                'base_cost_per_day' => $request->base_cost_per_day,
                'vat_percentage' => $request->vat_percentage,
                'images' => !empty($images) ? $images : null,
                'primary_pickup_location_id' => $request->primary_pickup_location_id,
                'alternate_pickup_location' => $request->alternate_pickup_location,
                'status' => $request->status ?? 1,
            ]);

            DB::commit();
            return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vehicles.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vehicle = Vehicle::with(['vehicleClass', 'transmission', 'primaryPickupLocation'])->findOrFail(decrypt($id));
        $title = $this->title;
        $subTitle = 'View Vehicle';

        return view($this->view . 'view', compact('title', 'subTitle', 'vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vehicle = Vehicle::findOrFail(decrypt($id));
        $title = $this->title;
        $subTitle = 'Edit Vehicle';
        $vehicleClasses = VehicleClass::active()->get();
        $transmissions = VehicleTransmission::active()->get();
        $locations = Location::all();

        // Get unique makes, years, fuel types, seats, doors from existing vehicles
        $makes = Vehicle::distinct()->whereNotNull('make')->pluck('make')->sort()->values();
        $years = range(date('Y'), 1900);
        $fuelTypes = Vehicle::distinct()->whereNotNull('fuel_type')->pluck('fuel_type')->sort()->values();
        $seats = Vehicle::distinct()->whereNotNull('seats')->pluck('seats')->sort()->values();
        $doors = Vehicle::distinct()->whereNotNull('doors')->pluck('doors')->sort()->values();

        return view($this->view . 'edit', compact('title', 'subTitle', 'vehicle', 'vehicleClasses', 'transmissions', 'locations', 'makes', 'years', 'fuelTypes', 'seats', 'doors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vehicle = Vehicle::findOrFail(decrypt($id));

        $request->validate([
            'vehicle_name' => 'required|string|max:255',
            'make' => 'nullable|string|max:255',
            'make_new' => 'nullable|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'vehicle_class_id' => 'nullable|exists:vehicle_classes,id',
            'transmission_id' => 'nullable|exists:vehicle_transmissions,id',
            'fuel_type' => 'nullable|string|max:255',
            'fuel_type_new' => 'nullable|string|max:255',
            'seats' => 'nullable|integer|min:1',
            'doors' => 'nullable|integer|min:1',
            'passengers' => 'nullable|integer|min:1',
            'luggage_capacity' => 'nullable|string|max:255',
            'other' => 'nullable|string',
            'base_cost_per_day' => 'required|numeric|min:0',
            'vat_percentage' => 'required|numeric|min:0|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_pickup_location_id' => 'nullable|exists:locations,id',
            'alternate_pickup_location' => 'nullable|string|max:255',
        ], [
            'vehicle_name.required' => 'The vehicle name field is required.',
            'model.required' => 'The model field is required.',
            'year.required' => 'The year field is required.',
            'base_cost_per_day.required' => 'The base cost per day field is required.',
            'vat_percentage.required' => 'The VAT percentage field is required.',
        ]);

        // Validate that either make or make_new is provided
        if (empty($request->make) && empty($request->make_new)) {
            return redirect()->back()->withInput()->withErrors(['make' => 'The make field is required.']);
        }

        // Handle make (use make_new if make is empty)
        $make = $request->make ?: $request->make_new;

        // Check for duplicate vehicle (excluding current vehicle)
        $duplicate = Vehicle::where('vehicle_name', $request->vehicle_name)
            ->where('make', $make)
            ->where('model', $request->model)
            ->where('year', $request->year)
            ->where('id', '!=', $vehicle->id)
            ->exists();

        if ($duplicate) {
            return redirect()->back()->withInput()->with('error', 'A vehicle with the same name, make, model, and year already exists.');
        }

        DB::beginTransaction();

        try {
            $images = $vehicle->images ?? [];
            
            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('vehicles', 'public');
                    $images[] = $path;
                }
            }

            // Handle image deletions
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $imagePath) {
                    if (Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                    }
                    $images = array_values(array_filter($images, function($img) use ($imagePath) {
                        return $img !== $imagePath;
                    }));
                }
            }

            // Handle fuel_type (use fuel_type_new if fuel_type is empty)
            $fuelType = $request->fuel_type ?: $request->fuel_type_new;

            $vehicle->update([
                'vehicle_name' => $request->vehicle_name,
                'make' => $make,
                'model' => $request->model,
                'year' => $request->year,
                'vehicle_class_id' => $request->vehicle_class_id,
                'transmission_id' => $request->transmission_id,
                'fuel_type' => $fuelType,
                'seats' => $request->seats,
                'doors' => $request->doors,
                'passengers' => $request->passengers,
                'luggage_capacity' => $request->luggage_capacity,
                'other' => $request->other,
                'base_cost_per_day' => $request->base_cost_per_day,
                'vat_percentage' => $request->vat_percentage,
                'images' => !empty($images) ? $images : null,
                'primary_pickup_location_id' => $request->primary_pickup_location_id,
                'alternate_pickup_location' => $request->alternate_pickup_location,
                'status' => $request->status ?? 1,
            ]);

            DB::commit();
            return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vehicles.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        
        // Delete associated images
        if ($vehicle->images) {
            foreach ($vehicle->images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
        
        $vehicle->delete();
        return response()->json(['success' => 'Vehicle deleted successfully.']);
    }

    /**
     * Check if vehicle already exists
     */
    public function checkDuplicate(Request $request)
    {
        $vehicleName = $request->input('vehicle_name');
        $make = $request->input('make') ?: $request->input('make_new');
        $model = $request->input('model');
        $year = $request->input('year');
        $id = $request->input('id');

        $query = Vehicle::where('vehicle_name', $vehicleName)
            ->where('make', $make)
            ->where('model', $model)
            ->where('year', $year);
        
        if ($id) {
            $query->where('id', '!=', decrypt($id));
        }

        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }
}
