@props(['team', 'component' => 'jet-dropdown-link'])

<form method="POST" action="{{ route('current-team.update') }}" x-data>
    @method('PUT')
    @csrf

    <!-- Hidden Team ID -->
    <input type="hidden"  name="team_id" value="{{ $team->id }}">

    <x-dynamic-component :component="$component" @class(['no-underline hover:no-underline focus:no-underline'])  href="#" x-on:click.prevent="$root.submit();">
        <div class="flex items-center grid grid-cols-12">
            <div class="col-span-2">
            @if (Auth::user()->isCurrentTeam($team))
                <svg class="mr-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @endif
            </div>
            <div class="truncate col-span-5">{{ $team->name }}</div>
            {{-- get user personal account  --}}
            @php
                $profile_id=DB::table('users')->join('teams','users.id','=','teams.user_id')->where('users.id','=',Auth::user()->id)->where('teams.personal_team','=','1')->select('teams.id')->first()->id;

            @endphp
            <div class="col-span-5">
                @if($team->id==$profile_id)
                    <span class="bg-blue-200 ml-2 mr-2 text-blue-400 p-1">{{ __('Owner') }}</span>
                    @else
                    <span class="bg-yellow-200 ml-2 mr-2 text-yellow-400 p-1">{{ __('Shared') }}</span>
                @endif
            </div>

        </div>
    </x-dynamic-component>
</form>
