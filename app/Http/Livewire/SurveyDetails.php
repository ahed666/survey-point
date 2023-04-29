<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\Survey;
class SurveyDetails extends Component
{
    public $survey_id;
    public $languages;
    public $lang = '[
        { "id": 1,"code":"en", "name": "english"},
        { "id": 2,"code":"ar" ,"name": "عربي"},
        { "id": 3, "code":"ur","name": "urdu"}
    ]';
    public $questions;

    public $surveys;

  public function getquestions($survey_id){
    return Questions::join('question_translations','Questions.id','=','question_translations.question_id')->
    select('Questions.*','question_translations.question_details As details','question_translations.question_local As local')->
    where('Questions.survey_id','=',$survey_id)->where('question_translations.question_local','=','en')->orderby('Questions.question_order')->get();
  }
//   to update when user re order the questions list
  public function updateQuestionOrder($questions){
    // dd($questions);
         foreach($questions as $question)
          {
            Questions::find($question['value'])->update(['question_order'=>$question['order']]);
          }
        //   $this->dispatchBrowserEvent('name-updated',"sorted");

          $this->questions =$this->getquestions($this->survey_id);

  }
    public function mount(){


        $this->languages = json_decode($this->lang, true);
        $this->questions =$this->getquestions($this->survey_id);

    }
    public function render()
    {

        return view('livewire.survey-details');
    }
}
