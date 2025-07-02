<?php

namespace Modules\ITAM\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Modules\ITAM\Entities\Asset;
use Illuminate\Support\Arr;

use Illuminate\Validation\ValidationException;


class AddAssetSpesification extends Component
{
    use WithFileUploads;
    
    public $selectedType;
    public $selectedAsset;
    public $cpus = [];
    public $rams = [];

    public $totalRam = 0;
    public $totalCores = 0;

    public $assetData = [];
    public $assets = [];
    public $existingAssets;

    public $type;
    public $fields = [];
    public $formData = [];

    public $assetId;
    public $assetType;
    public $cpuSlots = [];
    public $ramSlots = [];
    public $storages = [];
    public $gpus = [];
    public $psus = [];
    public $extraFields = [];
    public $maxCpu = 0;
    public $maxRam = 0;
    public $maxStorage;
    public $maxPsu;
    public array $ramTypes = ['DDR2', 'DDR3', 'DDR4', 'DDR5'];

    public $isPowerExceeded = false;
    public $hasMixedRamTypes = false;
    public $isMissingComponents = false;
    public $isSubmitDisabled = false; // Store the computed value

    public $psu = ['model' => '', 'wattage' => '', 'efficiency' => ''];
    public $totalPowerConsumption = 0;
    public array $efficiencyRatings = ['Standard', '80 Plus', '80 Plus Bronze', '80 Plus Silver', '80 Plus Gold', '80 Plus Platinum', '80 Plus Titanium'];

    public $screenSize;
    public $resolution;
    public $customResolution;
    public $panelType;
    public $refreshRate;
    public $responseTime;
    public $aspectRatio;
    public $connectivity = [
        'hdmi' => false,
        'displayPort' => false,
        'vga' => false,
        'usbC' => false,
    ];
    public $builtInSpeakers;
    public $curvedScreen;
    public $hdrSupport;
    public $adaptiveSync;
    public $brightness;
    public $contrastRatio;
    public $viewingAngles;
    public $colorGamut;
    public $vesaMount;

    //Switch
    public $deviceType;
    public $numPorts;
    public $networkSpeed;
    public $managed;
    public $poeSupport;

    public $connectivityTypes; // ✅ Initialize as an array


    public $printingTechnology, $printerType, $maxResolution = 0, $maxPaperSize;
    // public $connectivityTypes = []; // ✅ Initialize as an array
    public $connectivityPrinter = ['USB', 'Wi-Fi', 'Ethernet', 'Bluetooth', 'Serial', 'Parallel']; // ✅ Initialize as an array
    protected $connectivityMapping = [
        'USB' => 'usb',
        'Wi-Fi' => 'wifi',
        'Ethernet' => 'ethernet',
        'Bluetooth' => 'bluetooth',
        'Serial' => 'serial',
        'Parallel' => 'parallel',
    ];

    // Properti untuk input form cctv
    public $cctvTechnology;
    public $colorVu;
    public $installationType;
    public $storageType;
    public $cctvResolution=0;
    public $nightVision = "No";
    public $infrared = "No";
    public $motionDetection = "No";
    public $powerSource;

    // Pilihan opsi untuk dropdown
    public $analogTypes = ['CVBS', 'HD-TVI', 'AHD'];
    public $ipTypes = ['Wired', 'Wireless'];
    public $networkProtocols = ['RTSP', 'ONVIF'];
    public $powerSources = ['PoE', 'Adapter', 'Battery'];

    public $specifications = [];

    protected $template = [
        "computer" => [
            "max_cpu_sockets" => 1,
            "ram_slots" => 4,
            "storage_slots" => 4,
        ],
        "desktop" => [
            "max_cpu_sockets" => 1,
            "ram_slots" => 4,
            "storage_slots" => 4,
        ],
        "server" => [
            "max_cpu_sockets" => 4,
            "ram_slots" => 8,
            "storage_slots" => 16,
            "extra_fields" => ["RAID Configuration", "Network Interfaces"]
        ],
        "monitor" => [
            "max_cpu_sockets" => 0,
            "ram_slots" => 0,
            "storage_slots" => 0,
            "extra_fields" => ["Resolution", "Panel Type"]
        ]
    ];

