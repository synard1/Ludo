<?php

namespace Modules\ITAM\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

use Modules\ITAM\Entities\Partner;
use Modules\ITAM\Entities\AssetCategory;
use Modules\ITAM\Entities\AssetType;
use Modules\ITAM\Entities\Department;
use Modules\ITAM\Entities\Manufacture;
use Modules\ITAM\Entities\Category;
use Modules\ITAM\Entities\Location;
use Modules\ITAM\Entities\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Modules\Helpdesk\Entities\Ticket;
use Illuminate\Support\Facades\Validator;
use Modules\ITAM\Entities\Asset;

use Modules\ITAM\Services\AssetTagGenerator;
use Carbon\Carbon;

class AddAsset extends Component
{

    // protected $assetTagGenerator;

    // public function __construct(AssetTagGenerator $assetTagGenerator)
    // {
    //     $this->assetTagGenerator = $assetTagGenerator;
    // }

    public $editMode = false;

    public $partners, $categories, $users;
    public $partner_id, $asset_tag, $name, $category_id, $type_id, $manufacturer_id, $model, $serial_number, $purchase_date, $purchase_cost, $warranty_end_date, $status, $location_id, $assigned_to, $notes, $department_id;
    public $reportedNames, $selectedReporter, $reporterNames;

    public $selectedTag, $selectedType;
    public $selectedAssetType;
    public $newDepartmentName; // Property to store the new department name


    public $assetType = []; // Initialize as an empty array
    public $assetTypes = [];
    public $departments = [];
    public $locations = [];
    public $manufacturers = [];

    public $asset_id = null; // Initialize with null instead of empty string


    public $ownership_type = 'owned'; // Set the default value here


    protected $listeners = [
        'getDepartments' => 'getDepartments',
        'getLocations' => 'getLocations',
        'getManufacturers' => 'getManufacturers',
        // 'updateDepartment' => 'updateDepartment',
        'update-department_id' => 'updateDepartment',
        'update-location_id' => 'updateLocation',
        'update-manufacturer_id' => 'updateManufacturer',
        'update-category_id' => 'updateCategory',
        'updateAsset' => 'updateAsset',
        'deleteAsset' => 'deleteAsset',

    ];



    public function rules()
    {
        return [
            // 'ownership_type' => 'required|in:owned,leased,partner',
            // 'partner_id' => 'nullable|exists:itam_partners,id', // Only required if ownership_type is 'partner' (handled in validation logic)
            // 'asset_tag' => 'required|unique:itam_assets,asset_tag', // Assuming 'assets' is your table name
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:itam_asset_categories,id',
            'type_id' => 'required|exists:itam_asset_types,id', // Or validate against a custom rule if needed
            'manufacturer_id' => 'required|exists:itam_manufacturers,id',
            // 'model' => 'nullable|string|max:255',
            // 'serial_number' => 'nullable|string|max:255',
            // 'purchase_date' => 'nullable|date',
            // 'purchase_cost' => 'nullable|numeric|min:0',
            // 'warranty_end_date' => 'nullable|date|after_or_equal:purchase_date', // Warranty after purchase
            'status' => 'required|in:active,inactive,loaned',
            'location_id' => 'required|exists:itam_locations,id',
            // 'assigned_to' => 'nullable|exists:itam_users,id',
            // 'notes' => 'required|string',
            'department_id' => 'required|exists:itam_departments,id',
            // 'selectedReporter' => 'nullable|exists:itam_users,id', // If applicable
        ];
    }

    public function partnerRules()
    {
        return [
            'partner_id' => ['required', 'exists:itam_partners,id'], // Validation rules for partner
        ];
    }

    public function updatedOwnershipType($value)
    {
        if ($value === 'partner' || $value === 'leased') {
            $this->validate($this->partnerRules()); // Validate using partnerRules()
        } else {
            $this->partner_id = null; // Clear if ownership is not 'partner'
            $this->resetErrorBag('partner_id'); // Clear validation error for partner_id
        }
    }

    public function mount()
    {
        $this->partners = Partner::all() ?? collect(); // Ensure it's at least an empty collection
        
        $this->categories = AssetCategory::all() ?? collect(); // Fetch manufacturers from the database
        // $this->manufacturers = Manufacture::all(); // Fetch manufacturers from the database
        // $this->locations = Location::all(); // Fetch locations from the database
        $this->users = User::all() ?? collect(); // Fetch users from the database
        // $this->departments = Department::all(); // Fetch users from the database
        // $this->types = ['asdasd','qqqq','bbbb']; // Fetch users from the database
        // $this->types = []; // Fetch users from the database

        // $this->assetType = Ticket::distinct('reporter_name')
        //                                 ->pluck('reporter_name')
        //                                 ->filter()
        //                                 ->toArray();

        // $this->categories = ['Hardware','Software','License'];
        // $this->refreshDepartments(); // Load departments on mount
        $this->loadDepartments();
        $this->loadLocations();
        $this->loadManufacturers();


    }

