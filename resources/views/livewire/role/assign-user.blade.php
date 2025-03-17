<div class="modal fade" id="kt_modal_assign_role" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Assign User</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 my-7">
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold form-label mb-2">
                        <span class="required">User</span>
                        <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Choose new user to assign to this roles.">
                            {!! getIcon('information','fs-7') !!}
                        </span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select wire:model="user_id" class="form-control form-control-solid">
                        <option value="">-- Choose user --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <!-- <input class="form-control form-control-solid" placeholder="Enter a permission name" name="name" wire:model="name"/> -->
                    <!--end::Input-->
                    @error('name')
                    <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <!-- <input type="hidden" class="form-control form-control-solid" placeholder="Enter a permission name" name="name" wire:model="role_id" value="{{ $role }}"/> -->
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold form-label mb-2">
                        <span class="required">Role</span>
                        <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Choose role">
                            {!! getIcon('information','fs-7') !!}
                        </span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select wire:model="selectedRole" class="form-control form-control-solid">
                        <option value="">-- Choose Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <!-- <input class="form-control form-control-solid" placeholder="Enter a permission name" name="name" wire:model="name"/> -->
                    <!--end::Input-->
                    @error('name')
                    <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <!-- <input type="hidden" class="form-control form-control-solid" placeholder="Enter a permission name" name="name" wire:model="role_id" value="{{ $role }}"/> -->
                <!--end::Input group-->

                <!--begin::Form-->
                <!-- <div class="form-group">
                    <label for="user">User</label>
                    <select wire:model="user_id">
                        <option value="">-- Choose user --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div> -->

    <!-- <div class="form-group">
        <label for="role">Role</label>
        <select wire:model="role_id">
            <option value="">-- Choose role --</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div> -->

    <button wire:click="updateRole">Update Role</button>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

@push('scripts')
    <script>
        const modAs = document.querySelector('#kt_modal_assign_role');

        modAs.addEventListener('show.bs.modal', (e) => {
            // Livewire.emit('modal.show.role_name', e.relatedTarget.getAttribute('data-role-id'));
        });
    </script>
    <script>
            document.addEventListener('livewire:load', function () {
                Livewire.on('success', function () {
                    $('#kt_modal_assign_role').modal('hide');
                    window.LaravelDataTables['usersassingedrole-table'].ajax.reload();
                });
            });
        </script>
@endpush
