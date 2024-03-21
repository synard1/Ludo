<x-default-layout>

    <div class="card">

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            {{ $dataTable->table() }}
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    <livewire:permission.assign-permissions></livewire:permission.assign-permissions>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            document.addEventListener('livewire:load', function () {
                Livewire.on('success', function () {
                    $('#kt_modal_assign_permission').modal('hide');
                    window.LaravelDataTables['usersassingedpermission-table'].ajax.reload();
                });
            });
        </script>
    @endpush

</x-default-layout>
