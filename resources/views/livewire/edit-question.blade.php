<div >

    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            {{ __(' Editing Question ') }}
        </h3>
        <button wire:click="resetvalue()" type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
            items-center dark:hover:bg-gray-600 dark:hover:text-white close" data-dismiss="modal" aria-label="Close">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
            011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </div>
    <!-- Modal body -->

    <form  wire:submit.prevent="save" >
        @csrf
            {{-- yes or no || like or dislike || accept or not accept --}}
            @if($type=="yes_no"||$type=="like_dislike"||$type=="Agree_Disagree"||$type=="satisfaction"||$type=="rating"||$type=="rating"||$type=="email"||$type=="number"||$type=="date_question"||$type=="long_text_question")
                <div class="mt-2 flex justify-center" >
                    <span>{{ $type }}</span>
                </div>
                <div class="p-4 w-full h-1/2 flex justify-center " >
                    <div class="border-[1px] w-3/4 h-full  overflow-y-auto  p-2 rounded-lg border-gray-200" >
                        {{-- {!! nl2br($question) !!} --}}
                        <textarea maxlength="255"  rows="3" cols="85" class="border-none outline-none  w-full focus:outline-none focus:border-none
                        " required autofocus min="10" minlength="10" wire:model="question_text" name="" id="" ></textarea>

                    </div>
                </div>
                <div class="flex  justify-center mb-8">
                    {{-- yes or no --}}
                    @if($type=="yes_no")
                    @for($i = 0; $i < 2; $i++)
                    <div>
                        <div class="flex justify-center items-center ml-4 mr-4 w-20 h-10 border-[1px] border-gray-200 p-1 text-center">
                            <span class="text-{{ $i==0?"red":"green" }}-400 font-bold">
                                {{ $i==0?"No":"Yes" }}
                            </span>
                        </div>

                        <div class="flex justify-center">
                            <x-jet-dropdown align="false"  width="40">
                                <x-slot name="trigger">
                                    <span class="inline-flex  rounded-md">

                                        <button type="button" class="no-underline hover:no-underline focus:no-underline
                                        focus:outline-none inline-flex items-center
                                        text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50
                                        hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50
                                        transition">
                                            <span class="pl-[2px] text-xs">
                                                @if($answers[$i]['skip']==true)
                                                {{ __('Skip') }}
                                                @elseif($answers[$i]['terminate']==true)
                                                {{ __('Terminate') }}
                                                @else
                                                {{ __('None') }}
                                                @endif
                                            </span>
                                            <svg fill="none" class="w-4 h-4" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"></path>
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-60">


                                        <div class="border-t border-gray-100"></div>

                                        <!-- Team Switcher -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('if this answer choosen') }}
                                        </div>
                                        <div class="flex ml-2 my-1 mr-2">
                                        <span class="text-xs mr-1 ml-1">{{ __('Skip Next Question') }}</span>
                                        <input wire:model="setskip.{{ $i }}" wire:change="changesetskip({{ $i }})"  data-bs-toggle="tooltip"
                                        data-bs-html="true" title="Skip Next Question if the answer choosen"
                                        class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"
                                        />
                                        </div>
                                        <div class="flex ml-2 my-1 mr-2">
                                            <span class="text-xs mr-1 ml-1">{{ __('End Survey') }}</span>
                                        <input wire:model="setterminate.{{ $i }}" wire:change="changesetterminate({{ $i }})"  data-bs-toggle="tooltip"
                                        data-bs-html="true" title="Skip Next Question if the answer choosen"
                                        class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"
                                            />
                                        </div>


                                    </div>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    </div>
                    @endfor
                    {{-- satisfaction --}}
                    @elseif($type=="satisfaction"||$type=="rating")
                    @for($i = 0; $i < 5; $i++)
                        <div>
                            @php
                                $idx=$i+1;
                                $path="images/emoji/$idx.png"
                            @endphp
                        <div class="flex justify-center items-center ml-4 mr-4 w-20 h-20 border-[1px] border-gray-200 p-1 text-center">
                            @if($type=="rating")
                            <span class="text-sm">{{ $i+1 }}</span>
                            @else
                            <img class="object-contain" src="{{ asset($path) }}" alt="">
                            @endif
                        </div>
                        <div class="flex justify-center">
                            <x-jet-dropdown align="false"  width="40">
                                <x-slot name="trigger">
                                    <span class="inline-flex  rounded-md">

                                        <button type="button" class="no-underline hover:no-underline focus:no-underline
                                        focus:outline-none inline-flex items-center
                                        text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50
                                        hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50
                                        transition">
                                            <span class="pl-[2px] text-xs">
                                                @if($answers[$i]['skip']==true)
                                                {{ __('Skip') }}
                                                @elseif($answers[$i]['terminate']==true)
                                                {{ __('Terminate') }}
                                                @else
                                                {{ __('None') }}
                                                @endif
                                            </span>
                                            <svg fill="none" class="w-4 h-4" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"></path>
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-60">


                                        <div class="border-t border-gray-100"></div>

                                        <!-- Team Switcher -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('if this answer choosen') }}
                                        </div>
                                        <div class="flex ml-2 my-1 mr-2">
                                        <span class="text-xs mr-1 ml-1">{{ __('Skip Next Question') }}</span>
                                        <input wire:model="setskip.{{ $i }}" wire:change="changesetskip({{ $i }})"  data-bs-toggle="tooltip"
                                        data-bs-html="true" title="Skip Next Question if the answer choosen"
                                        class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"
                                        />
                                        </div>
                                        <div class="flex ml-2 my-1 mr-2">
                                            <span class="text-xs mr-1 ml-1">{{ __('End Survey') }}</span>
                                            <input wire:model="setterminate.{{ $i }}" wire:change="changesetterminate({{ $i }})"  data-bs-toggle="tooltip"
                                            data-bs-html="true" title="Skip Next Question if the answer choosen"
                                            class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"
                                            />
                                            </div>


                                    </div>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                        </div>
                    @endfor
                    @elseif($type=="Agree_Disagree")
                    @for($i = 0; $i < 2; $i++)
                    <div>
                        <div class="flex justify-center items-center ml-4 mr-4 w-28 h-10 border-[1px] border-gray-200 p-1 text-center">
                            <span class="text-{{ $i==0?"red":"green" }}-400 font-bold">
                                {{ $i==0?"Disagree":"Agree" }}
                            </span>
                        </div>
                        <div class="flex justify-center">
                            <x-jet-dropdown align="false"  width="40">
                                <x-slot name="trigger">
                                    <span class="inline-flex  rounded-md">

                                        <button type="button" class="no-underline hover:no-underline focus:no-underline
                                        focus:outline-none inline-flex items-center
                                        text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50
                                        hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50
                                        transition">
                                            <span class="pl-[2px] text-xs">
                                                @if($answers[$i]['skip']==true)
                                                {{ __('Skip') }}
                                                @elseif($answers[$i]['terminate']==true)
                                                {{ __('Terminate') }}
                                                @else
                                                {{ __('None') }}
                                                @endif
                                            </span>
                                            <svg fill="none" class="w-4 h-4" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"></path>
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-60">


                                        <div class="border-t border-gray-100"></div>

                                        <!-- Team Switcher -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('if this answer choosen') }}
                                        </div>
                                        <div class="flex ml-2 my-1 mr-2">
                                        <span class="text-xs mr-1 ml-1">{{ __('Skip Next Question') }}</span>
                                        <input wire:model="setskip.{{ $i }}" wire:change="changesetskip({{ $i }})"  data-bs-toggle="tooltip"
                                        data-bs-html="true" title="Skip Next Question if the answer choosen"
                                        class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"
                                        />
                                        </div>
                                        <div class="flex ml-2 my-1 mr-2">
                                            <span class="text-xs mr-1 ml-1">{{ __('End Survey') }}</span>
                                        <input wire:model="setterminate.{{ $i }}" wire:change="changesetterminate({{ $i }})"  data-bs-toggle="tooltip"
                                        data-bs-html="true" title="Skip Next Question if the answer choosen"
                                        class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"
                                            />
                                        </div>


                                    </div>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    </div>
                    @endfor

                    @elseif ($type=="like_dislike")
                    @for($i = 0; $i < 2; $i++)
                    <div>
                        <div class="flex justify-center items-center ml-4 mr-4 w-16 h-16  p-1 text-center">

                            <img src="{{$i==0?asset('images/icons/dislike.png'):asset('images/icons/like.png') }}" alt="">
                        </div>
                        <div class="flex justify-center">
                            <x-jet-dropdown align="false"  width="40">
                                <x-slot name="trigger">
                                    <span class="inline-flex  rounded-md">

                                        <button type="button" class="no-underline hover:no-underline focus:no-underline
                                        focus:outline-none inline-flex items-center
                                        text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50
                                        hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50
                                        transition">
                                            <span class="pl-[2px] text-xs">
                                                @if($answers[$i]['skip']==true)
                                                {{ __('Skip') }}
                                                @elseif($answers[$i]['terminate']==true)
                                                {{ __('Terminate') }}
                                                @else
                                                {{ __('None') }}
                                                @endif
                                            </span>
                                            <svg fill="none" class="w-4 h-4" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"></path>
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-60">


                                        <div class="border-t border-gray-100"></div>

                                        <!-- Team Switcher -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('if this answer choosen') }}
                                        </div>
                                        <div class="flex ml-2 my-1 mr-2">
                                        <span class="text-xs mr-1 ml-1">{{ __('Skip Next Question') }}</span>
                                        <input wire:model="setskip.{{ $i }}" wire:change="changesetskip({{ $i }})"  data-bs-toggle="tooltip"
                                        data-bs-html="true" title="Skip Next Question if the answer choosen"
                                        class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"
                                        />
                                        </div>
                                        <div class="flex ml-2 my-1 mr-2">
                                            <span class="text-xs mr-1 ml-1">{{ __('End Survey') }}</span>
                                        <input wire:model="setterminate.{{ $i }}" wire:change="changesetterminate({{ $i }})"  data-bs-toggle="tooltip"
                                        data-bs-html="true" title="Skip Next Question if the answer choosen"
                                        class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"
                                            />
                                        </div>


                                    </div>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    </div>
                    @endfor

                    @endif

                </div>


            {{-- end yes or no ||...... --}}
           {{-- custom satisfaction and custom rating --}}
           @elseif($type=='custom_rating'||$type=='custom_satisfaction')
             <div class="mt-2 flex justify-center" >
                 <span>{{ $type_details}}</span>
             </div>

             <div class="p-4 w-full h-1/2 flex justify-center " >

                 <div class="border-[1px] w-3/4 h-20 overflow-y-auto  p-2 rounded-lg border-gray-200" >

                 <input class="border-b-2 outline-none  w-full focus:border-indigo-300
                 " required autofocus min="10" minlength="10" wire:model="question_text" name="" id="" >

                 </div>


             </div>
              {{-- add answer button --}}
              <div class="flex justify-center" >
                <a   wire:click="addanswer()" class="bg-blue-400 hover:bg-blue-200 p-2 text-white  text-center items-center rounded-full flex justify-center w-10 h-10 {{ $stepanswer<=$numofanswers?"":"hidden" }} cursor-pointer text-white bg-blue-500  hover:bg-blue-400 font-medium rounded-lg
                text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 no-underline hover:no-underline focus:no-underline "><span class="text-lg">+</span></a>

              </div>
                {{-- single answer --}}
                @if(count($answers)<=1)
                    <div class="mt-2 ml-1 mr-1 flex justify-center max-h-[500px] ">
                        @foreach ($answers as $i =>  $answer )
                            @if( $stepanswer>=$i)

                                <div id="list{{ $i }}" class="   p-2  w-[400px] border-[0.5px] border-gray-200 rounded-lg" >
                                    {{-- header of answer  --}}
                                    <div class="flex justify-between" >
                                        <div><span class="text-sm text-blue-400" >{{ $answer['code'] }}</span></div>

                                        <div>
                                            <a onclick="confirm('Are you sure to delete the answer ?') || event.stopImmediatePropagation()" class="text-red-400 inline-block text-lg p-1 w-6  bg-red-200 hover:bg-red-400 hover:text-red-600 text-center rounded-2xl"
                                                wire:click="deleteanswer({{ $i }})" >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    {{-- add image section --}}
                                    <div class="{{  $answer['hide']==true?"opacity-25":"" }} mt-2 flex justify-center  " >
                                    <div class="border-[1px] border-gray-300 p-[2px] rounded-lg w-[200px] h-[200px] ">




                                        <img wire:model="{{ asset($answer['image'])}}" class="w-full h-full object-contain block ml-auto mr-auto"
                                            src="{{ asset($answer['image'])}}" alt="">

                                            <label class="items-center w-4 relative  flex bottom-[10px] right-[8px]  bg-green-300 border-[1px] rounded-2xl" for="image">
                                                <svg wire:click="updatecurrentimageindex({{ $i }})" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                                                </svg>
                                            <input   wire:model="image" class="image opacity-0 absolute -z-10" type="file" name="image" id="image" /></label>
                                    </div>
                                    </div>
                                    {{--end add image section --}}
                                    {{-- input answer for description of image --}}
                                    <div  class="{{  $answer['hide']==true?"opacity-25":"" }} mt-2 flex justify-center  " >
                                        <div><input    class="w-full border-b-2 outline-none {{ $errors->first("answers.$i.value")?"border-red-400":"border-green-400" }}
                                        "    wire:model.lazy="answers.{{$i}}.value"  name="answers.{{ $i }}.value"
                                        id="answers.{{ $i }}.value"  required autofocus >
                                        </div>
                                    </div>

                                </div>


                            @endif

                        @endforeach
                        @for($i = count($answers); $i < 1; $i++)

                            <div class=" p-2 w-[400px] border-[0.5px] border-gray-200 rounded-lg" >
                                <div class="opacity-0 flex justify-between" >
                                    <div><span class="text-sm text-blue-400" >{{ $i+1 }}</span></div>

                                    <div>
                                        <a  class="text-red-400 inline-block text-lg p-1 w-6  bg-red-200 hover:bg-red-400 hover:text-red-600 text-center rounded-2xl"
                                            wire:click="deleteanswer({{ $i }})" >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class=" mt-2 flex justify-center  " >
                                    <div class="border-[1px] border-gray-300 rounded-lg w-[100px] h-[100px] opacity-50 ">
                                    </div>
                                </div>
                                <div class="mt-2 flex justify-center  " >
                                <div> <input    class="w-auto border-b-2 border-gray-200  opacity-50 " disabled ></div>
                                </div>
                                <div class="opacity-0 row-span-6 mt-2 px-0 xs:pl-16">
                                    <span class="text-xs">hide</span>
                                    <input  type="checkbox" class="focus:ring-transparent  w-4 h-4 text-green-300 bg-gray-100  rounded-full">

                                    <span class="pl-2 border-l-[1px] border-gray-300 ml-2 text-xs">Score</span>
                                    <input    class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"   />
                                    <input    class=" p-[1px] text-xs text-center focus:ring-transparent ml-2 w-10 h-6 rounded-md" type="number" />

                                    <span class="pl-2 border-l-[1px] border-gray-300 ml-2 text-xs">Skip</span>
                                    <input     class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"   />


                                </div>
                            </div>
                        @endfor
                    </div>
                    @if($type=="custom_satisfaction")
                        {{-- emoji satisfaction --}}
                        <div class="mt-8 mb-8 flex justify-between pl-[300px] pr-[300px] space-x-[1px]">
                            <img class="w-10 h-10" src="{{ asset('images/icons/emoji/1.png') }}" alt="">
                            <img class="w-10 h-10" src="{{ asset('images/icons/emoji/2.png') }}" alt="">
                            <img class="w-10 h-10" src="{{ asset('images/icons/emoji/3.png') }}" alt="">
                            <img class="w-10 h-10" src="{{ asset('images/icons/emoji/4.png') }}" alt="">
                            <img class="w-10 h-10" src="{{ asset('images/icons/emoji/5.png') }}" alt="">
                        </div>

                    @elseif($type=="custom_rating")
                        {{-- emoji rating  --}}
                        <div class="mt-8 mb-8 flex justify-between pl-[300px] pr-[300px] space-x-[1px]">
                            <span class="border-[1px] border-gray-300 text-center w-10 h-10 p-1">1</span>
                            <span class="border-[1px] border-gray-300 text-center w-10 h-10 p-1">2</span>
                            <span class="border-[1px] border-gray-300 text-center w-10 h-10 p-1">3</span>
                            <span class="border-[1px] border-gray-300 text-center w-10 h-10 p-1">4</span>
                            <span class="border-[1px] border-gray-300 text-center w-10 h-10 p-1">5</span>
                        </div>
                    @endif

                @else
                    {{-- multiple answer --}}
                    <div class="mt-2 ml-1 mr-1 xs:border-t-[1px] border-gray-100 grid grid-cols-12 max-h-[500px] overflow-x-hidden  overflow-y-scroll sm:grid-cols-3 xs:grid-cols-3 gap-3 p-2" >

                        @foreach ($answers as $i =>  $answer )
                            @if( $stepanswer>=$i)

                            <div id="list{{ $i }}" class="   p-2  col-span-3 border-[0.5px] border-gray-200 rounded-lg" >
                                {{-- header of answer  --}}
                                <div class="flex justify-between" >
                                    <div><span class="text-sm text-blue-400" >{{ $answer['code'] }}</span></div>

                                    <div>
                                        {{-- delete answer --}}
                                        <a wire:click="deleteAnswerConfirmation({{ $i }})" class="text-red-400 inline-block text-lg p-1 w-6  bg-red-200 hover:bg-red-400 hover:text-red-600 text-center rounded-2xl"
                                            >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                {{-- add image section --}}
                                <div class="{{  $answer['hide']==true?"opacity-25":"" }} mt-2 flex justify-center  " >
                                <div class="border-[1px] border-gray-300 p-[2px] rounded-lg w-[100px] h-[100px] ">




                                    <img wire:model="{{ asset($answer['image'])}}" class="w-full h-full object-contain block ml-auto mr-auto"
                                        src="{{ asset($answer['image'])}}" alt="">

                                        <label class="items-center w-4 relative  flex bottom-[10px] right-[8px]  bg-green-300 border-[1px] rounded-2xl" for="image">
                                            <svg wire:click="updatecurrentimageindex({{ $i }})" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                                            </svg>
                                        <input   wire:model="image" class="image opacity-0 absolute -z-10" type="file" name="image" id="image" /></label>
                                </div>
                                </div>
                                {{--end add image section --}}
                                {{-- input answer for description of image --}}
                                <div  class="{{  $answer['hide']==true?"opacity-25":"" }} mt-2 flex justify-center  " >
                                    <div><input    class="w-full border-b-2 outline-none {{ $errors->first("answers.$i.value")?"border-red-400":"border-green-400" }}
                                    "    wire:model.lazy="answers.{{$i}}.value"  name="answers.{{ $i }}.value"
                                    id="answers.{{ $i }}.value"  required autofocus >
                                    </div>
                                </div>
                                {{-- emoji --}}
                                <div class=" mt-2 flex justify-between  space-x-[1px]   px-0 xs:pl-16">
                                    {{-- emoji satisfaction --}}
                                    @if($type=="custom_satisfaction")
                                        <img class="w-8 h-8" src="{{ asset('images/icons/emoji/1.png') }}" alt="">
                                        <img class="w-8 h-8" src="{{ asset('images/icons/emoji/2.png') }}" alt="">
                                        <img class="w-8 h-8" src="{{ asset('images/icons/emoji/3.png') }}" alt="">
                                        <img class="w-8 h-8" src="{{ asset('images/icons/emoji/4.png') }}" alt="">
                                        <img class="w-8 h-8" src="{{ asset('images/icons/emoji/5.png') }}" alt="">
                                    {{-- emoji rating --}}
                                    @elseif($type=="custom_rating")
                                        <span class="border-[1px] border-gray-300 text-center w-8 h-8 p-1">1</span>
                                        <span class="border-[1px] border-gray-300 text-center w-8 h-8 p-1">2</span>
                                        <span class="border-[1px] border-gray-300 text-center w-8 h-8 p-1">3</span>
                                        <span class="border-[1px] border-gray-300 text-center w-8 h-8 p-1">4</span>
                                        <span class="border-[1px] border-gray-300 text-center w-8 h-8 p-1">5</span>
                                    @endif
                                </div>
                            </div>

                            @endif

                        @endforeach
                        @for($i = $count; $i < $numofanswers; $i++)

                            <div class=" p-2 col-span-3 border-[0.5px] border-gray-200 rounded-lg" >
                                <div class="opacity-0 flex justify-between" >
                                    <div><span class="text-sm text-blue-400" >{{ $i+1 }}</span></div>

                                    <div>
                                        {{-- delete answer --}}
                                        <a wire:click="deleteAnswerConfirmation({{ $i }})"  class="text-red-400 inline-block text-lg p-1 w-6  bg-red-200 hover:bg-red-400 hover:text-red-600 text-center rounded-2xl"
                                            >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class=" mt-2 flex justify-center  " >
                                    <div class="border-[1px] border-gray-300 rounded-lg w-[100px] h-[100px] opacity-50 ">
                                    </div>
                                </div>
                                <div class="mt-2 flex justify-center  " >
                                <div> <input    class="w-auto border-b-2 border-gray-200  opacity-50 " disabled ></div>
                                </div>
                                <div class="opacity-0 row-span-6 mt-2 px-0 xs:pl-16">
                                    <span class="text-xs">hide</span>
                                    <input  type="checkbox" class="focus:ring-transparent  w-4 h-4 text-green-300 bg-gray-100  rounded-full">

                                    <span class="pl-2 border-l-[1px] border-gray-300 ml-2 text-xs">Score</span>
                                    <input    class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"   />
                                    <input    class=" p-[1px] text-xs text-center focus:ring-transparent ml-2 w-10 h-6 rounded-md" type="number" />

                                    <span class="pl-2 border-l-[1px] border-gray-300 ml-2 text-xs">Skip</span>
                                    <input     class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"   />


                                </div>
                            </div>
                        @endfor
                    </div>
                @endif

            {{--end of custom satisfaction and custom rating --}}
            {{-- Multi Option Question  with image section --}}
            @elseif($type=='mcq_pic'||$type=='checkbox_pic')
                <div class="mt-2 flex justify-center" >
                    <span>{{ $type_details}}</span>
                </div>

                <div class="p-4 w-full h-1/2 flex justify-center " >

                    <div class="border-[1px] w-3/4 h-20 overflow-y-auto  p-2 rounded-lg border-gray-200" >

                    <input class="border-b-2 outline-none  w-full focus:border-indigo-300
                    " required autofocus min="10" minlength="10" wire:model="question_text" name="" id="" >

                    </div>


                </div>
                {{-- add answer button --}}
                <div class="flex justify-center" >
                    <a   wire:click="addanswer()" class="bg-blue-400 hover:bg-blue-200 p-2 text-white  text-center items-center rounded-full flex justify-center w-10 h-10 {{ $stepanswer<=$numofanswers?"":"hidden" }} cursor-pointer text-white bg-blue-500  hover:bg-blue-400 font-medium rounded-lg
                    text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 no-underline hover:no-underline focus:no-underline "><span class="text-lg">+</span></a>

                </div>
                <div class="mt-2 ml-1 mr-1 xs:border-t-[1px] border-gray-100 grid grid-cols-12 max-h-[500px] overflow-x-hidden  overflow-y-scroll sm:grid-cols-3 xs:grid-cols-3 gap-3 p-2" >

                    @foreach ($answers as $i =>  $answer )
                        @if( $stepanswer>=$i)

                        <div id="list{{ $i }}" class="   p-2  col-span-3 border-[0.5px] border-gray-200 rounded-lg" >
                            {{-- header of answer  --}}
                            <div class="flex justify-between" >
                                <div><span class="text-sm text-blue-400" >{{ $answer['code'] }}</span></div>

                                <div>
                                    {{-- delete answer --}}
                                    <a wire:click="deleteAnswerConfirmation({{ $i }})" class="text-red-400 inline-block text-lg p-1 w-6  bg-red-200 hover:bg-red-400 hover:text-red-600 text-center rounded-2xl"
                                        >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            {{-- add image section --}}
                            <div class="{{  $answer['hide']==true?"opacity-25":"" }} mt-2 flex justify-center  " >
                            <div class="border-[1px] border-gray-300 p-[2px] rounded-lg w-[100px] h-[100px] ">




                                <img wire:model="{{ asset($answer['image'])}}" class="w-full h-full object-contain block ml-auto mr-auto"
                                    src="{{ asset($answer['image'])}}" alt="">

                                    <label class="items-center w-4 relative  flex bottom-[10px] right-[8px]  bg-green-300 border-[1px] rounded-2xl" for="image">
                                        <svg wire:click="updatecurrentimageindex({{ $i }})" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                                        </svg>
                                    <input   wire:model="image" class="image opacity-0 absolute -z-10" type="file" name="image" id="image" /></label>
                            </div>
                            </div>
                            {{--end add image section --}}
                            {{-- input answer for description of image --}}
                            <div  class="{{  $answer['hide']==true?"opacity-25":"" }} mt-2 flex justify-center  " >
                                <div><input    class="w-full border-b-2 outline-none {{ $errors->first("answers.$i.value")?"border-red-400":"border-green-400" }}
                                "    wire:model.lazy="answers.{{$i}}.value"  name="answers.{{ $i }}.value"
                                id="answers.{{ $i }}.value"  required autofocus >
                                </div>
                            </div>
                            {{-- emoji --}}
                            <div class=" mt-2 flex justify-between  space-x-[1px]   px-0 xs:pl-16">
                                {{-- emoji satisfaction --}}
                                @if($type=="custom_satisfaction")
                                    <img class="w-10 h-10" src="{{ asset('images/icons/emoji/1.png') }}" alt="">
                                    <img class="w-10 h-10" src="{{ asset('images/icons/emoji/2.png') }}" alt="">
                                    <img class="w-10 h-10" src="{{ asset('images/icons/emoji/3.png') }}" alt="">
                                    <img class="w-10 h-10" src="{{ asset('images/icons/emoji/4.png') }}" alt="">
                                    <img class="w-10 h-10" src="{{ asset('images/icons/emoji/5.png') }}" alt="">
                                {{-- emoji rating --}}
                                @elseif($type=="custom_rating")
                                    <span class="border-[1px] border-gray-300 text-center w-10 h-10 p-1">1</span>
                                    <span class="border-[1px] border-gray-300 text-center w-10 h-10 p-1">2</span>
                                    <span class="border-[1px] border-gray-300 text-center w-10 h-10 p-1">3</span>
                                    <span class="border-[1px] border-gray-300 text-center w-10 h-10 p-1">4</span>
                                    <span class="border-[1px] border-gray-300 text-center w-10 h-10 p-1">5</span>
                                @endif
                            </div>
                        </div>

                        @endif

                    @endforeach
                    @for($i = $count; $i < $numofanswers; $i++)

                    <div class=" p-2 col-span-3 border-[0.5px] border-gray-200 rounded-lg" >
                        <div class="opacity-0 flex justify-between" >
                            <div><span class="text-sm text-blue-400" >{{ $i+1 }}</span></div>

                            <div>
                                {{-- delete answer --}}
                                <a wire:click="deleteAnswerConfirmation({{ $i }})"  class="text-red-400 inline-block text-lg p-1 w-6  bg-red-200 hover:bg-red-400 hover:text-red-600 text-center rounded-2xl"
                                    >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class=" mt-2 flex justify-center  " >
                            <div class="border-[1px] border-gray-300 rounded-lg w-[100px] h-[100px] opacity-50 ">
                            </div>
                        </div>
                        <div class="mt-2 flex justify-center  " >
                        <div> <input    class="w-auto border-b-2 border-gray-200  opacity-50 " disabled ></div>
                        </div>
                        <div class="opacity-0 row-span-6 mt-2 px-0 xs:pl-16">
                            <span class="text-xs">hide</span>
                            <input  type="checkbox" class="focus:ring-transparent  w-4 h-4 text-green-300 bg-gray-100  rounded-full">

                            <span class="pl-2 border-l-[1px] border-gray-300 ml-2 text-xs">Score</span>
                            <input    class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"   />
                            <input    class=" p-[1px] text-xs text-center focus:ring-transparent ml-2 w-10 h-6 rounded-md" type="number" />

                            <span class="pl-2 border-l-[1px] border-gray-300 ml-2 text-xs">Skip</span>
                            <input     class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"   />


                        </div>
                    </div>
                    @endfor
                </div>


            {{-- End Multi Option Question multi answers with image section --}}
            {{-- Multi Option Questions --}}
            @elseif($type=='mcq'||$type=='checkbox')

                <div class="mt-2 flex justify-center" >
                    <span>{{ $type_details}}</span>
                </div>

                <div class="p-4 w-full h-1/2 flex justify-center " >

                    <div class="border-[1px] w-3/4 h-20 overflow-y-auto  p-2 rounded-lg border-gray-200" >
                        {{-- {!! nl2br($question) !!} --}}
                        <textarea maxlength="255"  rows="3" cols="85" class="border-none outline-none  w-full focus:outline-none focus:border-none
                                            " required autofocus min="10" minlength="10" wire:model="question_text" name="" id="" ></textarea>

                    </div>


                </div>
                {{-- add answer button --}}

                <div class="flex justify-center" >
                        <a   wire:click="addanswer()" class="bg-blue-400 hover:bg-blue-200 p-2 text-white  text-center items-center rounded-full flex justify-center w-10 h-10 {{ $stepanswer<=$numofanswers?"":"hidden" }} cursor-pointer text-white bg-blue-500  hover:bg-blue-400 font-medium rounded-lg
                        text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 no-underline hover:no-underline focus:no-underline "><span class="text-lg">+</span></a>
                </div>


                    {{-- answers  --}}
                <div class="xs:mt-2 xs:border-t-[1px] border-gray-100 flex justify-center">
                        <div class="mt-2 w-full p-4 max-h-[300px]  overflow-y-scroll  grid 2xl:grid-cols-12 lg:grid-cols-12
                        md:grid-cols-12 sm:grid-cols-2 xs:grid-cols-2 gap-2 " >


                            @foreach ($answers as $i =>  $answer )
                                @if( $stepanswer>=$i)
                                    <div id="list{{ $i }}" class="col-span-6 ">
                                        <div  class=" row-span-6" >
                                            <div class="w-[30px] inline-block" >
                                            <span class="whitespace-nowrap text-md  ">{{ $answer['code'] }}{{ __('.') }}</span>
                                            </div>
                                            {{-- answer input --}}
                                                <input    class="{{  $answer['hide']==true?"opacity-25":"" }} w-[300px] border-b-2 outline-none {{ $errors->first("answers.$i.value")?"border-red-400":"border-green-400" }}
                                                "  wire:model.lazy="answers.{{$i}}.value"  name="answers.{{ $i }}.value"
                                                id="answers.{{ $i }}.value"  required autofocus >
                                            {{-- end answer --}}

                                                <a wire:click="deleteAnswerConfirmation({{ $i }})" class="text-red-400 inline-block  text-lg p-1 w-4  bg-red-200 hover:bg-red-400 hover:text-red-600 text-center rounded-2xl"
                                                    >
                                                    <svg class="w-2 h-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"></path>
                                                    </svg>
                                                </a>
                                        </div>
                                        {{-- options of each answers  --}}
                                        <div class="row-span-6 mt-2 px-8">
                                            <span class="text-xs">hide</span>
                                            <input wire:model="sethide.{{ $i }}" wire:change="changesethide({{ $i }})" type="checkbox" class="focus:ring-transparent  w-4 h-4 text-green-300 bg-gray-100  rounded-full">

                                            <span class="pl-2 border-l-[1px] border-gray-300 ml-2 text-xs">Score</span>
                                            <input  wire:model="setscore.{{ $i }}"   class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"   />
                                            <input wire:model="answers.{{ $i }}.score"  max="10" min="0" onKeyDown="return false"  class="{{ $setscore[$i]==1?"":"hidden" }} p-[1px] text-xs text-center focus:ring-transparent ml-2 w-10 h-6 rounded-md" type="number" />
                                             <span class="pl-2 border-l-[1px] text-xs border-gray-300"></span>

                                              {{-- <input wire:model="setskip.{{ $i }}" wire:change="changesetskip({{ $i }})"  data-bs-toggle="tooltip"
                                                     data-bs-html="true" title="Skip Next Question if the answer choosen"
                                                     class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="radio"
                                                     name="options-skip-{{$i}}"  /> --}}

                                                     <x-jet-dropdown align="false"  width="40">
                                                        <x-slot name="trigger">
                                                            <span class="inline-flex  rounded-md">

                                                                <button type="button" class="no-underline hover:no-underline focus:no-underline
                                                                focus:outline-none inline-flex items-center
                                                                text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50
                                                                 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50
                                                                 transition">
                                                                    <span class="pl-[2px] text-xs">
                                                                        @if($answers[$i]['skip']==true)
                                                                        {{ __('Skip') }}
                                                                        @elseif($answers[$i]['terminate']==true)
                                                                        {{ __('Terminate') }}
                                                                        @else
                                                                        {{ __('None') }}
                                                                        @endif
                                                                    </span>
                                                                    <svg fill="none" class="w-4 h-4" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"></path>
                                                                    </svg>
                                                                </button>
                                                            </span>
                                                        </x-slot>

                                                        <x-slot name="content">
                                                            <div class="w-60">


                                                                <div class="border-t border-gray-100"></div>

                                                                <!-- Team Switcher -->
                                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                                    {{ __('if this answer choosen') }}
                                                                </div>
                                                                <div class="flex ml-2 my-1 mr-2">
                                                                 <span class="text-xs mr-1 ml-1">{{ __('Skip Next Question') }}</span>
                                                                <input wire:model="setskip.{{ $i }}" wire:change="changesetskip({{ $i }})"  data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="Skip Next Question if the answer choosen"
                                                                class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"
                                                                 />
                                                                </div>
                                                                <div class="flex ml-2 my-1 mr-2">
                                                                    <span class="text-xs mr-1 ml-1">{{ __('End Survey') }}</span>
                                                                   <input wire:model="setterminate.{{ $i }}" wire:change="changesetterminate({{ $i }})"  data-bs-toggle="tooltip"
                                                                   data-bs-html="true" title="Skip Next Question if the answer choosen"
                                                                   class="rounded-full focus:ring-transparent text-green-300 bg-gray-100 w-4 h-4" type="checkbox"
                                                                    />
                                                                   </div>


                                                            </div>
                                                        </x-slot>
                                                     </x-jet-dropdown>




                                        </div>



                                    </div>


                                @endif
                            @endforeach
                            @for($i = $count; $i < $numofanswers; $i++)


                                <div class="col-span-6 ">
                                    <input  class="w-auto border-b-2 border-gray-200  opacity-25 " disabled  wire:model.lazy="answers.{{ $i }}.value"  name="" id="" >
                                </div>
                            @endfor

                        </div>
                </div>


            {{-- End Multi Option Questions --}}



       @endif


    <!-- Modal footer -->
    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
        <button data-dismiss="modal" aria-label="Close" wire:click="resetvalue()" type="button"
        class="text-white bg-red-400 hover:bg-red-500  font-medium rounded-lg
        text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700  ">Cancel</button>
        <button    type="submit"  class="text-white bg-blue-400  hover:bg-blue-500 font-medium rounded-lg
        text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700  flex items-center">

        Save</button>

    </div>
   </form>
    {{-- crop modal --}}
    <div  id="cropimage-edit" class="modal absolute z-[100px] top-[0px] border-[1px] rounded-t-xl border-transparent    h-full w-full bg-white  {{ $model?"block":"hidden" }}">

        <div class="bg-blue-300 h-10 border-[1px] rounded-t-xl border-transparent p-2 flex justify-end modal-header">
          <a wire:click="closemodal" class="hover:bg-red-600 w-10 h-6 cursor-pointer flex justify-center" > <span  class="text-white close ">&times;</span></a>

        </div>
        <!-- Modal content -->
        <div class="box-2 mt-10 mb-10 overflow-y-scroll max-h-[600px]">
            <div class=" result-upload w-auto h-auto flex justify-center"></div>
        </div>
        <!--rightbox-->

        <!-- input file -->
        <div class="box flex justify-center mt-10 border-t border-gray-200 rounded-b p-6">
            <!-- save btn -->
            <button wire:click="closemodal " class="cursor-pointer ml-2 mr-2 p-2 border-[2px] border-transparent hover:bg-blue-400  rounded-xl bg-blue-500 w-auto">close</button>
            <a wire:click="cropimage"   class="btn save hide cursor-pointer ml-2 mr-2 p-2 border-[2px] border-transparent hover:bg-blue-400 rounded-xl bg-blue-500 w-auto">Save</a>
        </div>


    </div>
    {{-- end  crop modal --}}
