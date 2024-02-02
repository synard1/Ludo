<div class="card-header collapsible cursor-pointer rotate">
    <h3 class="card-title">Average Resolution HIS Report < {{$arthValue}} Minutes </h3>
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
        <button type="button" onclick="fetchDataHis()">Submit</button>

        <canvas id="myChartHis" width="400" height="400"></canvas>
    </div>
    <!--begin::Table-->
    <div class="container">
        <canvas id="myChartHis"></canvas>
    </div>
    <!--end::Table-->
</div>
<!--end::Card body-->
</div>


@push('scripts')
<script>

var myChartHis; // Declare a variable to store the chart instance
var arth = @json($arthValue);

function fetchDataHis() {
    var selectedMonth = document.getElementById('filterMonth').value;
    var selectedYear = document.getElementById('filterYear').value;

    // Destroy the previous chart instance if it exists
    if (myChartHis) {
        myChartHis.destroy();
    }

    fetch(`/apps/dashboard/api/fetch-data/AverageTimeHisReport?month=${selectedMonth}&year=${selectedYear}`)
        .then(response => response.json())
        .then(tickets => {
            console.log(tickets.filteredData);
            updateChartHis(tickets);

        });
}

function updateChartHis(tickets) {
    var ctx = document.getElementById('myChartHis').getContext('2d');

    var chartData = {
        labels: tickets.map(entry => entry.name),
        // labels: "HIS",
        datasets: [{
            label: 'Total Data',
            data: tickets.map(entry => Math.min(entry.total)), // Set max value to 60 minutes
            backgroundColor: 'blue', // Set color to red if > 60 minutes
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    myChartHis = new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: {
        scales: {
            y: {
                beginAtZero: true,
            }
        },
        // plugins: {
        //     legend: {
        //         display: true,
        //         position: 'top'
        //     }
        // },
    }
});
}

</script>
@endpush