    protected $listeners = [
        'loadAssetSpecification' => 'loadAsset',
    ];

    public function addSpecification()
    {
        $this->specifications[] = ['key' => '', 'value' => ''];
    }

    public function removeSpecification($index)
    {
        unset($this->specifications[$index]);
        $this->specifications = array_values($this->specifications); // Re-index array
    }

    public function loadAsset($assetId)
    {
        // Eager load the type relationship to avoid N+1 query
        $asset = Asset::with('type')->findOrFail($assetId);
        
        // Cache frequently accessed values
        $this->assetId = $asset->id;
        $this->assetType = strtolower($asset->type->name);
        
        // Decode JSON once and cache the result
        $specs = cache()->remember("asset_specs_{$assetId}", 300, function() use ($asset) {
            return json_decode($asset->specifications, true) ?? [];
        });

        // Use static configuration array instead of runtime array creation
        static $limits = [
            'server' => ['cpu' => 4, 'ram' => 8],
            'computer' => ['cpu' => 1, 'ram' => 4],
            'desktop' => ['cpu' => 1, 'ram' => 4],
            'laptop' => ['cpu' => 1, 'ram' => 2],
            'monitor' => ['cpu' => 0, 'ram' => 0],
        ];

        // Set limits in one assignment
        ['cpu' => $this->maxCpu, 'ram' => $this->maxRam] = $limits[$this->assetType] ?? ['cpu' => 0, 'ram' => 0];

        // Use static mapping for type loaders
        static $typeLoaders = [
            'monitor' => 'loadMonitorSpecs',
            'printer' => 'loadPrinterSpecs',
            'switch' => 'loadSwitchSpecs',
            'server' => ['loadComputerSpecs', true],
            'desktop' => ['loadComputerSpecs', false],
            'cctv' => 'loadCctvSpecs',
        ];

        // Load specifications based on type
        if (isset($typeLoaders[$this->assetType])) {
            $loader = $typeLoaders[$this->assetType];
            if (is_array($loader)) {
                $this->{$loader[0]}($specs, $loader[1]);
            } else {
                $this->{$loader}($specs);
            }
        } else {
            $this->specifications = $specs;
        }

        return $this;
    }

    private function loadMonitorSpecs($specs)
    {
        $this->screenSize = $specs['Screen Size (inches)'] ?? ['Screen Size (inches)' => ''];
        $this->panelType = $specs['Panel Type'] ?? ['Panel Type' => ''];
        $this->connectivityTypes = $specs['connectivityTypes'] ?? ['connectivityTypes' => ''];
    }

    private function loadPrinterSpecs($specs)
    {
        $this->printingTechnology = $specs['Print Technology'] ?? ['Print Technology' => ''];
        $this->printerType = $specs['Printer Type'] ?? ['Printer Type' => ''];
        $this->maxResolution = $specs['Max Resolution'] ??= 0;
        $this->maxPaperSize = $specs['Max Paper Size'] ?? ['Max Paper Size' => ''];
        $this->connectivityTypes = $specs['connectivityTypes'] ?? ['connectivityTypes' => ''];
    }

    private function loadSwitchSpecs($specs)
    {
        $fields = ['Device Type', 'Number of Ports', 'Management Type', 'Network Speed', 'PoE Support', 'Connectivity Types'];
        foreach ($fields as $field) {
            $property = lcfirst(str_replace(' ', '', $field));
            $this->$property = $specs[$field] ?? [$field => ''];
        }
        $this->dispatch('consoleLog', [
            'specifications' => $this->specifications,
            'asset_id' => $this->assetId,
            'type' => $this->assetType,
        ]);
    }

