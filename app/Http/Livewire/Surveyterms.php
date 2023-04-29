<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Answers;
use App\Models\AnswersTranslation;
use App\Models\CustomQuestion;
use App\Models\Kiosk;
use App\Models\Logos;
use App\Models\Pictures;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\QuestionType;
use App\Models\Survey;
use App\Models\SurveyTrnslations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Surveyterms extends Component
{
    public $current_message_id=null;
    public $survey_id;
    public $terms=null;
    public $local;
    protected $listeners = [
        'edit_terms'=>'editingterms'
     ];
    public function editingterms($message)
    {


        $this->current_message_id=$message['id'];
        $this->local=SurveyTrnslations::whereid($this->current_message_id)->first()->survey_local;
        $this->survey_id=$message['survey_id'];
        $this->terms=$message['terms'];
        }
    public function resetvalue()
    {
        $this->current_message_id=null;
        $this->survey_id=null;
        $this->terms=null;
    }
    public function editterms()
    {
        $survey_trans=SurveyTrnslations::find($this->current_message_id);
        $survey_trans->terms=$this->terms;
        $survey_trans->save();
        $this->resetvalue();
        // emit if terms edit success
        $this->emit('termseditsuccess',$this->survey_id);
    }
    public function render()
    {
        return view('livewire.surveyterms');
    }
}
