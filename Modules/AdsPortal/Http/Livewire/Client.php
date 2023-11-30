<?php

namespace Modules\AdsPortal\Http\Livewire;

use Livewire\Component;
use Modules\AdsPortal\Entities\AdsClient;

class Client extends Component
{
    public $name;
    public $address;
    public $pic;
    public $pic_phone;
    public $clientId;
    public $adsclient_id;

    protected $rules = [
        'name' => 'required|min:3',
        'address' => 'required|min:3',
        'pic' => '',
        'pic_phone' => '',
    ];

    // This is the list of listeners that this component listens to.
    // protected $listeners = ['modal.show.site_id' => 'mountSite'];
    protected $listeners = [
        'modal.show.client_id' => 'mountClient',
        'delete_client' => 'delete'
    ];

    public function render()
    {
        return view('adsportal::livewire.client');
    }

    public function mountClient($adsclient_id = '')
    {

        if ($adsclient_id) {
            $client = AdsClient::findOrFail($adsclient_id);
            $this->name = $client->name;
            $this->address = $client->address;
            $this->pic = $client->pic;
            $this->pic_phone = $client->pic_phone;
            $this->clientId = $client->id;
        }
        
    }

    public function mount($name = null)
    {
        if ($name) {
            $client = AdsClient::find($name);
            $this->name = $client->name;
            $this->address = $client->address;
            $this->pic = $client->pic;
            $this->pic_phone = $client->pic_phone;
            $this->clientId = $client->id;
        }
    }

    public function submit()
    {
        $this->validate();        

        AdsClient::updateOrCreate(['id' => $this->clientId], [
                'user_id' => auth()->id(),
                'name' => $this->name,
                'address' => $this->address,
                'pic' => $this->pic,
                'pic_phone' => $this->pic_phone,
        ]);

        $this->emit('success', 'Client ' . ucwords($this->name) . ' successfully updated');

        $this->resetForm();
    }

    private function resetForm()
    {
        // Reset the $name property to an empty string
        $this->name = '';
        $this->address = '';
        $this->pic = '';
        $this->pic_phone = '';
    }

    // public function delete($id)
    // {
    //     $client = AdsClient::where('id', $id)->first();

    //     if (!is_null($client)) {
    //         $client->delete();
    //     }

    //     $this->emit('success', 'Client ' . ucwords($this->name) . ' deleted');
    // }

    public function delete($id)
    {
        $client = AdsClient::with('ads')->where('id', $id)->first();

        if (!is_null($client)) {
            if ($client->ads->count() > 0) {
                $this->emit('error', 'Client ' . ucwords($client->name) . ' cannot be deleted because it has Ads associated with it');
            } else {
                $client->delete();
                $this->emit('success', 'Client ' . ucwords($client->name) . ' deleted');
            }
        } else {
            $this->emit('error', 'Client not found');
        }
    }
}
