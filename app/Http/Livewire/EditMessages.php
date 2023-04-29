<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SurveyTrnslations;
class EditMessages extends Component
{
    public $header=null;
    public $text=null;
    public $current_message_id=null;
    public $survey_id;
    public $type="";

    protected $listeners = [
        'edit_message'=>'editingmessage'
];
    public function editingmessage($type,$message)
    {

        $this->type=$type;
        $this->current_message_id=$message['id'];

        $this->survey_id=$message['survey_id'];

        if($this->type=='welcome')
        {
            $this->header=$message['survey_start_header'];
            $this->text=$message['survey_start_text'];
        }
        else
        {
            $this->header=$message['survey_end_header'];
            $this->text=$message['survey_end_text'];
        }

    }
    public function render()
    {
        return view('livewire.edit-messages');
    }
    public function resetvalue()
    {
        $this->header=null;
        $this->text=null;
        $this->current_message_id=null;

        $this->type=null;
    }
    public function edit()
    {
          $survey_trans=SurveyTrnslations::find($this->current_message_id);
          if($this->type=='welcome')
          {
            $survey_trans->survey_start_header=$this->header;
            $survey_trans->survey_start_text=$this->text;
            $survey_trans->save();
          }
          else
          {
            $survey_trans->survey_end_header=$this->header;
            $survey_trans->survey_end_text=$this->text;
            $survey_trans->save();
          }
            $this->resetvalue();
        // emit if message edit success

        $this->emit('messageeditsuccess',$this->survey_id);
    }
}
