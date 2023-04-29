
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>

    <div>
        <ul
            class="max-w-7xl mx-auto  sm:px-6 lg:px-8  mb-5 flex list-none  flex-wrap border-b-[2px] border-gray-300 pl-0 md:flex-row"
            role="tablist"
            data-te-nav-ref>
            <li role="presentation">
                <a
                href="#tabs-settings"
                class="my-2 block border-x-0  border-t-0 border-transparent px-7 pb-3.5 pt-4 text-sm font-medium uppercase leading-tight
                 text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent
                 data-[te-nav-active]:bg-blue-400 data-[te-nav-active]:text-white no-underline hover:no-underline focus:no-underline dark:text-neutral-400 dark:hover:bg-transparent
                  dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                data-te-toggle="pill"
                data-te-target="#tabs-settings"
                data-te-nav-active
                role="tab"
                aria-controls="tabs-settings"
                aria-selected="true"
                >{{ __('Account Settings') }}</a
                >
            </li>
            <li role="presentation">
                <a
                href="#tabs-billings"
                class="focus:border-transparen my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-sm font-medium
                 uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate
                 data-[te-nav-active]:bg-blue-400 data-[te-nav-active]:text-white no-underline hover:no-underline focus:no-underline dark:text-neutral-400 dark:hover:bg-transparent
                 dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                data-te-toggle="pill"
                data-te-target="#tabs-billings"
                role="tab"
                aria-controls="tabs-billings"
                aria-selected="false"
                >{{ __('Billings') }}</a
                >
            </li>
            <li role="presentation">
                <a
                href="#tabs-subscriptions"
                class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-sm font-medium uppercase leading-tight
                 text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent
                 data-[te-nav-active]:bg-blue-400 data-[te-nav-active]:text-white no-underline hover:no-underline focus:no-underline dark:text-neutral-400 dark:hover:bg-transparent
                 dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                data-te-toggle="pill"
                data-te-target="#tabs-subscriptions"
                role="tab"
                aria-controls="tabs-subscriptions"
                aria-selected="false"
                >{{ __('Subscriptions') }}</a
                >
            </li>

        </ul>
        {{-- settings --}}
        <div class=" max-w-7xl mx-auto py-2 sm:px-6 lg:px-8 hidden opacity-0 opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
             id="tabs-settings"
             role="tabpanel"
             aria-labelledby="tabs-settings-tab"
             data-te-tab-active
                >
            @livewire('teams.update-team-name-form', ['team' => $team])

            @livewire('teams.team-member-manager', ['team' => $team])

            @if (Gate::check('delete', $team) && ! $team->personal_team)
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('teams.delete-team-form', ['team' => $team])
                </div>
            @endif
        </div>
        {{-- billings --}}
        <div class=" max-w-7xl mx-auto py-2 sm:px-6 lg:px-8 hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
             id="tabs-billings"
             role="tabpanel"
             aria-labelledby="tabs-billings-tab"

                >
            @livewire('billings')
        </div>
        {{-- subscriptions --}}
        <div class=" max-w-7xl mx-auto py-2 sm:px-6 lg:px-8 hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
             id="tabs-subscriptions"
             role="tabpanel"
             aria-labelledby="tabs-subscriptions-tab"

                >
            @livewire('subscriptions')
        </div>

    </div>
</x-app-layout>
