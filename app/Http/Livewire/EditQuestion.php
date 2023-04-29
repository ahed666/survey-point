<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Questions;
use App\Models\QuestionTranslation;
use App\Models\Answers;
use App\Models\AnswersTranslation;
use App\Models\Survey;
use App\Models\Pictures;
use App\Models\QuestionType;
use App\Models\CustomQuestion;
use App\Models\CustomQuestionTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rules;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;
use Storage;
use Illuminate\Support\Facades\File;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;
class EditQuestion extends Component
{
    // old
    use WithFileUploads;
    public $step=1;
    public $type_details;
    public $model=false;
    public $stepanswer=0;
    public $stepimage;
    public $currentanswer=null;
    public $answers=[];
    public $current_image;
    public $imagesrc;
    public $show=false;
    public $numofanswers=50;
    public $numofanswerslist=200;
    public $count=0;
    public $image;
    public $answersdeleted=[];
    public $imagedefultsrc;
     public $answerdeleteid;
    // to detect where user click add score
    public $stepscore=null;
    public $setscore=array();
    public $sethide=array();
    public $setskip=array();
    public $setterminate=array();
    // new
    public $question;
    public $question_text;
    public $custom_questions;
    public $type;
    public $local;
    public $languages;
    protected $listeners = ['edit'=>'edit',
        // to delete survey
        'deleteanswerConfirmed'=>'deleteanswer'
];
    // to initializtion array of skip,hide,score,terminate and num of answers based on type of question
    public function initvalue($count)
    {    for ($i=0; $i <$count ; $i++) {
        $this->setscore[$i]=$this->answers[$i]['score'];
        $this->setskip[$i]=$this->answers[$i]['skip'];
        $this->setterminate[$i]=$this->answers[$i]['terminate'];
        $this->sethide[$i]=$this->answers[$i]['hide'];
    }
        // if type is logic (yes or no...) then there is only two answers and user cannot add it , we will add it auto
        if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree")
        { $this->numofanswers=$count;

        }
        elseif($this->type=="rating"||$this->type=="satisfaction")
        {$this->numofanswers=$count;
        }
        else
        $this->numofanswers=$count;
    }

