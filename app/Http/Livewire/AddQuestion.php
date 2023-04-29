<?php

namespace App\Http\Livewire;

use Livewire\Component;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rules;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;
use App\Models\QuestionType;
use App\Models\Survey;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\Answers;
use App\Models\AnswersTranslation;
use App\Models\Pictures;
use App\Models\CustomQuestionTranslation;
use App\Models\CustomQuestion;
use Illuminate\Support\Facades\Auth;
use App\Models\CategoryType;
class AddQuestion extends Component

{ use WithFileUploads;
    public $step=1;
    public $model=false;
    public $stepanswer=0;
    public $type=null;
    public $question;
    public $stepimage;
    public $currentanswer=null;
    public $answers=[];
    public $current_image;
    public $imagesrc;
    public $show=false;
    public $numofanswers;

    public $count=0;
    public $image;
    public $languages;
    public $imagedefultsrc;
    public $is_mandetory_question=null;
    // category of types
    public $category_types;
    // end category of types
    public $defult_q='[
        { "id": 1,"local":"en", "question": "do you like"},
        { "id": 2,"local":"ar" ,"question": "هل انت تفضل "},
        { "id": 3, "local":"tl","question": "gusto mo ba"},
        { "id": 4, "local":"ur","question": "کیا تمہیں پسند ہے"}
    ]';
    public $defult_question;

    // to detect where user click add score
    public $stepscore=null;
    public $setscore=array();
    public $sethide=array();
    public $setskip=array();
    public $setterminate=array();
    public $Types='[
        { "id": 1, "value": "Yes or No Question" ,"typeanswer":"1","src":"images/questions_types/English/Yes_or_No_Question.png" },
        { "id": 2, "value": "Like or Dislike Question" ,"typeanswer":"1","src":"images/questions_types/English/Like_or_Dislike.png" },
        { "id": 3, "value": "Agree or Disagree Question" ,"typeanswer":"1","src":"images/questions_types/English/Agree_or_Disagree.png" },
        { "id": 4, "value": "Satisfaction Question","typeanswer":"2","src":"images/questions_types/English/Satisfaction_Level.png" },
        { "id": 5, "value": "Custom Satisfaction Question","typeanswer":"3","src":"images/questions_types/English/Custom_Satisfaction.png" },
        { "id": 6, "value": "Rating Question","typeanswer":"4","src":"images/questions_types/English/Rating.png" },
        { "id": 7, "value": "Custom Rating Question","typeanswer":"5","src":"images/questions_types/English/Custom_rating.png" },
        { "id": 8, "value": "Multi Option Question multi answers","typeanswer":"multi answer","src":"images/questions_types/English/Multi-Option_(multi answer).png" },
        { "id": 9, "value": "Multi Option Question multi answers with image","typeanswer":"multi answer","src":"images/questions_types/English/Multi-Option_(with image)_(multi answer).png" },
        { "id": 10, "value": "Multiple Option Question single answers","typeanswer":"single answer","src":"images/questions_types/English/Multi-Option_(single answer).png" },
        { "id": 11, "value": "Multiple Option Question single answers with image","typeanswer":"single answer","src":"images/questions_types/English/Multi-Option_(with image)_(single answer).png" },
        { "id": 12, "value": "Choose From List","typeanswer":"single answer","src":"images/questions_types/English/Choose_From_a_List.png" }


    ]';
    public $survey_id;
    public $local;
    protected $listeners = ['add'=>'add'];
    public function add($survey_id,$local,$languages){
        $this->survey_id=$survey_id;
        $this->local=$local;
        $this->languages=$languages;
        $this->question=$this->selectquestiondefult();
    }
 public $TypesOfQuestion;
    // to set value of disabled of save button....if count of answer >0 then the disabled false
    public $disable=false;
    public function checkdisable()
    {
        if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="rating"||$this->type=="satisfaction"||$this->type=="short_text_question"||$this->type=="email"||$this->type=="number"||$this->type=="date_question"||$this->type=="long_text_question")
        {
            $this->disable=false;

        }
        else
        {
            if(count($this->answers)>0)
            $this->disable=false;
            else
            $this->disable=true;
        }


    }
    // to initializtion array of skip,hide,score,terminate and num of answers based on type of question
    public function initvalue()
    {   $this->answers=[];
        // if type is logic (yes or no...) then there is only two answers and user cannot add it , we will add it auto
        if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree")
        { $this->numofanswers=2;
            for ($i=0; $i <2 ; $i++) {

            $collect=collect(
                ["id"=>$i,
                "code"=>$i+1,
                "value"=>null,
                "image"=>null,
                "score"=>0,
                "hide"=>false,
                "skip"=>false,
                "terminate"=>false,
                ]
            );
            array_push($this->answers,$collect);
            }

        }
        elseif($this->type=="rating"||$this->type=="satisfaction")
         {$this->numofanswers=5;
            for ($i=0; $i <5 ; $i++) {

                $collect=collect(
                    ["id"=>$i,
                    "code"=>$i+1,
                    "value"=>null,
                    "image"=>null,
                    "score"=>0,
                    "hide"=>false,
                    "skip"=>false,
                    "terminate"=>false,
                    ]
                );
                array_push($this->answers,$collect);
                }

        }
        else
        $this->numofanswers=50;

        for ($i=0; $i <$this->numofanswers ; $i++) {
             $this->setscore[$i]=0;
             $this->setskip[$i]=0;
             $this->sethide[$i]=0;
             $this->setterminate[$i]=0;
        }


    }

    // to select question defult
    public function selectquestiondefult()
    {

        for ($i=0; $i <count($this->defult_question) ; $i++) {
            if($this->defult_question[$i]['local']==$this->local)
              return $this->defult_question[$i]['question'];

        }

    }
    public function mount(){

        $this->imagedefultsrc="images/default_answer_image.png";
        $this->step=1;
        $this->stepanswer=0;
        $this->show=false;
        $this->currentanswer=null;
        $this->category_types=CategoryType::all();



        $this->TypesOfQuestion = QuestionType::all();

        $this->defult_question = json_decode($this->defult_q, true);





    }
    // to set index of hide
    public function changesethide($i){
        if($this->sethide[$i]==true)

        {
            if(count(array_filter($this->sethide))<count($this->answers))
               $this->answers[$i]['hide']=true;
            else
            $this->sethide[$i]=false;


        }
        else{
        $this->answers[$i]['hide']=false;
        }
    }
     // to set index of skip
     public function changesetskip($i){
        if($this->setskip[$i]==1)
        {$this->answers[$i]['skip']=true;
         $this->answers[$i]['terminate']=false;
         $this->setterminate[$i]=0;
        }
        else
        $this->answers[$i]['skip']=false;

    }
     // to set index of terminate
     public function changesetterminate($i){
        if($this->setterminate[$i]==1)
        {$this->answers[$i]['terminate']=true;
         $this->answers[$i]['skip']=false;
         $this->setskip[$i]=0;
        }
        else
        $this->answers[$i]['terminate']=false;
    }
    public function changesetscore($i){
        if($this->setscore[$i]!=1)
        $this->answers[$i]['score']=0;

    }


    // setterminate
    // save image after crop it
    public function cropimage(){
        $this->dispatchBrowserEvent('save-add');



    }
    public function saveimage($image){
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
        if(str_contains($this->answers[$this->stepimage]['image'], 'images/temp/')||str_contains($this->answers[$this->stepimage]['image'], 'images/upload/'))
          {
            File::delete(public_path($this->answers[$this->stepimage]['image']));}
        $this->answers[$this->stepimage]['image']="/storage/images/temp/".$name;
        file_put_contents($file, $image_base64);

    }

    // index image
    public function updatecurrentimageindex($i){
        $this->stepimage=$i;
    }

    public function updatedimage(){
                //    dd();
                $this->model=true;

                // $this->answers[$this->stepimage]['image']=$this->image->temporaryUrl();
                $this->imagesrc=$this->image->temporaryUrl();
                $this->dispatchBrowserEvent('image-updated-add', ['image' => $this->image]);

      }

