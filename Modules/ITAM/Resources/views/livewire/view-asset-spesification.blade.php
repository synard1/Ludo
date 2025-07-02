<div wire:ignore.self class="modal fade" id="assetDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg rounded-3">
            
            {{-- Modal Header --}}
            <div class="modal-header bg-gradient-primary text-white py-3 rounded-top">
                <h6 class="modal-title mb-0">
                    <i class="fas fa-search"></i> Asset Specifications
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body">
                @if(empty($formattedSpecifications))
                    <p class="text-center text-muted">No specifications available.</p>
                @else
                @if($this->assetType === 'desktop')
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
                @elseif($this->assetType === 'server')
                    @include('itam::asset.server-details')
                @elseif($this->assetType === 'monitor')
                    @include('itam::asset.monitor-details')
                
                @elseif($this->assetType === 'printer')
                    @include('itam::asset.printer-details')
                @elseif($this->assetType === 'switch')
                    @include('itam::asset.switch-details')
                @else
                    @include('itam::asset.other-details')
                @endif

                    

                @endif
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer py-2 bg-light rounded-bottom">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>

        </div>
    </div>
</div>
