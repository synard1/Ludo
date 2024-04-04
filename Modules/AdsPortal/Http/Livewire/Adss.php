<?php

namespace Modules\AdsPortal\Http\Livewire;

use Livewire\Component;
use Modules\AdsPortal\Entities\Ads;
use Modules\AdsPortal\Entities\AdsClient;
use Modules\AdsPortal\Entities\AdsSite;

class Adss extends Component
{
    public $name;
    public $url;
    public $type = 'video';
    public $status;
    public $duration;
    public $clients;
    public $client_id;
    public $ads_id;
    public $adsId;
    public $sites;
    public $site_id;
    public $source;

    protected $rules = [
        'name' => 'required|min:3',
        'url' => 'required|active_url',
        'duration' => 'required|integer|max:300',
        'client_id' => 'required',
        'source' => 'required',
        'site_id' => '',
        'type' => 'required',
        'status' => '',
    ];

    // This is the list of listeners that this component listens to.
    // protected $listeners = ['modal.show.site_id' => 'mountSite'];
    protected $listeners = [
        'modal.show.ads_id' => 'mountAds',
        'delete_ads' => 'delete'
    ];

    public function render()
    {
        $sources = config('onexolution.sourceAdsVideo');
        return view('adsportal::livewire.adss',compact('sources'));
    }

    public function mountAds($ads_id = '')
    {
        $this->sites = AdsSite::all(); // Fetch all records from AdsSite model

        if ($ads_id) {
            $ads = Ads::findOrFail($ads_id);
            $this->name = $ads->name;
            $this->url = $ads->url;
            $this->status = $ads->status;
            $this->duration = $ads->duration;
            $this->client_id = $ads->client_id;
            $this->type = $ads->type;
            $this->adsId = $ads->id;
            $this->sites = 'asdasddsa';
            // $this->emit('success', 'Site ' . ucwords($ads_id) . ' have been');
            // $this->emit('success', 'Site ' . ucwords($this->name) . ' have been added');
        }

        // $site = AdsSite::all();
        // $this->sites = $site;
        
    }

    public function mount($adsId = null)
    {
        $this->sites = AdsSite::all(); // Fetch all records from AdsSite model
        if ($adsId) {
            $ads = Ads::findOrFail($adsId);
            $this->name = $ads->name;
            $this->url = $ads->url;
            $this->status = $ads->status;
            $this->duration = $ads->duration;
            $this->adsId = $ads->id;
            $this->type = $ads->type;
            $this->client_id = $ads->client_id;

        }

        
        $client = AdsClient::all();
        $this->clients = $client;

        // $site = AdsSite::all();
        // $this->sites = $site;

        

    }

    public function submit()
    {
        $this->validate();        

        Ads::updateOrCreate(['id' => $this->adsId], [
                'user_id' => auth()->id(),
                'name' => $this->name,
                'url' => $this->url,
                'source' => $this->source,
                'status' => $this->status,
                'duration' => $this->duration,
                'type' => $this->type,
                'client_id' => $this->client_id,
        ]);

        $this->emit('success', 'Ads ' . ucwords($this->name) . ' successfully updated');

        $this->resetForm();
    }

    private function resetForm()
    {
        // Reset the $name property to an empty string
        $this->name = '';
        $this->url = '';
        $this->source = '';
        $this->status = '';
        $this->duration = '';
        $this->type = '';
        $this->client_id = '';
    }

    public function delete($adsId)
    {
        // $ads = Ads::where('id', $adsId)->first();

        // if (!is_null($ads)) {
        //     $ads->delete();
        // }

        // $this->emit('success', 'Ads deleted');
        $ads = Ads::where('id', $adsId)->first();

        if (!is_null($ads)) {
            // check if the ads has any AdsSchedule
            if ($ads->adsSchedules()->count() > 0) {
                $this->emit('error', 'Cannot delete Ads because it has associated Schedules, Remove it first.');
            } else {
                $ads->delete();
                $this->emit('success', 'Ads deleted');
            }
        } else {
            $this->emit('error', 'Ads not found');
        }
    }
}
