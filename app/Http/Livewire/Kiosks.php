<?php

namespace App\Http\Livewire;

use Livewire\Component;
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
use Storage;
use Illuminate\Support\Facades\File;
use App\Models\Pictures;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use App\Models\DeviceCode;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Auth;
class Kiosks extends Component
{
    public $kiosks;
    public $validcode=false;
    public $isavilable=false;
    public $deviceCode;
    public $showmessage=false;
    public $ifedit=false;
    public $device_delete_id;
    public $currentNameDevice;
    public $currentSurveyName=null;
    public $currentInService;
    public $currentIdDevice;
    public $currentSurveyId;
    public $surveys;
    public $test;
    protected $listeners=[
    //    to refresh after add device
    'deviceaddsuccess'=>'deviceaddsuccess',
    // to confirm delete question
    'deleteDeviceConfirmed'=>'deletedevice',

    ];
    // validation rules
    protected $rules=[
        'currentNameDevice' => 'required|min:2|max:25',
    ];
    // error messages
    protected $messages=[
        'currentNameDevice.required' => 'The Email Address cannot be empty.',
        'currentNameDevice.min' => 'Device name must be 2 or more characters',
        'currentNameDevice.max' => 'Device name must be less of or equal 25 characters ',
    ];



    public function sendrefresh($id)
    {
        $this->emitTo('livewire.survey-template',$id,'refresh',$id);
    }
    public function mount()
    {
        $this->kiosks=Kiosk::leftjoin('surveys','surveys.id','=','devices.survey_id')
        ->leftjoin('device_codes','device_codes.id','=','devices.device_code_id')
        ->where('devices.profile_id',Auth::user()->current_team_id)->select('devices.*','device_codes.device_code as device_code','surveys.survey_name as survey_name')->get();


    }
     //   delete question confirmation
     public function deletedeviceConfirmation($id)
     {
         $this->device_delete_id=$id;
         $this->mount();
         $this->dispatchBrowserEvent('show-device-delete-confirmation');

     }
    //  delete device
    public function deletedevice()
    {
        Kiosk::whereid($this->device_delete_id)->delete();
        $this->mount();
    }
    // after add sucessfuly
    public function deviceaddsuccess()
    {
        $this->mount();
       $this->dispatchBrowserEvent('close_modal_add_device');

    }
    // if the process is edit
    public function edit($id)
    {    $this->resetvalues();
        $this->ifedit=true;

        $currentdevice=Kiosk::leftjoin('surveys','surveys.id','=','devices.survey_id')
        ->where('devices.profile_id',Auth::user()->current_team_id)->where('devices.id',$id)->select('devices.*','surveys.survey_name as survey_name')->first();

        $this->currentIdDevice=$id;
        $this->currentNameDevice=$currentdevice->device_name;
        $this->currentSurveyName=$currentdevice->survey_name;
        $this->currentSurveyId=$currentdevice->survey_id;
        $this->surveys=Survey::whereteam_id(Auth::user()->current_team_id)->get();
        $this->currentInService=$currentdevice->in_service;
        $this->mount();
    }

     public function updated($properatyName)
     {
        if($properatyName="currentSurveyId"){
            if($this->currentSurveyId=="")
        {
            $this->currentInService=false;
        }
        }
        $this->mount();
     }
     public function resetvalues()
     {
        $this->isavilable=false;
         $this->validcode=false;
         $this->ifadd=false;
         $this->ifedit=false;
         $this->showmessage=false;
         $this->currentIdDevice=null;
        $this->currentNameDevice=null;
        $this->currentSurveyName=null;
        $this->currentSurveyId=null;
        $this->currentInService=false;
        $this->mount();


     }
    //  add device
    public function editdevice()
    {

         $this->validateOnly('currentNameDevice');
         $device=Kiosk::whereid($this->currentIdDevice)->first();
         $device->device_name=$this->currentNameDevice;

         if($this->currentSurveyId!="")
         { $device->survey_id= $this->currentSurveyId;}
         else
         { $device->survey_id= null;}


         $device->in_service=$this->currentInService;
         $device->save();

         $this->resetvalues();
         $this->mount();



    }
    public function render()
    {
        return view('livewire.kiosks');
    }
}
