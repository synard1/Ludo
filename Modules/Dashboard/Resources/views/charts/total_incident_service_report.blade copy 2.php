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
    <option value="year">Year</option>
</select>
        </div>
        <!--end::Card body-->
        </div>

    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

$(document).ready(function () {
    // var lineChart; // Declare a variable to store the chart instance

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
                        renderChart(data);
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


    // Function to render the chart
// function renderChart(data) {

//     // Define all months
//     var allMonths = [
//         'January', 'February', 'March', 'April', 'May', 'June',
//         'July', 'August', 'September', 'October', 'November', 'December'
//     ];

//     // Clear the existing chart canvas
//     var chartCanvas = document.getElementById('lineChart');
//     var parent = chartCanvas.parentNode;
//     parent.innerHTML = '';
//     var newCanvas = document.createElement('canvas');
//     newCanvas.id = 'lineChart';
//     parent.appendChild(newCanvas);


//     console.log('data : ' + data.incidentData);

//     var incidentData = data.incidentData || []; // Ensure incidentData is an array
//     var serviceData = data.serviceData || []; // Ensure serviceData is an array

//     // Initialize counts for all months to zero
//     var incidentTotal = Array(allMonths.length).fill(0);
//     var serviceTotal = Array(allMonths.length).fill(0);

//     // Fill in counts for months where you have data
//     if (Array.isArray(incidentData)) {
//         incidentData.forEach(function (item) {
//             var index = allMonths.indexOf(item.month);
//             if (index !== -1) {
//                 incidentTotal[index] = item.total;
//             }
//         });
//     }

//     if (Array.isArray(serviceData)) {
//         serviceData.forEach(function (item) {
//             var index = allMonths.indexOf(item.month);
//             if (index !== -1) {
//                 serviceTotal[index] = item.total;
//             }
//         });
//     }

//     // Create a line chart
//     var ctx = newCanvas.getContext('2d');
//     new Chart(ctx, {
//         type: 'line',
//         data: {
//             labels: allMonths,
//             datasets: [
//                 {
//                     label: 'Incident Total',
//                     borderColor: 'rgb(75, 192, 192)',
//                     data: incidentTotal,
//                 },
//                 {
//                     label: 'Service Total',
//                     borderColor: 'rgb(255, 99, 132)',
//                     data: serviceTotal,
//                 },
//             ],
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             scales: {
//                 y: {
//                     beginAtZero: true, // Start the y-axis from zero
//                 },
//             },
//         },
//     });

//     // Create a line chart
//     // var ctx = document.getElementById('lineChart').getContext('2d');
//     // lineChart = new Chart(ctx, {
//     //     type: 'line',
//     //     data: {
//     //         labels: allMonths,
//     //         datasets: [
//     //             {
//     //                 label: 'Incident Total',
//     //                 borderColor: 'rgb(75, 192, 192)',
//     //                 data: incidentTotal,
//     //             },
//     //             {
//     //                 label: 'Service Total',
//     //                 borderColor: 'rgb(255, 99, 132)',
//     //                 data: serviceTotal,
//     //             },
//     //         ],
//     //     },
//     //     options: {
//     //         responsive: true,
//     //         maintainAspectRatio: false,
//     //         scales: {
//     //             y: {
//     //                 beginAtZero: true, // Start the y-axis from zero
//     //             },
//     //         },
//     //     },
//     // });
// }
    // function renderChart(data) {
    //     var incidentData = data.incidentData;
    //     var serviceData = data.serviceData;

    //     // Extract labels and datasets from the data
    //     var labels = incidentData.map(function (item) {
    //         return item.month;
    //     });

    //     var incidentTotal = incidentData.map(function (item) {
    //         return item.total;
    //     });

    //     var serviceTotal = serviceData.map(function (item) {
    //         return item.total;
    //     });

    //     // Create a line chart
    //     var ctx = document.getElementById('lineChart').getContext('2d');
    //     var lineChart = new Chart(ctx, {
    //         type: 'line',
    //         data: {
    //             labels: labels,
    //             datasets: [
    //                 {
    //                     label: 'Incident Total',
    //                     borderColor: 'rgb(75, 192, 192)',
    //                     data: incidentTotal,
    //                 },
    //                 {
    //                     label: 'Service Total',
    //                     borderColor: 'rgb(255, 99, 132)',
    //                     data: serviceTotal,
    //                 },
    //             ],
    //         },
    //         options: {
    //             responsive: true,
    //             maintainAspectRatio: false,
    //             scales: {
    //                     y: {
    //                         beginAtZero: true
    //                     }
    //             },
    //         },
    //     });
    // }

        // Initial data fetch on page load
        // fetchData('daily');

            // Example function to fetch data based on filter values
// function fetchDataBasedOnFilter() {
//     // Implement logic to fetch data based on the selected filter
//     // For simplicity, returning static data here, replace with your logic
//     return {
//         incidentData: [
//             { month: 'January', total: 5 },
//             { month: 'February', total: 10 },
//             // ... more data
//         ],
//         serviceData: [
//             { month: 'January', total: 3 },
//             { month: 'February', total: 8 },
//             // ... more data
//         ],
//     };
// }

// Function to render the chart
function renderChart(data) {
            var labels = [];
            var incidentData = [];
            var serviceData = [];

            var allDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var labels = allDays.slice(); // Create a copy of allDays
            var incidentData = Array(allDays.length).fill(0);
            var serviceData = Array(allDays.length).fill(0);

            // Extract day names and totals from the data
            // data.incidentData.forEach(function (item) {
            //     labels.push(item.day);
            //     incidentData.push(item.total);
            // });

            // data.serviceData.forEach(function (item) {
            //     serviceData.push(item.total);
            // });

            // Fill in counts for days where you have data
            data.incidentData.forEach(function (item) {
                var index = allDays.indexOf(item.day);
                if (index !== -1) {
                    incidentData[index] = item.total;
                }
            });

            data.serviceData.forEach(function (item) {
                var index = allDays.indexOf(item.day);
                if (index !== -1) {
                    serviceData[index] = item.total;
                }
            });

            // Create a line chart
            var ctx = document.getElementById('lineChart').getContext('2d');
            var lineChart = new Chart(ctx, {
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
                            beginAtZero: true,
                        },
                    },
                },
            });
        }

        // Initial chart rendering when the page loads
        // fetchDataBasedOnFilter();

// Function to update the chart on filter change
function updateChart() {
    // Fetch updated data based on the new filter values
    // This might involve making an AJAX request to the server
    var newData = fetchDataBasedOnFilter();

    // Render the updated chart with the new data
    renderChart(newData);
}
    });


    </script>
    @endpush