    private function loadComputerSpecs($specs, $isServer)
    {
        $template = $this->template[$this->assetType] ?? [
            "max_cpu_sockets" => 0,
            "ram_slots" => 0,
            "storage_slots" => 0,
            "max_psu_slots" => 0,
            "extra_fields" => []
        ];

        $this->maxPsu = $isServer ? 2 : 1;
        $this->maxStorage = $template["storage_slots"];

        $defaultComponent = [
            'cpus' => ['model' => '', 'cores' => '', 'clock_speed' => '', 'hyperthreading' => false],
            'rams' => ['model' => '', 'size' => ''],
            'gpus' => ['model' => '', 'vram' => '', 'clock_speed' => ''],
            'storages' => ['type' => '', 'capacity' => '']
        ];

        foreach ($defaultComponent as $key => $default) {
            $this->$key = $specs[$key] ?? [$default];
        }

        $this->psus = $specs['psus'] ?? array_fill(0, $this->maxPsu, ['model' => '', 'wattage' => '', 'efficiency' => '']);
        
        if (!$isServer) {
            $this->extraFields = $specs['extra_fields'] ?? array_fill_keys($template["extra_fields"], '');
        }

        $this->totalPowerConsumption = $this->getTotalPowerConsumptionProperty();
        $this->dispatch('powerUpdated', $this->totalPowerConsumption);
        $this->runValidationChecks();
    }

    private function loadCctvSpecs($specs)
    {
        $fields = [
            'CCTV Technology' => 'cctvTechnology',
            'Installation Location' => 'installationType',
            'Resolution' => 'cctvResolution',
            'Storage' => 'storageType',
            'ColorVu' => 'colorVu',
            'Night Vision' => 'nightVision',
            'Infrared (IR) Support' => 'infrared',
            'Motion Detection' => 'motionDetection',
            'Power Source' => 'powerSource'
        ];

        foreach ($fields as $specKey => $property) {
            $this->$property = $specs[$specKey] ?? [$specKey => ''];
        }

        $this->cctvResolution = $specs['Resolution'] ??= 0;
        
        $this->dispatch('consoleLog', [
            'specifications' => $specs,
            'asset_id' => $this->assetId,
            'type' => $this->assetType,
        ]);
    }

    public function mount($assetId = null)
    {
        if ($assetId) {
            $this->loadAsset($assetId);

        }
    }
    
    public function addCpuSlot()
    {
        if (count($this->cpus) < $this->maxCpu) {
            $this->cpus[] = ['model' => '', 'cores' => '', 'clock_speed' => '', 'hyperthreading' => false];
        }
    }

    // public function removeCpuSlot($index)
    // {
    //     unset($this->cpus[$index]);
    //     $this->cpus = array_values($this->cpus);
    // }

    public function removeCpuSlot($index)
    {
        if (isset($this->cpus[$index])) {
            unset($this->cpus[$index]);
            $this->cpus = array_values($this->cpus);
            $this->dispatch('$refresh'); // Force UI refresh
            $this->updatePowerConsumption();
        }
    }

    public function addRamSlot()
    {
        if (count($this->rams) < $this->maxRam) {
            $this->rams[] = ['model' => '', 'size' => ''];
        }
    }

    // public function removeRamSlot($index)
    // {
    //     unset($this->rams[$index]);
    //     $this->rams = array_values($this->rams);
    // }
    public function removeRamSlot($index)
    {
        if (isset($this->rams[$index])) {
            unset($this->rams[$index]);
            $this->rams = array_values($this->rams);
            $this->dispatch('$refresh'); // Force UI refresh
            $this->updatePowerConsumption();
        }
    }

    public function addGpuSlot()
    {
        $this->gpus[] = ['model' => '', 'vram' => '', 'clock_speed' => ''];
    }

    // public function removeGpuSlot($index)
    // {
    //     unset($this->gpus[$index]);
    //     $this->gpus = array_values($this->gpus);
    // }
    public function removeGpuSlot($index)
    {
        if (isset($this->gpus[$index])) {
            unset($this->gpus[$index]);
            $this->gpus = array_values($this->gpus);
            $this->dispatch('$refresh'); // Force UI refresh
            $this->updatePowerConsumption();
        }
    }