    public function render()
    {

        return view('itam::livewire.AddAsset', [
            'partners' => $this->partners,
            'categories' => $this->categories,
            // 'manufacturers' => $this->manufacturers,
            // 'locations' => $this->locations,
            'users' => $this->users,
        ]);
    }

    // public function updatedCategoryId($value)
    // {
    //     // $this->assetTypes = AssetType::where('category_id', $value)->get();
    //     $this->loadAssetTypes();
    //     // $this->dispatch('updateDropdowns'); // Add this line

    // }

    // #[On('update-category_id')]
    public function updateCategory(string $id) // Accept parameter directly
    {
        // $this->category_id = $id; 
        $this->loadAssetTypes(); 
        // $this->dispatch('success', __($id));

    }

    // public function updatedSelectedAssetType()
    // {
    //     if (!in_array($this->selectedAssetType, $this->assetType)) {
    //         $this->assetType[] = $this->selectedAssetType;
    //         $this->selectedAssetType = null; // Reset selected value
    //         $this->dispatchBrowserEvent('clearSelect2'); // Trigger a custom event

    //     }
    // }

    // public function updatedCategoryId($value)
    // {
    //     $this->category_id = $value;
    //     $this->loadAssetTypes();
    //     $this->selectedAssetType = null; // Reset type_id when category changes
    // }

    private function loadAssetTypes()
    {
        if ($this->category_id) {
            $this->assetTypes = AssetType::where('category_id', $this->category_id)->get();
        } else {
            $this->assetTypes = []; // Clear if no category selected
        }
    }

    // public function updatedDepartmentId($value)
    // {
    //     // Check if a new tag is added
    //     if (is_string($value) && !empty($value)) {
    //         $existingDepartment = Department::where('name', $value)->first();

    //         if (!$existingDepartment) {
    //             // Create a new department if it doesn't exist
    //             $newDepartment = Department::create(['name' => $value]);
    //             $this->department_id = $newDepartment->id;

    //             // Refresh department list
    //             $this->departments = Department::all();
    //         } else {
    //             $this->department_id = $existingDepartment->id;
    //         }
    //     }
    // }

    // public function addNewTag($newTag)
    // {
    //     if (!empty($newTag)) {
    //         $existingDepartment = Department::where('name', $newTag)->first();

    //         if (!$existingDepartment) {
    //             $newDepartment = Department::create(['name' => $newTag]);
    //             $this->department_id = $newDepartment->id;
    //             $this->departments = Department::all(); // Refresh list
    //         } else {
    //             $this->department_id = $existingDepartment->id;
    //         }
    //     }
    // }

    // public function loadDepartments()
    // {
    //     $this->departments = Department::all()->map(function ($department) {
    //         return [
    //             'id' => $department->id,
    //             'name' => $department->name,
    //         ];
    //     })->toArray();
    // }
    public function loadDepartments()
    {
        $this->departments = Department::select('id', 'name')->get()->toArray();
    }

    public function loadLocations()
    {
        $this->locations = Location::all()->map(function ($location) {
            return [
                'id' => $location->id,
                'name' => $location->name,
            ];
        })->toArray();
    }

    public function loadManufacturers()
    {
        $this->manufacturers = Manufacture::all()->map(function ($manufacture) {
            return [
                'id' => $manufacture->id,
                'name' => $manufacture->name,
            ];
        })->toArray();
    }

    public function addNewDepartment($departmentName)
    {
        $validatedData = Validator::make(['name' => $departmentName], [
            'name' => 'required|unique:itam_departments,name|max:255',
        ])->validate();

        $newDepartment = Department::create($validatedData);

        // $this->departments = Department::all(); // Refresh departments list
        // $this->refreshDepartments(); // CRUCIAL: Refresh the $departments collection
        $this->loadDepartments(); // Reload departments
                // $this->dispatch('updateDropdowns'); // Add this line


        $this->department_id = $newDepartment->id;

        // Dispatch updated department list and new ID to frontend
        $this->dispatch('departmentAdded', $newDepartment->id, $this->departments);

        // $this->dispatch('departmentAdded', $newDepartment->id); // Emit the event
        // $this->dispatch('updateDropdowns'); // Add this line

    }

