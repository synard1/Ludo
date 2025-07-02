@php
    $sections = [
        'general' => ['title' => '📋 General Asset Details', 'color' => 'primary'],
        'connectivity' => ['title' => '🔌 Connectivity Options', 'color' => 'info']
    ];
@endphp

@foreach($sections as $key => $info)
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
                                @foreach(array_keys($formattedSpecifications[$key][0]) as $header)
                                    <th class="text-uppercase small fw-bold">{{ ucfirst($header) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formattedSpecifications[$key] as $item)
                                <tr>
                                    @foreach($item as $value)
                                        <td>{!! is_bool($value) ? ($value ? '✅' : '❌') : ($value ?? '-') !!}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endforeach
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
                                @foreach(array_keys($formattedSpecifications[$key][0]) as $header)
                                    <th class="text-uppercase small fw-bold">{{ ucfirst($header) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formattedSpecifications[$key] as $item)
                                <tr>
                                    @foreach($item as $value)
                                        <td>{!! is_bool($value) ? ($value ? '✅' : '❌') : ($value ?? '-') !!}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    asdasd
