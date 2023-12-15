<?php

namespace Modules\Helpdesk\Http\Livewire;

use Livewire\Component;
use Modules\Helpdesk\Entities\Ticket;

class ReporterSelect extends Component
{
    public $selectedReporter;
    public $reporterNames;

    public function mount()
    {
        $user = auth()->user();
        $userId = $user->id;
        $cid = $user->cid;

        $this->reporterNames = Ticket::distinct('reporter_name')
                                        ->where('user_cid',$cid)
                                        ->pluck('reporter_name')
                                        ->filter()
                                        ->toArray();
    }

    public function updatedSelectedReporter()
    {
        if (!in_array($this->selectedReporter, $this->reporterNames)) {
            $this->reporterNames[] = $this->selectedReporter;
            $this->selectedReporter = null; // Reset selected value
            $this->dispatchBrowserEvent('clearSelect2'); // Trigger a custom event
            // You can choose to save the new tag to the database or handle it as needed.
            // For example, to save it to the database, you would do something like:
            // Ticket::create(['reporter_name' => $this->selectedReporter]);

            // For this example, we'll just add it to the list for demonstration.
            // $this->reporterNames[] = $this->selectedReporter;
        }
    }

    public function render()
    {
        return view('helpdesk::livewire.reporter-select');
    }
}
