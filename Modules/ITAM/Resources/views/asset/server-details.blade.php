@foreach([
    'cpus' => ['title' => '🖥️ CPU Details', 'color' => 'dark'],
    'rams' => ['title' => '💾 RAM Details', 'color' => 'success'],
    'storages' => ['title' => '💽 Storage Details', 'color' => 'warning'],
    'psus' => ['title' => '🔌 Power Supply (PSU)', 'color' => 'danger']
] as $key => $info)

    @if(!empty($formattedSpecifications[$key]))
        <div class="card mb-3 shadow-sm border-0">
            
            {{-- Section Header --}}
            <div class="card-header text-white py-2 rounded-top bg-gradient-{{ $info['color'] }}">
                <h6 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-circle me-2"></i> {{ $info['title'] }}
                </h6>
            </div>

            {{-- Table Content --}}
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                @foreach(array_keys((array) reset($formattedSpecifications[$key])) as $header)
                                    @if(!($key === 'cpus' && $header === 'hyperthreading')) {{-- Skip "hyperthreading" --}}
                                        <th class="text-uppercase small fw-bold">{{ ucfirst($header) }}</th>
                                    @endif
                                @endforeach
                                @if($key === 'cpus') 
                                    <th class="text-uppercase small fw-bold">Hyperthreading</th> {{-- Add it separately --}}
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formattedSpecifications[$key] as $item)
                                <tr>
                                    @foreach($item as $column => $value)
                                        @if(!($key === 'cpus' && $column === 'hyperthreading')) {{-- Skip "hyperthreading" --}}
                                            <td>{{ $value ?? '-' }}</td>
                                        @endif
                                    @endforeach
                                    @if($key === 'cpus')
                                        <td class="text-center">
                                            {!! ($item['hyperthreading'] ?? 0) ? '✅' : '❌' !!}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>

        </div>
    @endif
@endforeach

{{-- Summary Section --}}
<div class="alert alert-info d-flex align-items-center mt-3 mb-0">
    <i class="fas fa-chart-bar me-2"></i>
    <div>
        <strong>📊 Summary:</strong><br>
        🔢 Max CPU Slots: <strong>{{ $formattedSpecifications['maxCpu'] ?? '-' }}</strong><br>
        🛠 Max RAM Slots: <strong>{{ $formattedSpecifications['maxRam'] ?? '-' }}</strong><br>
        💾 Max Storage Slots: <strong>{{ $formattedSpecifications['maxStorage'] ?? '-' }}</strong><br>
        ⚡ Total Power Consumption: <strong>{{ $formattedSpecifications['totalPowerConsumption'] ?? '-' }}W</strong>
    </div>
</div>