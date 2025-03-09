<!-- Monitor Details Blade Template -->

<!-- Extract formattedSpecifications from the first params entry -->
@php
    $specs = $this->formattedSpecifications ?? [];
    $connectivityOptions = ['VGA', 'HDMI', 'Display Port', 'USB Type-C', 'Serial'];
    $connectivityData = [];
    foreach ($connectivityOptions as $index => $option) {
        $connectivityData[$option] = isset($specs['connectivityTypes'][$index]) && $specs['connectivityTypes'][$index] === true 
                                     ? '✅' 
                                     : '❌';
    }
    $maxResolution = is_array($specs['Max Resolution'] ?? null) 
                     ? ($specs['Max Resolution']['maxResolution'] ?? '-') 
                     : ($specs['Max Resolution'] ?? '-');
    $formattedSpecifications = [
        'general' => [
            ['Screen Size (inches)' => $specs['Screen Size (inches)'] ?? '-', 
             'Panel Type' => $specs['Panel Type'] ?? '-', 
            //  'Refresh Rate' => $specs['Refresh Rate'] ?? '-', 
            //  'Response Time' => $specs['Response Time'] ?? '-', 
            //  'Max Resolution' => $maxResolution
             ]
        ],
        'connectivity' => [$connectivityData]
    ];
@endphp

<!-- Display Monitor Details -->
@foreach([
    'general' => ['title' => '🖥️ General Monitor Details', 'color' => 'primary'],
    'connectivity' => ['title' => '🔌 Connectivity Options', 'color' => 'info']
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
                                @foreach(array_keys($formattedSpecifications[$key][0]) as $header)
                                    <th class="text-uppercase small fw-bold">{{ ucfirst($header) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formattedSpecifications[$key] as $item)
                                <tr>
                                    @foreach($item as $value)
                                        <td>
                                            @if(is_bool($value))
                                                {!! $value ? '✅' : '❌' !!}
                                            @elseif(is_array($value))
                                                {{ json_encode($value) }} {{-- Safely encode array values --}}
                                            @else
                                                {{ $value ?? '-' }}
                                            @endif
                                        </td>
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