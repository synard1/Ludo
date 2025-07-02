<div class="card shadow-sm mb-5">
    <div class="card-header collapsible cursor-pointer rotate">
        <h3 class="card-title" id="incidentTitleForm">New Incident Report</h3>
        <div class="card-toolbar rotate-180">
            <i class="ki-duotone ki-down fs-1"></i>
        </div>
    </div>
    <div id="kt_docs_card_asset_new" class="collapse">
        <form id="kt_new_asset_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
            <div class="card-body p-9">

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
                    <div class="col fv-row">
                        <label class="form-label">Reported By:</label>
                        <div class="input-group">
                            <div class="col-lg-8 fv-row">
                                <select wire:model="selectedAssetType" id="assetTypeSelect" class="js-select2 form-control" wire:ignore>
                                    <option value="">-- Select Asset Type --</option>
                                    @foreach ($assetType as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
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
                        <select wire:model="manufacturer_id" id="manufacture" class="js-select2 form-control">
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

                    <div class="col-md-4">
                        <label for="department_id" class="form-label">Department:</label>
                        <select wire:model="department_id" id="department_id" class="js-select2 form-control">
                            <option value="">-- Select Department --</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
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
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status:</label>
                        <select wire:model="status" id="status" class="form-control" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="loaned">Loaned</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2 btn-cancel" id="kt_new_incident_cancel">Discard</button>
                <button type="submit" id="kt_new_incident_submit" class="btn btn-primary">
                    @include('partials/general/_button-indicator', ['label' => 'Save Changes'])
                </button>
            </div>
            <input type="hidden">
        </form>
    </div>
</div>