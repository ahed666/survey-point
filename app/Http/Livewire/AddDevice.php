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

class AddDevice extends Component
{

    public $validcode=false;
    public $isavilable=false;
    public $deviceCode;
    public $showmessage=false;

    public $currentNameDevice;
    public $currentInService;
    public $currentIdDevice;
    public $currentSurveyId;
    public $surveys;

    // validation rules
    protected $rules=[
        'deviceCode' => 'required|min:6|max:6',
        'currentNameDevice'=>'required|min:2|max:25',
    ];
    // error messages
    protected $messages=[
        'deviceCode.required' => 'The Device Code cannot be empty.',
        'deviceCode.min' => 'length of code must be 6 digits',
        'deviceCode.max' => 'length of code must be 6 digits',
        'currentNameDevice.required' => 'The Device Name cannot be empty.',
        'currentNameDevice.min' => 'Device name must be 2 or more characters',
        'currentNameDevice.max' => 'Device name must be less of or equal 25 characters ',
    ];
    public function mount()
    {
        $this->surveys=Survey::whereteam_id(Auth::user()->current_team_id)->get();
    }

    // to check if there is not a survey then the service is false
    public function updatedcurrentSurveyId()
    {
    if($this->currentSurveyId=="")
    {
        $this->currentInService=false;
    }
    }
     // validation device code
     public function updateddeviceCode(){
         $this->resetErrorBag();
         $this->resetdevicecode();
         $this->validateOnly('deviceCode');
         $this->validcode=true;
         $device_code=DeviceCode::wheredevice_code($this->deviceCode)->first();
         if($device_code!=null)
         {
             $kiosk=Kiosk::wheredevice_code_id($device_code->id)->first();
             if($kiosk==null)
             $this->isavilable=true;
         }

         $this->showmessage=true;

     }
     // to check if device is avilable by device code;
      public function checkdevicecode()
      {
         $device_code=DeviceCode::wheredevice_code($this->deviceCode)->first();
         if($device_code!=null)
         {
             $kiosk=Kiosk::wheredevice_code_id($device_code->id)->first();
             if($kiosk==null)
             $this->isavilable=true;
         }

         $this->showmessage=true;

      }
    //   reset device code
      public function resetdevicecode()
      {
         $this->isavilable=false;
         $this->validcode=false;
        $this->showmessage=false;
      }
     // reset value
     public function resetvalues()
     {
        $this->isavilable=false;
        $this->validcode=false;
        $this->showmessage=false;
        $this->currentNameDevice=null;
        $this->deviceCode=null;
        $this->currentInService=false;
        $this->currentIdDevice=null;
        $this->currentSurveyId=null;
        $this->surveys=null;

     }
     //  add device
     public function adddevice()
     {
        $this->validateOnly('currentNameDevice');
        $this->currentIdDevice=DeviceCode::wheredevice_code($this->deviceCode)->first()->id;
        $device=new Kiosk();
        $device->device_name=$this->currentNameDevice;
        $device->in_service=(bool)$this->currentInService;
        $device->device_code_id=$this->currentIdDevice;
        $device->profile_id=Auth::user()->current_team_id;
        $device->user_id=Auth::user()->id;
        if($this->currentSurveyId!=null)
          { $device->survey_id= $this->currentSurveyId;}
        $device->url=url("/devices/{$this->deviceCode}/{$this->currentIdDevice}");
        $device->save();
        $this->resetvalues();
        $this->emit('deviceaddsuccess');


     }
    public function render()
    {
        return view('livewire.add-device');
    }
}
