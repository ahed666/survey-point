<div>

    <form method="POST" action="{{ route('login') }}" class="mt-3">
        @csrf
        <div class="grid grid-cols-1 gap-1">
        <div class="grid grid-cols-4 gap-4 ">
             <div class="flex items-center" ><x-jet-label  class="lg:w-30 xl:w-30 "  for="email" value="{{ __('Email   ') }}" />
             </div>
             <div class="col-span-3"> <x-jet-input id="email" :maxlength="50" class="block mt-1 w-full  lg:w-70 xl:w-70" type="email" name="email"  required autofocus /></div>


        </div>

        <div class=" mt-4 grid grid-cols-4 gap-4">
            <div class="flex items-center">
            <x-jet-label class="lg:w-30 xl:w-30" for="password" value="{{ __('Password') }}" />
        </div>
        <div class="relative col-span-3" >
            <x-jet-input :maxlength="20" id="password" class="block mt-1 w-full lg:w-70 xl:w-70" type="{{ $show ? 'text' : 'password' }}" name="password" required autocomplete="current-password" wire:model="password" />
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">

                <svg class="h-6 w-8 text-gray-700 " fill="none" wire:click="showpassword()"
                    xmlns="http://www.w3.org/2000/svg"
                    viewbox="0 0 576 576">
                    <path fill="currentColor"
                    d="{{ $show ? 'M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z' : 'M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z' }} ">
                    </path>
                </svg>



              </div>
        </div>
        </div>
        </div>
        <div class="block mt-4 ">
            <label style="left:106px;" for="remember_me" class="block relative  items-center">
                <x-jet-checkbox id="remember_me" name="remember" />
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

       <div class="container py-4 px-4 mx-0 min-w-full flex flex-col items-center">
            <button id="login" type="submit "  class=" disabled:opacity-50 text-center lg:w-2/5 md:w-full items-center px-4 py-2 bg-btn border border-transparent
                 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none
               focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ">
                {{ __('login') }}
            </button>
        </div>
        {{-- <div  class="flex mt-4">


            <button class="block text-center w-full  items-center px-4 py-2 bg-gray-800 border border-transparent
             rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none
            focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ">
                {{ __('Log in') }}
            </button>
        </div> --}}
        <div  class="flex relative justify-between w-70 mt-4">
            <div>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            </div>
            <div>

                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                        {{ __('create account') }}
                    </a>

            </div>


        </div>

    </form>
</div>
