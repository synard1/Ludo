<div class="row g-3">
    <!-- Printer Type Select -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="printerType" class="form-select shadow-sm" id="printerTypeSelect">
                <option value="" selected>🔽 Select Printer Type</option>
                <option value="Laser">🖨️ Laser</option>
                <option value="Inkjet">🖋️ Inkjet</option>
                <option value="Dot Matrix">📜 Dot Matrix</option>
                <option value="Thermal">🔥 Thermal</option>
            </select>
            <label for="printerTypeSelect">🖨️ Printer Type</label>
        </div>
    </div>

    <!-- Printing Technology Select -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="printingTechnology" class="form-select shadow-sm" id="printingTechnologySelect">
                <option value="" selected>🔽 Select Printing Technology</option>
                <option value="Monochrome">⚫ Monochrome</option>
                <option value="Color">🌈 Color</option>
            </select>
            <label for="printingTechnologySelect">🎨 Printing Technology</label>
        </div>
    </div>

    <!-- Max Print Resolution -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <input type="text" wire:model.defer="maxResolution" class="form-control shadow-sm" id="maxResolutionInput" placeholder=" ">
            <label for="maxResolutionInput">📏 Max Print Resolution (e.g., 1200x1200 DPI)</label>
        </div>
    </div>

    <!-- Max Paper Size -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="maxPaperSize" class="form-select shadow-sm" id="maxPaperSizeSelect">
                <option value="" selected>🔽 Select Max Paper Size</option>
                <option value="A4">📄 A4</option>
                <option value="A3">📜 A3</option>
                <option value="Letter">✉️ Letter</option>
                <option value="Legal">📑 Legal</option>
            </select>
            <label for="maxPaperSizeSelect">📏 Max Paper Size</label>
        </div>
    </div>

    <!-- Multiple Connectivity Types Checkboxes -->
    <div class="col-12">
        <label class="fw-bold">🔌 Connectivity Types:</label>
        <div class="d-flex flex-wrap gap-2">
            @foreach (['USB', 'Wi-Fi', 'Ethernet', 'Bluetooth', 'Serial', 'Parallel'] as $index => $connectivity)
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
