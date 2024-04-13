<div class="card-header collapsible cursor-pointer rotate">
    <h3 class="card-title">Resolve Time Hardware Network < 120 Minutes </h3>
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
        <button type="button" onclick="fetchDataResolveHN()">Submit</button>

        <canvas id="chartResolveHn" width="400" height="400"></canvas>
    </div>
</div>
<!--end::Card body-->
</div>


@push('scripts')
<script>

var chartResolveHn; // Declare a variable to store the chart instance
// var arth = @json($arthValue);

function fetchDataResolveHN() {
    var selectedMonth = document.getElementById('filterMonth').value;
    var selectedYear = document.getElementById('filterYear').value;
    var task = 'GET_RESOLVE_TIME_HN';
    var type = 'chart';

    // Destroy the previous chart instance if it exists
    if (chartResolveHn) {
        chartResolveHn.destroy();
    }

    fetch(`/apps/dashboard/api/fetch-data/report?month=${selectedMonth}&year=${selectedYear}&task=${task}&type=${type}`)
    // fetch(`/apps/dashboard/api/fetch-data/report?month=${selectedMonth}&year=${selectedYear}`)
        .then(response => response.json())
        .then(response => {
            // console.log(response);
            updateChartResponseHn(response);

        });
}

// Function to calculate the maximum limit dynamically
function calculateMaxLimit(totalData) {
    const warningLimit = 10; // Set a default warning limit
    const increaseFactor = 1.5; // Adjust the factor as needed

    // Calculate the maximum limit dynamically
    return totalData > warningLimit ? Math.ceil(totalData * increaseFactor) : warningLimit;
}

function updateChartResponseHn(response) {
    var ctx = document.getElementById('chartResolveHn').getContext('2d');

    var chartDataResolveHn = {
        labels: response.map(entry => entry.name),
        datasets: [
            {
                label: 'Under 120',
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'blue',
                data: response.map(entry => Math.min(entry.under)),
            },
            {
                label: 'Upper 120',
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'red',
                data: response.map(entry => Math.min(entry.upper)),
            },
        ],
    };

    // Calculate maxlimit
    var totalUnder = response.reduce((sum, entry) => sum + entry.under, 0);
    var totalUpper = response.reduce((sum, entry) => sum + entry.upper, 0);

    // Get the total data count
    const totalData = totalUnder + totalUpper;

    // Calculate the maximum limit based on the total data count
    var maxLimit;

    // Calculate the maximum limit dynamically
    maxLimit = calculateMaxLimit(totalData);

    chartResolveHn = new Chart(ctx, {
        type: 'line',
        data: chartDataResolveHn,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: maxLimit, // Set the maximum value on the y-axis
                }
            },
        }
    });
}

</script>
@endpush