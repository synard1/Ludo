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
    // Fetch initial data using Ajax
    fetchData('day');

    // Add change event listener to the dropdown
    $('#timeRange').change(function () {
        var selectedRange = $(this).val();
        fetchData(selectedRange);
    });

});

        // var ctx = document.getElementById('incidentServiceChart').getContext('2d');
        // Assuming you have a canvas with id 'myChart' in your HTML
        // var myChart12 = new Chart(ctx, {
        //     type: 'line',
        //     data: {
        //         labels: [],
        //         datasets: [{
        //             label: 'Incidents',
        //             data: [],
        //             borderColor: 'rgba(255, 99, 132, 1)',
        //             borderWidth: 2,
        //             fill: false
        //         }, {
        //             label: 'Services',
        //             data: [],
        //             borderColor: 'rgba(75, 192, 192, 1)',
        //             borderWidth: 2,
        //             fill: false
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             x: {
        //                 type: 'linear',
        //                 position: 'bottom'
        //             }
        //         }
        //     }
        // });

        // Function to fetch data based on the selected date filter
        function fetchData(selectedFilter) {
            console.log('test load data');
            // Make an AJAX request to Laravel route to get data
        //     axios.get('/apps/dashboard/api/fetch-data/IncidentService', {
        //         // params: {
        //         //     dateFilter: selectedFilter
        //         // }
        //     })
        //     .then(function (data) {
        //         // For demonstration, let's assume data is an array of objects
        //         // where each object has a 'date' and 'count' property
        //         var labels = data.map(item => item.date);
        //         var incidentsData = data.map(item => item.incidents);
        //         var servicesData = data.map(item => item.services);

        //         // Update the chart data
        //         myChart12.data.labels = labels;
        //         myChart12.data.datasets[0].data = incidentsData;
        //         myChart12.data.datasets[1].data = servicesData;
        //         myChart12.update();
        //     })
        //     .catch(function (error) {
        //         console.error('Error fetching data:', error);
        //     });
        // }
        $.ajax({
            url: '/apps/dashboard/api/fetch-data/IncidentService',
            type: 'GET',
            data: {
                // dateFilter: 'dateFilter'
            },
            success: function (data) {
                renderChart(data);
            // const months = response.data.map(entry => entry.month);
            // const totals = response.data.map(entry => entry.total);

            // var myChart = new Chart(ctx, {
            //     type: 'line',
            //     data: {
            //         labels: months,
            //         datasets: [{
            //             label: 'Total Data',
            //             data: totals,
            //             borderColor: 'rgba(75, 192, 192, 1)', // Customize the color
            //             borderWidth: 2
            //         }]
            //     },
            //     options: {
            //         scales: {
            //             y: {
            //                 beginAtZero: true
            //             }
            //         }
            //     }
            // });
        },
        //     success: function (response) {
        //     let dataArray;

        //     // Check if the response is an array
        //     if (Array.isArray(response)) {
        //         dataArray = response;
        //     } else if (typeof response === 'object') {
        //         // If the response is an object, convert it to an array
        //         dataArray = Object.values(response);
        //     } else {
        //         // Handle other data types if needed
        //         console.error('Unexpected data type:', typeof response);
        //         return;
        //     }

        //     // Use map on the array
        //     dataArray.map(item => {
        //         // Your mapping logic here
        //         console.log(item);
        //     });
        // },
            // success: function (data) {
            //     console.log('data : ' + data);
            //     // For demonstration, let's assume data is an array of objects
            //     // where each object has a 'date' and 'count' property
            //     var labels = data.map(item => item.date);
            //     var incidentsData = data.map(item => item.incidents);
            //     var servicesData = data.map(item => item.services);

            //     // Update the chart data
            //     myChart12.data.labels = labels;
            //     myChart12.data.datasets[0].data = incidentsData;
            //     myChart12.data.datasets[1].data = servicesData;
            //     myChart12.update();
            // },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
        
    }


    // Function to render the chart
    function renderChart(data) {
        // Define all months
        var allMonths = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        var incidentData = data.incidentData;
        var serviceData = data.serviceData;

        // Initialize counts for all months to zero
        var incidentTotal = Array(allMonths.length).fill(0);
        var serviceTotal = Array(allMonths.length).fill(0);

        // Fill in counts for months where you have data
        incidentData.forEach(function (item) {
            var index = allMonths.indexOf(item.month);
            if (index !== -1) {
                incidentTotal[index] = item.total;
            }
        });

        serviceData.forEach(function (item) {
            var index = allMonths.indexOf(item.month);
            if (index !== -1) {
                serviceTotal[index] = item.total;
            }
        });

        // Create a line chart
        var ctx = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: allMonths,
                datasets: [
                    {
                        label: 'Incident Total',
                        borderColor: 'rgb(75, 192, 192)',
                        data: incidentTotal,
                    },
                    {
                        label: 'Service Total',
                        borderColor: 'rgb(255, 99, 132)',
                        data: serviceTotal,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true, // Start the y-axis from zero
                    },
                },
            },
        });
    }
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
        fetchData('daily');

    </script>
    @endpush