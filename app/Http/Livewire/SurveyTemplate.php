<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Kiosk;
use Illuminate\Support\Facades\DB;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\Survey;
use App\Models\Answers;
use App\Models\Logos;
use App\Models\SurveyTrnslations;
use App\Models\AnswersTranslation;
use App\Models\QuestionType;
use Illuminate\Support\Facades\File;
use App\Models\Pictures;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use App\Models\DeviceCode;
use App\Models\Team;
use Carbon\Carbon;
class SurveyTemplate extends Component
{
    public $survey;
    public $account;
    public $logo;
    public $step;
    public $currentkiosk;
    public $surveylanguages;
    public $questions;
    public $fullquestions;
    public $current_surveyid;
    public $current_question;
    public $current_question_no=0;
    public $answerchecked=array();
    //  main languages of survey
    public $main_lang = '[
        { "id": 1,"code":"en", "name": "English","trans":"en"},
        { "id": 2,"code":"ar" ,"name": "عربي","trans":"ar"},
        { "id": 3, "code":"ur","name": "urdu","trans":"ur"},
        { "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    ]';
    public $start_buttons='[
        { "id": 1,"code":"en", "text": "Start","flag":"images/flags/gb.svg"},
        { "id": 2,"code":"ar" ,"text": "ابدأ","flag":"images/flags/sa.svg"},
        { "id": 3, "code":"ur","text": "شروع کریں۔","flag":"images/flags/pk.svg"},
        { "id": 4, "code":"tl","text": "simulan","flag":"images/flags/ph.svg"}
    ]';
    public $buttons;
    public $main_languages;
    public $current_lang;
    public $progressbarvalue;
    public $submitedquestions=[];
    public $countanswerchecked=0;
    protected $listeners=[
        //    to check if there is any update on kiosk
        'checkonupdate'=>'checkonupdate',
        'refresh'=>'refreshpage',

        ];
    public function refreshpage($id)
    {          dd($id);
        $this->dispatchBrowserEvent('refresh');


    }
    public function mount()
    {
        // json decode for main languages
        $this->main_languages = json_decode($this->main_lang, true);
        // json decode for start buttons
        $this->buttons = json_decode($this->start_buttons, true);
        // get device info from url
        $deviceinfo = explode('/', url()->current());
        $this->currentkiosk=Kiosk::wheredevice_code_id($deviceinfo[5])->first();
        $this->current_surveyid=Kiosk::wheredevice_code_id($deviceinfo[5])->first()->survey_id;

        $this->survey=Survey::whereid( $this->current_surveyid)->first();
        $this->account=Team::whereid($this->survey->team_id)->first();
        $this->logo=Logos::whereid($this->survey->logo_id)->first();
        $this->surveylanguages = $this->getLocalesOfSurvey(  $this->current_surveyid);
        $this->messages = SurveyTrnslations::wheresurvey_id(  $this->current_surveyid)->get();


        $this->step=1;



    }
    // to calculate progress bar value
    public function calculateProgressBarValue()
    {
        $countofallquestions=count($this->questions);
        $countofsubmitedquestions=count($this->submitedquestions);
        $this->progressbarvalue=round(( $countofsubmitedquestions/$countofallquestions)*100);
        // dd($countofallquestions, $countofsubmitedquestions,$this->progressbarvalue);
    }
    // to get current question
    public function getCurrentQuestion($questions)
    {
        foreach($questions as $i=>$question)
        if($i==$this->current_question_no)
        return $question;
    }

    // get answers for each question and convert it to json
    public function questionsWithAnswers($questions){

        $fullquestions=[];
      foreach($questions as $question)
      {
        if($question['type']=='mcq_pic'||$question['type']=='checkbox_pic')
            {
            $answers=Answers::join('answer_translations','Answers.id','=','answer_translations.answer_id')->
            join('pictures','pictures.id','=','Answers.picture_id')->where('Answers.question_id','=',$question['id'])->where('answer_translations.answer_local','=',$this->current_lang)->select('Answers.*','answer_translations.*','pictures.pic_url as picture')->get();

            }
            else{
                $answers=Answers::join('answer_translations','Answers.id','=','answer_translations.answer_id')->
                where('Answers.question_id','=',$question['id'])->where('answer_translations.answer_local','=',$this->current_lang)->get();

            }
            $collect=collect(
                ["question_id"=>$question['id'],
                 "question_details"=>$question['details'],
                 "type_id"=>$question['type_of_question_id'],
                 "type"=>$question['type'],
                 "order"=>$question['question_order'],
                 "optional"=>$question['optional'],
                 "answers"=>$answers,
                ]
            );
            array_push($fullquestions,$collect);
      }
      return $fullquestions;
    }

