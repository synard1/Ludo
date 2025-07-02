<div class="row g-3">
    <!-- CCTV Technology Selection -->
    <div class="col-12">
        <div class="form-floating">
            <select wire:model="cctvTechnology" class="form-select shadow-sm" id="cctvTechnologySelect">
                <option value="" selected>🔽 Select CCTV Technology</option>
                <option value="Analog">📡 Analog CCTV</option>
                <option value="IP Camera">🌐 IP CCTV</option>
            </select>
            <label for="cctvTechnologySelect">🔬 CCTV Technology</label>
        </div>
    </div>

    <!-- Installation Type (Indoor/Outdoor) -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="installationType" class="form-select shadow-sm" id="installationTypeSelect">
                <option value="" selected>🔽 Select Installation Location</option>
                <option value="Indoor">🏠 Indoor</option>
                <option value="Outdoor">🌳 Outdoor</option>
            </select>
            <label for="installationTypeSelect">📍 Installation Location</label>
        </div>
    </div>

    <!-- Options Based on CCTV Technology -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <input type="text" wire:model.defer="cctvResolution" class="form-control shadow-sm" id="resolutionInput" placeholder=" ">
            <label for="resolutionInput">🖼️ Resolution (e.g. 720p, 1080p)</label>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="storageType" class="form-select shadow-sm" id="storageTypeSelect">
                <option value="" selected>🔽 Select Storage</option>
                <option value="DVR">📼 DVR (Digital Video Recorder)</option>
                <option value="NVR">💾 NVR (Network Video Recorder)</option>
                <option value="Cloud">☁️ Cloud Storage</option>
                <option value="SD Card">📀 SD Card</option>
            </select>
            <label for="storageTypeSelect">💾 Storage</label>
        </div>
    </div>

    <!-- Additional Features -->
    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="colorVu" class="form-select shadow-sm" id="colorVuSelect">
                <option value="" selected>🔽 Select ColorVu Support</option>
                <option value="Yes">🌈 Yes</option>
                <option value="No">🚫 No</option>
            </select>
            <label for="colorVuSelect">🌈 ColorVu (Full Color Night Vision)</label>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="nightVision" class="form-select shadow-sm" id="nightVisionSelect">
                <option value="" selected>🔽 Select Night Vision Feature</option>
                <option value="Yes">🌙 Yes</option>
                <option value="No">🚫 No</option>
            </select>
            <label for="nightVisionSelect">🌙 Night Vision</label>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="infrared" class="form-select shadow-sm" id="infraredSelect">
                <option value="" selected>🔽 Select Infrared Feature</option>
                <option value="Yes">🔦 Yes</option>
                <option value="No">🚫 No</option>
            </select>
            <label for="infraredSelect">🔦 Infrared (IR) Support</label>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="motionDetection" class="form-select shadow-sm" id="motionDetectionSelect">
                <option value="" selected>🔽 Select Motion Detection Feature</option>
                <option value="Yes">🎯 Yes</option>
                <option value="No">🚫 No</option>
            </select>
            <label for="motionDetectionSelect">🎯 Motion Detection</label>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-floating">
            <select wire:model="powerSource" class="form-select shadow-sm" id="powerSourceSelect">
                <option value="" selected>🔽 Select Power Source</option>
                <option value="PoE">⚡ PoE (Power over Ethernet)</option>
                <option value="Adapter">🔌 Adapter</option>
                <option value="Battery">🔋 Battery</option>
            </select>
            <label for="powerSourceSelect">🔋 Power Source</label>
        </div>
    </div>

</div>
