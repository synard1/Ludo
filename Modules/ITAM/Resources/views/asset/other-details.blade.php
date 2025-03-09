<div class="card mb-3 shadow-sm border-0">
    <div class="card-header text-white py-2 rounded-top bg-gradient-primary">
        <h6 class="mb-0 d-flex align-items-center">
            <i class="fas fa-desktop me-2"></i> Assets Specifications
        </h6>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase small fw-bold">Property</th>
                        <th class="text-uppercase small fw-bold">Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formattedSpecifications as $item)
                        <tr>
                            <td>{{ ucfirst($item['key']) }}</td>
                            <td>{{ $item['value'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>