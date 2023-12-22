        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">Mean Time to Response ( MTTR ) KPI < 60 Minutes </h3>
        </div>
        <div id="kt_docs_card_workorder_list" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body py-4">
            <div>
                <label for="filterMonth">Filter by Month:</label>
                <select id="filterMonth">
                    @foreach($months as $key => $month)
                        <option value="{{ $key }}">{{ $month }}</option>
                    @endforeach
                </select>

                <label for="filterYear">Filter by Year:</label>
                <input type="number" id="filterYear" value="{{ date('Y') }}" min="1900" max="2099">
                <button type="button" onclick="fetchData()">Submit</button>

                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
            <!--begin::Table-->
            <div class="container">
                <canvas id="myChart"></canvas>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
        </div>

    
    @push('scripts')
    <script>

    var myChart; // Declare a variable to store the chart instance


        // document.getElementById('filterMonth').addEventListener('change', function () {
        //     fetchData();
        // });

        // document.getElementById('filterYear').addEventListener('input', function () {
        //     fetchData();
        // });

        function fetchData() {
            var selectedMonth = document.getElementById('filterMonth').value;
            var selectedYear = document.getElementById('filterYear').value;

            // Destroy the previous chart instance if it exists
            if (myChart) {
                myChart.destroy();
            }

            fetch(`/apps/dashboard/api/fetch-data/AverageTimeBySourceReport?month=${selectedMonth}&year=${selectedYear}`)
                .then(response => response.json())
                .then(tickets => {
                    updateChart(tickets);
                });
        }

        function updateChart(tickets) {
            var ctx = document.getElementById('myChart').getContext('2d');

            var chartData = {
                labels: tickets.map(entry => entry.source_report),
                datasets: [{
                    label: 'Average Time (minutes)',
                    data: tickets.map(entry => Math.min(entry.avg_time)), // Set max value to 60 minutes
                    // data: tickets.map(entry => Math.min(entry.avg_time, 60)), // Set max value to 60 minutes
                    backgroundColor: tickets.map(entry => entry.avg_time > 60 ? 'red' : 'blue'), // Set color to red if > 60 minutes
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            myChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 60 // Set max value on the y-axis to 60 minutes
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                annotation: {
                    annotations: [{
                        type: 'line',
                        mode: 'horizontal',
                        scaleID: 'y',
                        value: 60,
                        borderColor: 'red',
                        borderWidth: 2,
                        label: {
                            content: 'KPI < 60 minutes',
                            enabled: true,
                            position: 'end'
                        }
                    }]
                }
            }
        });
        }

        // Initial data load
        // fetchData();
    </script>
    {{-- <script>
        var ctx = document.getElementById('myChart').getContext('2d');
    
        var data = {!! json_encode($data) !!};
    
        var chartData = {
            labels: data.map(entry => entry.source_report),
            datasets: [{
                label: 'Average Time (minutes)',
                data: data.map(entry => Math.min(entry.avg_time, 60)), // Set max value to 60 minutes
                backgroundColor: data.map(entry => entry.avg_time > 60 ? 'red' : 'blue'), // Set color to red if > 60 minutes
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };
    
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 60 // Set max value on the y-axis to 60 minutes
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                annotation: {
                    annotations: [{
                        type: 'line',
                        mode: 'horizontal',
                        scaleID: 'y',
                        value: 60,
                        borderColor: 'red',
                        borderWidth: 2,
                        label: {
                            content: 'KPI < 60 minutes',
                            enabled: true,
                            position: 'end'
                        }
                    }]
                }
            }
        });
    </script> --}}
    @endpush