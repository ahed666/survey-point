<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SurveyTemplateQuestions extends Component
{
    public $lang;
    public function mount()
    {

    }
    public function render()
    {
        return view('livewire.survey-template-questions');
    }
}
