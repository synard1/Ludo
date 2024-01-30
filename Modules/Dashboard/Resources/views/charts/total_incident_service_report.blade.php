        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">Total Incident Service Report </h3>
        </div>
        <div id="kt_docs_card_workorder_list" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body py-4">
            <div>
                <canvas id="lineChart" width="400" height="200"></canvas>
            </div>
            <!-- Create a dropdown for time range selection -->
<select id="timeRange">
    <option value="day">Day</option>
    <option value="week">Week</option>
    <option value="month">Month</option>
</select>
        </div>
        <!--end::Card body-->
        </div>

    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var lineChart;

$(document).ready(function () {

    // Fetch initial data using Ajax
    fetchData('day');

    // Add change event listener to the dropdown
    $('#timeRange').change(function () {
        var selectedRange = $(this).val();
        fetchData(selectedRange);
    });


        // Function to fetch data based on the selected date filter
        function fetchData(timeRange) {
            console.log('test load data');
        $.ajax({
            url: '/apps/dashboard/api/fetch-data/IncidentService',
            type: 'GET',
            data: {
                // data: { timeRange: timeRange },
                filter: timeRange,
            },
            success: function (data) {
                if (data && data.incidentData && data.serviceData) {
                        renderChart(data, timeRange);
                    } else {
                        console.error('Invalid data format:', data);
                    }
                // renderChart(response.data);
                // updateChart();

        },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
        
    }

// Function to group data by week
function groupDataByWeek(data) {
    const groupedData = {};

    data.forEach(item => {
        const weekNumber = moment(item.date).week();
        if (!groupedData[weekNumber]) {
            groupedData[weekNumber] = { week: weekNumber, total: 0 };
        }
        groupedData[weekNumber].total += item.total;
    });

    // Convert the grouped data object to an array
    const result = Object.values(groupedData);

    return result;
}

    // Adjust the renderChart function to handle 'week' filter
function renderChart(data, filterType) {
    // Define labels based on the filter type
    var labels = [];
    var incidentData = [];
    var serviceData = [];

    // Destroy the previous chart instance if it exists
    if (lineChart) {
        console.log('ada chart');
        lineChart.destroy();
    }

    // Check the filter type and set labels accordingly
    if (filterType === 'day') {
        labels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    } else if (filterType === 'month') {
        labels = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
    } else if (filterType === 'week') {
        // Use getWeekLabels function for week filter
        labels = getWeekLabels(data.incidentData);
    }

    // Initialize counts for all labels to zero
    incidentData = Array(labels.length).fill(0);
    serviceData = Array(labels.length).fill(0);

    // Fill in counts for labels where you have data
    data.incidentData.forEach(function (item) {
        var index = labels.indexOf(filterType === 'day' ? item.day : (filterType === 'week' ? `Week ${item.week}` : item.month));
        if (index !== -1) {
            incidentData[index] = item.total;
        }
    });

    data.serviceData.forEach(function (item) {
        var index = labels.indexOf(filterType === 'day' ? item.day : (filterType === 'week' ? `Week ${item.week}` : item.month));
        if (index !== -1) {
            serviceData[index] = item.total;
        }
    });

    // Set a maximum limit for the chart when filtering by day
    // var maxLimit = filterType === 'day' ? 10 : null;
    var maxLimit;
    switch (filterType) {
        case 'day':
            maxLimit = 10;
            break;
        case 'week':
            maxLimit = 15;
            break;
        case 'month':
            maxLimit = 25;
            break;
        default:
            maxLimit = null;
    }

    // Create a line chart
    var ctx = document.getElementById('lineChart').getContext('2d');
    lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Incident Total',
                    borderColor: 'rgb(75, 192, 192)',
                    data: incidentData,
                },
                {
                    label: 'Service Total',
                    borderColor: 'rgb(255, 99, 132)',
                    data: serviceData,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    max: maxLimit, // Set the maximum limit for the y-axis
                },
            },
        },
    });
}

// Function to get time labels based on the selected filter
function getTimeLabels(data) {
            if ($('#filter').val() === 'day') {
                return data.incidentData.map(item => item.day);
            } else {
                return ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            }
        }

        // Function to fill data array with zeros for missing days
        function fillDataArray(dataArray, timeLabels) {
            var filledArray = Array(timeLabels.length).fill(0);

            dataArray.forEach(function (item) {
                var index = timeLabels.indexOf(item.day);
                if (index !== -1) {
                    filledArray[index] = item.total;
                }
            });

            return filledArray;
        }

        // Function to get week labels
function getWeekLabels(data) {
    // Extract unique week numbers from the data
    const weekNumbers = [...new Set(data.map(item => item.week))];
    // Convert week numbers to labels
    return weekNumbers.map(weekNumber => `Week ${weekNumber}`);
}

    });


    </script>
    @endpush