    public function addPsuSlot()
    {
        if (count($this->psus) < $this->maxPsu) {
            $this->psus[] = ['model' => '', 'wattage' => '', 'efficiency' => ''];
            $this->dispatch('$refresh'); // Force UI refresh
            $this->updatePowerConsumption();
        }

    }

    public function removePsuSlot($index)
    {
        unset($this->psus[$index]);
        $this->psus = array_values($this->psus);
        $this->dispatch('$refresh'); // Force UI refresh
        $this->updatePowerConsumption();
    }

    public function getTotalCpuClockProperty()
    {
        return array_sum(array_map(fn($cpu) => (float) ($cpu['clock_speed'] ?? 0), $this->cpus));
    }
    
    public function getTotalCpuClockWithHTProperty()
    {
        return array_sum(array_map(function ($cpu) {
            $clockSpeed = (float) ($cpu['clock_speed'] ?? 0);
            return !empty($cpu['hyperthreading']) ? $clockSpeed * 2 : $clockSpeed;
        }, $this->cpus));
    }
    
    public function getTotalCpuCoresProperty()
    {
        return array_sum(array_map(fn($cpu) => (int) ($cpu['cores'] ?? 0), $this->cpus));
    }
    
    public function getTotalCpuPerformanceProperty()
    {
        return array_sum(array_map(fn($cpu) => ((float) ($cpu['clock_speed'] ?? 0)) * ((int) ($cpu['cores'] ?? 0)), $this->cpus));
    }
    
    public function getTotalCpuPerformanceWithHTProperty()
    {
        return array_sum(array_map(function ($cpu) {
            $clockSpeed = (float) ($cpu['clock_speed'] ?? 0);
            $cores = (int) ($cpu['cores'] ?? 0);
            $multiplier = !empty($cpu['hyperthreading']) ? 2 : 1;
            return $clockSpeed * $cores * $multiplier;
        }, $this->cpus));
    }

    public function getTotalRamSizeProperty()
    {
        return array_sum(array_map(fn($ram) => (int) ($ram['size'] ?? 0), $this->rams));
    }

    public function validateRamCompatibility()
    {
        $types = array_unique(array_map(fn($ram) => $ram['type'] ?? '', $this->rams));

        if (count($types) > 1) {
            $this->addError('rams', 'All RAM modules must be of the same memory type.');
            return false;
        }

        return true;
    }

    // public function hasMixedRamTypes(): bool
    // {
    //     $ramTypes = array_filter(array_column($this->rams, 'type')); // Get all selected RAM types
    //     $this->disableSubmit = true;
    //     return count(array_unique($ramTypes)) > 1; // Check if more than one unique type exists
    // }
    public function getHasMixedRamTypesProperty(): bool
    {
        $ramTypes = array_filter(array_column($this->rams, 'type')); // Get all selected RAM types
        return count(array_unique($ramTypes)) > 1; // Check if more than one unique type exists
    }

    public function runValidationChecks()
    {
        $this->isPowerExceeded = $this->checkPowerConsumption();
        $this->hasMixedRamTypes = $this->checkRamTypes();
        $this->isMissingComponents = $this->checkMissingComponents(); // New validation check

        // Disable submit if any validation fails
        $this->isSubmitDisabled = $this->isPowerExceeded || $this->hasMixedRamTypes || $this->isMissingComponents;

        // Emit event if components are missing
        if ($this->isMissingComponents) {
            $this->dispatch('isMissingComponentsWarning');
        }

        // Debugging output
        $this->dispatch('consoleLog', [
            'isPowerExceeded' => $this->isPowerExceeded,
            'hasMixedRamTypes' => $this->hasMixedRamTypes,
            'isMissingComponents' => $this->isMissingComponents,
            'finalResult' => $this->isSubmitDisabled
        ]);
    }

