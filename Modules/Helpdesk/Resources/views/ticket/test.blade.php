<x-default-layout>
    <div class="card shadow-sm mb-5">
        <div id="kt_docs_card_ticket_list" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body py-4">
            <button id="test-button">Test Broadcasting</button>
        </div>
        <!--end::Card body-->
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('test-button').addEventListener('click', () => {
            axios.post('/apps/helpdesk/broadcast-test').then(response => {
                console.log(response.data);
            });
        });
    </script>
    @endpush

</x-default-layout>
