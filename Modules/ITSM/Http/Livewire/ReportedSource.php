<?php

namespace Modules\ITSM\Http\Livewire;

use Livewire\Component;
use Modules\ITSM\Entities\Reported;

class ReportedSource extends Component
{
    public $selectedSources;
    public $sourceReport;

    public function mount()
    {
        $user = auth()->user();

        $this->sourceReport = Reported::distinct('source')
                                        ->where('user_cid',$user->cid)
                                        ->pluck('source')
                                        ->filter()
                                        ->toArray();
    }

    public function updatedSelectedSources()
    {
        if (!in_array($this->selectedSources, $this->sourceReport)) {
            $this->sourceReport[] = $this->selectedSources;
            $this->selectedSources = null; // Reset selected value
            $this->dispatchBrowserEvent('clearSelect2'); // Trigger a custom event
        }
    }

    public function render()
    {
        return view('itsm::livewire.reported-source');
    }
}
