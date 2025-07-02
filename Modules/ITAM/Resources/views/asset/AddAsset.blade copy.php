<div class="modal fade" id="kt_modal_new_asset" tabindex="-1" aria-labelledby="createAssetModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl">  {{-- Adjust modal size as needed --}}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAssetModalLabel">Create IT Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form wire:submit.prevent="saveAsset">  {{-- Use wire:submit.prevent --}}

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ownership_type" class="form-label">Ownership Type:</label>
                            <select wire:model="ownership_type" id="ownership_type" class="form-control" required>
                                <option value="owned">Owned</option>
                                <option value="leased">Leased</option>
                                <option value="partner">Partner</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="partner_id" class="form-label">Partner (if applicable):</label>
                            <select wire:model="partner_id" id="partner_id" class="form-control" @if($ownership_type === 'owned') disabled @endif>
                                <option value="">-- Select Partner --</option>
                                @foreach ($partners as $partner)
                                    <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="asset_tag" class="form-label">Asset Tag:</label>
                            <input type="text" wire:model="asset_tag" id="asset_tag" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" wire:model="name" id="name" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        {{-- <div class="col-md-6">
                            <label for="type" class="form-label">Type:</label> --}}
                            {{-- <input type="text" wire:model="type" id="type" name="type" class="form-control js-select2" required> --}}
                            {{-- <select wire:model="selectedType" id="type"  name="type" class="js-select2 form-control">
                                <option value="">Select Type</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select> --}}
                            {{-- <select wire:model="selectedReporter" id="reporter-dropdown"  name="reporter-dropdown" class="js-select2 form-control">
                                <option value="">Select Reporter Name</option>
                                @foreach ($reporterNames as $name)
                                    <option value="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col fv-row">
                            <label for="" class="form-label">Reported By:</label>
                            <div class="input-group">
                                {{-- <livewire:itsm::reported-user /> --}}
                                <div class="col-lg-8 fv-row">
                                    {{-- <select wire:model="selectedType" id="types" name="types" class="js-select2 form-control">
                                        @foreach ($assetType as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select> --}}
                                    <!-- Select2 Field -->
                                    {{-- <select wire:model="selectedType" id="types" class="form-control" wire:ignore>
                                        @foreach ($assetType as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select> --}}
                                    {{-- <livewire:itam::asset-type-select /> --}}
                                    <select wire:model="selectedAssetType" id="assetTypeSelect" class="js-select2 form-control" wire:ignore>
                                        <option value="">-- Select Asset Type --</option>
                                        @foreach ($assetType as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category:</label>
                            <select wire:model="category_id" id="category_id" class="js-select2 form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="manufacturer_id" class="form-label">Manufacturer:</label>
                            <select wire:model="manufacturer_id" id="manufacture" name="manufacture" class="js-select2 form-control">
                                <option value="">-- Select Manufacturer --</option>
                                @foreach ($manufacturers as $manufacturer)
                                    <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="model" class="form-label">Model:</label>
                            <input type="text" wire:model="model" id="model" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="serial_number" class="form-label">Serial Number:</label>
                            <input type="text" wire:model="serial_number" id="serial_number" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="purchase_date" class="form-label">Purchase Date:</label>
                            <input type="date" wire:model="purchase_date" id="purchase_date" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="purchase_cost" class="form-label">Purchase Cost:</label>
                            <input type="number" wire:model="purchase_cost" id="purchase_cost" class="form-control" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label for="warranty_end_date" class="form-label">Warranty End Date:</label>
                            <input type="date" wire:model="warranty_end_date" id="warranty_end_date" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status:</label>
                            <select wire:model="status" id="status" class="form-control" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="loaned">Loaned</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="location_id" class="form-label">Location:</label>
                            <select wire:model="location_id" id="location_id" class="js-select2 form-control">
                                <option value="">-- Select Location --</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
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
                        </div>
                        <div class="col-md-6">
                            <label for="notes" class="form-label">Notes:</label>
                            <textarea wire:model="notes" id="notes" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="specifications" class="form-label">Specifications (JSON):</label>
                        <textarea wire:model="specifications" id="specifications" class="form-control"></textarea>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>

        </div>
        <p>Selected Tags: @json($selectedTag)</p> {{-- Display the selected tags --}}

    </div>

    @push('scripts')

{{-- <script>
    function initSelect2() {
        $('#types').select2({
            dropdownParent: $('#myModal'), // Fix Select2 in Bootstrap Modal
            tags: true,
            tokenSeparators: [','],
            placeholder: "Select or add a tag",
            allowClear: true,
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') { return null; }
                return { id: term, text: term, newTag: true };
            }
        });

        // Update Livewire on selection
        $('#types').on('select2:select', function (e) {
            let data = e.params.data;
            @this.set('selectedTag', data.id);
        });
    }

    $(document).ready(function () {
        $('#kt_modal_new_asset').on('shown.bs.modal', function () {
            initSelect2(); // Initialize when modal is opened
        });
    });

    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            initSelect2(); // Reinitialize after Livewire update
        });
    });
</script> --}}

    {{-- <script>
        function initSelect2() {
            $('#tagSelect').select2({
                tags: true,
                tokenSeparators: [','],
                placeholder: "Select or add a tag", // Optional for better UX
                allowClear: true, // Optional: allows clearing the selection
                createTag: function (params) {
                    var term = $.trim(params.term);
                    if (term === '') { return null; }
                    return { id: term, text: term, newTag: true };
                }
            });
    
            // Ensure Livewire updates the selected value
            $('#tagSelect').on('select2:select', function (e) {
                let data = e.params.data;
                @this.set('selectedTag', data.id);
            });
        }
    
        $(document).ready(function() {
            initSelect2();
        });
    
        // Reinitialize Select2 after Livewire DOM updates
        document.addEventListener('livewire:load', function () {
            Livewire.hook('message.processed', (message, component) => {
                initSelect2();
            });
        });
    </script> --}}

    <script>
        $('#assetTypeSelect').select2({
            tags: true, // Allow adding new asset types
            tokenSeparators: [','],
            placeholder: "Select or search asset type",
            allowClear: true,
            minimumInputLength: 1, // Enables searching
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') { return null; }
                return { id: term, text: term, newTag: true };
            }
        });
        
        document.addEventListener('DOMContentLoaded', function () {
          const ownershipTypeSelect = document.getElementById('ownership_type');
          const partnerSelect = document.getElementById('partner_id');
      
          function togglePartnerSelect() {
            const selectedOwnershipType = ownershipTypeSelect.value;
            partnerSelect.disabled = selectedOwnershipType === 'owned'; // Disable if 'owned'
            if (selectedOwnershipType === 'owned') {
              partnerSelect.value = ''; // Reset partner if ownership is 'owned'
            }
          }
      
          // Initial check on page load
          togglePartnerSelect();
      
          // Event listener for ownership type change
          ownershipTypeSelect.addEventListener('change', togglePartnerSelect);
        });

        // $('#types').select2({
        //     tags: true, // Enable tags for new values
        //     // maximumSelectionLength: 2
        // });

        // Initialize Select2 with tag support
        // $('#type').select2({
        //     tags: true,
        //     tokenSeparators: [',', ' '],
        //     createTag: function(params) {
        //         return {
        //             id: params.term,
        //             text: params.term,
        //             newTag: true
        //         };
        //     }
        // });

        $('#reporter-dropdown').select2({
            tags: true, // Enable tags for new values
            // maximumSelectionLength: 2
        });

        $('#location_id').select2({
            tags: true, // Enable tags for new values
            // maximumSelectionLength: 2
        });
        $('#manufacture').select2({
            tags: true, // Enable tags for new values
            // maximumSelectionLength: 2
        });
      </script>
        
    @endpush
</div>
