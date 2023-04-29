

        <x-jet-form-section submit="updateTeamName">
            <x-slot name="title">
                {{ __('Account Name') }}
            </x-slot>

            <x-slot name="description">
                {{ __('The account\'s name and owner information.') }}
            </x-slot>

            <x-slot name="form">
                <!-- Team Owner Information -->
                <div class="col-span-6">
                    <x-jet-label value="{{ __('Profile Owner') }}" />

                    <div class="flex items-center mt-2">
                        <img class="w-12 h-12 rounded-full object-cover" src="{{ $team->owner->profile_photo_url }}" alt="{{ $team->owner->name }}">

                        <div class="ml-4 leading-tight">
                            <div>{{ $team->owner->name }}</div>
                            <div class="text-gray-700 text-sm">{{ $team->owner->email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Team Name -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Profile Name') }}" />

                    <x-jet-input id="name"
                                type="text"
                                class="mt-1 block w-full"
                                wire:model.defer="state.name"
                                :disabled="! Gate::check('update', $team)" />

                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                {{-- company name --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="company_name" value="{{ __('Company Name') }}" />

                    <x-jet-input id="company_name"
                                type="text"
                                class="mt-1 block w-full"
                                wire:model.defer="state.company_name"
                                :disabled="! Gate::check('update', $team)" />

                    <x-jet-input-error for="company_name" class="mt-2" />
                </div>
                {{-- company Address --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="company_address" value="{{ __('Company Address') }}" />

                    <x-jet-input id="company_address"
                                type="text"
                                class="mt-1 block w-full"
                                wire:model.defer="state.company_address"
                                :disabled="! Gate::check('update', $team)" />

                    <x-jet-input-error for="company_address" class="mt-2" />
                </div>
                {{-- billing address --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="billing_address" value="{{ __('Billing_Address') }}" />

                    <x-jet-input id="billing_address"
                                type="text"
                                class="mt-1 block w-full"
                                wire:model.defer="state.billing_address"
                                :disabled="! Gate::check('update', $team)" />

                    <x-jet-input-error for="billing_address" class="mt-2" />
                </div>

                {{-- tax Number --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="tax_number" value="{{ __('Tax Number') }}" />

                    <x-jet-input id="tax_number"
                                type="text"
                                class="mt-1 block w-full"
                                wire:model.defer="state.tax_number"
                                :disabled="! Gate::check('update', $team)" />

                    <x-jet-input-error for="tax_number" class="mt-2" />
                </div>
            </x-slot>

            @if (Gate::check('update', $team))
                <x-slot name="actions">
                    <x-jet-action-message class="mr-3" on="saved">
                        {{ __('Saved.') }}
                    </x-jet-action-message>

                    <x-jet-button>
                        {{ __('Save') }}
                    </x-jet-button>
                </x-slot>
            @endif
        </x-jet-form-section>