    public function mount(){

        $this->imagedefultsrc="images/default_answer_image.png";
        $this->step=1;
        $this->stepanswer=0;
        $this->show=false;
        $this->currentanswer=null;



    }
    // initial function
    public function edit($id,$local,$languages){
        $this->resetvalue();
        // $this->question=new Questions();
        $this->question=Questions::whereid($id)->first();

        $this->local=$local;
        $this->languages=$languages;
        $this->type=QuestionType::whereid($this->question['type_of_question_id'])->first()->question_type ;
        $this->type_details=QuestionType::whereid($this->question['type_of_question_id'])->first()->question_type_details;
        // if type of question is custom
        if($this->type=='custom_rating'||$this->type=='custom_satisfaction')
        {    $ques=Questions::join('custom_questions', 'Questions.id', '=', 'custom_questions.question_id')->
            groupBy('custom_questions.custom_question_id')->
            join('custom_question_translations','custom_questions.custom_question_id','=','custom_question_translations.custom_question_id')->
            where('custom_question_translations.question_local','=',$this->local)->where('Questions.id','=',$this->question['id'])
            ->select('Questions.*','custom_question_translations.question_details As details','custom_question_translations.question_local As local')
            ->orderby('Questions.question_order')->first();

            $this->question_text=$ques->details;
            $parent_question=CustomQuestion::wherequestion_id($ques->id)->first();

            $child_questions=Questions::join('custom_questions', 'Questions.id', '=', 'custom_questions.question_id')
            ->join('question_translations','Questions.id','=','question_translations.question_id')
             ->join('pictures','custom_questions.picture_id','=','pictures.id')
            ->where('custom_questions.custom_question_id','=',$parent_question->id)
            ->where('question_translations.question_local','=',$this->local)
            ->select('custom_questions.id as child_id','Questions.*','question_translations.id as question_trans_id','question_translations.question_details as details','pictures.pic_url As image')->get();
            foreach($child_questions as $i=> $answer)
                {
                    $collect=collect(
                        ["id"=>$answer['id'],
                        "value"=>$answer['details'],
                        "code"=>$i+1,
                        "score"=>null,
                        "hide"=>null,
                        "skip"=>null,
                        "terminate"=>null,
                        "image"=>$answer['image'],

                        ]
                    );
                    array_push($this->answers,$collect);
                }




        }
        // if type of question is not custom
        else
        {
            // get question
            $ques=Questions::join('question_translations','Questions.id','=','question_translations.question_id')->
            whereNotIn('Questions.type_of_question_id',[8,9])->
            select('Questions.*','question_translations.question_details As details','question_translations.question_local As local')->
            where('question_translations.question_local','=',$this->local)->where('Questions.id','=',$this->question['id'])->get();
            // question details
            $this->question_text=$ques[0]->details;
            // answers
            // multi with image

             if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="satisfaction"||$this->type=="rating"||$this->type=="rating")
             {
                $answers=Answers::where('question_id','=',$this->question['id'])->get();
                foreach($answers as $i=> $answer)
                {
                    $collect=collect(
                        ["id"=>$answer['id'],
                        "value"=>null,
                        "code"=>$i+1,
                        "score"=>$answer['score'],
                        "hide"=>$answer['hide'],
                        "skip"=>$answer['conditional'],
                        "terminate"=>$answer['terminate'],
                        "image"=>null,

                        ]
                    );
                    array_push($this->answers,$collect);

                }

             }
            elseif($this->type=='mcq_pic'||$this->type=='checkbox_pic')
            {
                $answers=Answers::where('question_id','=',$this->question['id'])->join('answer_translations','Answers.id','=','answer_translations.answer_id')
                ->where('answer_translations.answer_local','=',$this->local)->join('pictures','Answers.picture_id','=','pictures.id')
                ->select('Answers.*','answer_translations.*','pictures.pic_url As image')->get();
                foreach($answers as $i=> $answer)
                {
                    $collect=collect(
                        ["id"=>$answer['id'],
                        "value"=>$answer['answer_details'],
                        "code"=>$i+1,
                        "score"=>$answer['score'],
                        "hide"=>$answer['hide'],
                        "skip"=>$answer['conditional'],
                        "terminate"=>$answer['terminate'],
                        "image"=>$answer['image'],

                        ]
                    );
                    array_push($this->answers,$collect);
                }
            }
            // only multi without images
            else{
                $answers=Answers::where('question_id','=',$this->question['id'])->join('answer_translations','Answers.id','=','answer_translations.answer_id')
                ->where('answer_translations.answer_local','=',$this->local)
                ->select('Answers.*','answer_translations.*')->get();
                foreach($answers as $i=> $answer)
                {
                    $collect=collect(
                        ["id"=>$answer['id'],
                        "value"=>$answer['answer_details'],
                        "code"=>$i+1,
                        "score"=>$answer['score'],
                        "hide"=>$answer['hide'],
                        "skip"=>$answer['conditional'],
                        "terminate"=>$answer['terminate'],
                        "image"=>null,

                        ]
                    );
                    array_push($this->answers,$collect);
                }

            }



        }


        $this->count=count($this->answers);
        $this->stepanswer=count($this->answers);
        $this->initvalue($this->count);


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

    // save image after crop it
    public function cropimage(){
        $this->dispatchBrowserEvent('save');



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


        if(str_contains($this->answers[$this->stepimage]['image'], 'images/temp/')||str_contains($this->answers[$this->stepimage]['image'], 'images/upload/'))
          {File::delete(public_path($this->answers[$this->stepimage]['image']));}
        $this->answers[$this->stepimage]['image']="/storage/images/temp/".$name;
        file_put_contents($file, $image_base64);

    }

    // index image
    public function updatecurrentimageindex($i){
        $this->stepimage=$i;
    }

