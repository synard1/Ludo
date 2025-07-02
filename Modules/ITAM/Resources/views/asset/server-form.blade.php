<div class="row g-3">
    {{-- CPU Section --}}
    <div class="mb-6">
        <h5 class="mb-3 text-primary">🖥️ CPU Specifications</h5>
        <div class="text-muted small mb-2">
            Total Cores: <strong>{{ $this->totalCpuCores }}</strong> |
            Total Clock: <strong>{{ $this->totalCpuClock }} GHz</strong> |
            Performance: <strong>{{ $this->totalCpuPerformance }} GHz</strong>
        </div>

        <div class="row g-3">
            @foreach ($cpus as $index => $cpu)
                <div class="col-md-6 col-lg-4">
                    <div class="border p-3 rounded">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">CPU Slot {{ $index + 1 }}</h6>
                            <button type="button" class="btn btn-danger btn-sm" wire:click="removeCpuSlot({{ $index }})">✖</button>
                        </div>

                        <div class="mb-2">
                            <input type="text" wire:model.lazy="cpus.{{ $index }}.model" class="form-control" placeholder="CPU Model">
                        </div>
                        <div class="mb-2">
                            <input type="number" wire:model.lazy="cpus.{{ $index }}.cores" class="form-control" placeholder="Cores">
                        </div>
                        <div class="mb-2">
                            <input type="number" wire:model.lazy="cpus.{{ $index }}.clock_speed" step="0.1" class="form-control" placeholder="Clock Speed (GHz)">
                        </div>
                        <div>
                            <select wire:model.lazy="cpus.{{ $index }}.hyperthreading" class="form-select">
                                <option value="0">No HT</option>
                                <option value="1">HT Enabled</option>
                            </select>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @error('cpus') <span class="text-danger">{{ $message }}</span> @enderror

        @if(count($cpus) < $maxCpu)
            <button type="button" wire:click="addCpuSlot" class="btn btn-sm btn-primary mt-3">➕ Add CPU</button>
        @endif
    </div>

    <!-- RAM Configuration -->
    <div class="col-12">
        <label class="fw-bold">💾 RAM Configuration:</label>
        <div class="d-flex flex-column gap-2">
            @foreach ($rams as $index => $ram)
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <input type="text" wire:model="rams.{{ $index }}.model" class="form-control shadow-sm" placeholder="RAM Model">
                    </div>
                    <div class="col-md-4">
                        <input type="number" wire:model="rams.{{ $index }}.size" class="form-control shadow-sm" placeholder="GB">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm" wire:click="removeRam({{ $index }})">❌</button>
                    </div>
                </div>
            @endforeach
            <button type="button" class="btn btn-success btn-sm" wire:click="addRam">➕ Add RAM</button>
        </div>
    </div>

    {{-- Storage Section --}}
    <div class="mb-6">
        <h5 class="mb-3 text-primary">💽 Storage Specifications</h5>
        <div class="text-muted small mb-2">
            Total Storage: <strong>{{ $this->totalStorageCapacity }} GB</strong>
        </div>

        <div class="row g-3">
            @foreach ($storages as $index => $storage)
                <div class="col-md-6 col-lg-4">
                    <div class="border p-3 rounded">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Storage Slot {{ $index + 1 }}</h6>
                            <button type="button" class="btn btn-danger btn-sm" wire:click="removeStorageSlot({{ $index }})">✖</button>
                        </div>

                        <div class="mb-2">
                            <select wire:model.lazy="storages.{{ $index }}.type" class="form-select">
                                <option value="">Select Type</option>
                                <option value="HDD">HDD</option>
                                <option value="SSD">SSD</option>
                                <option value="NVMe">NVMe</option>
                            </select>
                        </div>
                        <div>
                            <input type="number" wire:model.lazy="storages.{{ $index }}.capacity" class="form-control" placeholder="Capacity (GB)">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @error('storages') <span class="text-danger">{{ $message }}</span> @enderror

        @if(count($storages) < $maxStorage)
            <button type="button" wire:click="addStorageSlot" class="btn btn-sm btn-primary mt-3">➕ Add Storage</button>
        @endif
    </div>

    <!-- PSU Configuration -->
    <div class="col-12">
        <label class="fw-bold">⚡ Power Supply Unit (PSU):</label>
        <div class="d-flex flex-column gap-2">
            @foreach ($psus as $index => $psu)
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <input type="text" wire:model="psus.{{ $index }}.model" class="form-control shadow-sm" placeholder="PSU Model">
                    </div>
                    <div class="col-md-4">
                        <input type="number" wire:model="psus.{{ $index }}.wattage" class="form-control shadow-sm" placeholder="Wattage">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm" wire:click="removePsu({{ $index }})">❌</button>
                    </div>
                </div>
            @endforeach
            <button type="button" class="btn btn-success btn-sm" wire:click="addPsu">➕ Add PSU</button>
        </div>
    </div>
</div>
