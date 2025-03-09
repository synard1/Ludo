@php
    // Extract formattedSpecifications from the first params entry
    $specs = $this->formattedSpecifications ?? [];
    // $specs = $params[0]['formattedSpecifications'] ?? [];

    // Connectivity options mapping
    $connectivityOptions = ['USB', 'Wi-Fi', 'Ethernet', 'Bluetooth', 'Serial', 'Parallel'];

    // Map connectivity types (handling non-boolean values)
    $connectivityData = [];
    foreach ($connectivityOptions as $index => $option) {
        $connectivityData[$option] = isset($specs['connectivityTypes'][$index]) && $specs['connectivityTypes'][$index] === true 
                                     ? '✅' 
                                     : '❌';
    }

    // Extract max resolution safely (handle array case)
    $maxResolution = is_array($specs['Max Resolution'] ?? null) 
                     ? ($specs['Max Resolution']['maxResolution'] ?? '-') 
                     : ($specs['Max Resolution'] ?? '-');

    // Organize sections
    $formattedSpecifications = [
        'general' => [
            ['Print Technology' => $specs['Print Technology'] ?? '-', 
             'Printer Type' => $specs['Printer Type'] ?? '-', 
             'Max Paper Size' => $specs['Max Paper Size'] ?? '-', 
             'Max Resolution' => $specs['Max Resolution'] ?? '-', 
            //  'Max Resolution' => $maxResolution
             ]
        ],
        'connectivity' => [$connectivityData]
    ];
@endphp

@foreach([
    'general' => ['title' => '🖨️ General Printer Details', 'color' => 'primary'],
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
