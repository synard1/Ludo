<?php

namespace Modules\AdsPortal\Http\Livewire;

use Livewire\Component;
use Modules\AdsPortal\Entities\Ads;
use Modules\AdsPortal\Entities\AdsClient;
use Modules\AdsPortal\Entities\AdsSite;
use GuzzleHttp\Client;


class AdsImage extends Component
{
    public $name;
    public $url;
    public $type = 'image';
    public $status;
    public $duration = '1';
    public $clients;
    public $client_id;
    public $ads_id;
    public $adsId;
    public $sites;
    public $site_id;

    protected $rules = [
        'name' => 'required|min:3',
        'url' => 'required|active_url',
        'duration' => 'required|integer|max:300',
        'client_id' => 'required',
        'site_id' => '',
        'type' => 'required',
        'status' => '',
    ];

    // This is the list of listeners that this component listens to.
    // protected $listeners = ['modal.show.site_id' => 'mountSite'];
    protected $listeners = [
        'modal.show.ads_id' => 'mountAds',
        'delete_adsImage' => 'delete'
    ];

    public function render()
    {
        // return view('adsportal::livewire.adss');
        return view('adsportal::livewire.ads-image');
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

    public function submitAdsImage()
    {
        $this->validate();
        $client = new Client();
        $response = $client->head($this->url);

        $contentType = $response->getHeaderLine('content-type');

        $imageMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/svg+xml', 'image/webp'];

        if (in_array($contentType, $imageMimeTypes)) {
            // echo "The URL points to an image.";
            Ads::updateOrCreate(['id' => $this->adsId], [
                'user_id' => auth()->id(),
                'name' => $this->name,
                'url' => $this->url,
                'status' => $this->status,
                'duration' => '1',
                'type' => 'image',
                'client_id' => $this->client_id,
            ]);

            $this->emit('success', 'Ads ' . ucwords($this->name) . ' successfully updated');

            $this->resetForm();
        } else{
            $this->emit('error', 'URL ' . ucwords($this->url) . ' not an image');
        } 

        

        
    }

    // public function submitAdsVideo()
    // {
    //     $this->validate();        

    //     Ads::updateOrCreate(['id' => $this->adsId], [
    //             'user_id' => auth()->id(),
    //             'name' => $this->name,
    //             'url' => $this->url,
    //             'status' => $this->status,
    //             'duration' => $this->duration,
    //             'type' => $this->type,
    //             'client_id' => $this->client_id,
    //     ]);

    //     $this->emit('success', 'Ads ' . ucwords($this->name) . ' successfully updated');

    //     $this->resetForm();
    // }

    private function resetForm()
    {
        // Reset the $name property to an empty string
        $this->name = '';
        $this->url = '';
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
