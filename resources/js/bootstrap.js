import Echo from 'laravel-echo';
import Swal from 'sweetalert2';

window.io = require('socket.io-client');

try {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        // host: 'http://localhost:6001', // Update the port if needed
        // host: localhost + ':6001', // Update the port if needed
        host: window.location.hostname + ':6001', // Update the port if needed
    });

    console.log('Laravel Echo started successfully.');
} catch (error) {
    console.error('Error starting Laravel Echo:', error);
}

try {
    window.Echo.channel('new-ticket-channel')
    .listen('NewTicketEvent', (event) => {
        console.log('New Ticket Created!!');
    });

    
    
} catch (error) {
    console.error('Error receive data:', error);
}
