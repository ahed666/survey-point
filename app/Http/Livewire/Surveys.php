<?php

namespace App\Http\Livewire;

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
use Livewire\Component;
// google translate api
use Stichoza\GoogleTranslate\GoogleTranslate;

class Surveys extends Component
{
    public $current_survey_id;
    public $question_delete_id;
    public $language_delete_id;
    public $current_survey;
    public $languages;
    public $current_survey_kiosks;
    //    to set the id of survey that want user delete it
    public $survey_delete_id;
    // add survey details
    public $survey_logo;
    public $logosrc;
    public $logo;
    public $survey_BusinessName;
    public $survey_Name;
    public $modal = false;
    // end add survey details
    public $surveylanguages;
    public $main_languages;
    //    edit question
    public $questionediting;
    public $current_questions;
    public $modalopen = false;

    public $local = "en";
    //    survey options
    public $surveyexpiry = false;
    public $surveyexpirydate = null;
    public $service = false;
    public $terms=false;
    // end of survey options
    //    messages of survey
    public $current_message;
    public $messages_defult =
        '[{"local":"en","start_header":"welcome in my survey","start_text":"you can choose language and start","end_header":"Thank You","end_text":"the survey submitted","terms":"defult terms"},
       {"local":"ar","start_header":"اهلا وسهلا بك في هذا الأستبيان","start_text":"تستطيع اختيار اللغة و من ثم البدء","end_header":"شكرا لك","end_text":"تم حفظ الأستبيان","terms":"مصطلح افتراضي"},
       {"local":"tl","start_header":"welcome in my survey","start_text":"you can choose language and start","end_header":"Thank You","end_text":"the survey submitted","terms":"defult terms"},
       {"local":"ur","start_header":"welcome in my survey","start_text":"you can choose language and start","end_header":"Thank You","end_text":"the survey submitted","terms":"defult terms"}
       ]';
    public $messages;
    // end messages of survey
    public $lang =
        '[
           { "id": 1,"code":"en", "name": "English"},
           { "id": 2,"code":"ar" ,"name": "عربي"},
           { "id": 3, "code":"ur","name": "urdu"}
    ]';
    public $main_lang = '[
        { "id": 1,"code":"en", "name": "English","trans":"en"},
        { "id": 2,"code":"ar" ,"name": "عربي","trans":"ar"},
        { "id": 3, "code":"ur","name": "urdu","trans":"ur"},
        { "id": 4, "code":"tl","name": "Tagalog","trans":"fil"}
    ]';
    public $questions;
    public $surveys;

    protected $listeners = [
        // to update survey every second
        'updatecurrentsurvey' => 'update_currentsurvey',
        // to delete survey
        'deleteConfirmed' => 'deletesurvey',
        // to delete question
        'deleteQuestionConfirmed' => 'deletequestion',
        // to delete language
        'deleteLanguageConfirmed' => 'deletelang',
        //  to refresh after edit message
        'messageeditsuccess' => 'messageeditsuccess',
        //  to refresh after edit terms
        'termseditsuccess' => 'termseditsuccess',
        //    to refresh after edit survey
        'surveyeditsuccess' => 'surveyeditsuccess',
        //    to refresh after add survey
        'surveyaddsuccess' => 'surveyaddsuccess',
        //  to refresh after edit question
        'questioneditsuccess' => 'questioneditsuccess',
        //  to refresh after add question
        'questionaddsuccess' => 'questionaddsuccess',


    ];
    
//   if message edit success
    public function messageeditsuccess($id)
    {

        $this->current_questions = $this->getquestions($id);

        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')
            ->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {
            $this->current_survey_id = $this->current_survey->survey_id;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
        }
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();
        $this->dispatchBrowserEvent('contentChanged');

    }
    //   if message edit success
    public function termseditsuccess($id)
    {

        $this->current_questions = $this->getquestions($id);

        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')
            ->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {
            $this->current_survey_id = $this->current_survey->survey_id;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
        }
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();
        $this->dispatchBrowserEvent('contentChanged');
        $this->dispatchBrowserEvent('close_modal_edit_terms');


    }
    //   if question edit success
    public function questioneditsuccess($id)
    {

        $this->current_questions = $this->getquestions($id);
        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')
            ->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {
            $this->current_survey_id = $this->current_survey->survey_id;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
        }
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();
        $this->dispatchBrowserEvent('contentChanged');
        $this->dispatchBrowserEvent('close_modal_edit_question');


    }
    //   if question add success
    public function questionaddsuccess($id)
    {
        $this->current_questions = $this->getquestions($id);
        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')
            ->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {
            $this->current_survey_id = $this->current_survey->survey_id;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
        }

        $this->dispatchBrowserEvent('contentChanged');
        $this->dispatchBrowserEvent('close_modal_add_question');


    }
