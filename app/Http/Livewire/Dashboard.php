<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Answers;
use App\Models\AnswersTranslation;
use App\Models\CustomQuestion;
use App\Models\Logos;
use App\Models\Pictures;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\QuestionType;
use App\Models\Survey;
use App\Models\DeviceCode;
use App\Models\kiosk;
use App\Models\SurveyTrnslations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\TypeSubscribe;
use App\Models\Subscribe;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
class Dashboard extends Component
{   public $surveys;
    public $kiosks;





    public function mount()
    {
        // surveys
        $this->surveys=Survey::whereteam_id(Auth::user()->current_team_id)->get();
        // kiosks
        $this->kiosks=Kiosk::leftjoin('surveys','surveys.id','=','devices.survey_id')
        ->leftjoin('device_codes','device_codes.id','=','devices.device_code_id')
        ->where('devices.profile_id',Auth::user()->current_team_id)->select('devices.*','device_codes.device_code as device_code','surveys.survey_name as survey_name')->get();
        //  subscribe
        $this->current_subscribe=Subscribe::join("type_of_subscriptions","type_of_subscriptions.id","=","subscriptions.type_of_subscription_id")
        ->where("subscriptions.account_id",Auth::user()->current_team_id)->select('subscriptions.*','type_of_subscriptions.subscription_type as type')
        ->first();
    }
    // to update serivce of kiosk
    public function changekioskservice($id){
        $kiosk=Kiosk::whereid($id)->first();
        if($kiosk->in_service==true)
         $kiosk->in_service=false;
        else
        $kiosk->in_service=true;

        $kiosk->save();
        $this->mount();
        $this->dispatchBrowserEvent('contentdashChanged');

    }
    //  to get the count question of each survey by id of survey
    public function questions_count($id)
    {
        $count1 = questions::where('survey_id', '=', $id)->whereNotIn('type_of_question_id', [8, 9])->get();
        $count2 = DB::table('questions')
            ->join('custom_questions', 'questions.id', '=', 'custom_questions.question_id')
            ->where('questions.survey_id', '=', $id)
            ->groupBy('custom_questions.custom_question_id')
            ->select('questions.*')
            ->get();
        $count = count($count1) + count($count2);

        return $count;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
