<?php

namespace Modules\AdsPortal\Http\Livewire;

use Livewire\Component;
use Modules\AdsPortal\Entities\AdsSite;

class AddSites extends Component
{
    public $name;
    public $address;
    public $pic;
    public $pic_phone;
    public $siteId;
    public $adssite_id;

    protected $rules = [
        'name' => 'required|min:3',
        'address' => 'required|min:3',
        'pic' => '',
        'pic_phone' => '',
    ];

    // This is the list of listeners that this component listens to.
    // protected $listeners = ['modal.show.site_id' => 'mountSite'];
    protected $listeners = [
        'modal.show.site_id' => 'mountSite',
        'delete_site' => 'delete'
    ];

    public function render()
    {
        return view('adsportal::livewire.add-sites');
    }

    public function mountSite($site_id = '')
    {
        
        // $this->emit('success', 'Site ' . ucwords($this->name) . ' have been added');
        // $this->emit('success', 'Site ' . ucwords($this->adssite_id) . ' have been added');

        if ($site_id) {
            $site = AdsSite::findOrFail($site_id);
            $this->name = $site->sites;
            $this->address = $site->address;
            $this->pic = $site->pic;
            $this->pic_phone = $site->pic_phone;
            $this->siteId = $site->id;
            // $this->emit('success', 'Site ' . ucwords($site) . ' have been');
            // $this->emit('success', 'Site ' . ucwords($this->name) . ' have been added');
        }
        
    }

    public function mount($name = null)
    {
        if ($name) {
            $site = AdsSite::find($name);
            $this->name = $site->name;
            $this->address = $site->address;
            $this->pic = $site->pic;
            $this->pic_phone = $site->pic_phone;
            $this->siteId = $site->id;
        }
    }

    public function submit()
    {
        $this->validate();

        // $this->emit('success', 'Site ' . ucwords($this->name) . ' successfully updated');
        

        AdsSite::updateOrCreate(['id' => $this->siteId], [
                'user_id' => auth()->id(),
                'sites' => $this->name,
                'address' => $this->address,
                'pic' => $this->pic,
                'pic_phone' => $this->pic_phone,
        ]);

        $this->emit('success', 'Site ' . ucwords($this->name) . ' successfully updated');

        // if ($this->name) {
        //     $site = AdsSite::findOrFail($this->name);
        //     $site->update([
        //         'sites' => $this->name,
        //         'address' => $this->address,
        //         'pic' => $this->pic,
        //         'pic_phone' => $this->pic_phone,
        //     ]);

        //     // session()->flash('message', 'Site successfully updated.');
        //     $this->emit('success', 'Site ' . ucwords($this->name) . ' successfully updated');
        // } else {
        //     AdsSite::create([
        //         'sites' => $this->name,
        //         'address' => $this->address,
        //         'pic' => $this->pic,
        //         'pic_phone' => $this->pic_phone,
        //     ]);

        //     // session()->flash('message', 'Site successfully created.');
        //     $this->emit('success', 'Site ' . ucwords($this->name) . ' have been added');
        // }

        

        // session()->flash('message', 'Site successfully created.');
        // $this->emit('success', 'Site ' . ucwords($this->name) . ' have been added');
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

    public function delete($id)
    {
        $site = AdsSite::where('id', $id)->first();

        if (!is_null($site)) {
            $site->delete();
        }

        $this->emit('success', 'Site deleted');
    }
}