//   if survey add success
    public function surveyaddsuccess($id)
    {

        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {
            $this->current_survey_id = $this->current_survey->survey_id;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
        }
        //   dd($this->current_survey);
        $this->surveys = Survey::whereteam_id(Auth::user()->current_team_id)->get();
        $this->main_languages = json_decode($this->main_lang, true);

        $this->messages = json_decode($this->messages_defult, true);
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();
        $this->surveylanguages = $this->getLocalesOfSurvey($this->current_survey_id);
        $this->current_message = SurveyTrnslations::wheresurvey_id($this->current_survey_id)->wheresurvey_local($this->local)->first();

        $this->current_questions = $this->getquestions($this->current_survey_id);

        $this->dispatchBrowserEvent('contentChanged');
        $this->dispatchBrowserEvent('close_modal_add_survey');


    }
    //   if survey edit success
    public function surveyeditsuccess()
    {
        $this->mount();

        $this->dispatchBrowserEvent('contentChanged');


    }

// update current survey after change
    public function update_currentsurvey()
    {
        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {$this->current_survey_id = $this->current_survey->survey_id;
            $this->service = (bool) $this->current_survey->active;
            $this->surveyexpiry = (bool) $this->current_survey->expiry;
            $this->surveyexpirydate = $this->current_survey->expiry_date;} else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
            $this->service = (bool) $this->current_survey->active;
            $this->terms = (bool) $this->current_survey->terms;
            $this->surveyexpiry = (bool) $this->current_survey->expiry;
            $this->surveyexpirydate = $this->current_survey->expiry_date;
        }
        $this->surveys = Survey::whereteam_id(Auth::user()->current_team_id)->get();
        $this->main_languages = json_decode($this->main_lang, true);
        $this->messages = json_decode($this->messages_defult, true);
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();
        $this->surveylanguages = $this->getLocalesOfSurvey($this->current_survey_id);
        $this->current_message = SurveyTrnslations::wheresurvey_id($this->current_survey_id)->wheresurvey_local($this->local)->first();
        $this->current_questions = $this->getquestions($this->current_survey_id);
        $this->dispatchBrowserEvent('contentChanged');

    }
// **  edit web option of survey
   public function addterms()
   {  $languages=$this->getLocalesOfSurvey($this->current_survey_id);

    if(count($languages)>0)
    {   $term="defult term";
        foreach($languages as $language)
        {   $survey_trans=SurveyTrnslations::wheresurvey_id($this->current_survey_id)->wheresurvey_local($language['code'])->first();
            if($survey_trans->terms==null)
             {
                try {
                    $tr = new GoogleTranslate();
                    $survey_trans->terms= $tr->setSource('en')->setTarget($language['code'])->translate($term);
                } catch (\Throwable $th) {
                    $survey_trans->terms=$term;
                }
             }
             $survey_trans->save();

        }
    }
    //    if survey have lang
          //if terms not null
          // if terms null

   }
//terms
    public function updatedterms()
    {
        $survey = Survey::whereid($this->current_survey_id)->first();
        $survey->terms = $this->terms;
        $survey->save();
        if($survey->terms==true)
         $this->addterms();
        $this->update_currentsurvey();


    }
// service
    public function updatedservice()
    {
        $survey = Survey::whereid($this->current_survey_id)->first();
        $survey->active = $this->service;
        $survey->save();
        $this->update_currentsurvey();

    }
// expiry
    public function updatedsurveyexpiry()
    {
        $survey = Survey::whereid($this->current_survey_id)->first();
        $survey->expiry = $this->surveyexpiry;
        $survey->save();
        $this->update_currentsurvey();

    }