    //    to get all questions by id of survey
    public function getquestions($id)
    {

        //  custom questions
        $questions1 = Questions::
            where('Questions.survey_id', '=', $id)->
            join('custom_questions', 'Questions.id', '=', 'custom_questions.question_id')->
            groupBy('custom_questions.custom_question_id')->
            join('custom_question_translations', 'custom_questions.custom_question_id', '=', 'custom_question_translations.custom_question_id')->
            join('type_of_questions', 'type_of_questions.id', '=', 'Questions.type_of_question_id')->
            where('custom_question_translations.question_local', '=', $this->current_lang)
            ->select('Questions.*', 'custom_question_translations.question_details As details', 'custom_question_translations.question_local As local', 'type_of_questions.question_type as type')
            ->orderby('Questions.question_order')->get();

        //   another type of question
        $questions2 = Questions::join('question_translations', 'Questions.id', '=', 'question_translations.question_id')->
            join('type_of_questions', 'type_of_questions.id', '=', 'Questions.type_of_question_id')->
            // leftjoin('answers','answers.question_id','=','Questions.id')
            // ->join('answer_translations','answer_translations.answer_id','=','answers.id')->
            // where('answer_translations.answer_local', '=', $this->current_lang)->
            whereNotIn('Questions.type_of_question_id', [8, 9])->
            where('Questions.survey_id', '=', $id)->where('question_translations.question_local', '=', $this->current_lang)->

            select('Questions.*', 'question_translations.question_details As details', 'question_translations.question_local As local',
             'type_of_questions.question_type as type')->

            orderby('Questions.question_order')->get();

        $questions = array_merge(json_decode($questions1, true), json_decode($questions2, true));

        usort($questions, function ($a, $b) {
            return $a['question_order'] - $b['question_order'];
        });

        return $questions;

    }
    // function of checking on update for kiosk
    /*public function checkonupdate()
    {
        dd($this->step);
        // $updated_at=Carbon::create($this->currentkiosk->updated_at);
        // $deff=$updated_at->diffInHours(Carbon::now('Asia/Dubai'));
        //      dd($updated_at,Carbon::now('Asia/Dubai'),$deff);
        // if($deff<2){


        //    $this->dispatchBrowserEvent('contentupdated');
        // }



    }*/
    // to initialization the answers checked array for every question
    public function  initanswerscheckedarray($count){
       for ($i=0; $i <$count ; $i++) {
           $this->answerchecked[$i]=0;
       }


    }
    // to calculate the num of answers checked
    public function calanswerchecked(){
        $count=0;
        for ($i=0; $i <count($this->answerchecked) ; $i++) {
            if($this->answerchecked[$i]==1)
            $count+=1;
        }
        $this->countanswerchecked=$count;


    }
    // to set answer 1 or 0 when click on answer by it index ->$idx
    public function setanswercheck_checkbox($idx){
        $this->answerchecked[$idx]==1?$this->answerchecked[$idx]=0:$this->answerchecked[$idx]=1;
        try {
            $this->countanswerchecked=array_count_values( $this->answerchecked)['1'];
        } catch (\Throwable $th) {
            $this->countanswerchecke=0;
        }
    }
   public function setanswercheck_mcq($idx){

        $this->answerchecked = array_fill(0,count($this->answerchecked),0);
         $this->answerchecked[$idx]=1;
    try {
        $this->countanswerchecked=array_count_values( $this->answerchecked)['1'];
    } catch (\Throwable $th) {
        $this->countanswerchecke=0;
    }


   }

    //next question and do some of functions
    public function next()
    {
        //1) set answer to questions
        $answers=[];

        for ($i=0; $i <count($this->answerchecked) ; $i++) {
              if($this->answerchecked[$i]==1)
              {
                array_push($answers,$this->current_question['answers'][$i]);
              }

        }
        $collect=collect(
        ["question_id"=>$this->current_question['question_id'],
         "question_details"=>$this->current_question['question_details'],
         "type_id"=>$this->current_question['type_id'],

         "order"=>$this->current_question['order'],
         "optional"=>$this->current_question['optional'],
         "answers"=>$answers,
        ]);
        array_push($this->submitedquestions,$collect);
        //2) plus count of questions

        $this->current_question_no+=1;
        //3)get new question

        $this->current_question=$this->getCurrentQuestion($this->fullquestions);
        //4)inital answers array
        $this->answerchecked=array();
        $this->initanswerscheckedarray(count($this->current_question['answers']));
        $this->countanswerchecked=0;

        $this->calculateProgressBarValue();
    }
    // start survey after detect language
    public function startsurvey($lang)
    {
        $this->current_lang=$lang['code'];
        $this->questions=$this->getquestions( $this->current_surveyid);
        $this->fullquestions=$this->questionsWithAnswers($this->questions);
        $this->current_question=json_decode($this->getCurrentQuestion($this->fullquestions),true);
        $this->calculateProgressBarValue();
        $this->initanswerscheckedarray(count($this->current_question['answers']));

        $this->step=2;



    }
    // get locales of survey
    public function getLocalesOfSurvey($id)
    {
        $locales = SurveyTrnslations::
            where('survey_id', '=', $id)->
            select('survey_translations.survey_local As local')->get();
        $locales = json_decode($locales, true);
        $surveylocales = [];
        foreach ($locales as $i => $local) {foreach ($this->main_languages as $main) {
            if ($local['local'] == $main['code']) {
                $collect = collect(
                    ["id" => $main['id'],
                        "code" => $local['local'],
                        "name" => $main['name'],
                        "trans" => $main['trans'],

                    ]
                );

                array_push($surveylocales, $collect);
            }
        }

        }

        return $surveylocales;

    }
    public function render()
    {


        return view('livewire.survey-template');
    }
}
