"use strict";

// Class definition
var KTAccountOverview = function () {
    // Specify the URLs you want to load
    let apiUrls = [
        '/setting/api/limit',
        '/setting/api/version'
        // Add more URLs as needed
    ];

    // Private functions
    var initSettings = function() {

        // Loop through each URL and send an AJAX request
        $.each(apiUrls, function(index, apiUrl) {
            $.ajax({
                url: apiUrl,
                method: 'GET',
                success: function(response) {
                    console.log('URL loaded successfully:', apiUrl);
                    // You can handle the response here if needed
                },
                error: function(error) {
                    console.error('Error loading URL:', apiUrl, error);
                    // Handle the error if needed
                }
            });
        });

    }

    // Public methods
    return {
        init: function () {
            initSettings();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTAccountOverview.init();
});