    public function checkMissingComponents(): bool
    {
        return empty($this->cpus) || empty($this->rams) || empty($this->storages) || empty($this->psus);
    }

    public function checkPowerConsumption(): bool
    {
        $psuWattage = $this->psus[0]['wattage'] ?? 0;
        $totalPower = $this->totalPowerConsumption ?? 0;
        return $psuWattage && $totalPower > $psuWattage;
    }

    public function checkRamTypes(): bool
    {
        $ramTypes = array_filter(array_column($this->rams, 'type'));
        return count(array_unique($ramTypes)) > 1;
    }

    public function getPowerWarningProperty()
    {
        $psuWattage = $this->psus[0]['wattage'] ?? 0;
        $totalPower = $this->totalPowerConsumption ?? 0;
        // $psuWattage = $this->formattedSpecifications['psus'][0]['wattage'] ?? 0;
        // $totalPower = $this->formattedSpecifications['totalPowerConsumption'] ?? 0;


        // var_dump($psuWattage);
        // var_dump($totalPower);
        return $psuWattage && $totalPower > $psuWattage
            ? "⚠️ Warning: Total power consumption ({$totalPower}W) exceeds PSU capacity ({$psuWattage}W)."
            : null;
    }

    public function getRamTypeWarningProperty()
    {
        $ramTypes = array_filter(array_column($this->rams, 'type')); // Extract RAM types
        $uniqueRamTypes = array_unique($ramTypes);

        return count($uniqueRamTypes) > 1
            ? "⚠️ Warning: Mixed RAM types detected (" . implode(', ', $uniqueRamTypes) . "). Please use matching RAM types."
            : null;
    }

    public function getIsPowerExceededProperty()
    {
        $psuWattage = $this->psus[0]['wattage'] ?? 0;
        $totalPower = $this->totalPowerConsumption ?? 0;

        return $psuWattage && $totalPower > $psuWattage;
    }

    public function getMissingComponentsWarningProperty()
    {
        $missing = [];

        if (empty($this->cpus)) {
            $missing[] = 'CPU';
        }
        if (empty($this->rams)) {
            $missing[] = 'RAM';
        }
        if (empty($this->storages)) {
            $missing[] = 'Storage';
        }
        if (empty($this->psus)) {
            $missing[] = 'PSU';
        }

        return count($missing) > 0
            ? "⚠️ Warning: Missing required components: " . implode(', ', $missing) . "."
            : null;
    }

    public function getTotalStorageCapacityProperty()
    {
        return array_sum(array_map(fn($storage) => (int) $storage['capacity'], $this->storages));
    }

    public function addStorageSlot()
    {
        if (count($this->storages) < $this->maxStorage) {
            $this->storages[] = ['type' => '', 'capacity' => ''];
        }
    }

    // public function removeStorageSlot($index)
    // {
    //     unset($this->storages[$index]);
    //     $this->storages = array_values($this->storages);
    // }

    public function removeStorageSlot($index)
    {
        if (isset($this->storages[$index])) {
            unset($this->storages[$index]);
            $this->storages = array_values($this->storages);
            $this->dispatch('$refresh'); // Force UI refresh
            $this->updatePowerConsumption();
        }
    }
    

    public function updatedType()
    {
        $this->cpus = [];
        $this->rams = [];
        $this->totalRam = 0;
        $this->totalCores = 0;
        $this->extraFields = $this->assets[$this->type]['extra_fields'] ?? [];
    }

    public function calculateTotalRam()
    {
        $this->totalRam = array_sum(array_column($this->rams, 'size'));
    }

    public function calculateTotalCores()
    {
        $this->totalCores = array_sum(array_column($this->cpus, 'cores'));
    }

    public function validatePsuCapacity()
    {
        $totalPower = $this->totalPowerConsumption;
        $psuWattage = array_sum(array_column($this->psus ?? [], 'wattage'));

        if ($psuWattage < $totalPower) {
            $this->addError('psu', '⚠️ PSU wattage is insufficient! Consider upgrading.');
            return false;
        }

        return true;
    }


