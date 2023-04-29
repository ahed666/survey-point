<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TypeSubscribe;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Auth;
class Subscriptions extends Component
{
    public $types;
    public $show=false;
    public $current_subscribe;
    // if user want upgrade
    public function upgrade_confirm()
    {
        $this->show=true;
        $this->mount();
    }
    public function mount()
    {
        $this->types=TypeSubscribe::all();
        $this->current_subscribe=Subscribe::join("type_of_subscriptions","type_of_subscriptions.id","=","subscriptions.type_of_subscription_id")
        ->where("subscriptions.account_id",Auth::user()->current_team_id)->select('subscriptions.*','type_of_subscriptions.subscription_type as type')
        ->first();

    }
    public function render()
    {
        return view('livewire.subscriptions');
    }
}