    public function updatedimage(){

                $this->model=true;

                // $this->answers[$this->stepimage]['image']=$this->image->temporaryUrl();
                $this->imagesrc=$this->image->temporaryUrl();
                $this->dispatchBrowserEvent('image-updated-edit', ['image' => $this->image]);

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
    public function deleteanswer()
    {
        array_push($this->answersdeleted,$this->answers[$this->answerdeleteid]['id']);

        //    $this->answers[$i]['code']=null;
        // if the item deleted IS the last item
            if($this->answerdeleteid==$this->count-1)
            {
                $this->count-=1;

                $this->stepanswer-=1;
                array_pop($this->answers);
            }
        else
        {
          for($j=$this->answerdeleteid;$j<$this->count-1;$j++)
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
          {$image=null;}

            // if the question is the first question
        if($this->count==0)
            {


                $collect=collect(
                    ["id"=>-1,
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
                    ["id"=>-1,
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
        $this->answersdeleted=[];
        $this->question="do you           ?";
        for ($i=0; $i <$this->numofanswers ; $i++) {
            $this->setscore[$i]=0;
            $this->setskip[$i]=0;
            $this->setterminate[$i]=0;
            $this->sethide[$i]=0;
       }

        $this->resetErrorBag();

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

    //   delete Answer confirmation
    public function deleteAnswerConfirmation($id){
        $this->answerdeleteid=$id;
        $this->dispatchBrowserEvent('show-delete-answer-confirmation');
        //    to re select the current survey

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
    // to  save question
    public function save(){
        if($this->type=="yes_no"||$this->type=="like_dislike"||$this->type=="Agree_Disagree"||$this->type=="rating"||$this->type=="satisfaction")
        {$this->validatequestion();}
        else
        {     $this->validatedata();}
        $survey_id=$this->question['survey_id'];
        // if custom question
        if($this->type=='custom_satisfaction'||$this->type=='custom_rating')
        {
            // delete the answers that its deleted
            for ($i=0; $i <count($this->answersdeleted) ; $i++)
            {
                $answer=Questions::where('questions.id',$this->answersdeleted[$i])

                ->join('custom_questions','custom_questions.question_id','=','Questions.id')
                ->select('Questions.id as q_id','custom_questions.picture_id as picture_id')->first();

                // AnswersTranslation::whereanswer_id($answer['answer_id'])->delete();
                Questions::whereid($answer['q_id'])->delete();
                // if answer have image
                if($answer['picture_id']!=null)
                {
                $imagepath=Pictures::whereid($answer['picture_id'])->first()->pic_url;
                    if(str_contains($imagepath, 'images/temp/')||str_contains($imagepath, 'images/upload/'))
                {
                    File::delete(public_path($imagepath));}
                    Pictures::whereid($answer['picture_id'])->delete();}


            }


                $question_trans=CustomQuestionTranslation::join('custom_questions','custom_questions.id','=','custom_question_translations.custom_question_id')
                ->where('custom_questions.question_id','=',$this->question['id'])
                ->where('custom_question_translations.question_local',$this->local)->select('custom_question_translations.*')->first();

                $question_trans->question_details=$this->question_text;
                $Parentquestion=CustomQuestion::wherequestion_id($this->question['id'])->first();
                $question_trans->save();
                $folderPath ='storage/images/upload/';
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                //  detect the source of trnslation
                $source="";
                foreach($this->languages as $lang)
                {if($lang['code']==$this->local)
                    {
                    $source=$lang['trans'];
                    }

                }

                //  add child questions
                foreach($this->answers as $ans)

                {
                     if(Questions::find($ans['id']))
                     {
                        $answer=Questions::where('Questions.id',$ans['id'])
                        ->join('custom_questions','custom_questions.question_id','=','Questions.id')
                        ->join('question_translations','question_translations.question_id','=','Questions.id')

                        ->where('question_translations.question_local',$this->local)->select()->first();

                        // if child question  have image
                        if($answer->picture_id!=null)
                            {

                                $image=Pictures::whereid($answer->picture_id)->first();

                                if(str_contains($ans['image'],'images/temp/'))
                                {
                                    $image_name="image-".Auth::user()->id.$ans['value']."-".$answer->question_id;
                                    $name=$image_name . '.jpg';
                                    $file = $folderPath .$name;

                                    $old=public_path($ans['image']);
                                    $new=$file;
                                    File::copy($old , $new);
                                }
                                    else
                                    $new=$ans['image'];

                                $image->pic_url=$new;

                                $image->save();

                                $question_child_trans=QuestionTranslation::join('questions','questions.id','=','question_translations.question_id')->where('questions.id','=',$answer->question_id)->first();

                                $question_child_trans->question_details=$ans['value'];

                                $question_child_trans->save();


                            }
                            // if child question not have image => answer without image
                            else{
                                $question_child_trans=QuestionTranslation::join('questions','questions.id','=','question_translations.question_id')->where('questions.id','=',$answer->question_id)->first();
                                $question_child_trans->question_details=$ans['value'];

                                $question_child_trans->save();

                            }
                        // edit answer details score,skip,hide

                        // $Answer=Answers::find($answer->answer_id);

                        // $Answer->score=$ans['score'];
                        // $Answer->conditional=$ans['skip'];
                        // $Answer->hide=$ans['hide'];
                        // $Answer->Save();
                     }
                     else
                     {

                        //  if image is not defult
                        if(str_contains($ans['image'], 'images/temp/'))
                        {
                        $image_name="image-".Auth::user()->id.$ans['value']."-".uniqid();
                        $name=$image_name . '.jpg';
                        $file = $folderPath .$name;
                        $old=public_path($ans['image']);
                        $new=$file;
                        File::copy($old , $new);
                        }
                        // if image is defult
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
                        $child_question->question_order=$this->question['question_order'];
                        $child_question->survey_id=$survey_id;
                        $child_question->type_of_question_id=QuestionType::wherequestion_type($this->type)->first()->id;
                        $child_question->optional=$this->question['optional'];
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


        }
        // if type is another type of custom question
        else
        {
                    // delete the answers that its deleted
                    for ($i=0; $i <count($this->answersdeleted) ; $i++)
                    {
                        $answer=Answers::wherequestion_id($this->question['id'])
                        ->join('answer_translations','answer_translations.answer_id','=','Answers.id')->Where('answer_translations.id','=',$this->answersdeleted[$i])
                        ->select('Answers.*','answer_translations.*')->first();

                        AnswersTranslation::whereanswer_id($answer['answer_id'])->delete();
                        Answers::whereid($answer['answer_id'])->delete();
                        // if answer have image
                        if($answer['picture_id']!=null)
                        {
                        $imagepath=Pictures::whereid($answer['picture_id'])->first()->pic_url;
                            if(str_contains($imagepath, 'images/temp/')||str_contains($imagepath, 'images/upload/'))
                        {
                            File::delete(public_path($imagepath));}
                            Pictures::whereid($answer['picture_id'])->delete();}


                    }


                $question_trans=QuestionTranslation::wherequestion_id($this->question['id'])->wherequestion_local($this->local)->first();
                $question_trans->question_details=$this->question_text;
                $question_trans->save();
                $folderPath ='storage/images/upload/';
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                //  detect the source of trnslation
                $source="";
                foreach($this->languages as $lang)
                {if($lang['code']==$this->local)
                    {
                    $source=$lang['trans'];
                    }

                }

                foreach($this->answers as $ans)

                {

                    // if answer is exsist =>edit it
                    if(AnswersTranslation::find($ans['id']))
                    {   $answer=Answers::wherequestion_id($this->question['id'])
                        ->join('answer_translations','answer_translations.answer_id','=','Answers.id')->Where('answer_translations.id','=',$ans['id'])
                        ->where('answer_translations.answer_local',$this->local)->first();

                        // if answer  have image
                        if($answer->picture_id!=null)
                            {    $image=Pictures::join('answers','pictures.id','=','Answers.picture_id')->where('answers.id','=',$answer->answer_id)->select('pictures.*')->first();

                                if(str_contains($ans['image'],'images/temp/'))
                                {
                                    $image_name="image-".Auth::user()->id.$ans['value']."-".$answer->answer_id;
                                    $name=$image_name . '.jpg';
                                    $file = $folderPath .$name;

                                    $old=public_path($ans['image']);
                                    $new=$file;
                                    File::copy($old , $new);
                                }
                                    else
                                    $new=$ans['image'];

                                $image->pic_url=$new;

                                $image->save();

                                $answer_trans=AnswersTranslation::find($answer->id);
                                $answer_trans->answer_details=$ans['value'];

                                $answer_trans->save();


                            }
                            // if answer not have image => answer without image
                        else{
                                $answer_trans=AnswersTranslation::find($answer->id);
                                $answer_trans->answer_details=$ans['value'];
                                $answer_trans->save();


                            }
                        // edit answer details score,skip,hide

                        $Answer=Answers::find($answer->answer_id);

                        $Answer->score=$ans['score'];
                        $Answer->conditional=$ans['skip'];
                        $Answer->terminate=$ans['terminate'];
                        $Answer->hide=$ans['hide'];
                        $Answer->Save();
                    }
                    // if answer is not exsist =>add it
                    else
                    {  // if answer  have image
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
                            $answer->question_id=$this->question['id'];
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
                                $answer_trans->answer_details=" ";
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
                            $answer->question_id=$this->question['id'];
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
                    }



                }


        }

        // emit if question edit success
        $this->emit('questioneditsuccess',$survey_id);

    }
    public function render()
    {

        return view('livewire.edit-question');
    }
}
