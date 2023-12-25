<div>
    <!-- Display your notifications here -->
    @foreach ($notifications as $notification)
        <div>{{ $notification->data['message'] }}</div>
    @endforeach
</div>
