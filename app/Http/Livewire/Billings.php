<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class Billings extends Component
{    public $invoices;
    public $sortfield='invoice_no';
    public $sortdirection='asc';
    public $searchtext='';
    public $filtertext=null;

    public function mount()
    {
       $this->invoices=Invoice::whereaccount_id(Auth::user()->current_team_id)->orderBy('invoice_no', 'asc')
       ->orderBy('invoice_description', 'asc')
       ->orderBy('price_ex_tax', 'asc')->orderBy('invoice_date', 'asc')->get();

    }
    /* searching method*/


    /*sorting methods*/
    // invoiceno method
    public function sortBy($field)
    {
      if( $this->sortfield===$field)
      {
        $this->sortdirection=$this->sortdirection==='asc'?'desc':'asc';
      }
      else
      {
        $this->sortdirection='asc';
      }
      $this->sortfield=$field;
    }


    /*end of methods */
    // filter
    public function setfilter($filter)
    {
        $this->filtertext=$filter;
    }
    public function render()
    {
        if($this->filtertext!=null&&$this->searchtext=='')
        {$this->invoices=Invoice::whereaccount_id(Auth::user()->current_team_id)
        ->where('status',$this->filtertext)
        ->orderBy($this->sortfield,  $this->sortdirection)->get();}
        else
        {
            $this->invoices=Invoice::whereaccount_id(Auth::user()->current_team_id)
            ->where('invoice_no','like','%' .$this->searchtext.'%')->orwhere('invoice_description','like', '%' .$this->searchtext.'%' )
            ->orwhere('price_ex_tax','like','%' .$this->searchtext.'%')->orwhere('invoice_date','like','%' .$this->searchtext.'%')
            ->orwhere('status','like','%' .$this->searchtext.'%')
            ->orderBy($this->sortfield,  $this->sortdirection)->get();
        }
        return view('livewire.billings');
    }
}