    public function getTotalPowerConsumptionProperty()
    {
        $totalPower = 0;

        // CPU Power Calculation: Each core ~ 15W + Clock Speed ~ 5W per GHz
        $cpuPower = array_sum(array_map(function ($cpu) {
            return isset($cpu['cores'], $cpu['clock_speed']) 
                ? ((int) $cpu['cores'] * 15 + (float) $cpu['clock_speed'] * 5) 
                : 0;
        }, $this->cpus ?? []));

        // GPU Power Calculation: VRAM ~ 10W per GB + Clock Speed ~ 3W per GHz
        $gpuPower = array_sum(array_map(function ($gpu) {
            return isset($gpu['vram'], $gpu['clock_speed']) 
                ? ((int) $gpu['vram'] * 10 + ((float) $gpu['clock_speed'] * 0.003)) // Convert MHz to GHz
                : 0;
        }, $this->gpus ?? []));

        // RAM Power Calculation: Assume 5W per RAM stick
        $ramPower = count($this->rams ?? []) * 5;

        // Storage Power Calculation: Assume 10W per storage device
        $storagePower = count($this->storages ?? []) * 10;

        // Base power consumption for motherboard, cooling, etc.
        $basePower = 50;

        // Total Power Calculation
        $totalPower = $cpuPower + $gpuPower + $ramPower + $storagePower + $basePower;

        // Logging the final power consumption
        Log::info("Total Power Consumption Calculated: " . $totalPower);

        return max($totalPower, 0); // Ensure no negative values
    }

