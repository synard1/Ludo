<div id="kt_docs_card_asset_new" class="card shadow-sm mb-5 collapse" wire:ignore.self>
    <form id="kt_new_asset_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" wire:submit.prevent="submit">
        <div class="card-body p-9">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ownership_type" class="form-label required">Ownership Type:</label>
                    <select wire:model="ownership_type" id="ownership_type" class="form-control" required>
                        <option value="owned">Owned</option>
                        <option value="leased">Leased</option>
                        <option value="partner">Partner</option>
                    </select>
                    @error('ownership_type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label for="partner_id" class="form-label">Partner (if applicable):</label>
                    <select wire:model="partner_id" id="partner_id" class="form-control" @if($ownership_type === 'owned' )
                        disabled @endif>
                        <option value="">-- Select Partner --</option>
                        @foreach ($partners as $partner)
                        <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                        @endforeach
                    </select>
                    @error('partner_id') <span class="text-danger">{{ $message }}</span> @enderror

                </div>
            </div>

            

            <fieldset class="border p-4 mb-5">
                <legend class="w-auto px-2">Asset Information</legend>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label required">Name:</label>
                        <input type="text" wire:model="name" id="name" class="form-control" required>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="serial_number" class="form-label">Serial Number:</label>
                        <input type="text" wire:model="serial_number" id="serial_number" class="form-control">
                        @error('serial_number') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="category_id" class="form-label required">Category:</label>
                        <select wire:model="category_id" id="category_id" class="js-select2 form-control" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="selectedAssetType" class="form-label required">Type:</label>
                        <select wire:model="type_id" id="assetTypeSelect" class="js-select2 form-control" required>
                            <option value="">-- Select Asset Type --</option>
                            @foreach ($assetTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('type_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="manufacturer_id" class="form-label required">Manufacturer:</label>
                        <select wire:model="manufacturer_id" id="manufacturer_id" class="js-select2 js-select2-tags form-control" required>
                            <option value="">-- Select Manufacturer --</option>
                            @foreach ($manufacturers as $manufacturer)
                                {{-- <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option> --}}
                                <option value="{{ $manufacturer['id'] }}">{{ $manufacturer['name'] }}</option> {{-- Access as array --}}

                            @endforeach
                        </select>
                        @error('manufacturer_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="model" class="form-label">Model:</label>
                        <input type="text" wire:model="model" id="model" class="form-control">
                        @error('model') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
    
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="purchase_cost" class="form-label">Purchase Cost:</label>
                        <input type="number" wire:model="purchase_cost" id="purchase_cost" class="form-control" step="0.01">
                        @error('purchase_cost') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="purchase_date" class="form-label">Purchase Date:</label>
                        <input type="date" wire:model="purchase_date" id="purchase_date" class="form-control">
                        @error('purchase_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="warranty_end_date" class="form-label">Warranty End Date:</label>
                        <input type="date" wire:model="warranty_end_date" id="warranty_end_date" class="form-control">
                        @error('warranty_end_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-4 mb-5"> {{-- Status and Assignment Group --}}
                <legend class="w-auto px-2">Status & Assignment</legend>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="status" class="form-label required">Status:</label>
                        <select wire:model="status" id="status" class="form-control" required>
                            <option value="">-- Select Status --</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="loaned">Loaned</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    {{-- <div class="col-md-4">
                        <label for="department_id" class="form-label">Department:</label>
                        <select wire:model="department_id" id="department_id" class="js-select2 js-select2-tags form-control">
                            <option value="">-- Select Department --</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div> --}}
                    <div class="col-md-4">
                        <label for="department_id" class="form-label required">Department:</label>
                        <select wire:model="department_id" id="department_id" class="js-select2 js-select2-tags form-control" required>
                            <option value="">-- Select Department --</option>
                            @foreach ($this->departments as $department)  {{-- Use $this->departments --}}
                                <option value="{{ $department['id'] }}">{{ $department['name'] }}</option> {{-- Access as array --}}
                            @endforeach
                        </select>
                        @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="location_id" class="form-label required">Location:</label>
                        <select wire:model="location_id" id="location_id" class="js-select2 js-select2-tags form-control" required>
                            <option value="">-- Select Location --</option>
                            @foreach ($this->locations as $location)
                            <option value="{{ $location['id'] }}">{{ $location['name'] }}</option> {{-- Access as array --}}
                            {{-- <option value="{{ $location->id }}">{{ $location->name }}</option> --}}
                            @endforeach
                        </select>
                        @error('location_id') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="assigned_to" class="form-label">Assigned To:</label>
                        <select wire:model="assigned_to" id="assigned_to" class="js-select2 form-control">
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('assigned_to') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>
                    <div class="col-md-6">
                        <label for="notes" class="form-label">Notes:</label>
                        <textarea wire:model="notes" id="notes" class="form-control"></textarea>
                        @error('notes') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>
                </div>
            </fieldset> {{-- End Status and Assignment Group --}}


        </div>

        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="reset" class="btn btn-light btn-active-light-primary me-2 btn-cancel"
                id="kt_new_asset_cancel">Discard</button>
            <button type="submit" id="kt_new_asset_submit" class="btn btn-primary">
                @include('partials/general/_button-indicator', ['label' => 'Save Changes'])
            </button>
            {{-- <button id="refreshSelect2" class="btn btn-primary">Refresh Select2</button> --}}

        </div>
        <input type="hidden">
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const partnerSelect = $('#partner_id');
            partnerSelect.prop('disabled', true); // Disable the select

            const modelInput = $('#model');
            modelInput.prop('disabled', true); // Disable the select

            var xButton = document.querySelector('#kt_new_asset_cancel');


            // Add a click event listener to the "Cancel" button
            xButton.addEventListener('click', function (e) {
                e.preventDefault();
                form.reset();

                // Close kt_docs_card_change_new
                $('#kt_docs_card_asset_new').collapse('hide');
                // Show kt_docs_card_change_list
                $('#kt_docs_card_asset_list').collapse('show');
                $("#assets-table").DataTable().ajax.reload(null, false); 

                
                // Clear select elements (using jQuery)
                $('select').val(''); // Or null for some select boxes: $('select').val(null);
                $('select').trigger('change'); // Important for select2 or other enhanced selects

                // Clear input fields (text, number, date, textarea)
                $('input[type="text"], input[type="number"], input[type="date"], textarea').val('');

                // Reset any Livewire properties (if needed)
                // This is the most crucial part for Livewire integration
                @this.ownership_type = ''; // Example: Resetting Livewire properties
                @this.partner_id = '';
                @this.name = '';
                @this.serial_number = '';
                @this.category_id = '';
                @this.type_id = '';
                @this.manufacturer_id = '';
                @this.model = '';
                @this.purchase_cost = '';
                @this.purchase_date = '';
                @this.warranty_end_date = '';
                @this.status = '';
                @this.department_id = '';
                @this.location_id = '';
                @this.assigned_to = '';
                @this.notes = '';

                // If using select2 or similar libraries, you might need to
                // manually clear their selections as well:
                $('.js-select2').val(null).trigger('change'); // Clear select2 selects

                // Reset validation errors (if any) - This depends on how you handle validation
                $('.text-danger').text(''); // Clear error messages
                $('.is-invalid').removeClass('is-invalid'); // Remove red borders
                
                
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const departmentSelect = $('#department_id');
            const locationSelect = $('#location_id');
            const manufacturerSelect = $('#manufacturer_id');

            // departmentSelect.select2({
            //     tags: true,
            //     createTag: function (params) {
            //         var term = $.trim(params.term);
            //         if (term === '') {
            //             return null;
            //         }
            //         return {
            //             id: term,
            //             text: term,
            //             newTag: true
            //         }
            //     }
            // });

            departmentSelect.on('select2:select', function (e) {
                var data = e.params.data;

                if (data.newTag) {
                    Swal.fire({
                        title: 'Are you sure you want to add this new department?',
                        text: data.text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, add it!',
                        cancelButtonText: 'No, cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.addNewDepartment(data.text);
                        } else {
                            $(this).val(null).trigger('change'); // Revert selection
                        }
                    });
                } else {
                    let componentId = departmentSelect.closest('[wire\\:id]').attr('wire:id');
                    Livewire.find(componentId).set('department_id', departmentSelect.val());
                }
                // } else {
                //     @this.set('department_id', $(this).val());
                // }
            });

            locationSelect.on('select2:select', function (e) {
                var data = e.params.data;

                if (data.newTag) {
                    Swal.fire({
                        title: 'Are you sure you want to add this new location?',
                        text: data.text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, add it!',
                        cancelButtonText: 'No, cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.addNewLocation(data.text);
                        } else {
                            $(this).val(null).trigger('change'); // Revert selection
                        }
                    });
                } else {
                    let componentId = departmentSelect.closest('[wire\\:id]').attr('wire:id');
                    Livewire.find(componentId).set('department_id', departmentSelect.val());
                }
                // } else {
                //     @this.set('location_id', $(this).val());
                // }
            });

            manufacturerSelect.on('select2:select', function (e) {
                var data = e.params.data;

                if (data.newTag) {
                    Swal.fire({
                        title: 'Are you sure you want to add this new manufacturer?',
                        text: data.text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, add it!',
                        cancelButtonText: 'No, cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.addNewManufacture(data.text);
                        } else {
                            $(this).val(null).trigger('change'); // Revert selection
                        }
                    });
                } else {
                    @this.set('manufacturer_id', $(this).val());
                }
            });

            // Livewire.on('departmentAdded', (data) => {
            //     console.log('Received params:', data);

            //     // Extract department ID and departments list correctly
            //     const newDepartmentId = data[0];  // First item is the new department ID
            //     const departments = data[1];      // Second item is the updated departments list

            //     console.log('New department ID:', newDepartmentId);
            //     console.log('Updated departments:', departments);

            //     if (Array.isArray(departments) && departments.length > 0) {
            //         const select2Data = departments.map(department => ({
            //             id: department.id,
            //             text: department.name
            //         }));

            //         const departmentSelect = $('#department_id');

            //         // Destroy and reinitialize Select2 with updated data
            //         departmentSelect.select2('destroy');
            //         departmentSelect.empty();
            //         departmentSelect.select2({
            //             data: select2Data,
            //             tags: true,
            //             placeholder: '-- Select Department --'
            //         });

            //         // Select the newly added department
            //         // departmentSelect.val(newDepartmentId).trigger('change');

            //         console.log('Before setting value:', departmentSelect.val());
            //         departmentSelect.val(newDepartmentId).trigger('change');
            //         console.log('After setting value:', departmentSelect.val());

            //         console.log('Department selection updated:', newDepartmentId);

            //         // Update Livewire property
            //         // Livewire.dispatch('updateDepartment', { departmentId: newDepartmentId });

            //         Livewire.dispatch('updateDepartment', { departmentId: newDepartmentId });

                    

            //     } else {
            //         console.warn("Departments list is empty or invalid.");
            //     }
            // });

            // Livewire.on('locationAdded', (newLocationId) => {
            //     @this.getLocations().then(locations => {
            //         if (locations && Array.isArray(locations) && locations.length > 0) { // Check if locations is valid
            //             const select2Data = locations.map(location => ({
            //                 id: location.id,
            //                 text: location.name
            //             }));

            //             console.log(locations);

            //             locationSelect.select2('destroy');
            //             locationSelect.empty();
            //             locationSelect.select2({
            //                 data: select2Data,
            //                 tags: true,
            //                 placeholder: '-- Select Department --'
            //             });

            //             // 1. Set the selected value in Select2
            //             locationSelect.val(newLocationId);

            //             // 2. Trigger the change event for Select2
            //             locationSelect.trigger('change');

            //             // 3. MOST IMPORTANT: Update the Livewire property *AFTER* Select2 is updated
            //             @this.set('location_id', newLocationId);  // This is the CRUCIAL line

            //         } else {
            //             console.warn("Locations data is invalid or empty. Cannot update Select2.");
            //             // Handle the case where locations is invalid (e.g., show a message to the user)
            //             locationSelect.empty(); // Clear existing options
            //             locationSelect.append('<option value="">-- No Locations Available --</option>'); // Add a message option
            //             locationSelect.prop('disabled', true); // Disable the select
            //         }
            //     });
            // });

            // Livewire.on('manufactureAdded', (newManufacturerId) => {
            //     @this.getManufacturers().then(manufacturers => {
            //         if (manufacturers && Array.isArray(manufacturers) && manufacturers.length > 0) { // Check if locations is valid
            //             const select2Data = manufacturers.map(manufacturer => ({
            //                 id: manufacturer.id,
            //                 text: manufacturer.name
            //             }));

            //             // console.log(locations);

            //             manufactureSelect.select2('destroy');
            //             manufactureSelect.empty();
            //             manufactureSelect.select2({
            //                 data: select2Data,
            //                 tags: true,
            //                 placeholder: '-- Select Manufacturer --'
            //             });

            //             // 1. Set the selected value in Select2
            //             manufactureSelect.val(newManufacturerId);

            //             // 2. Trigger the change event for Select2
            //             manufactureSelect.trigger('change');

            //             // 3. MOST IMPORTANT: Update the Livewire property *AFTER* Select2 is updated
            //             @this.set('manufacturer_id', newManufacturerId);  // This is the CRUCIAL line

            //         } else {
            //             console.warn("Manufacturers data is invalid or empty. Cannot update Select2.");
            //             // Handle the case where locations is invalid (e.g., show a message to the user)
            //             manufactureSelect.empty(); // Clear existing options
            //             manufactureSelect.append('<option value="">-- No Manufacturers Available --</option>'); // Add a message option
            //             manufactureSelect.prop('disabled', true); // Disable the select
            //         }
            //     });
            // });


            ['department', 'location', 'manufacturer'].forEach(type => {
                Livewire.on(`${type}Added`, (data) => {
                    console.log(`Received params for ${type}:`, data);
                    updateDropdown(`${type}_id`, data[0], data[1]);
                });
            });

        });

        function updateDropdown(selectId, newItemId, items) {
            console.log(`New item ID for ${selectId}:`, newItemId);
            console.log(`Updated items for ${selectId}:`, items);

            if (!Array.isArray(items) || items.length === 0) {
                console.warn(`${selectId} list is empty or invalid.`);
                return;
            }

            const select2Data = items.map(item => ({
                id: item.id,
                text: item.name
            }));

            const selectElement = $(`#${selectId}`);

            // Destroy and reinitialize Select2 with updated data
            selectElement.select2('destroy');
            selectElement.empty();
            selectElement.select2({
                data: select2Data,
                tags: true,
                placeholder: `-- Select ${selectId.replace('_', ' ')} --`
            });

            console.log(`Before setting value for ${selectId}:`, selectElement.val());
            selectElement.val(newItemId).trigger('change');
            console.log(`After setting value for ${selectId}:`, selectElement.val());

            // Update Livewire property
            Livewire.dispatch(`update-${selectId}`, { id: newItemId });
        }

        function updateSelect2Dropdown(elementId, data) {
            const itemId = data.departmentId || data.locationId || data.manufacturerId; // Extract UUID dynamically
            const selectElement = $(`#${elementId}`);

            console.log(`Updating Select2 for ${elementId}:`, itemId);

            if (!itemId) return; // Prevent errors if undefined/null

            // Set value & ensure it updates
            selectElement.val(itemId).trigger('change.select2');

            // Add option if missing
            if (!selectElement.find(`option[value="${itemId}"]`).length) {
                selectElement.append(new Option('New Option', itemId, true, true)).trigger('change.select2');
            }
        }

        function checkformModel() {
            let isValid = true;
            // console.log('checkformModel');
            

            function checkSelect(selector, errorMessage) {
                const select = $(selector);
                if (!select.val()) {
                    // alert(errorMessage);
                    select.addClass('is-invalid');
                    isValid = false;
                } else {
                    select.removeClass('is-invalid');
                }
                return select.val();
            }

            // const departmentValue = checkSelect('#department_id', "Please select a department.");
            // const locationValue = checkSelect('#location_id', "Please select a location.");
            const manufactureValue = checkSelect('#manufacturer_id', "Please select a manufacture.");

            // Check if ALL select values are present
            if (manufactureValue) {
                // console.log('departmentValue : '+departmentValue);
                // console.log('locationValue : '+locationValue);
                console.log('manufactureValue : '+manufactureValue);
                
                // All selects are filled, enable the input and do something, e.g.
                $('#model').prop('disabled', false); // Enable the input
                $('#model').removeClass('disabled'); //Remove the disabled class for styling

                // Example: populate the model input (if needed)
                // $('#model').val(departmentValue + "-" + locationValue + "-" + manufactureValue); // Or any other logic

                // Or trigger an event, like enabling a button, or submitting
                // $('#submitButton').prop('disabled', false);
                // $('form').submit();
            } else {
                $('#model').prop('disabled', true); // Disable the input
                $('#model').addClass('disabled'); // Add the disabled class for styling

            }

            return isValid;
        }


        function initSelect2() {
            $('.js-select2').each(function () {
                // Destroy existing Select2 instance if it exists
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2('destroy');
                }
                
                let allowTags = $(this).hasClass('js-select2-tags');
                
                $(this).select2({
                    tags: allowTags,
                    placeholder: "Select or add an option",
                    allowClear: true,
                    width: '100%',
                    createTag: function (params) {
                            var term = $.trim(params.term);
                            if (term === '') {
                                return null;
                            }
                            return {
                                id: term,
                                text: term,
                                newTag: true
                            }
                        }
                });

                // Sync changes with Livewire
                $(this).on('change', function () {
                    let selectedValues = $(this).val();
                    let modelName = $(this).attr('wire:model');

                    if (modelName) {
                        @this.set(modelName, selectedValues);
                    }
                });

                // Ensure newly added tags persist after Livewire updates
                $(this).on('select2:select', function (e) {
                    let newTag = e.params.data.id; // Get the new tag value
                    let currentValues = $(this).val() || [];

                    if (!currentValues.includes(newTag)) {
                        currentValues.push(newTag);
                        $(this).val(currentValues).trigger('change');
                    }
                });

                // Add change handler directly after initialization
                $(this).on('select2:select select2:unselect', function(e) {
                    const modelName = $(this).attr('wire:model');
                    const value = $(this).val();
                    
                    if (modelName) {
                        Livewire.find($(this).closest('[wire\\:id]').attr('wire:id'))
                            .set(modelName, value);
                    }
                });
            });
        }

    
        // $(document).ready(function () {
        //     initSelect2();
        //     checkformModel();

    
        //     // $('#category_id').on('change', function () {
        //     //     let categoryId = $(this).val();
        //     //     @this.set('category_id', categoryId);
    
        //     //     let assetTypeSelect = $('#assetTypeSelect');
        //     //     assetTypeSelect.empty().append('<option value="">-- Loading... --</option>');
        //     //     assetTypeSelect.prop('disabled', true);
    
        //     //     // if (categoryId) {
        //     //     //     $.ajax({
        //     //     //         url: '/api/v1/itam/get-asset-types/' + categoryId,
        //     //     //         type: 'GET',
        //     //     //         dataType: 'json',
        //     //     //         headers: {
        //     //     //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        //     //     //             'Authorization': 'Bearer ' + window.accessToken
        //     //     //         },
        //     //     //         success: function (data) {
        //     //     //             assetTypeSelect.empty().append('<option value="">-- Select Asset Type --</option>');
        //     //     //             $.each(data, function (key, value) {
        //     //     //                 assetTypeSelect.append(new Option(value.name, value.id));
        //     //     //             });
        //     //     //             assetTypeSelect.prop('disabled', false);
        //     //     //             assetTypeSelect.trigger('change');
        //     //     //         },
        //     //     //         error: function (error) {
        //     //     //             console.error('Error fetching asset types:', error);
        //     //     //             alert('Error fetching asset types. Please try again.');
        //     //     //             assetTypeSelect.prop('disabled', true);
        //     //     //         }
        //     //     //     });
        //     //     // }
        //     // });
        // });
    
        document.addEventListener('livewire:init', function () {
            // Attach Livewire listeners for each dropdown type
            Livewire.on('departmentUpdated', (data) => updateSelect2Dropdown('department_id', data));
            Livewire.on('locationUpdated', (data) => updateSelect2Dropdown('location_id', data));
            Livewire.on('manufactureUpdated', (data) => updateSelect2Dropdown('manufacturer_id', data));

            // Livewire.on('departmentUpdated', (data) => {
            //     const departmentId = data.departmentId; // Extract UUID
            //     const departmentSelect = $('#department_id');

            //     console.log("Updating Select2:", departmentId);

            //     if (!departmentId) return; // Prevent errors if undefined/null

            //     // Set value & ensure it updates
            //     departmentSelect.val(departmentId).trigger('change.select2');

            //     // Add option if missing
            //     if (!departmentSelect.find(`option[value="${departmentId}"]`).length) {
            //         departmentSelect.append(new Option('New Department', departmentId, true, true)).trigger('change.select2');
            //     }
            // });

        //     Livewire.hook('message.processed', () => {
        //         initSelect2();
        //         checkformModel();


        //     });

        //     // Livewire.on('success', function () {
        //     //     $('#kt_docs_card_asset_new').collapse('hide');
        //     //     $('#kt_docs_card_asset_list').collapse('show');
        //     //     window.LaravelDataTables['assets-table'].ajax.reload();
        //     // });
        });


        // Reinitialize Select2 after Livewire updates the DOM
        document.addEventListener('DOMContentLoaded', function () {
            // Initial setup
            initSelect2();

            // Handle Livewire updates
            Livewire.hook('morph.updated', (el) => {
                initSelect2();
                // checkformModel();
            });

            // $('#department_id').val('78735b52-eeb7-43e0-8730-f3a6655b31bd');
            // $('#department_id').val('9ac043f6-b02d-4782-9a2c-ea405fb3ed77').trigger('change');
            // 2. Trigger the change event for Select2
            // $('#department_id').trigger('change');


            // Handle Select2 change events
            // $('.js-select2').each(function() {
            //     $(this).on('change', function(e) {
            //         const modelName = $(this).attr('wire:model');
            //         const value = $(this).val();
                    
            //         if (modelName) {
            //             // Prevent recursive updates
            //             if (!$(this).data('updating')) {
            //                 $(this).data('updating', true);
            //                 @this.set(modelName, value);
            //                 $(this).data('updating', false);
            //             }
            //         }
            //     });
            // });

            // Remove refresh button
            // $('#refreshSelect2').remove();

            $('#category_id').on('change', function () {
                let categoryId = $(this).val();
                // Livewire.dispatch('update-category_id', { id: categoryId });
                // Livewire.dispatch('update-category_id', { id: categoryId }); // Pass a single parameter
                Livewire.dispatch(`update-category_id`, { id: categoryId });


    
                let assetTypeSelect = $('#assetTypeSelect');
                assetTypeSelect.empty().append('<option value="">-- Loading... --</option>');
                assetTypeSelect.prop('disabled', true);
            });
        });
    </script>
    

    @endpush
</div>