    public function addNewLocation($locationName)
    {
        $validatedData = Validator::make(['name' => $locationName], [
            'name' => 'required|unique:itam_locations,name|max:255',
        ])->validate();

        $newLocation = location::create($validatedData);

        // $this->departments = Department::all(); // Refresh departments list
        // $this->refreshDepartments(); // CRUCIAL: Refresh the $departments collection
        $this->loadLocations(); // Reload departments

        $this->location_id = $newLocation->id;

        $this->dispatch('locationAdded', $newLocation->id, $this->locations);

        // $this->dispatch('locationAdded', $newLocation->id); // Emit the event
        // $this->dispatch('updateDropdowns'); // Add this line

    }

    public function addNewManufacture($manufactureName)
    {
        $validatedData = Validator::make(['name' => $manufactureName], [
            'name' => 'required|unique:itam_manufacturers,name|max:255',
        ])->validate();

        $user = Auth::user();

        // dd($user);

        $newManufacture = Manufacture::create($validatedData);

        // $this->departments = Department::all(); // Refresh departments list
        // $this->refreshDepartments(); // CRUCIAL: Refresh the $departments collection
        $this->loadManufacturers(); // Reload departments

        $this->manufacturer_id = $newManufacture->id;

        $this->dispatch('manufacturerAdded', $newManufacture->id, $this->manufacturers);


        // $this->dispatch('manufactureAdded', $newManufacture->id); // Emit the event
        // $this->dispatch('updateDropdowns'); // Add this line

    }

    public function getDepartmentsProperty() // Use a computed property
    {
        return $this->departments;
    }

    public function getLocationsProperty() // Use a computed property
    {
        return $this->locations;
    }

    public function getManufacturersProperty() // Use a computed property
    {
        return $this->manufacturers;
    }

    public function submit()
    {
        // Dump all properties of the Livewire component
        // dd($this->all());
        $this->validate();


        try {
            // Wrap database operation in a transaction (if applicable)
            DB::beginTransaction();

            $assetTagFormat = config('itam.asset_tag');

            // Check if editing an existing asset
            $isUpdating = !empty($this->asset_id);

            // If editing, find existing asset
            $asset = $isUpdating ? Asset::where('id',$this->asset_id)->first() : new Asset();

            // Check for duplicate asset tag when creating a new asset
            if (!$this->asset_id && Asset::where('asset_tag', $this->asset_tag)->exists()) {
                throw new \Exception("Asset tag already exists.");
            }

            // Assign values
            $asset->ownership_type = $this->ownership_type;
            $asset->partner_id = $this->partner_id ?: NULL;
            $asset->name = $this->name;
            $asset->category_id = $this->category_id;
            $asset->type_id = $this->type_id;
            $asset->manufacturer_id = $this->manufacturer_id;
            $asset->model = $this->model;
            $asset->serial_number = $this->serial_number ?: NULL;
            $asset->purchase_date = $this->purchase_date ?: NULL;
            $asset->purchase_cost = $this->purchase_cost ?: NULL;
            $asset->warranty_end_date = $this->warranty_end_date ?: NULL;
            $asset->department_id = $this->department_id;
            $asset->location_id = $this->location_id;
            $asset->status = $this->status;
            $asset->assigned_to = $this->assigned_to ?: NULL;
            $asset->notes = $this->notes ?: NULL;
            $asset->specifications = $this->specifications ?? NULL;

            // Only generate a new asset tag if creating a new asset
            if (!$isUpdating) {
                $asset->asset_tag = $this->generateAssetTag($assetTagFormat, $asset);
            }

            $asset->save();

            DB::commit();

            // ✅ Reset Form Fields
            // Reset only input fields (not collections)
            $this->reset(['name', 'model', 'serial_number', 'purchase_cost', 'purchase_date', 'warranty_end_date', 'notes']);
            $this->resetValidation();
            // $this->reset(); // Clears all Livewire properties
            // $this->resetValidation(); // Clears validation errors

            // Dispatch success notification
            $message = $isUpdating ? __('Data Asset Berhasil Diubah') : __('Data Asset Berhasil Dibuat');
            $this->dispatch('success', $message);

            // ✅ Dispatch an event to refresh Select2 (if applicable)
            $this->dispatch('refreshSelect2');

        } catch (\Exception $e) {
            DB::rollBack();
            // Handle validation and general errors
            $this->dispatch('error', 'Terjadi kesalahan saat menyimpan data.'. $e);
        }
        // } finally {
        //     // Reset the form in all cases to prepare for new data
        //     // $this->reset();
        //     $this->resetForm();

        // }

    }

