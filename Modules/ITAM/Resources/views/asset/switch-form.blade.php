<div class="row g-3">
    <!-- Device Type Select -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="deviceType" class="form-select shadow-sm" id="deviceTypeSelect">
                <option value="" selected>🔽 Select Device Type</option>
                <option value="Switch">🔀 Switch</option>
                <option value="Hub">🔗 Hub</option>
            </select>
            <label for="deviceTypeSelect">🔌 Device Type</label>
        </div>
    </div>

    <!-- Number of Ports -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <input type="number" wire:model.defer="numPorts" class="form-control shadow-sm" id="numPortsInput" placeholder=" ">
            <label for="numPortsInput">🔢 Number of Ports</label>
        </div>
    </div>

    <!-- Network Speed Select -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="networkSpeed" class="form-select shadow-sm" id="networkSpeedSelect">
                <option value="" selected>🔽 Select Network Speed</option>
                <option value="10/100 Mbps">🌐 10/100 Mbps</option>
                <option value="1 Gbps">⚡ 1 Gbps</option>
                <option value="2.5 Gbps">🚀 2.5 Gbps</option>
                <option value="10 Gbps">🔥 10 Gbps</option>
            </select>
            <label for="networkSpeedSelect">⚡ Network Speed</label>
        </div>
    </div>

    <!-- Power Over Ethernet (PoE) Support -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="poeSupport" class="form-select shadow-sm" id="poeSupportSelect">
                <option value="" selected>🔽 Select PoE Support</option>
                <option value="Yes">✅ Yes</option>
                <option value="No">❌ No</option>
            </select>
            <label for="poeSupportSelect">🔋 Power Over Ethernet (PoE)</label>
        </div>
    </div>

    <!-- Managed / Unmanaged Select -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="managed" class="form-select shadow-sm" id="managedSelect">
                <option value="" selected>🔽 Select Management Type</option>
                <option value="Managed">🛠️ Managed</option>
                <option value="Unmanaged">⚙️ Unmanaged</option>
                <option value="Smart">🤖 Smart</option>
            </select>
            <label for="managedSelect">🔧 Management Type</label>
        </div>
    </div>

    <!-- Connectivity Types (Checkboxes) -->
    <div class="col-12">
        <label class="fw-bold">🔌 Connectivity Types:</label>
        <div class="d-flex flex-wrap gap-2">
            @foreach (['Ethernet', 'Fiber', 'Wi-Fi', 'SFP', 'USB', 'Serial'] as $index => $connectivity)
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
