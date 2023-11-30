<?php

namespace Modules\Helpdesk\Http\Livewire;

use Livewire\Component;
use Modules\Helpdesk\Entities\Ticket;

class SourceReport extends Component
{

    public $selectedSources;
    public $sourceReport;

    public function mount()
    {
        $user = auth()->user();
        $userId = $user->id;
        $cid = $user->cid;

        $this->sourceReport = Ticket::distinct('source_report')
                                        ->where('user_cid',$cid)
                                        ->pluck('source_report')
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
        return view('helpdesk::livewire.source-report');
    }
}
