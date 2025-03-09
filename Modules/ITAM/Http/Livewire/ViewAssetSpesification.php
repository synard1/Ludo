<?php

namespace Modules\ITAM\Http\Livewire;

use Livewire\Component;

use Modules\ITAM\Entities\Asset;


class ViewAssetSpesification extends Component
{

    public $formattedSpecifications = [];
    public $assetType;

    protected $listeners = [
        'viewDetails' => 'viewDetails',
    ];

    public function render()
    {
        return view('itam::livewire.view-asset-spesification');
    }

    public function viewDetails($assetId)
    {
        $asset = Asset::where('id', $assetId)->firstOrFail();

        // dd($asset);

        if ($asset) {
            $this->assetType = strtolower($asset->type->name);
            $this->formattedSpecifications = json_decode($asset->specifications, true);
            // Debugging output
            $this->dispatch('consoleLog', [
                'formattedSpecifications' => $this->formattedSpecifications
            ]);
            // dd($this->formattedSpecifications);
        } else {
            $this->formattedSpecifications = [];
        }

        $this->dispatch('showDetailsModal'); // Trigger modal
    }
}
