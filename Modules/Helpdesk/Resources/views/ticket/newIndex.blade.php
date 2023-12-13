<x-default-layout>
    <div class="card">
        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">Tickets List</h3>
            <div class="card-toolbar">
                <!--begin::Menu-->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_new_ticket">
                    <i class="ki-duotone ki-plus fs-2"></i> New Ticket
                </button>
                <!--end::Menu-->
            </div>
        </div>
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            {{ $dataTable->table() }}
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
        {{ $dataTable->scripts() }}
    @endpush

</x-default-layout>
