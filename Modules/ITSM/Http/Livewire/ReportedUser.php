<?php

namespace Modules\ITSM\Http\Livewire;

use Livewire\Component;
use Modules\ITSM\Entities\Reported;

class ReportedUser extends Component
{
    public $selectedUser;
    public $reportedNames;

    public function mount()
    {
        $user = auth()->user();

        $this->reportedNames = Reported::distinct('user')
                                        ->where('user_cid',$user->cid)
                                        ->pluck('user')
                                        ->filter()
                                        ->toArray();
    }

    public function updatedSelectedReporter()
    {
        if (!in_array($this->selectedUser, $this->reportedNames)) {
            $this->reportedNames[] = $this->selectedUser;
            $this->selectedUser = null; // Reset selected value
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
        return view('itsm::livewire.reported-user');
    }
}
