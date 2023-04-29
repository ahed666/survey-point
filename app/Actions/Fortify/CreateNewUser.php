<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use App\Models\Subscribe;
use App\Models\TypeSubscribe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Carbon\Carbon;

class CreateNewUser implements CreatesNewUsers
{    public $input;
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $this->input=$input;

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) {
                $this->createTeam($user);

            });
        });

    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        if($this->input['company_name']!=null)
            $name =$this->input['company_name']."(".explode(' ', $user->name, 2)[0].")";
        else
            $name =explode(' ', $user->name, 2)[0];

        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,

            'name' => $name,
            'personal_team' => true,
            'company_name'=>$this->input['company_name'],
            'billing_address'=>$this->input['billing_address'],
            'tax_number'=>$this->input['tax_number'],
            'city'=>$this->input['city'],
            'country'=>$this->input['country'],
        ]));

        $team_id=Team::whereuser_id($user->id)->first()->id;
        $dt = Carbon::today();
        $dt=$dt->addMonth();

        $subscribe=new Subscribe();
        $subscribe->expired_at=$dt;
        $subscribe->account_id=$team_id;
        $subscribe->type_of_subscription_id=TypeSubscribe::wheresubscription_type('Free')->first()->id;
        $subscribe->save();



    }
}