</div>
@push('scripts')

{{-- hint on hover --}}
<script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js" charset="utf-8"></script>


<script type="text/javascript">
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl);
  });
</script>
{{-- crop image --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- sweet alert delete confirm --}}
<script>
    // to confirm delete survey
     window.addEventListener('show-delete-answer-confirmation', event => {
        (async () => {

const { value: accept } = await Swal.fire({
    text: "Deleting the answer will wipe all data,reviews,scores,and statistics that belong to it, this action cannot be undone!!",
  input: 'checkbox',
  inputValue: 0,
  icon:'question',
  confirmButtonColor: '#3085d6',
  showCancelButton: true,
  inputPlaceholder:
  'I\'m sure I want  to delete',
  confirmButtonText:
    'Delete ',
  inputValidator: (result) => {
    return !result && 'Checkbox is required'
  }
})

if (accept) {
    Livewire.emit('deleteanswerConfirmed');

}

})()
     });
</script>
<script >

      document.addEventListener('image-updated-edit', event =>  {

     result = document.querySelector('.result-upload');
    // img_w = document.querySelector('.img-w'),
    // img_h = document.querySelector('.img-h'),
    // options = document.querySelector('.options'),
    save = document.querySelector('.save');

    // dwn = document.querySelector('.download'),
    upload = document.querySelector('.image');
    cropper = '';
    var finalCropWidth = 640;
    var finalCropHeight = 480;
    var finalAspectRatio = finalCropWidth / finalCropHeight;
    // on change show image with crop options

            // start file reader
        const reader = new FileReader();
        let img = document.createElement('img');
        img.id = 'image';
        img.src = @this.imagesrc;
        console.log(img.src);
                    // clean result before
        result.innerHTML = '';
                    // append new image
        result.appendChild(img);

                    // show save btn and options
        // save.classList.remove('hide');
        // options.classList.remove('hide');
                    // init cropper
        cropper = new Cropper(img, {
            dragMode: 'move',
            aspectRatio: 1/1,
            autoCropArea: 0.9,
            restore: false,
            guides: false,
            center: false,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,

            toggleDragModeOnDblclick: false,
        });




    // save on click

});
document.addEventListener('save',(e)=>{
    e.preventDefault();
    // get result to data uri
    let imgSrc = cropper.getCroppedCanvas({
         width:100,
         height:100
        }).toDataURL();



        @this.saveimage(imgSrc);
        @this.closemodalwithsave();
    // dwn.classList.remove('hide');
    // dwn.download = 'imagename.png';
    // dwn.setAttribute('href',imgSrc);
    });
</script>
@endpush
