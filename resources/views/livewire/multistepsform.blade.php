<div>
{{-- wire:submit.prevent="register" --}}
        <form method="POST" action="{{ route('register') }}" >
            @csrf

            <div class="grid gap-4 mb-6 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2">
                <div class="" >
                    <x-jet-label style="margin:10px;" class="lg:w-30 xl:w-30" for="country" value="{{ __('Country') }}"  />
                    <select autofocus name="country" id="country" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" wire:change="onchangestepone()" wire:model="country" required>

                    @foreach ($countries as $Country )
                    @if($Country->country=="United Arab Emaraties")
                    <option value="{{$Country->country}}" selected >{{$Country->country}}</option>
                    @else
                    <option value="{{$Country->country}}" >{{$Country->country}}</option>
                    @endif
                    @endforeach

                    </select>

                    @error('country') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300">{{ $message }}</span> @enderror

                </div>
                <div class="" >
                    <x-jet-label style="white-space:nowrap;margin:10px;" class=" lg:w-30 xl:w-30" for="city" value="{{ __('City') }}" />
                    <select {{ $isDisabled ? 'disabled' : '' }}  name="city" id="city" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" required  wire:model="city">
                    <option value="">select city</option>
                    @foreach ($cities as $city )
                    <option value="{{$city->city_name}}" >{{$city->city_name}}</option>
                    @endforeach

                    </select>
                    @error('city') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300">{{ $message }}</span> @enderror
                </div>
            </div>



             <div class="text-2xl card-header bg-secondary text-black">{{ __('Personal Information') }} </div>
            <div class="grid gap-4 mb-6 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3">
                <div class=" ">
                    <x-jet-label style="white-space:nowrap;margin:10px;" class=" lg:w-30 xl:w-30" for="name" value="{{ __('Full Name') }}" />

                    <input {{ $isDisabled ? 'disabled' : '' }} maxlength="20" placeholder="Joe Bloggs" id="name" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full placeholder-gray-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" wire:model="name" />
                    @error('name') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300" style="">{{ $message }}</span> @enderror
                </div>

                <div class="">
                    <x-jet-label style="white-space:nowrap;margin:10px;" class="lg:w-30 xl:w-30" for="email" value="{{ __('Email') }}" />
                    <input {{ $isDisabled ? 'disabled' : '' }} maxlength="50" placeholder="example@domain.com" id="email" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full placeholder-gray-300" type="email" name="email"  required  wire:model="email" />
                    @error('email') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300" style="">{{ $message }}</span> @enderror

                </div>

                <div class="">

                    <x-jet-label style="white-space:nowrap;margin:10px;" class="block font-medium text-sm text-gray-700 lg:w-30 xl:w-30" for="" value="{{ __(' Mobile Number') }}" />
                    <div class="mt-1 row flex ">
                        <input type="text" id="CountryMobileCode" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                        focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-20 mr-2 ml-2" value={{$CountryMobileCode}} type="text" name="CountryMobileCode"  wire:model="CountryMobileCode" disabled>
                    <input  {{ $isDisabled ? 'disabled' : '' }} placeholder="5xxxxxxxx" maxlength="10"  id="mobile_number" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full placeholder-gray-300" type="text" required  name="mobile_number"  wire:model="mobile_number"  />
                    </div>


                    @error('mobile_number') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300" style="">{{$message}}</span> @enderror

                </div>
            </div>
            <div class="text-2xl card-header bg-secondary text-black">{{ __('Business Information') }} </div>
            <div class="grid gap-4 mb-6 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4">
                <div class="">
                    <x-jet-label style="white-space:nowrap;margin:10px;" class=" lg:w-30 xl:w-30" for="company_name" value="{{ __('Company Name  (Optional)') }}" />
                    <input maxlength="40" {{ $isDisabled ? 'disabled' : '' }} placeholder="Advent corporation"  id="company_name" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full placeholder-gray-300" type="text" name="company_name" wire:model="company_name"  />
                    @error('company_name') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300">{{ $message }}</span> @enderror
                </div>

                <div class="">
                    <x-jet-label style="white-space:nowrap;margin:10px;" class=" lg:w-30 xl:w-30" for="phone_number" value="{{ __(' Phone Number  (Optional)') }}" />
                    <input maxlength="12" {{ $isDisabled ? 'disabled' : '' }} id="phone_number" placeholder="123456789" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full placeholder-gray-300" type="text" name="phone_number"   wire:model="phone_number"  />
                    @error('phone_number') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300">{{ $message }}</span> @enderror
                </div>
                <div class="">
                    <x-jet-label style="white-space:nowrap;margin:10px;" class=" lg:w-30 xl:w-30" for="tax_number" value="{{ __('Tax Number  (Optional)') }}" />
                    <input maxlength="20" {{ $isDisabled ? 'disabled' : '' }} placeholder="1234567899876543212" id="tax_number" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full placeholder-gray-300" type="text" name="tax_number"  wire:model="tax_number" />
                    @error('tax_number') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300 ">{{ $message }}</span> @enderror
                </div>

                <div class=" ">
                    <x-jet-label style="white-space:nowrap;margin:10px;" class=" lg:w-30 xl:w-30" for="billing_address" value="{{ __('Billing Address  (Optional)') }}" />
                    <input maxlength="100" {{ $isDisabled ? 'disabled' : '' }} id="billing_address" placeholder="1677 Hillcrest Lane, El Toro, California, 92630" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full placeholder-gray-300" type="text" name="billing_address" wire:model="billing_address"  />
                    @error('billing_address') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="text-2xl card-header bg-secondary text-black">{{ __('Account Security') }} </div>
                <div class="grid gap-4 mb-6 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2">
                                    <div class="">

                                    <div class="flex relative justify-between w-70  " >
                                        <x-jet-label style="white-space:nowrap;margin:8px;" class=" lg:w-30 xl:w-30" for="password" value="{{ __('Password') }}" />
                                        <div class="justify-end" >
                                            @if($passwordempty==1)
                                            @if($passwordStrength>=1)
                                            <span class="flex font-medium text-sm text-gray-700  lg:w-30 xl:w-30 text-{{ $passwordLevelsColors[$passwordStrength] }}-600 " style="white-space:nowrap;margin:6px;">
                                    <svg class="flex w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                                    </svg>
                                    {{ $passwordLevels[$passwordStrength] }}
                                    @elseif($passwordStrength==0)
                                    <span class="flex font-medium text-sm text-gray-700  lg:w-30 xl:w-30 text-{{ $passwordLevelsColors[$passwordStrength] }}-600 " style="white-space:nowrap;margin:6px;">
                                    <svg class="flex w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    {{ $passwordLevels[$passwordStrength] }}
                                    @endif
                                    @elseif($passwordempty==0)
                                    <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300" style="white-space:nowrap;margin:6px;">
                                        {{ __('*required') }}
                                    @endif

                                    <!-- Component Start -->
                                    <div class="flex group" >
                                        <svg class="inline-block w-4 text-gray-700 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                        <div style="right:-241px"  class=" inline-flex absolute bottom-0 whitespace-normal w-96  sm:right-1 items-center hidden mb-6 group-hover:flex">
                                            <span class=" relative text-ellipsis square z-10 p-2 text-xs leading-none text-gray-400  bg-white shadow-lg">
                                                {!! $password_policy !!}

                                            </span>

                                        </div>
                                        </div>
                        <!-- Component End  -->
                                    </span>
                                    </div>
                                </div>
                                {{-- border-{{ $passwordLevelsColors[$passwordStrength] }}-400   focus:border-{{ $passwordLevelsColors[$passwordStrength] }}-400 focus:ring focus:ring-{{ $passwordLevelsColors[$passwordStrength] }}-400 --}}
                                {{-- <div id="tooltip-error" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Tooltip content
                                    <div class="tooltip-arrow" data-popper-arrow></div> --}}
                                    <div class="relative" >
                                    <input wire:change="onchangepassword()" wire:model="password" maxlength="20" id="password" {{ $isDisabled ? 'disabled' : '' }} class="border-gray-300  focus:border-{{ $passwordLevelsColors[$passwordStrength] }}-300 focus:ring focus:ring-indigo-200
                                    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" type="{{ $show ? 'text' : 'password' }}" name="password"  required autocomplete="new-password"    />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">

                                        <svg class="h-6 text-gray-700" fill="none" wire:click="showpassword()"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewbox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="{{ $show ? 'M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z' : 'M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z' }} ">
                                        </path>
                                        </svg>



                                    </div>
                                    </div>

                                </div>
                                <div class="">
                                    <x-jet-label style="white-space:nowrap;margin:10px;" class=" lg:w-30 xl:w-30" for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                    <input maxlength="20" {{ $isDisabled ? 'disabled' : '' }} id="password_confirmation"   class="border-gray-300  focus:border-{{ $passwordLevelsColors[$isconfirm] }}-300 focus:ring focus:ring-indigo-200
                                    focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"    type="password" name="password_confirmation" wire:change="onchangeconfirmpassword()" required autocomplete="new-password"  wire:model="password_confirmation" />
                                    @error('password_confirmation') <span class="flex font-medium text-sm   lg:w-30 xl:w-30 text-red-600 text-danger  error placeholder-gray-300" required style="">{{ $message }}</span> @enderror

                                </div>
                </div>
        <div class="grid gap-4 mb-6 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3 ">
            <div class="">
                <input id="terms"  name="terms" wire:model="terms"  aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                <label for="terms" class="font-light text-gray-500 dark:text-gray-300">I accept the <a class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="#"> <a href="" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"> Terms and Conditions</a></label>

            </div>
        </div>
        <div class="grid gap-4 mb-6 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3 ">
            <div class="col-span-2">
                <input id="receive_emails"  name="receive_emails" wire:model="receive_emails"  aria-describedby="receive_emails" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" >
                <label for="receive_emails" class="font-light text-gray-500 dark:text-gray-300">
                    {{ __('I would like to receive emails from survey point about our new offers and events ...etc.') }}</label>

            </div>
        </div>
        <div class="container py-10 px-10 mx-0 min-w-full flex flex-col items-center">
            <button type="submit "  class=" text-center 2xl:w-full xl:w-full lg:w-full md:w-full items-center px-4 py-2 bg-btn border border-transparent
                 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none
              focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ">
                    {{ __('Register') }}
            </button>
            <div class="mt-5 pt-2 w-full flex justify-center border-t border-gray-400">
                <span class="" >Already registered us ? <a class="text-link" href="{{ route('login') }}">sign in</a></span>
            </div>
        </div>

        </div>
        </form>
</div>