    public function deleteAsset($assetId)
    {
        // Delete the asset record with the specified ID
        $asset = Asset::where('id', $assetId)->firstOrFail();
        $asset->delete();

        // Emit a success event with a message
        $this->dispatch('success', 'Asset successfully deleted');
    }

    private function resetForm()
    {
        // Reset the $name property to an empty string
        $this->name = '';

        // Reset the $permission property to a new Permission instance
    }

    // public function updatedSelectedTags()
    // {
    //     if (!in_array($this->selectedReporter, $this->selectedTags)) {
    //         $this->selectedTags[] = $this->selectedReporter;
    //         $this->selectedReporter = null; // Reset selected value
    //         $this->dispatchBrowserEvent('clearSelect2'); // Trigger a custom event
    //         // You can choose to save the new tag to the database or handle it as needed.
    //         // For example, to save it to the database, you would do something like:
    //         // Ticket::create(['reporter_name' => $this->selectedReporter]);

    //         // For this example, we'll just add it to the list for demonstration.
    //         // $this->reporterNames[] = $this->selectedReporter;
    //     }
    // }

    // public function updatedSelectedType()
    // {
    //     if (!in_array($this->selectedType, $this->types)) {
    //         $this->types[] = $this->selectedType;
    //         $this->selectedType = null; // Reset selected value
    //         $this->dispatchBrowserEvent('clearSelect2'); // Trigger a custom event
    //     }
    // }

    // public function refreshDepartments()
    // {
    //     $this->departments = Department::all(); // Reload the departments from the database
    //     return $this->departments; // Return the departments data
    // }

    public function getDepartments() {
        return $this->departments; // Return the departments data
    }

    public function getLocations() {
        return $this->locations; // Return the departments data
    }

    public function getManufacturers() {
        return $this->manufacturers; // Return the departments data
    }

    public function generateAssetTag($format, $asset)
    {
        $assetTagGenerator = resolve(AssetTagGenerator::class); // Or app(AssetTagGenerator::class);

        // Or if you are using laravel 8 and above, you can use class name directly.
        // $assetTagGenerator = app(AssetTagGenerator::class);

        $assetTag = $assetTagGenerator->generate($format, $asset); // Example usage

        return $assetTag;

        // ... use $assetTag
    }

    public function updateDepartment(string $id) // Ensure it's a string
    {
        $this->department_id = $id;
        $this->dispatch('departmentUpdated', departmentId: (string) $id);

    }

    public function updateLocation(string $id) // Ensure it's a string
    {
        $this->location_id = $id;
        $this->dispatch('locationUpdated', locationId: (string) $id);

    }

    public function updateManufacturer(string $id) // Ensure it's a string
    {
        $this->manufacturer_id = $id;
        $this->dispatch('manufactureUpdated', manufacturerId: (string) $id);

    }

    // public function updateDropdowns()
    // {
    //     // This method can be empty, it's just a listener to trigger JS updates
    // }

    public function updateAsset($assetId)
    {
        
        $asset = Asset::where('id', $assetId)->first();

        if ($asset) {
            $this->asset_id = $asset->id;
            $this->ownership_type = $asset->ownership_type;
            $this->partner_id = $asset->partner_id;
            // $this->asset_tag = $asset->asset_tag;
            $this->name = $asset->name;
            $this->category_id = $asset->category_id;
            $this->assetTypes = AssetType::where('category_id', $this->category_id)->get();
            $this->type_id = $asset->type_id;
            $this->manufacturer_id = $asset->manufacturer_id;
            $this->model = $asset->model;
            $this->serial_number = $asset->serial_number;

            // ✅ Convert Date Format (Fixes Date Format Error)
            $this->purchase_date = $asset->purchase_date ? Carbon::parse($asset->purchase_date)->format('Y-m-d') : null;
            $this->warranty_end_date = $asset->warranty_end_date ? Carbon::parse($asset->warranty_end_date)->format('Y-m-d') : null;

            $this->purchase_cost = $asset->purchase_cost;
            $this->department_id = $asset->department_id;
            $this->location_id = $asset->location_id;
            $this->status = $asset->status;
            $this->assigned_to = $asset->assigned_to;
            $this->notes = $asset->notes;
            $this->editMode = true;

            $this->dispatch('consoleLog', [
                'assets' => $asset,
            ]);
        }
    }

}
