<?php

namespace Modules\AdsPortal\Http\Livewire;

use Livewire\Component;
use Modules\AdsPortal\Entities\Ads;
use Modules\AdsPortal\Entities\AdsSchedule;
use Modules\AdsPortal\Entities\AdsSite;

class AdsSched extends Component
{
    public $name;
    public $url;
    public $status;
    public $duration;
    public $days;
    public $ads_time;
    public $clients;
    public $client_id;
    // public $sites;
    public $site_id;
    public $ads_id;
    public $adsId;

    protected $listeners = [
        'modal.show.ads_id' => 'mountAds',
        'delete_sched' => 'delete'
    ];

    public function mountAds($ads_id = '')
    {
        // $this->sites = AdsSite::all(); // Fetch all records from AdsSite model


        if ($ads_id) {
            $ads = Ads::findOrFail($ads_id);
            $this->name = $ads->name;
            $this->duration = $ads->duration;
            $this->client_id = $ads->client_id;
            $this->adsId = $ads->id;
        }

        
    }

    public function submit()
    {

        // check if these details already exist in the database
        $exists = AdsSchedule::where([
            'site_id' => $this->site_id,
            'ads_time' => $this->ads_time,
            'days' => $this->days,
        ])->first();

        if ($exists) {
            session()->flash('warning', 'Please select other days or times');
            $this->emit('error', 'Ads ' . ucwords($this->name) . $this->days . $this->ads_time . ' cannot added');
            return;
        }

        $ads = Ads::where('id',$this->adsId)->first();

        AdsSchedule::updateOrCreate([
            'ads_id' => $this->adsId,
            'client_id' => $this->client_id,
            'site_id' => $this->site_id,
            'ads_time' => $this->ads_time,
            'days' => $this->days,
            ], [
            'user_id' => auth()->id(),
            'status' => '2',
            'duration' => $this->duration,
            'url' => $ads->url,
        ]);

        $this->emit('success', 'Ads ' . ucwords($this->name) . $this->days . $this->ads_time . ' successfully updated');

        $this->resetForm();
    }

    private function resetForm()
    {
        // Reset the $name property to an empty string
        $this->ads_id = '';
        $this->client_id = '';
        $this->site_id = '';
        $this->ads_time = '';
        $this->days = '';
    }

//     public function render()
//     {
//         return view('adsportal::livewire.ads-sched');
//     }

    public function delete($id)
    {
        $sched = AdsSchedule::where('id', $id)->first();

        if (!is_null($sched)) {
            $sched->delete();
        }

        $this->emit('success', 'Schedule deleted');
    }

    public function render()
        {
            $sites = AdsSite::all();

            // Return the view with the sites variable passed in.
            return view('adsportal::livewire.ads-sched', compact('sites'));
        }
}
