<div class="row g-3">
    <!-- Screen Size Input -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <input type="number" wire:model="screenSize" class="form-control shadow-sm" id="screenSizeInput" placeholder=" ">
            <label for="screenSizeInput">
                📏 Screen Size (inches)
            </label>
        </div>
    </div>

    <!-- Panel Type Select -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="panelType" class="form-select shadow-sm" id="panelTypeSelect">
                <option value="" selected>🔽 Select Panel Type</option>
                <option value="TN">🖥️ TN</option>
                <option value="IPS">🌈 IPS</option>
                <option value="VA">🔲 VA</option>
                <option value="OLED">✨ OLED</option>
            </select>
            <label for="panelTypeSelect">
                🎨 Panel Type
            </label>
        </div>
    </div>
</div>
<div class="row g-3">
    <!-- Multiple Connectivity Types Checkboxes -->
    <div class="col-12">
        <label class="fw-bold">🔌 Connectivity Types:</label>
        <div class="d-flex flex-wrap gap-2">
            @foreach (['VGA', 'HDMI', 'Display Port', 'USB Type-C', 'Serial'] as $index => $connectivity)
                <div class="form-check">
                    <input type="checkbox" wire:model="connectivityTypes.{{ $index }}" 
                        value="{{ $connectivity }}" class="form-check-input shadow-sm" 
                        id="connectivity-{{ Str::slug($connectivity) }}"
                        @checked($connectivityTypes[$index] ?? false)>
                    <label class="form-check-label" for="connectivity-{{ Str::slug($connectivity) }}">
                        {{ $connectivity }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>