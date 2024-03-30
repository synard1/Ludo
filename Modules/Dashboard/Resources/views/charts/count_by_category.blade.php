<div class="card-header collapsible cursor-pointer rotate">
    <h3 class="card-title">Total Data by Category </h3>
</div>
<div id="kt_docs_card_workorder_list" class="collapse show">
<!--begin::Card body-->
<div class="card-body py-4">
    <div>
        <label for="filterMonth">Filter by Month:</label>
        <select id="filterMonth1">
            @foreach($months as $key => $month)
                <option value="{{ $key }}">{{ $month }}</option>
            @endforeach
        </select>

        <label for="filterYear">Filter by Year:</label>
        <input type="number" id="filterYear" value="{{ date('Y') }}" min="1900" max="2099">
        <button type="button" onclick="fetchData2()">Submit</button>

        <canvas id="chartCountCategory" width="400" height="400"></canvas>
    </div>
    <!--begin::Table-->
    <div class="container">
        <canvas id="chartCountCategory"></canvas>
    </div>
    <!--end::Table-->
</div>
<!--end::Card body-->
</div>


@push('scripts')
<script>

var chartCountCategory; // Declare a variable to store the chart instance
var art = @json($artValue);
var artH = art / 2;
// console.log(art);

function fetchData2() {
var selectedMonth = document.getElementById('filterMonth1').value;
var selectedYear = document.getElementById('filterYear').value;
var task = 'GET_CATEGORY_COUNT';
var type = 'chart';

// Destroy the previous chart instance if it exists
if (chartCountCategory) {
    chartCountCategory.destroy();
}

// Define the base URL
// const baseUrl = '/apps/dashboard/api/fetch-data/chart';

// // Define the task variable
// const task = 'GET_BY_STAFF';

// // Build the URL based on the task variable
// const url = `${baseUrl}?month=${selectedMonth}&year=${selectedYear}${task ? `&task=${task}` : ''}`;

// Fetch data using the constructed URL
fetch(`/apps/dashboard/api/fetch-data/report?month=${selectedMonth}&year=${selectedYear}&task=${task}&type=${type}`)
    .then(response => response.json())
    .then(data => {
        // console.log(data);
        updateChartCountCategory(data);
    });
}

function updateChartCountCategory(data) {
var ctx1 = document.getElementById('chartCountCategory').getContext('2d');

// Assuming data is an array of average times
var avgTimes = data.map(entry => Math.min(entry.avg_time));

// Add logic for coloring bars based on average time
// var backgroundColors = avgTimes.map(function (avgTime) {
// if (avgTime > artH && avgTime <= art) {
//     return 'rgba(255, 255, 0, 0.2)'; // Yellow
// } else if (avgTime > art) {
//     return 'rgba(255, 0, 0, 0.2)'; // Red
// } else {
//     return 'rgba(75, 192, 192, 0.2)'; // Default color
// }
// });

var borderColor = 'rgba(75, 192, 192, 1)'; // Default border color

var chartData1 = {
labels: data.map(entry => entry.category_name),
datasets: [{
    label: 'Total data',
    data: data.map(entry => Math.min(entry.category_count)),
    // backgroundColor: backgroundColors,
    borderColor: borderColor,
    borderWidth: 1
}]
};

chartCountCategory = new Chart(ctx1, {
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