    public function saveSpec()
    {
        // dd($this->connectivityTypes);

        $validations = [
            'monitor' => [
                'assetType' => 'required',
                'screenSize' => 'required',
                'panelType' => 'required',
            ],
            'printer' => [
                'printingTechnology' => 'required',
                'printerType' => 'required',
                'maxPaperSize' => 'required',
            ],
            'computer' => [
                'assetType' => 'required',
                'cpus' => 'required|array|min:1',
                'cpus.*.model' => 'nullable|string',
                'cpus.*.cores' => 'nullable|integer|min:1',
                'cpus.*.clock_speed' => 'nullable|numeric|min:1',
                'cpus.*.hyperthreading' => 'boolean',
                'rams' => 'required|array|min:1',
                'rams.*.size' => 'nullable|integer|min:1',
                'storages' => 'required|array|min:1',
                'storages.*.type' => 'required|string',
                'storages.*.capacity' => 'required|integer|min:1',
                'psus' => 'required|array|min:1',
                'psus.*.model' => 'required|string',
                'psus.*.wattage' => 'required|integer|min:1',
            ],
            'server' => [
                'cpus' => 'required|array|min:1',
                // 'cpus.*.model' => 'nullable|string',
                // 'cpus.*.cores' => 'nullable|integer|min:1',
                // 'cpus.*.clock_speed' => 'nullable|numeric|min:1',
                // 'cpus.*.hyperthreading' => 'boolean',
                // 'rams' => 'required|array|min:1',
                // 'rams.*.size' => 'nullable|integer|min:1',
                // 'storages' => 'required|array|min:1',
                // 'storages.*.type' => 'required|string',
                // 'storages.*.capacity' => 'required|integer|min:1',
                // 'psus' => 'required|array|min:1',
                // 'psus.*.model' => 'required|string',
                // 'psus.*.wattage' => 'required|integer|min:1',
            ],
            'switch' => [
                'deviceType' => 'required',
                'numPorts' => 'required|integer|min:1',
                'networkSpeed' => 'required|string',
                'managed' => 'required',
                'poeSupport' => 'required',
                'connectivityTypes' => 'array|min:1',
            ],
            'cctv' => [
                'cctvTechnology' => 'required',
                'installationType' => 'required',
                'cctvResolution' => 'required',
                'storageType' => 'required',
                'colorVu' => 'required',
                'nightVision' => 'required',
                'infrared' => 'required',
                'motionDetection' => 'required',
                'powerSource' => 'required',
            ],
        ];

        $specifications = [
            'monitor' => [
                'Screen Size (inches)' => $this->screenSize,
                'Panel Type' => $this->panelType,
                'connectivityTypes' => $this->connectivityTypes,
            ],
            'printer' => [
                'Print Technology' => $this->printingTechnology,
                'Printer Type' => $this->printerType,
                'Max Paper Size' => $this->maxPaperSize,
                'Max Resolution' => $this->maxResolution ?? '-',
                'connectivityTypes' => $this->connectivityTypes,
            ],
            'switch' => [
                'Device Type' => $this->deviceType,
                'Number of Ports' => $this->numPorts,
                'Network Speed' => $this->networkSpeed,
                'Management Type' => $this->managed,
                'PoE Support' => $this->poeSupport,
                'Connectivity Types' => $this->connectivityTypes,
            ],
            'computer' => [
                'cpus' => $this->filterEmptyItems($this->cpus, ['model', 'cores']),
                'rams' => $this->filterEmptyItems($this->rams, ['model', 'size', 'type']),
                'gpus' => $this->filterEmptyItems($this->gpus, ['model', 'vram', 'clock_speed']),
                'psus' => $this->filterEmptyItems($this->psus, ['model', 'wattage']),
                'storages' => $this->filterEmptyItems($this->storages, ['type', 'capacity']),
                'extra_fields' => $this->filterEmptyItems($this->extraFields, ['name', 'value']),
                'maxCpu' => $this->maxCpu,
                'maxRam' => $this->maxRam,
                'maxStorage' => $this->maxStorage,
                'maxPsu' => $this->maxPsu,
                'screenSize' => $this->screenSize,
                'totalStorageCapacity' => $this->calculateTotalStorage(),
                'totalPowerConsumption' => $this->calculateTotalPowerConsumption(),
            ],
            'server' => [
                'cpus' => $this->filterEmptyItems($this->cpus, ['model', 'cores']),

                // 'cpus' => $this->filterEmptyItems($this->cpus, ['model', 'cores', 'clock_speed', 'hyperthreading']),
                'rams' => $this->filterEmptyItems($this->rams, ['model', 'size', 'type']),
                'gpus' => $this->filterEmptyItems($this->gpus, ['model', 'vram', 'clock_speed']),
                'psus' => $this->filterEmptyItems($this->psus, ['model', 'wattage']),
                'storages' => $this->filterEmptyItems($this->storages, ['type', 'capacity']),
                'extra_fields' => $this->filterEmptyItems($this->extraFields, ['name', 'value']),
                'maxCpu' => $this->maxCpu,
                'maxRam' => $this->maxRam,
                'maxStorage' => $this->maxStorage,
                'maxPsu' => $this->maxPsu,
                'screenSize' => $this->screenSize,
                'totalStorageCapacity' => $this->calculateTotalStorage(),
                'totalPowerConsumption' => $this->calculateTotalPowerConsumption(),
            ],
            'cctv' => [
                'CCTV Technology' => $this->cctvTechnology,
                'Installation Location' => $this->installationType,
                'Resolution' => $this->cctvResolution,
                'Storage' => $this->storageType,
                'ColorVu' => $this->colorVu,
                'Night Vision' => $this->nightVision,
                'Infrared (IR) Support' => $this->infrared,
                'Motion Detection' => $this->motionDetection,
                'Power Source' => $this->powerSource,
            ],
        ];

        try {
            $asset = Asset::where('id', $this->assetId)->firstOrFail();

            // Perform validation if applicable
            if (isset($validations[$this->assetType])) {
                $this->validate($validations[$this->assetType]);
            }

            // Assign specifications
            $asset->specifications = json_encode($specifications[$this->assetType] ?? $this->specifications);

            
            $asset->save();

            // dd($asset->specifications);

    
            // session()->flash('success', 'Asset added successfully!');
            $this->dispatch('success', ('Asset Spesification Changed Successfully!'));

        } catch (ValidationException $e) {
            $errors = $e->validator->getMessageBag()->toArray();
            $errorMessage = '';
            foreach ($errors as $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $errorMessage .= $error . '<br>';
                }
            }
            // $this->dispatch('toast', message: $errorMessage, type: 'error');
            $this->dispatch('toast', detail: ['message' => $errorMessage, 'type' => 'error']);

        }

