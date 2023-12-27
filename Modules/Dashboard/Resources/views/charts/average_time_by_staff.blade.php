        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">Average Resolution Time SLA < 120 Minutes </h3>
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
                <button type="button" onclick="fetchData2()">Submit</button>

                <canvas id="myChart1" width="400" height="400"></canvas>
            </div>
            <!--begin::Table-->
            <div class="container">
                <canvas id="myChart1"></canvas>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
        </div>

    
    @push('scripts')
    <script>

    var myChart1; // Declare a variable to store the chart instance
    function fetchData2() {
        var selectedMonth = document.getElementById('filterMonth').value;
        var selectedYear = document.getElementById('filterYear').value;

        // Destroy the previous chart instance if it exists
        if (myChart1) {
            myChart1.destroy();
        }

        fetch(`/apps/dashboard/api/fetch-data/AverageTimeByStaff?month=${selectedMonth}&year=${selectedYear}`)
            .then(response => response.json())
            .then(data => {
                updateChart1(data);
            });
    }

    function updateChart1(data) {
    var ctx1 = document.getElementById('myChart1').getContext('2d');

    // Assuming data is an array of average times
    var avgTimes = {!! json_encode(array_column($avgTimes, 'avg_time')) !!};

    // Add logic for coloring bars based on average time
    var backgroundColors = avgTimes.map(function (avgTime) {
        if (avgTime > 60 && avgTime <= 90) {
            return 'rgba(255, 255, 0, 0.2)'; // Yellow
        } else if (avgTime > 90) {
            return 'rgba(255, 0, 0, 0.2)'; // Red
        } else {
            return 'rgba(75, 192, 192, 0.2)'; // Default color
        }
    });

    var borderColor = 'rgba(75, 192, 192, 1)'; // Default border color

    var chartData1 = {
        labels: {!! json_encode(array_column($avgTimes, 'staff')) !!},
        datasets: [{
            label: 'Average Time (minutes)',
            data: avgTimes,
            backgroundColor: backgroundColors,
            borderColor: borderColor,
            borderWidth: 1
        }]
    };

    myChart1 = new Chart(ctx1, {
        type: 'bar',
        data: chartData1,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}


    // Initial data load
    // fetchData2();
    </script>
    @endpush