<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddSurvey;
use Illuminate\Support\Facades\Route;
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
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\SurveyTemplate;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::post('/upload',function(){})->name('crop');
// Route::get('/dashboard', function () {


//     return view('dashboard');

// })->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/statistics', function () {


//     return view('statistics');

// })->middleware(['auth', 'verified'])->name('statistics');
// Route::get('/surveys', function () {

//     return view('surveys' );

// })->middleware(['auth', 'verified'])->name('surveys');
//   // when registerition done
//   Route::get('/registerdone/{user}', function ($user) {
//     $user=User::whereid($user)->first();
//      if($user->email_verified_at==null){
//         Auth::login($user);

//     return view('auth.registerdone',compact('user'));
//      }
//      else{
//         return redirect()->route('login');
//      }

// })->name('responseregister');
// Route::get('/login/{user}', function ($user) {
//     $user=User::whereid($user)->first();
//     // Auth::logout($user);
//      return redirect()->route('login');
// })->name('loginfromregister');
// Route::post('/add-survey',[AddSurvey::class, 'store'])->name('add-survey');
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

    // to test the url generate
Route::get('/devices/{device_name}/{device_id}',function($device_name,$device_id)
{
    $id=Kiosk::wheredevice_code_id($device_id)->first()->id;
    return view('survey-template');
}
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::post('/upload',function(){})->name('crop');
    // dashboard route
    Route::get('/statistics', function () {


        return view('statistics');

    })->name('statistics');

    // Route::get('/devices/{device_name}/{device_code}',SurveyTemplate::class);
    // kiosks route
    Route::get('/kiosks', function () {


        return view('kiosks');

    })->name('kiosks');
    // survey route
    Route::get('/surveys', function () {

        return view('surveys' );

    })->name('surveys');
    // billing route
    Route::get('/billings', function () {

        return view('teams.billings' );

    })->name('billings');
    // subscriptions route
    Route::get('/subscriptions', function () {

        return view('teams.subscriptions' );

    })->name('subscriptions');
});
  Route::get('/registerdone/{user}', function ($user) {
    $user=User::whereid($user)->first();
     if($user->email_verified_at==null){
        Auth::login($user);

    return view('auth.registerdone',compact('user'));
     }
     else{
        return redirect()->route('login');
     }

})->name('responseregister');
Route::get('/login/{user}', function ($user) {
    $user=User::whereid($user)->first();
    // Auth::logout($user);
     return redirect()->route('login');
})->name('loginfromregister');
// require_once __DIR__ .'/jetstream.php';
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require_once __DIR__.'/auth.php';
require_once __DIR__ .'/jetstream.php';
