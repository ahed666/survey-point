<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rules;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;
use App\Models\QuestionType;
use App\Models\Pictures;
use App\Models\Survey;
use App\Models\SurveyTrnslations;
use App\Models\Logos;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Facades\File;
class Addsurveys extends Component
{
    use WithFileUploads;
    // add survey details
    public $survey_logo;
    public $logosrc;
    public $logo;
    public $survey_BusinessName=null;
    public $survey_Name=null;
    public $survey_DefultLanguage=null;
    public $modal=false;
    public $idadd=false;
    public $languages;
    public $messages;
    public $isdisable=true;
    public $survey_id=null;

    protected $listeners = [

        'edit_survey'=>'edit_survey',
        'add_survey'=>'add_survey'

];
    // end add survey details
    public function mount()
    {
        $this->survey_logo="images/default_survey_logo.png";
        $this->logo="images/default_survey_logo.png";
        $this->modal=false;
    }
    // to reset value after save
    public function resetvalue()
    {
        if(str_contains($this->survey_logo,'images/temp/'))
        {
          File::delete(public_path($this->survey_logo));}
          $this->survey_logo="images/logo_1_transparent.png";
          $this->logo="images/logo_1_transparent.png";
          $this->modal=false;
        $this->logosrc=null;

        $this->survey_BusinessName=null;
        $this->survey_Name=null;
        $this->survey_id=null;
        $this->isadd=false;

    }
    // to edit survey
    public function edit_survey($name,$bname,$logo,$id)
    {
        $this->survey_Name=$name;
        $this->survey_BusinessName=$bname;
        $this->survey_logo=$logo;
        $this->logo=$logo;
        $this->survey_id=$id;
    }
    // to add survey
    public function add_survey($languages,$messages)
    {
       $this->languages=$languages;
       $this->messages=$messages;
       $this->isadd=true;

    }
    // realtime validate
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,[
            'survey_BusinessName' =>['required','min:5'],
            'survey_Name'=>['required','min:5'],
            'survey_DefultLanguage'=>[ 'required']

        ],
        [
            'survey_BusinessName.min'=>'The :attribute must contain at least 5 characters ',
            'survey_BusinessName.required'=>'The :attribute is empty ',
            'survey_Name.min'=>'The :attribute must contain at least 5 characters ',
            'survey_Name.required'=>'The :attribute is empty ',
            'survey_DefultLanguage.required'=>'The :attribute is empty ',
        ]
    );

}
 // validate on submit on add
 public function validatedataonadd(){


    $this->validate([
        'survey_BusinessName' =>['required','min:5'],
        'survey_Name'=>['required','min:5'],
        'survey_DefultLanguage'=>[ 'required']

    ],[
        'survey_BusinessName.min'=>'The :attribute must contain at least 5 characters ',
        'survey_BusinessName.required'=>'The :attribute is empty ',
        'survey_Name.min'=>'The :attribute must contain at least 5 characters ',
        'survey_Name.required'=>'The :attribute is empty ',
        'survey_DefultLanguage.required'=>'The :attribute is empty ',
    ]
      );
}
 // validate on submit on edit
 public function validatedataonedit(){


    $this->validate([
        'survey_BusinessName' =>['required','min:5'],
        'survey_Name'=>['required','min:5'],


    ],[
        'survey_BusinessName.min'=>'The :attribute must contain at least 5 characters ',
        'survey_BusinessName.required'=>'The :attribute is empty ',
        'survey_Name.min'=>'The :attribute must contain at least 5 characters ',
        'survey_Name.required'=>'The :attribute is empty ',

    ]
      );
}
    public function addsurvey(){


        $folderPath ='storage/images/upload/';
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        // if there is survey =>Edit survey
        if($this->survey_id!=null)

        {
            $this->validatedataonedit();
            $this->resetErrorBag();
            $survey=Survey::find($this->survey_id);
            $logo=Logos::find($survey->logo_id);
              if($logo==null)
              {
                $logo=new Logos();
              }

            if(str_contains($this->survey_logo,'images/temp/'))
            {
                $numofsurvey=count(Survey::whereteam_id(Auth::user()->current_team_id)->get());
                $lastsurvey=Survey::whereteam_id(Auth::user()->current_team_id)->get()->last();
                $image_name="survey-logo-".Auth::user()->id.$this->survey_id.$numofsurvey.$lastsurvey->id.uniqid();
                $name=$image_name . '.jpg';
                $file = $folderPath .$name;

                $old=public_path($this->survey_logo);
                $new=$file;
                File::copy($old , $new);
            }
                else
                $new=$this->survey_logo;

            $logo->logo_url=$new;
            $logo->team_id=Auth::user()->current_team_id;
            $logo->user_id=Auth::user()->id;
            $logo->logo_name=$this->survey_BusinessName."-".$this->survey_Name;
            $logo->save();
            $survey->survey_name=$this->survey_Name;
            $survey->business_name=$this->survey_BusinessName;
            $survey->user_id=Auth::user()->id;
            $survey->team_id=Auth::user()->current_team_id;
            $survey->logo_id=$logo->id;

            $survey->save();


        }
        // if there is not survey =>add survey
        else
        { $this->validatedataonadd();
            $this->resetErrorBag();
            $logo=new Logos();

            if(str_contains($this->survey_logo,'images/temp/'))
            {
                $numofsurvey=count(Survey::whereteam_id(Auth::user()->current_team_id)->get());
                $lastsurvey=Survey::whereteam_id(Auth::user()->current_team_id)->get()->last();
                $image_name="survey-logo-".Auth::user()->id.$numofsurvey.$lastsurvey->id.uniqid();
                $name=$image_name . '.jpg';
                $file = $folderPath .$name;

                $old=public_path($this->survey_logo);
                $new=$file;
                File::copy($old , $new);
            }
                else
                $new=$this->survey_logo;

            $logo->logo_url=$new;
            $logo->team_id=Auth::user()->current_team_id;
            $logo->user_id=Auth::user()->id;
            $logo->logo_name=$this->survey_BusinessName."-".$this->survey_Name;
            $logo->save();



            $survey=new Survey();
            $survey->survey_name=$this->survey_Name;
            $survey->business_name=$this->survey_BusinessName;
            $survey->user_id=Auth::user()->id;
            $survey->team_id=Auth::user()->current_team_id;
            $survey->logo_id=$logo->id;

            $survey->save();
            // add defult messages
            $survey_trans=new SurveyTrnslations();
            foreach($this->messages as $message)
            {
            if($message['local']==$this->survey_DefultLanguage)
            {
                $survey_trans->survey_start_header=$message['start_header'];
                $survey_trans->survey_start_text=$message['start_text'];
                $survey_trans->survey_end_header=$message['end_header'];
                $survey_trans->survey_end_text=$message['end_text'];
                $survey_trans->survey_id=$survey->id;
                $survey_trans->survey_local=$this->survey_DefultLanguage;
                $survey_trans->save();

            }

              }


        }

        // // return redirect(request()->header('Referer'));
        // $this->emit('add-survey',$this->survey_logo,$this->survey_Name,$this->survey_BusinessName);
        //  return redirect()->to('/surveys');
        $this->resetvalue();
        $this->emit('surveyaddsuccess',$survey->id);
        //    return redirect()->to('/surveys');

    }
    public function updatedlogo()
    {
        $this->modal=true;
        $this->logosrc=$this->logo->temporaryUrl();

        $this->dispatchBrowserEvent('survey-image-updated', ['image' => $this->logo]);

    }
    // save image after crop it
    public function cropingimage(){
        $this->dispatchBrowserEvent('saving');



    }
    // to close the crop modal if user click close button or icon
    public function closemodal(){
        $this->survey_logo="images/logo_1_transparent.png";
        $this->modal=false;
    }

    // t oclose crop modal if user click save
    public function closemodalwithsave(){

        $this->modal=false;
    }
    // save image after crop it
    public function SavImage($image){
        $folderPath = public_path('storage/images/temp/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $name=uniqid() . '.jpg';
        $file = $folderPath .$name;
        $this->modal=false;
        // dd($this->answers[$this->stepimage]['image']);
        if(str_contains($this->survey_logo, 'images/temp/')||str_contains($this->survey_logo, 'images/upload/'))
          {
            File::delete(public_path($this->survey_logo));}
        $this->survey_logo="/storage/images/temp/".$name;
        file_put_contents($file, $image_base64);

    }
    public function render()
    {
        return view('livewire.addsurveys');
    }
}
