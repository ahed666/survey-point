<div class="">
    {{-- Liecence --}}
     <div class="border-[1px] border-gray-300 rounded-2xl mb-10">
        {{-- pro liecence --}}
       @if($current_subscribe->type=="Pro")
       <div class="border-[1px] bg-[#FFCE44] flex justify-center rounded-2xl w-20 p-2 relative top-[-20px]">
        <span class="font-bold">{{ $current_subscribe->type  }}</span>
       </div>
       <div class="grid grid-cols-12 xs:block">
        {{-- lecinece info --}}
        <div class="p-2 col-span-5 xs:mb-2">
            <span>{{ __('You have ') }} <span class="text-[#FFCE44]  font-bold">{{$current_subscribe->type   }}</span> {{ __('Liecence') }} </span>
         <br><span>{{ __('Expiry Date: ') }}<span class="text-blue-300  font-bold">{{$current_subscribe->expired_at   }}</span></span>
        </div>
        {{-- buttons options --}}
        <div class="col-span-7 xs:mx-1 xs:flex xs:mt-2 xs:mb-2 xs:justify-between xs:items-center ">
            <button class="bg-yellow-200 rounded-xl p-2">
                {{ __('Renew') }}
            </button>

            <a class="text-red-400 rounded-xl p-2  hover:text-red-400 hover:cursor-pointer hover:font-bold hover:no-underline focus:no-underline no-underline">
                {{ __('Cancel') }}
            </a>
        </div>
        </div>
       {{-- premium liecence --}}
       @elseif ($current_subscribe->type=="Premium")
       <div class="border-[1px] bg-[#54C571] flex justify-center rounded-2xl w-20 p-2 relative top-[-20px]">
        <span class="font-bold">{{ $current_subscribe->type  }}</span>
       </div>
       <div class="grid grid-cols-12 xs:block">
        {{-- lecinece info --}}
        <div class="p-2 col-span-5 xs:mb-2">
            <span>{{ __('You have ') }} <span class="text-[#54C571]  font-bold">{{$current_subscribe->type   }}</span> {{ __('Liecence') }} </span>
         <br><span>{{ __('Expiry Date: ') }}<span class="text-blue-300  font-bold">{{$current_subscribe->expired_at   }}</span></span>
        </div>
        {{-- buttons options --}}
        <div class="col-span-7 xs:mx-1 xs:flex xs:mt-2 xs:mb-2 xs:justify-between xs:items-center ">
            <button class="bg-yellow-200 rounded-xl p-2">
                {{ __('Renew') }}
            </button>
            <a wire:click="upgrade_confirm()" class="text-green-400 rounded-xl  hover:text-green-400 hover:cursor-pointer hover:font-bold hover:no-underline focus:no-underline no-underline p-2">
                {{ __('Upgrade') }}
            </a>
            <a class="text-red-400 rounded-xl p-2  hover:text-red-400 hover:cursor-pointer hover:font-bold hover:no-underline focus:no-underline no-underline">
                {{ __('Cancel') }}
            </a>


        </div>
        </div>

       {{-- free liecence --}}
       @else
       <div class="border-[1px] bg-[#54C571] flex justify-center items-center rounded-2xl w-20 p-2 relative top-[-20px]">
        <span class="font-bold text-white">{{ $current_subscribe->type  }}</span>
       </div>
       <div class="grid grid-cols-12 xs:block">
        {{-- lecinece info --}}
        <div class="p-2 col-span-5 xs:mb-2">
            <span>{{ __('You have ') }} <span class="text-[#7D0552]  font-bold">{{$current_subscribe->type   }}</span> {{ __('Liecence') }} </span>
         <br><span>{{ __('Expiry Date: ') }}<span class="text-blue-300  font-bold">{{$current_subscribe->expired_at   }}</span></span>
        </div>
        {{-- buttons options --}}
        <div class="col-span-7 xs:flex xs:mx-1 xs:mt-2 xs:mb-2  xs:justify-between xs:items-center">

            <a wire:click="upgrade_confirm()" class="text-green-400 rounded-xl p-2 hover:text-green-400 hover:cursor-pointer hover:font-bold hover:no-underline focus:no-underline no-underline">
                {{ __('Upgrade') }}
            </a>

        </div>
        </div>
       @endif
     </div>
    {{-- plans --}}
    <div class="bg-blue-200 p-2 {{ $show?"block":"hidden" }}">
        <div class="flex justify-center items-center mb-10">

        <span class="font-bold text-md">{{ __('Subscriptions Plan') }}</span>
        </div>
        <div class="grid grid-cols-12 xs:block gap-2 ">

            @foreach ($types as $type )
            {{-- PRO --}}
            @if($type->subscription_type=="Pro")
            <div class="col-span-6 xs:mt-2 bg-[#fafafa] border-[1px] shadow-md rounded-2xl p-4  ">
                      {{-- type --}}
                    <div class="flex justify-center items-center">
                    <span class="text-black text-xl font-bold">{{ $type->subscription_type }}</span>
                    </div>
                    {{-- price --}}
                    <div class="text-center mt-2 items-center">
                       <span class="text-lg font-bold text-[#FFCE44]">{{ $type->price }}</span>
                       <br><span>{{ __('AED') }}</span>
                    </div>
                    {{-- features --}}
                    <ul class="">
                    @for($i = 0; $i < 4; $i++)
                        <li class="flex items-center ">
                        <svg class="mr-1 ml-1 h-5 w-5 text-[#FFCE44]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span >{{ __('feture') }}</span>
                        </li>
                    @endfor
                    </ul>
                    {{-- buy button --}}
                    <div class="flex justify-center items-center mt-4 ">
                        <button class="bg-blue-400 rounded-lg p-2 w-25">
                        {{ __('Buy') }}
                        </button>
                    </div>

            </div>
            {{-- Premium --}}
            @elseif($type->subscription_type=="Premium")
            <div class="{{$current_subscribe->type=="Premium"?"disabled opacity-50":""}} col-span-6 xs:mt-2 bg-[#fafafa] border-[1px] shadow-md rounded-2xl p-4  ">
                {{-- type --}}
                <div class="flex justify-center items-center ">
                <span class="text-black text-xl font-bold">{{ $type->subscription_type }}</span>
                </div>
                {{-- price --}}
                <div class="text-center items-center mt-2">
                    <span class="text-lg font-bold text-[#54C571]">{{ $type->price }}</span>
                    <br><span>{{ __('AED') }}</span>
                </div>
                {{-- features --}}
                 <ul class="">
                    @for($i = 0; $i < 4; $i++)
                    <li class="flex items-center ">
                    <svg class="mr-1 ml-1 h-5 w-5 text-[#54C571]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span >{{ __('feture') }}</span>
                    </li>
                    @endfor
                </ul>
                {{-- buy button --}}
                <div class="flex justify-center items-center mt-4">
                   <button class="{{$current_subscribe->type=="Premium"?"disabled opacity-50":""}} bg-blue-400 rounded-lg p-2 w-25">
                    {{ __('Buy') }}
                   </button>
                </div>
            </div>

            @endif

            @endforeach
        </div>
    </div>



</div>
