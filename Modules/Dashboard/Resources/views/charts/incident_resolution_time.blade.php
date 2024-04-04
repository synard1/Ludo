<x-default-layout>
    <div class="card shadow-sm mb-5">
        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">Work Order List</h3>
        </div>
        <div id="kt_docs_card_workorder_list" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="container">
                <canvas id="incidentResolutionTimeChart"></canvas>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
        </div>
    </div>

    
    @push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('incidentResolutionTimeChart').getContext('2d');
            var data = @json($data);

            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        label: 'Average Response Time',
                        data: Object.values(data),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    @endpush

</x-default-layout>
