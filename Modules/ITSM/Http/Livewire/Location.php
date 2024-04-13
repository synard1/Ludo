<?php

namespace Modules\ITSM\Http\Livewire;

use Livewire\Component;
use Modules\ITSM\Entities\Reported;


class Location extends Component
{
    public $selectedLocation;
    public $locationName;

    public function mount()
    {
        $user = auth()->user();

        $this->locationName = Reported::distinct('location')
                                        ->where('user_cid',$user->cid)
                                        ->pluck('location')
                                        ->filter()
                                        ->toArray();
    }

    public function updatedselectedLocation()
    {
        if (!in_array($this->selectedLocation, $this->locationName)) {
            $this->locationName[] = $this->selectedLocation;
        }
    }

    public function render()
    {
        return view('itsm::livewire.location');
    }
}
