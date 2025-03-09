<div id="kt_docs_card_asset_spesification" class="card shadow-sm mb-5 collapse" wire:ignore.self>
    <!--begin::Card body-->
    <div class="card-body pt-5 pb-5">
        <div class="container">
            <input type="hidden" wire:model="assetType" class="form-control bg-light" readonly>

            {{-- <h2 class="mb-4 text-primary">🖥️ Add New Asset</h2>

            <!-- Asset Type -->
            <div class="mb-4">
                <label class="form-label fw-bold">Asset Type:</label>
                <input type="text" wire:model="assetType" class="form-control bg-light" readonly>
            </div> --}}

            @if (in_array($assetType, ['computer', 'server', 'desktop']))

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

            {{-- RAM Section --}}
            <div class="mb-6">
                <h5 class="mb-3 text-primary">💾 RAM Specifications</h5>
                <div class="text-muted small mb-2">
                    Total RAM: <strong>{{ $this->totalRamSize }} GB</strong>
                </div>

                <div class="row g-3">
                    @foreach ($rams as $index => $ram)
                        <div class="col-md-6 col-lg-4">
                            <div class="border p-3 rounded">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">RAM Slot {{ $index + 1 }}</h6>
                                    <button type="button" class="btn btn-danger btn-sm" wire:click="removeRamSlot({{ $index }})">✖</button>
                                </div>

                                <div class="mb-2">
                                    <select wire:model.lazy="rams.{{ $index }}.type" class="form-select">
                                        <option value="">Select RAM Type</option>
                                        @foreach ($ramTypes as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <input type="text" wire:model.lazy="rams.{{ $index }}.model" class="form-control" placeholder="RAM Model">
                                </div>
                                <div class="mb-2">
                                    <input type="number" wire:model.lazy="rams.{{ $index }}.size" class="form-control" placeholder="Size (GB)">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @error('rams') <span class="text-danger">{{ $message }}</span> @enderror

                @if(count($rams) < $maxRam)
                    <button type="button" wire:click="addRamSlot" class="btn btn-sm btn-primary mt-3">➕ Add RAM</button>
                @endif

                @if ($this->ramTypeWarning)
                    <div class="alert alert-warning">
                        {{ $this->ramTypeWarning }}
                    </div>
                @endif
            </div>

            {{-- GPU Section --}}
            <div class="mb-6">
                <h5 class="mb-3 text-primary">🎮 GPU Specifications</h5>
                <div class="row g-3">
                    @foreach ($gpus as $index => $gpu)
                        <div class="col-md-6 col-lg-4">
                            <div class="border p-3 rounded">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">GPU Slot {{ $index + 1 }}</h6>
                                    <button type="button" class="btn btn-danger btn-sm" wire:click="removeGpuSlot({{ $index }})">✖</button>
                                </div>

                                <div class="mb-2">
                                    <input type="text" wire:model.lazy="gpus.{{ $index }}.model" class="form-control" placeholder="GPU Model">
                                </div>
                                <div class="mb-2">
                                    <input type="number" wire:model.lazy="gpus.{{ $index }}.vram" class="form-control" placeholder="VRAM (GB)">
                                </div>
                                <div>
                                    <input type="number" wire:model.lazy="gpus.{{ $index }}.clock_speed" class="form-control" placeholder="Clock Speed (MHz)">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" wire:click="addGpuSlot" class="btn btn-sm btn-primary mt-3">➕ Add GPU</button>
            </div>

            {{-- PSU Section --}}
            <div class="mb-6">
                <h5 class="mb-3 text-primary">🔌 Power Supply (PSU) Specifications</h5>
                <div class="row g-3">
                    @foreach ($psus as $index => $psu)
                        <div class="col-md-6 col-lg-4">
                            <div class="border p-3 rounded">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">PSU Slot {{ $index + 1 }}</h6>
                                    <button type="button" class="btn btn-danger btn-sm" wire:click="removePsuSlot({{ $index }})">✖</button>
                                </div>

                                <div class="mb-2">
                                    <input type="text" wire:model.lazy="psus.{{ $index }}.model" class="form-control" placeholder="PSU Model">
                                </div>
                                <div class="mb-2">
                                    <input type="number" wire:model.lazy="psus.{{ $index }}.wattage" class="form-control" placeholder="Wattage (W)">
                                </div>
                                <div>
                                    <select wire:model.lazy="psus.{{ $index }}.efficiency" class="form-select">
                                        <option value="">Efficiency Rating</option>
                                        @foreach ($efficiencyRatings as $rating)
                                            <option value="{{ $rating }}">{{ $rating }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if ($this->powerWarning)
                            <div class="alert alert-danger">
                                {{ $this->powerWarning }}
                            </div>
                        @endif
                    @endforeach
                </div>

                @error('psus') <span class="text-danger">{{ $message }}</span> @enderror

                @if (count($psus) < $maxPsu)
                <button type="button" wire:click="addPsuSlot" class="btn btn-sm btn-primary mt-3">➕ Add PSU</button>
                @endif

                <div class="mt-3">
                    <h6>🔋 Total Power Consumption: <strong>{{ $totalPowerConsumption }}W</strong></h6>
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

            <!-- Missing Components Warning -->
            @if ($this->missingComponentsWarning)
                <div class="alert alert-warning mt-2">
                    {{ $this->missingComponentsWarning }}
                </div>
            @endif
            @elseif($assetType === 'server')
                {{-- Monitor Section --}}
                @include('itam::asset.server-form')

            @elseif($assetType === 'monitor')
                {{-- Monitor Section --}}
                @include('itam::asset.monitor-form')

            @elseif($assetType === 'printer')
                @include('itam::asset.printer-form')

            @elseif($assetType === 'switch')
                @include('itam::asset.switch-form')

            @elseif($assetType === 'cctv')
                @include('itam::asset.cctv-form')
            
            @else
                @include('itam::asset.other-form')

                    {{-- <div class="row g-3">
                        <!-- Printer Type Select -->
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <select wire:model="printerType" class="form-select shadow-sm" id="printerTypeSelect">
                                    <option value="" selected>🔽 Select Printer Type</option>
                                    <option value="laser">🖨️ Laser</option>
                                    <option value="inkjet">🖋️ Inkjet</option>
                                    <option value="dot_matrix">📜 Dot Matrix</option>
                                    <option value="thermal">🔥 Thermal</option>
                                </select>
                                <label for="printerTypeSelect">🖨️ Printer Type</label>
                            </div>
                        </div>
                
                        <!-- Printing Technology Select -->
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <select wire:model="printingTechnology" class="form-select shadow-sm" id="printingTechnologySelect">
                                    <option value="" selected>🔽 Select Printing Technology</option>
                                    <option value="monochrome">⚫ Monochrome</option>
                                    <option value="color">🌈 Color</option>
                                </select>
                                <label for="printingTechnologySelect">🎨 Printing Technology</label>
                            </div>
                        </div>
                
                        <!-- Max Print Resolution -->
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="text" wire:model="maxResolution" class="form-control shadow-sm" id="maxResolutionInput" placeholder=" ">
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
                
                        <!-- Wireless Support Checkbox -->
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" wire:model="wirelessSupport" class="form-check-input shadow-sm" id="wirelessSupportCheck">
                                <label class="form-check-label" for="wirelessSupportCheck">📡 Wireless Support</label>
                            </div>
                        </div>
                    </div> --}}
            
                {{-- <div class="mb-4">
                    <label>Resolution</label>
                    <select wire:model="resolution" class="form-select">
                        <option value="">Select Resolution</option>
                        <option value="1280x720 (720p)">1280x720 (720p)</option>
                        <option value="1920x1080 (1080p)">1920x1080 (1080p)</option>
                        <option value="2560x1440 (1440p)">2560x1440 (1440p)</option>
                        <option value="3840x2160 (4K)">3840x2160 (4K)</option>
                        <option value="Other">Other (Specify Below)</option>
                    </select>
                    @if ($resolution === 'Other')
                        <input type="text" wire:model="customResolution" class="form-control mt-2" placeholder="Enter Custom Resolution">
                    @endif
                </div> --}}


                {{-- <div class="mb-4">
                    <label>Refresh Rate (Hz)</label>
                    <input type="number" wire:model="refreshRate" class="form-control">
                </div>

                <div class="mb-4">
                    <label>Response Time (ms)</label>
                    <input type="number" wire:model="responseTime" class="form-control">
                </div>

                <div class="mb-4">
                    <label>Aspect Ratio</label>
                    <select wire:model="aspectRatio" class="form-select">
                        <option value="">Select Aspect Ratio</option>
                        <option value="16:9">16:9</option>
                        <option value="16:10">16:10</option>
                        <option value="21:9">21:9 (Ultrawide)</option>
                        <option value="32:9">32:9 (Super Ultrawide)</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label>Connectivity</label>
                    <div class="form-check">
                        <input type="checkbox" wire:model="connectivity.hdmi" class="form-check-input" id="hdmiCheckbox">
                        <label class="form-check-label" for="hdmiCheckbox">HDMI</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" wire:model="connectivity.displayPort" class="form-check-input" id="displayPortCheckbox">
                        <label class="form-check-label" for="displayPortCheckbox">DisplayPort</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" wire:model="connectivity.vga" class="form-check-input" id="vgaCheckbox">
                        <label class="form-check-label" for="vgaCheckbox">VGA</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" wire:model="connectivity.usbC" class="form-check-input" id="usbCCheckbox">
                        <label class="form-check-label" for="usbCCheckbox">USB-C</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label>Built-in Speakers</label>
                    <select wire:model="builtInSpeakers" class="form-select">
                        <option value="">Select Option</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label>Curved Screen</label>
                    <select wire:model="curvedScreen" class="form-select">
                        <option value="">Select Option</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label>HDR Support</label>
                    <select wire:model="hdrSupport" class="form-select">
                        <option value="">Select Option</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label>Adaptive Sync</label>
                    <select wire:model="adaptiveSync" class="form-select">
                        <option value="">Select Option</option>
                        <option value="FreeSync">FreeSync</option>
                        <option value="G-Sync">G-Sync</option>
                        <option value="None">None</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label>Brightness (cd/m²)</label>
                    <input type="number" wire:model="brightness" class="form-control">
                </div>

                <div class="mb-4">
                    <label>Contrast Ratio</label>
                    <input type="text" wire:model="contrastRatio" class="form-control">
                </div>

                <div class="mb-4">
                    <label>Viewing Angles</label>
                    <input type="text" wire:model="viewingAngles" class="form-control" placeholder="e.g., 178°/178°">
                </div>

                <div class="mb-4">
                    <label>Color Gamut</label>
                    <input type="text" wire:model="colorGamut" class="form-control" placeholder="e.g., 99% sRGB">
                </div>

                <div class="mb-4">
                    <label>VESA Mount Compatibility</label>
                    <select wire:model="vesaMount" class="form-select">
                        <option value="">Select Option</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div> --}}
            @endif
        </div>

        <button wire:click="saveSpec" class="btn btn-success mt-4"
            @if($isSubmitDisabled === true) disabled @endif>
            Save Changes
        </button>

        
    </div>

    
</div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('toast', (event) => {
                if (event.detail) { // Add null check here
                    if (event.detail.type === 'success') {
                        toastr.success(event.detail.message);
                    } else if (event.detail.type === 'error') {
                        toastr.error(event.detail.message);
                    } else {
                        toastr.warning(event.detail.message);
                    }
                }else{
                    console.error('toast event dispatched without detail object:', event);
                }
            });

            Livewire.on('consoleLog', data => console.log(data));

            Livewire.on('isMissingComponentsWarning', () => {
                // document.getElementById('missingComponentsWarning').style.display = 'block';
                console.log('missing');
                
            });

        });
    </script>
    @endpush
</div>