        // if (!$this->validateRamCompatibility()) {
        //     return;
        // }

        // if (!$this->validatePsuCapacity()) {
        //     return;
        // }


    }

    public function render()
    {
        return view('itam::livewire.add-asset-spesification');
    }

    public function updatedCpus()
    {
        $this->updatePowerConsumption();
    }

    public function updatedGpus()
    {
        $this->updatePowerConsumption();
    }

    public function updatedRams()
    {
        $this->updatePowerConsumption();
        $this->runValidationChecks(); // Run checks on form load

    }

    public function updatedPsus()
    {
        $this->updatePowerConsumption();
        $this->runValidationChecks(); // Run checks on form load

    }

    public function updatedStorages()
    {
        $this->updatePowerConsumption();
    }

    private function updatePowerConsumption()
    {
        $this->totalPowerConsumption = $this->getTotalPowerConsumptionProperty();
        $this->runValidationChecks(); // Run checks on form load

        $this->dispatch('powerUpdated', $this->totalPowerConsumption);

    }

    private function filterEmptyItems(array $items, array $requiredKeys): array
    {
        return array_filter($items, function ($item) use ($requiredKeys) {
            foreach ($requiredKeys as $key) {
                if (empty($item[$key])) {
                    return false;
                }
            }
            return true;
        });
    }

    private function calculateTotalStorage(): int
    {
        return array_sum(array_map(fn($storage) => (int) $storage['capacity'], $this->storages));
    }

    private function calculateTotalPowerConsumption(): float
    {
        $cpuPower = array_sum(array_map(fn($cpu) => $this->getCpuPower($cpu), $this->cpus));
        $gpuPower = array_sum(array_map(fn($gpu) => $this->getGpuPower($gpu), $this->gpus));

        // RAM Power: Assume 5W per RAM stick
        $ramPower = count($this->rams ?? []) * 5;

        // Storage Power: Assume 10W per storage device
        $storagePower = count($this->storages ?? []) * 10;

        // Base Power: Motherboard, cooling, etc.
        $basePower = 50;

        return $cpuPower + $gpuPower + $ramPower + $storagePower + $basePower;
    }

    private function getCpuPower(array $cpu): float
    {
        // return isset($cpu['cores'], $cpu['clock_speed'])
        //     ? (int) $cpu['cores'] * (float) $cpu['clock_speed'] * 10 // Example power formula
        //     : 0;

            $cpuPower = array_sum(array_map(function ($cpu) {
                return isset($cpu['cores'], $cpu['clock_speed']) 
                    ? ((int) $cpu['cores'] * 15 + (float) $cpu['clock_speed'] * 5) 
                    : 0;
            }, $this->cpus ?? []));
        
        return $cpuPower;
    }

    private function getGpuPower(array $gpu): float
    {
        // return isset($gpu['vram'], $gpu['clock_speed'])
        //     ? (float) $gpu['vram'] * (float) $gpu['clock_speed'] * 5 // Example power formula
        //     : 0;
        $gpuPower = array_sum(array_map(function ($gpu) {
            return isset($gpu['vram'], $gpu['clock_speed']) 
                ? ((int) $gpu['vram'] * 10 + ((float) $gpu['clock_speed'] * 0.003)) // Convert MHz to GHz
                : 0;
        }, $this->gpus ?? []));

        return $gpuPower;
    }

    

}