// to close the crop modal if user click close button or icon
    public function closemodal(){
        $this->answers[$this->stepimage]['image']=$this->imagedefultsrc;
        $this->model=false;
    }

    // t oclose crop modal if user click save
    public function closemodalwithsave(){

        $this->model=false;
    }
    // on update question
    public function updatedquestion($value){
        $this->question=$value;
    }

     // increase the step
    public function increasestep(){
        $this->step+=1;
    }

    //   on delete answer
    public function deleteanswer($i)
    {

        //    $this->answers[$i]['code']=null;
        // if the item deleted IS the last item
            if($i==$this->count-1)
            {
                $this->count-=1;

                $this->stepanswer-=1;
                array_pop($this->answers);
            }
        else
        {
          for($j=$i;$j<$this->count-1;$j++)
           {
                    $this->answers[$j]['value']= $this->answers[$j+1]['value'];
                    $this->answers[$j]['image']= $this->answers[$j+1]['image'];
                    $this->answers[$j]['score']= $this->answers[$j+1]['score'];
                    $this->answers[$j]['hide']= $this->answers[$j+1]['hide'];
                    $this->answers[$j]['skip']= $this->answers[$j+1]['skip'];
                    $this->answers[$j]['terminate']= $this->answers[$j+1]['terminate'];
                    $this->setscore[$j]=$this->setscore[$j+1];
                    $this->setskip[$j]=$this->setskip[$j+1];
                    $this->setterminate[$j]=$this->setterminate[$j+1];
                    $this->sethide[$j]=$this->sethide[$j+1];
            }

            $this->count-=1;

            $this->stepanswer-=1;
            array_pop($this->answers);
        }
        // if there is one answer
        if(count($this->answers)==1)
        { $this->answers[0]['hide']=false;
         $this->sethide[0]=false;}
         $this->checkdisable();

    }

    // function to add answers
    public function addanswer(){



        $this->validate
            (
                ['answers.*.value' =>['required'],],
                ['answers.*.value.required'=>'The answer can\'t be  empty '


                ]
            );


            // set the type of image dependent on type of question
          if($this->type=="mcq_pic"||$this->type=="checkbox_pic"||$this->type=="custom_rating"||$this->type=="custom_satisfaction")
             { $image=$this->imagedefultsrc;

            }
          else
          {$image=null;

        }

            // if the question is the first question
        if($this->count==0)
            {


                $collect=collect(
                    ["id"=>$this->count,
                    "code"=>$this->count+1,
                    "value"=>null,
                    "image"=>$image,
                    "score"=>0,
                    "hide"=>false,
                    "skip"=>false,
                    "terminate"=>false,
                    ]
                );
                array_push($this->answers,$collect);
                $this->count+=1;
                $this->stepanswer+=1;
            }

        elseif($this->count>0)
        {

            $this->currentanswer=$this->answers[$this->count-1]['value'];
            if( $this->currentanswer!=" " &&  $this->currentanswer!=null)
            {  $name='answer'.$this->count-1;

                $collect=collect(
                    ["id"=>$this->count,
                    "code"=>$this->count+1,
                    "value"=>null,
                    "image"=>$image,
                    "score"=>0,
                    "hide"=>false,
                    "skip"=>false,
                    "terminate"=>false,
                    ]
                );
                array_push($this->answers,$collect);
                $this->count+=1;
                $this->stepanswer+=1;

            }
        }

      $this->checkdisable();

    }

    // reset value
    public function resetvalue(){
       foreach ($this->answers as $i =>  $answer )
        {
            if(str_contains($answer['image'],'images/temp/'))
            {
              File::delete(public_path($answer['image']));}
        }
        $this->step=1;
        $this->type=null;
        $this->answers=[];
        $this->stepanswer=0;
        $this->currentanswer=null;
        $this->count=0;
        // $this->question=$this->selectquestiondefult();
        for ($i=0; $i <$this->numofanswers ; $i++) {
            $this->setscore[$i]=0;
            $this->setskip[$i]=0;
            $this->setterminate[$i]=0;
            $this->sethide[$i]=0;
       }
        $this->resetErrorBag();

    }
    public function selecttype($type){
        $this->type=$type;
        $this->checkdisable();
        $this->initvalue();

    }
    public function render()
    {
        return view('livewire.add-question');
    }
    // realtime validate
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName,[
            'answers.*.value' =>['required'],
            'question' =>['required','min:6'],
            'answers'=>['required','min:1'],
            'answers.*.score'=>[ 'required','numeric','min:0','max:10']
        ],
        [
        'answers.*.value.required'=>'The answer can\'t be  empty ',
        'answers.*.score.required'=>'The score can\'t be  empty ',
        'question.min'=>'The :attribute must contain at least 10 characters ',
        'answers.*.score.max'=>'the score should be between 0 and 10',
        'answers.*.score.min'=>'the score should be between 0 and 10',
        'question.required'=>'The :attribute is empty ',
        'answers.required'=>'You should add at least one answer']
      );
    }
    // validate on submit
    public function validatedata(){


        $this->validate([

            'answers.*.value' =>['required'],
            'question' =>['required','min:6'],
            'answers'=>['required','min:1'],
            'answers.*.score'=>[ 'required','numeric','min:0','max:10']

        ],[
            'answers.*.value.required'=>'The answer can\'t be  empty ',
            'answers.*.score.required'=>'The score can\'t be  empty ',
            'question.min'=>'The :attribute must contain at least 10 characters ',
            'answers.*.score.max'=>'the score should be between 0 and 10',
        'answers.*.score.min'=>'the score should be between 0 and 10',
            'question.required'=>'The :attribute is empty ',
            'answers.required'=>'You should add at least one answer',

        ]
          );
    }
    // validate on submit only for yes or no types
    public function validatequestion(){


        $this->validate([


            'question' =>['required','min:6'],


        ],[

            'question.min'=>'The :attribute must contain at least 10 characters ',

            'question.required'=>'The :attribute is empty ',


        ]
          );
    }
    public function save(){
        // validation
        if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="rating"||$this->type=="satisfaction"||$this->type=="short_text_question"||$this->type=="email"||$this->type=="number"||$this->type=="date_question"||$this->type=="long_text_question")
        {$this->validatequestion();}
        else
        {     $this->validatedata();}
        //  end of validation
        $this->resetErrorBag();
        // custom type
        if($this->type=="custom_satisfaction"||$this->type=="custom_rating")
        {
              // add custom parent question
            $Question=new Questions();
            if($this->is_mandetory_question==1)
            $Question->optional=0;
            else
            $Question->optional=1;
            // calculate the order of question order
            $questions_orders=Questions::wheresurvey_id($this->survey_id)->select('questions.question_order')->get();
            $max_order=0;
                foreach($questions_orders as $order)
                { if($order->question_order>$max_order)
                $max_order=$order->question_order;
                }

            $Question->question_order=$max_order+=1;

            // end calculate of question order
            $Question->survey_id=$this->survey_id;
            $Question->type_of_question_id=QuestionType::wherequestion_type($this->type)->first()->id;

            $Question->save();
            // end of add custom parent question
            // -----------------------------------------------
            // add question parent to custom question table
            $Parentquestion=new CustomQuestion();
            $Parentquestion->question_id=$Question->id;
            $Parentquestion->save();
            // re set the custom_question_id
            $Parentquestion=CustomQuestion::find($Parentquestion->id);
            $Parentquestion->custom_question_id=$Parentquestion->id;
            $Parentquestion->save();


           //  detect the source of trnslation
            $source="";
            foreach($this->languages as $lang)
            {if($lang['code']==$this->local)
                {
                $source=$lang['trans'];
                }

            }
            // add translation of parent question for each language of survey languages
            foreach($this->languages as $lang)
            {
                $question_trans=new CustomQuestionTranslation();
                // if language is same the local language of survey
                if($lang['code']==$this->local)
                {  $question_trans->question_details=$this->question;
                $question_trans->question_local=$lang['code'];
                $question_trans->custom_question_id=$Parentquestion->id;

                }
                // if language is not same the local language of survey
                else
                {
                    try {
                        $tr = new GoogleTranslate();
                        $question_trans->question_details=$tr->setSource($source)->setTarget($lang['trans'])->translate($this->question);
                    } catch (\Throwable $th) {
                        $question_trans->question_details=$this->question;
                    }

                $question_trans->question_local=$lang['code'];
                $question_trans->custom_question_id=$Parentquestion->id;
                }

                $question_trans->save();
            }
            $folderPath ='storage/images/upload/';
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

          //    add child questions
            foreach($this->answers as $ans)

            {
                        if(str_contains($ans['image'], 'images/temp/'))
                        {
                        $image_name="image-".Auth::user()->id.$ans['value']."-".uniqid();
                        $name=$image_name . '.jpg';
                        $file = $folderPath .$name;
                        $old=public_path($ans['image']);
                        $new=$file;
                        File::copy($old , $new);
                        }
                        else
                        {
                            $new=$ans['image'];
                        }
                        $image_ans=new Pictures();
                        $image_ans->pic_url=$new;
                        $image_ans->pic_name=$ans['value'];
                        $image_ans->user_id=Auth::user()->id;
                        $image_ans->save();
                        // add each question to question table
                        $child_question=new Questions();
                        $child_question->question_order=$Question->question_order;
                        $child_question->survey_id=$this->survey_id;
                        $child_question->type_of_question_id=QuestionType::wherequestion_type($this->type)->first()->id;
                        $child_question->optional=$Question->optional;
                        $child_question->save();
                        // end of add to question table


                        // add translation of each child question for each language of survey languages
                        foreach($this->languages as $lang)
                        {
                            $child_question_trans=new QuestionTranslation();
                            // if language is same the local language of survey
                            if($lang['code']==$this->local)
                            {  $child_question_trans->question_details=$ans['value'];
                            $child_question_trans->question_local=$lang['code'];
                            $child_question_trans->question_id=$child_question->id;

                            }
                            // if language is not same the local language of survey
                            else
                            {
                                try {
                                    $tr = new GoogleTranslate();
                                    $child_question_trans->question_details=$tr->setSource($source)->setTarget($lang['trans'])->translate($ans['value']);
                                } catch (\Throwable $th) {
                                    $child_question_trans->question_details=$ans['value'];
                                }

                            $child_question_trans->question_local=$lang['code'];
                            $child_question_trans->question_id=$child_question->id;
                            }

                            $child_question_trans->save();
                        }
                        //  end of add translation of each child question

                        // add child question to custom question table with custom question id
                        $childcustomquestion=new CustomQuestion();
                        $childcustomquestion->question_id=$child_question->id;
                        $childcustomquestion->custom_question_id=$Parentquestion->id;
                        $childcustomquestion->picture_id=$image_ans->id;
                        $childcustomquestion->save();
                        // end of child question to custom question table with custom question id





            }
        }

        // another types of questions

        else
        {

            $Question=new Questions();
            if($this->is_mandetory_question==1)
            $Question->optional=0;
            else
            $Question->optional=1;
            // calculate the order of question
            $questions_orders=Questions::wheresurvey_id($this->survey_id)->select('questions.question_order')->get();
            $max_order=0;
                foreach($questions_orders as $order)
                { if($order->question_order>$max_order)
                $max_order=$order->question_order;
                }

            $Question->question_order=$max_order+=1;

            // end calculate of question order
            $Question->survey_id=$this->survey_id;
            //add the type of question
            $Question->type_of_question_id=QuestionType::wherequestion_type($this->type)->first()->id;
            //  save question
            $Question->save();

           //  detect the source of trnslation
            $source="";
            foreach($this->languages as $lang)
            {if($lang['code']==$this->local)
                {
                $source=$lang['trans'];
                }

            }
            // add translation of question for each language of survey languages
            foreach($this->languages as $lang)
            {
                $question_trans=new QuestionTranslation();
                // if language is same the local language of survey
                if($lang['code']==$this->local)
                {  $question_trans->question_details=$this->question;
                $question_trans->question_local=$lang['code'];
                $question_trans->question_id=$Question->id;

                }
                // if language is not same the local language of survey
                else
                {
                    try {
                        $tr = new GoogleTranslate();
                        $question_trans->question_details=$tr->setSource($source)->setTarget($lang['trans'])->translate($this->question);
                    } catch (\Throwable $th) {
                        $question_trans->question_details=$this->question;
                    }

                $question_trans->question_local=$lang['code'];
                $question_trans->question_id=$Question->id;
                }

                $question_trans->save();
            }
            // create folder upload if not exsist
            $folderPath ='storage/images/upload/';
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            //  if question of type yes_no or like_dislike or..........or rating ..... then i will store only the answer without translate or image
            if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="rating"||$this->type=="satisfaction")
            {
                foreach($this->answers as $ans){
                        $answer=new Answers();
                        $answer->question_id=$Question->id;
                        $answer->picture_id=null;
                        $answer->score=$ans['score'];
                        $answer->conditional=$ans['skip'];
                        $answer->terminate=$ans['terminate'];
                        $answer->hide=$ans['hide'];
                        $answer->save();
                }
            }
            // if there another type of question
            else{
            foreach($this->answers as $ans)

            {

                // if answer  have image
                    if($ans['image']!=null)
                    {
                        if(str_contains($ans['image'], 'images/temp/'))
                        {
                        $image_name="image-".Auth::user()->id.$ans['value']."-".uniqid();
                        $name=$image_name . '.jpg';
                        $file = $folderPath .$name;
                        $old=public_path($ans['image']);
                        $new=$file;
                        File::copy($old , $new);
                        }
                        else
                        {
                            $new=$ans['image'];
                        }
                        $image_ans=new Pictures();
                        $image_ans->pic_url=$new;
                        $image_ans->pic_name=$ans['value'];
                        $image_ans->user_id=Auth::user()->id;
                        $image_ans->save();
                        $answer=new Answers();
                        $answer->question_id=$Question->id;
                        $answer->picture_id=$image_ans->id;
                        $answer->score=$ans['score'];
                        $answer->conditional=$ans['skip'];
                        $answer->terminate=$ans['terminate'];
                        $answer->hide=$ans['hide'];
                        $answer->save();

                        foreach($this->languages as $lang)
                        {
                            $answer_trans=new AnswersTranslation();
                            $answer_trans->answer_local=$lang['code'];
                            $answer_trans->answer_id=$answer->id;
                            if($lang['code']==$this->local)
                            $answer_trans->answer_details=$ans['value'];
                            else
                            {
                                try {
                                    $tr = new GoogleTranslate();
                                    $answer_trans->answer_details=$tr->setSource($source)->setTarget($lang['trans'])->translate($ans['value']);
                                } catch (\Throwable $th) {
                                    $answer_trans->answer_details=$ans['value'];
                                }


                        }
                        $answer_trans->save();
                        }

                    }
                    // if answer not have image => answer without image
                    else
                    {

                        $answer=new Answers();
                        $answer->question_id=$Question->id;
                        $answer->picture_id=null;
                        $answer->score=$ans['score'];
                        $answer->conditional=$ans['skip'];
                        $answer->terminate=$ans['terminate'];
                        $answer->hide=$ans['hide'];
                        $answer->save();

                        foreach($this->languages as $lang)
                        {
                            $answer_trans=new AnswersTranslation();
                            $answer_trans->answer_local=$lang['code'];
                            $answer_trans->answer_id=$answer->id;
                            if($lang['code']==$this->local)
                            $answer_trans->answer_details=$ans['value'];
                            else
                            {
                                try {
                                    $tr = new GoogleTranslate();
                                $answer_trans->answer_details=$tr->setSource($source)->setTarget($lang['trans'])->translate($ans['value']);
                                } catch (\Throwable $th) {
                                    $answer_trans->answer_details=$ans['value'];
                                }

                            }
                            $answer_trans->save();
                        }
                    }




            }}
        }
        // to reset value after save
        $this->resetvalue();

    // emit if question add success
    $this->emit('questionaddsuccess',$this->survey_id);
    }

}