// expiry date
    public function updatedsurveyexpirydate()
    {

        $survey = Survey::whereid($this->current_survey_id)->first();
        $survey->expiry_date = $this->surveyexpirydate;
        $survey->save();
        $this->update_currentsurvey();

    }
// **  edit web option of survey
    //  select the question to edit it
    public function selecteditquestion($id)
    {

        $this->questionediting = Questions::whereid($id)->first();

        // $this->emitTo('edit',$this->questionediting,$this->local,$this->surveylanguages,true);

        $this->dispatchBrowserEvent('contentChanged');
        return $this->questionediting;

    }
    //    to check if this language in languages of survey or not
    public function surveylang($id)
    {
        foreach ($this->surveylanguages as $lang) {if ($lang['id'] == $id) {
            return true;
        }

        }
        return false;
    }
    //  to delete language
    public function deletelang()
    {

        foreach ($this->surveylanguages as $key => $lang) {
            if ($lang['id'] == $this->language_delete_id) {unset($this->surveylanguages[$key]);
                SurveyTrnslations::wheresurvey_id($this->current_survey_id)->wheresurvey_local($lang['code'])->delete();
                foreach ($this->getquestions($this->current_survey_id) as $question) {
                    // delete custom question
                    if (QuestionType::whereid($question['type_of_question_id'])->first()->question_type == "custom_rating" || QuestionType::whereid($question['type_of_question_id'])->first()->question_type == "custom_satisfaction") {
                        $parent_question = CustomQuestion::wherequestion_id($question['id'])->first();
                        // get and save child questions
                        $child_questions = Questions::join('custom_questions', 'custom_questions.question_id', '=', 'Questions.id')
                            ->where('custom_questions.custom_question_id', '=', $parent_question->id)
                            ->whereNotIn('custom_questions.question_id', [$parent_question->question_id])->get();
                        // delete each child question
                        foreach ($child_questions as $child) {
                            $imagepath = Pictures::whereid($child->picture_id)->first()->pic_url;
                            if (str_contains($imagepath, 'images/temp/') || str_contains($imagepath, 'images/upload/')) {File::delete(public_path($imagepath));}
                            // delete image
                            Pictures::whereid($child->picture_id)->delete();
                            // delete question
                            Questions::whereid($child->question_id)->delete();

                        }
                        // delete parent question
                        Questions::whereid($question['id'])->delete();

                    }
                    // another type of questions
                    else {
                        $answers = Answers::wherequestion_id($question['id'])->get();
                        foreach ($answers as $answer) {
                            // if the languages count =1 delete images of answers else then no delete images
                            if(count($this->surveylanguages)==1){
                            if ($answer->picture_id != null) {
                            $imagepath = Pictures::whereid($answer->picture_id)->first()->pic_url;
                            if (str_contains($imagepath, 'images/temp/') || str_contains($imagepath, 'images/upload/')) {File::delete(public_path($imagepath));}
                            Pictures::whereid($answer['picture_id'])->delete();
                        }}
                            AnswersTranslation::whereanswer_id($answer->id)->whereanswer_local($lang['code'])->delete();
                        }
                        QuestionTranslation::wherequestion_id($question['id'])->wherequestion_local($lang['code'])->delete();
                    }
                }

            }

        }

        $local = reset($this->surveylanguages);
        $this->changelocal($local['id']);

        $this->dispatchBrowserEvent('languagesChanged');
        $this->dispatchBrowserEvent('contentChanged');

    }
    // add lnaguage to survey
    public function addlang($id)
    {
        foreach ($this->main_languages as $lang) {
            if ($lang['id'] == $id) {
                $lan = $lang;
            }

        }
        $collect = collect(
            ["id" => $lan['id'],
                "code" => $lan['code'],
                "name" => $lan['name'],
                "trans" => $lan['trans'],
            ]
        );
        $this->local = $lan['code'];
        array_push($this->surveylanguages, $collect);
        // add defult messages
        $survey_trans = new SurveyTrnslations();
        foreach ($this->messages as $message) {
            if ($message['local'] == $this->local) {
                $survey_trans->survey_start_header = $message['start_header'];
                $survey_trans->survey_start_text = $message['start_text'];
                $survey_trans->survey_end_header = $message['end_header'];
                $survey_trans->survey_end_text = $message['end_text'];
                $survey_trans->terms = $message['terms'];
                $survey_trans->survey_id = $this->current_survey_id;
                $survey_trans->survey_local = $this->local;
                $survey_trans->save();

            }

        }
        //  end of add defult messages

        //  add question and answers
        // ***
        //  detect the source of trnslation
        $source = "";
        $destination = "";
        foreach ($this->surveylanguages as $lang) {if ($lang['code'] == $this->local) {
            $destination = $lang['trans'];
        } else { $source = $lang['trans'];
            $source_code = $lang['code'];
        }

        }

        foreach ($this->current_questions as $question) {
            if (QuestionType::whereid($question['type_of_question_id'])->first()->question_type == "custom_rating" || QuestionType::whereid($question['type_of_question_id'])->first()->question_type == "custom_satisfaction")
             {$parent_question = CustomQuestion::wherequestion_id($question['id'])->first();
                try {
                    $tr = new GoogleTranslate();
                    $question_trans = $tr->setSource($source)->setTarget($destination)->translate($question['details']);
                } catch (\Throwable $th) {
                    $question_trans=$question['details'];
                }

                DB::insert('insert into custom_question_translations (question_details, question_local,custom_question_id) values (?, ?,?)', [$question_trans, $this->local, $parent_question->id]);
                // get and save child questions
                $child_questions = Questions::join('custom_questions', 'custom_questions.question_id', '=', 'Questions.id')
                    ->where('custom_questions.custom_question_id', '=', $parent_question->id)->whereNotIn('custom_questions.question_id', [$parent_question->question_id])->get();

                foreach ($child_questions as $child) {
                    $child_trans = QuestionTranslation::wherequestion_id($child->question_id)->wherequestion_local($source_code)->first();
                          try {
                            $tr = new GoogleTranslate();
                            $child_details = $tr->setSource($source)->setTarget($destination)->translate($child_trans->question_details);
                          } catch (\Throwable $th) {
                            $child_details=$child_trans->question_details;
                          }


                    DB::insert('insert into question_translations (question_details, question_local,question_id) values (?, ?,?)', [$child_details, $this->local, $child->question_id]);
                }

            }
            else {
                try {
                    $tr = new GoogleTranslate();
                $question_trans = $tr->setSource($source)->setTarget($destination)->translate($question['details']);
                } catch (\Throwable $th) {
                    $question_trans=$question['details'];
                }


                DB::insert('insert into question_translations (question_details, question_local,question_id) values (?, ?,?)', [$question_trans, $this->local, $question['id']]);

                // $question_trans->save();
                $answers = Answers::where('question_id', '=', $question['id'])->get();

                foreach ($answers as $answer) {
                    $answer_trans = AnswersTranslation::whereanswer_id($answer->id)->whereanswer_local($source_code)->first();
                    if($answer_trans!=null){
                   try {
                    $tr = new GoogleTranslate();
                    $answer_details = $tr->setSource($source)->setTarget($destination)->translate($answer_trans->answer_details);

                   } catch (\Throwable $th) {

                    $answer_details=$answer_trans->answer_details;
                   }

                    DB::insert('insert into answer_translations (answer_details, answer_local,answer_id) values (?, ?,?)', [$answer_details, $this->local, $answer->id]);
                }}
            }

        }
        // ***
        // end of add question and it answers

        $this->dispatchBrowserEvent('languagesChanged');
        $this->dispatchBrowserEvent('contentChanged');
        $this->current_message = $survey_trans;
        $this->current_questions = $this->getquestions($this->current_survey_id);
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();
        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')
            ->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {
            $this->current_survey_id = $this->current_survey->survey_id;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
        }

    }

    //  to change local of show survey when click on tab
    public function changelocal($local_id)
    {

        foreach ($this->surveylanguages as $lang) {
            if ($lang['id'] == $local_id) {
                $local = $lang['code'];
            }
        }

        $this->local = $local;

        $this->current_questions = $this->getquestions($this->current_survey_id);
        $this->dispatchBrowserEvent('languagesChanged');
        $this->dispatchBrowserEvent('contentChanged');
        $this->current_message = SurveyTrnslations::wheresurvey_id($this->current_survey_id)->wheresurvey_local($this->local)->first();
        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')
            ->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {
            $this->current_survey_id = $this->current_survey->survey_id;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
        }

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
            where('custom_question_translations.question_local', '=', $this->local)
            ->select('Questions.*', 'custom_question_translations.question_details As details', 'custom_question_translations.question_local As local', 'type_of_questions.question_type_details as type')
            ->orderby('Questions.question_order')->get();

        //   another type of question
        $questions2 = Questions::join('question_translations', 'Questions.id', '=', 'question_translations.question_id')->
            join('type_of_questions', 'type_of_questions.id', '=', 'Questions.type_of_question_id')->
            whereNotIn('Questions.type_of_question_id', [8, 9])->
            select('Questions.*', 'question_translations.question_details As details', 'question_translations.question_local As local', 'type_of_questions.question_type_details as type')->
            where('Questions.survey_id', '=', $id)->where('question_translations.question_local', '=', $this->local)->orderby('Questions.question_order')->get();
        $questions = array_merge(json_decode($questions1, true), json_decode($questions2, true));
        usort($questions, function ($a, $b) {
            return $a['question_order'] - $b['question_order'];
        });

        return $questions;

    }

    //   to update when user re order the questions list
    public function updateQuestionOrder($questions)
    {

        foreach ($questions as $question) {
            // foreach($this->current_questions as $i=>$curr_ques){
            //     if($curr_ques['id']==$question['value'])
            //     $this->current_questions[$i]['question_order']=$question['order'];
            // }
            $ques = Questions::find($question['value']);

            if ($ques->type_of_question_id == 8 || $ques->type_of_question_id == 9) {
                $parentid = Questions::join('custom_questions', 'Questions.id', '=', 'custom_questions.question_id')->
                    where('Questions.id', '=', $ques->id)->select('custom_questions.*')->first();
                //  $parentid->custom_question_id
                $custom_questions = Questions::join('custom_questions', 'Questions.id', '=', 'custom_questions.question_id')->
                    where('custom_questions.custom_question_id', '=', $parentid->custom_question_id)->where('custom_questions.question_id', '!=', $parentid->question_id)->select('custom_questions.*')->get();

                foreach ($custom_questions as $custom_question) {$custom_ques = Questions::find($custom_question->question_id);

                    $custom_ques->question_order = $question['order'];
                    $custom_ques->update();

                }

                $ques->question_order = $question['order'];
                $ques->update();
            } else {

                $ques->question_order = $question['order'];
                $ques->update();
            }

        }

        // dd($this->current_questions);
        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {
            $this->current_survey_id = $this->current_survey->survey_id;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
        }
        $this->surveys = Survey::whereteam_id(Auth::user()->current_team_id)->get();
        $this->main_languages = json_decode($this->main_lang, true);
        $this->messages = json_decode($this->messages_defult, true);
        $this->surveylanguages = $this->getLocalesOfSurvey($this->current_survey_id);
        $this->current_message = SurveyTrnslations::wheresurvey_id($this->current_survey_id)->wheresurvey_local($this->local)->first();
        $this->current_questions = $this->getquestions($this->current_survey_id);
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();

        usort($this->current_questions, function ($a, $b) {
            return $a['question_order'] - $b['question_order'];
        });
        $this->dispatchBrowserEvent('contentChanged');

    }

    //  to get the count question of survey
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

    public function mount()
    {

        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')->where('surveys.team_id', Auth::user()->current_team_id)->orderBy('surveys.created_at', 'desc')->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {$this->current_survey_id = $this->current_survey->survey_id;
            $this->service = (bool) $this->current_survey->active;
            $this->terms = (bool) $this->current_survey->terms;
            $this->surveyexpiry = (bool) $this->current_survey->expiry;
            $this->surveyexpirydate = $this->current_survey->expiry_date;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->orderBy('surveys.created_at', 'desc')->get()->first();

            if ($this->current_survey != null) {$this->current_survey_id = $this->current_survey->survey_id;
                $this->surveyexpiry = (bool) $this->current_survey->expiry;
                $this->surveyexpirydate = $this->current_survey->expiry_date;
            }

        }

        $this->surveys = Survey::whereteam_id(Auth::user()->current_team_id)->get();
        $this->main_languages = json_decode($this->main_lang, true);
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();
        $this->messages = json_decode($this->messages_defult, true);

        $this->surveylanguages = $this->getLocalesOfSurvey($this->current_survey_id);
        if ($this->surveylanguages != null) {
            $this->local = $this->surveylanguages[0]['code'];
        }

        $this->current_message = SurveyTrnslations::wheresurvey_id($this->current_survey_id)->wheresurvey_local($this->local)->first();

        $this->current_questions = $this->getquestions($this->current_survey_id);

        //    $this->survey_logo="images/logo_1_transparent.png";
        //    $this->logo="images/logo_1_transparent.png";
        //    $this->modal=false;

        // $this->questionediting=new Questions();


    }
    public function updatedlogo()
    {
        $this->modal = true;
        $this->logosrc = $this->logo->temporaryUrl();
        $this->dispatchBrowserEvent('survey-image-updated', ['image' => $this->logo]);

    }
    // save image after crop it
    public function cropingimage()
    {
        $this->dispatchBrowserEvent('saving');

    }
    // to close the crop modal if user click close button or icon
    public function closemodal()
    {
        $this->survey_logo = "images/logo_1_transparent.png";
        $this->modal = false;
    }

    // t oclose crop modal if user click save
    public function closemodalwithsave()
    {

        $this->modal = false;
    }
    // save image after crop it
    public function SavImage($image)
    {
        $folderPath = public_path('storage/images/temp/');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $name = uniqid() . '.jpg';
        $file = $folderPath . $name;
        $this->modal = false;
        // dd($this->answers[$this->stepimage]['image']);
        if (str_contains($this->survey_logo, 'images/temp/') || str_contains($this->survey_logo, 'images/upload/')) {
            File::delete(public_path($this->survey_logo));}
        $this->survey_logo = "/storage/images/temp/" . $name;
        file_put_contents($file, $image_base64);

    }
    //    select survey
    public function selectsurvey($id)
    {
        $this->current_survey_id = $id;
        $this->current_questions = [];
        $this->current_survey = null;
        $this->surveylanguages = $this->getLocalesOfSurvey($this->current_survey_id);
        $this->local = $this->surveylanguages[0]['code'];
        $this->current_message = SurveyTrnslations::wheresurvey_id($this->current_survey_id)->wheresurvey_local($this->local)->first();
        $this->current_questions = $this->getquestions($this->current_survey_id);

        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')
            ->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {$this->current_survey_id = $this->current_survey->survey_id;
            $this->service = (bool) $this->current_survey->active;
            $this->terms = (bool) $this->current_survey->terms;
            $this->surveyexpiry = (bool) $this->current_survey->expiry;
            $this->surveyexpirydate = $this->current_survey->expiry_date;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
            $this->service = (bool) $this->current_survey->active;
            $this->terms = (bool) $this->current_survey->terms;
            $this->surveyexpiry = (bool) $this->current_survey->expiry;
            $this->surveyexpirydate = $this->current_survey->expiry_date;
        }
        // $this->current_survey=Survey::whereuser_id(Auth::user()->id)->whereid($this->current_survey_id)->first();
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();
        // dd($current_survey_kiosks);
        $this->dispatchBrowserEvent('contentChanged');
        // dd($this->current_survey);
    }


    //   delete survey confirmation
    public function deleteConfirmation($id)
    {
        $this->survey_delete_id = $id;
        $this->dispatchBrowserEvent('show-delete-confirmation');
        //    to re select the current survey
        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')
            ->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {
            $this->current_survey_id = $this->current_survey->survey_id;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
        }
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();
        $this->dispatchBrowserEvent('contentChanged');
    }
    //   delete question confirmation
    public function deletequestionConfirmation($id)
    {
        $this->question_delete_id = $id;
        $this->dispatchBrowserEvent('show-question-delete-confirmation');
        //    to re select the current survey
        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')
            ->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {
            $this->current_survey_id = $this->current_survey->survey_id;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
        }
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();
        $this->dispatchBrowserEvent('contentChanged');
    }
    // end of  delete question confirmation
    //   *****************
    //   delete language confirmation
    public function deletelanguageConfirmation($id)
    {
        $this->language_delete_id = $id;
        $this->dispatchBrowserEvent('show-language-delete-confirmation');
        //    to re select the current survey
        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')
            ->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {
            $this->current_survey_id = $this->current_survey->survey_id;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
        }
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();
        $this->dispatchBrowserEvent('contentChanged');
    }
    //  end of delete language confirmation
    // function to delete survey
    public function deletesurvey()
    {
        $survey = Survey::whereteam_id(Auth::user()->current_team_id)->whereid($this->survey_delete_id)->first();
        // if answer have image
        if ($survey->logo_id != null) {
            $imagepath = Logos::whereid($survey->logo_id)->first()->logo_url;
            if (str_contains($imagepath, 'images/temp/') || str_contains($imagepath, 'images/upload/')) {
                File::delete(public_path($imagepath));
            }
            Logos::whereid($survey->logo_id)->delete();
        }

        $survey->delete();
        SurveyTrnslations::wheresurvey_id($this->survey_delete_id)->delete();

        $this->mount();
        $this->dispatchBrowserEvent('contentChanged');

    }
    // function to delete question
    //         use App\Models\Questions;
    // use App\Models\QuestionTranslation;
    // use App\Models\Survey;
    // use App\Models\Answers;
    // use App\Models\Logos;
    // use App\Models\SurveyTrnslations;
    // use App\Models\AnswersTranslation;
    public function deletequestion()
    {
        $question = Questions::whereid($this->question_delete_id)->first();
        // if question is custom
        if (QuestionType::whereid($question->type_of_question_id)->first()->question_type == "custom_rating" || QuestionType::whereid($question->type_of_question_id)->first()->question_type == "custom_satisfaction") {$parent_question = CustomQuestion::wherequestion_id($question->id)->first();
            // get and save child questions
            $child_questions = Questions::join('custom_questions', 'custom_questions.question_id', '=', 'Questions.id')
                ->where('custom_questions.custom_question_id', '=', $parent_question->id)
                ->whereNotIn('custom_questions.question_id', [$parent_question->question_id])->get();
            // delete each child question
            foreach ($child_questions as $child) {
                // delete image
                $imagepath = Pictures::whereid($child->picture_id)->first()->pic_url;
                if (str_contains($imagepath, 'images/temp/') || str_contains($imagepath, 'images/upload/')) {File::delete(public_path($imagepath));}
                Pictures::whereid($child->picture_id)->delete();
                // delete question
                Questions::whereid($child->question_id)->delete();

            }
            // delete parent question
            Questions::whereid($question->id)->delete();

        }
        // if question is another type of custom
        else {
            // delete question
            //delete question translation
            //delete answers
            //delte answers translation
            $answers = Answers::wherequestion_id($this->question_delete_id)->get();
            foreach ($answers as $answer) {
                if ($answer->picture_id != null) {
                    $imagepath = Pictures::whereid($answer->picture_id)->first()->pic_url;
                    if (str_contains($imagepath, 'images/temp/') || str_contains($imagepath, 'images/upload/')) {File::delete(public_path($imagepath));}
                    Pictures::whereid($answer['picture_id'])->delete();
                }
                AnswersTranslation::whereanswer_id($answer->id)->delete();
                Answers::whereid($answer->id)->delete();

            }
            QuestionTranslation::wherequestion_id($this->question_delete_id)->delete();
            Questions::whereid($this->question_delete_id)->delete();
        }

        $this->current_questions = $this->getquestions($this->current_survey_id);
        // re order the questions
        foreach ($this->current_questions as $ques) {
            $q = Questions::whereid($ques['id'])->first();
            if ($q->question_order > $question->question_order) {
                $q->question_order -= 1;
            }

            $q->save();
        }
        $this->current_survey = Survey::join('logos', 'logos.id', '=', 'surveys.logo_id')
            ->where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->select('surveys.id as survey_id', 'surveys.*', 'logos.*')->get()->first();
        if ($this->current_survey != null) {
            $this->current_survey_id = $this->current_survey->survey_id;
        } else {
            $this->current_survey = Survey::where('surveys.team_id', Auth::user()->current_team_id)->where('surveys.id', $this->current_survey_id)->get()->first();
            $this->current_survey_id = $this->current_survey->id;
        }
        $this->current_survey_kiosks = Kiosk::wheresurvey_id($this->current_survey_id)->get();
        $this->dispatchBrowserEvent('contentChanged');

    }
    public function render()
    {

        return view('livewire.surveys');
    }

}
