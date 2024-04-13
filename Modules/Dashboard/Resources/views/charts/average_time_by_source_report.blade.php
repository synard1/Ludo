        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">Mean Time to Response ( MTTR ) SLA < {{$mttrValue}} Minutes </h3>
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

                <canvas id="myChartSource" width="400" height="400"></canvas>
            </div>
            <!--begin::Table-->
            <div class="container">
                <canvas id="myChartSource"></canvas>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
        </div>

    
    @push('scripts')
    <script>

    var myChartSource; // Declare a variable to store the chart instance
    var mttr = @json($mttrValue);
    console.log('mttr : '+mttr);

        function fetchData() {
            var selectedMonth = document.getElementById('filterMonth').value;
            var selectedYear = document.getElementById('filterYear').value;

            // Destroy the previous chart instance if it exists
            if (myChartSource) {
                myChartSource.destroy();
            }

            fetch(`/apps/dashboard/api/fetch-data/AverageTimeBySourceReport?month=${selectedMonth}&year=${selectedYear}`)
                .then(response => response.json())
                .then(response => {
                    updateChartSource(response);
                    console.log(response);
                });
        }

        function updateChartSource(response) {
            var ctx = document.getElementById('myChartSource').getContext('2d');

            var chartDataSource = {
                labels: response.map(entry => entry.source),
                datasets: [{
                    label: 'Average Time (minutes)',
                    data: response.map(entry => Math.min(entry.avg_time)), // Set max value to 60 minutes
                    // data: response.map(entry => Math.min(entry.avg_time, 60)), // Set max value to 60 minutes
                    backgroundColor: response.map(entry => entry.avg_time > mttr ? 'red' : 'blue'), // Set color to red if > 60 minutes
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            myChartSource = new Chart(ctx, {
            type: 'bar',
            data: chartDataSource,
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
    </script>
    @endpush