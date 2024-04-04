<?php

namespace Modules\Helpdesk\Http\Livewire;

use Livewire\Component;
use Modules\Helpdesk\Entities\Ticket;

class UnitSelect extends Component
{

    public $selectedUnit;
    public $UnitNames;

    public function mount()
    {
        $user = auth()->user();
        $userId = $user->id;
        $cid = $user->cid;

        $this->UnitNames = Ticket::distinct('origin_unit')
                                        ->where('user_cid',$cid)
                                        ->pluck('origin_unit')
                                        ->filter()
                                        ->toArray();
    }

    public function updatedselectedUnit()
    {
        if (!in_array($this->selectedUnit, $this->UnitNames)) {
            // You can choose to save the new tag to the database or handle it as needed.
            // For example, to save it to the database, you would do something like:
            // Ticket::create(['reporter_name' => $this->selectedUnit]);

            // For this example, we'll just add it to the list for demonstration.
            $this->UnitNames[] = $this->selectedUnit;
        }
    }

    public function render()
    {
        return view('helpdesk::livewire.unit-select');
    }
}
