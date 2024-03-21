<div class="card-header collapsible cursor-pointer rotate">
    <h3 class="card-title">Response Time < 30 Minutes </h3>
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
        <button type="button" onclick="fetchDataResponse()">Submit</button>

        <canvas id="chartResponseTimeTotal" width="400" height="400"></canvas>
    </div>
</div>
<!--end::Card body-->
</div>


@push('scripts')
<script>

var chartResponseTimeTotal; // Declare a variable to store the chart instance
// var arth = @json($arthValue);

function fetchDataResponse() {
    var selectedMonth = document.getElementById('filterMonth').value;
    var selectedYear = document.getElementById('filterYear').value;
    var task = 'GET_RESPONSE_TIME';
    var type = 'chart';

    // Destroy the previous chart instance if it exists
    if (chartResponseTimeTotal) {
        chartResponseTimeTotal.destroy();
    }

    fetch(`/apps/dashboard/api/fetch-data/report?month=${selectedMonth}&year=${selectedYear}&task=${task}&type=${type}`)
    // fetch(`/apps/dashboard/api/fetch-data/report?month=${selectedMonth}&year=${selectedYear}`)
        .then(response => response.json())
        .then(response => {
            // console.log(response);
            updateChartResponse(response);

        });
}

function updateChartResponse(response) {
    var ctx = document.getElementById('chartResponseTimeTotal').getContext('2d');

    var chartDataResponse = {
        labels: response.map(entry => entry.name),
        datasets: [
            {
                label: 'Under 30',
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'blue',
                data: response.map(entry => Math.min(entry.under)),
            },
            {
                label: 'Upper 30',
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'red',
                data: response.map(entry => Math.min(entry.upper)),
            },
        ],
    };

    // Calculate maxlimit
    var totalUnder = response.reduce((sum, entry) => sum + entry.under, 0);
    var totalUpper = response.reduce((sum, entry) => sum + entry.upper, 0);
    var maxlimit = totalUnder + totalUpper;

    chartResponseTimeTotal = new Chart(ctx, {
        type: 'line',
        data: chartDataResponse,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: maxlimit, // Set the maximum value on the y-axis
                }
            },
        }
    });
}

</script>
@endpush