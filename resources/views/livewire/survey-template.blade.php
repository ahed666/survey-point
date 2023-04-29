

<div class="bg-black  overflow-hidden h-[100vh]" >

    <div class=" flex items-center  justify-between  p-4">
        <div class="flex items-center">
            <div class="border-1 border-white"><img class="object-contain w-32 h-16 " src="{{ asset($logo->logo_url) }}" alt=""></div>
            <span class="text-white ml-4 mr-4 text-lg font-semibold">{{ $survey->business_name }}</span>
        </div>

        <div class="{{ $step==2?'block':'hidden' }} w-[400px] h-6 bg-neutral-200 dark:bg-neutral-600  ">
            <div
            class="bg-blue-400  h-6 flex justify-center items-center  p-0.5 text-center text-xs font-medium leading-none text-primary-100"
            style="width:{{ $progressbarvalue*4 }}px" >
            {{ $progressbarvalue }}{{ __('%') }}
            </div>
        </div>

    </div>
    <div class=" border-2 bg-gray-200 rounded-2xl h-full m-2 xs:h-auto">
    @if($step==1)

        {{-- start messages with all languages  --}}
            <div class="owl-carousel owl-theme mt-40 xs:mt-2">

                @foreach ($messages as $message )
                <div class="item text-center " >
                    <h1 class="font-bold text-5xl">{{ $message->survey_start_header }}</h1>
                    <span class="font-weight-bolder text-3xl " >{{ $message->survey_start_text }}</span>
                </div>
                @endforeach

            </div>
            {{-- flex justify-between items-center space-x-32 --}}
        {{-- end of start messages with all languages  --}}
        @php
            $count=count($surveylanguages);
        @endphp
        <div class=" flex items-center justify-center">
        <div class="grid grid-cols-12 xs:grid-cols-4 gap-6  p-4 mt-10 ">
            @foreach ($surveylanguages as $lang )
                @foreach ($buttons as $button )
                    @if($lang['code']==$button['code'])

                        <div class="col-span-{{ 12/$count }} xs:row-span-1">
                            <button onclick="start()" wire:click="startsurvey({{$lang}})"  class="focus:z-[1000px] focus:border-blue-700  focus:bg-white focus:drop-shadow-2xl hover:z-50 hover:border-blue-600 hover:bg-white hover:drop-shadow-xl border-[1px] border-blue-500 rounded-xl bg-transparent text-blue-500 p-4 w-32">
                                <span class="whitespace-nowrap text-lg font-bold ">{{ $button['text'] }}</span>
                            </button>
                            <img class="my-2 w-6 h-4 block ml-auto mr-auto" src="{{ asset($button['flag']) }}" alt="">
                        </div>
                    @endif
                @endforeach

            @endforeach

        </div>
        </div>

    @elseif($step==2)

        @if($current_question['type_id']=="4"||$current_question['type']=="mcq")


            <div class="text-center p-4 w-full h-auto flex items-center {{ $current_lang=='en'||$current_lang=='tl'?"text-left justify-start":"text-right justify-end" }} " >
            <span class="text-2xl font-bold pointer-events-none">{{$current_question['question_details']  }}</span>
            </div>

                {{-- answers  --}}
            <div class="ml-64 mr-64   mt-4   flex justify-center">
                    <div class="mt-2 w-full pr-2 scrollbar scrollbar-thumb-blue-400 scrollbar-track-white scrollbar-thumb-rounded-full scrollbar-track-rounded-full  max-h-[320px] h-[320px] min-h-[320px] text-center  overflow-y-auto  grid grid-cols-12  gap-2 " >



                        @foreach ($current_question['answers'] as $i =>  $answer )

                                <div id="list{{ $i }}" class="col-span-6 mt-2 ">
                                    <input   class="hidden peer" wire:click="setanswercheck_mcq({{ $i }})"  value="answerchecked.{{ $i }}" name="answer" id="answer{{ $i }}" type="radio" >
                                            <label for="answer{{ $i }}" class="min-h-16 h-16 max-h-16   flex items-center px-2 {{ $current_lang=='en'||$current_lang=='tl'?"text-left justify-start":"text-right justify-end" }} w-full  text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                            dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-400
                                            hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <span class="pointer-events-none"  >{{ $answer['answer_details'] }}</span>

                                        </label>


                                </div>



                        @endforeach


                    </div>
            </div>
        @elseif($current_question['type_id']=="6"||$current_question['type']=="checkbox")
            <div class="text-center p-4 w-full h-auto flex justify-center " >
            <span class="text-2xl font-bold pointer-events-none">{{$current_question['question_details']  }}</span>
            </div>

                {{-- answers  --}}
            <div class="ml-64 mr-64   mt-20   flex justify-center">
                    <div class="mt-2 w-full p-4 max-h-[300px] text-center  overflow-y-auto  grid grid-cols-12  gap-2 " >



                        @foreach ($current_question['answers'] as $i =>  $answer )

                                <div id="list{{ $i }}" class="col-span-6 mt-2 ">
                                    <input   class="hidden peer" wire:click="setanswercheck_checkbox({{ $i }})"  value="answerchecked.{{ $i }}" name="answer" id="answer{{ $i }}" type="checkbox" >
                                            <label for="answer{{ $i }}" class="min-h-16 h-16 max-h-16   flex items-center px-2 {{ $current_lang=='en'||$current_lang=='tl'?"text-left justify-start":"text-right justify-end" }} w-full  text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                            dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-400
                                            hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <span class="pointer-events-none"  >{{ $answer['answer_details'] }}</span>

                                        </label>


                                </div>



                        @endforeach


                    </div>
            </div>
        @elseif($current_question['type_id']=="5"||$current_question['type']=="mcq_pic")
            <div class="text-center p-4 w-full h-auto flex justify-center " >
              <span class="text-2xl font-bold pointer-events-none">{{$current_question['question_details']  }}</span>
            </div>

                {{-- answers  --}}
            <div class="ml-48 mr-48   mt-4  flex justify-center">
                    <div class="mt-2 w-full scrollbar scrollbar-thumb-blue-400 scrollbar-track-white scrollbar-thumb-rounded-full scrollbar-track-rounded-full pr-2 max-h-[320px] h-[320px] min-h-[320px] text-center  overflow-y-scroll  grid grid-cols-12  gap-2" >



                        @foreach ($current_question['answers'] as $i =>  $answer )

                                <div id="list{{ $i }}" class="col-span-3 h-[300px]   mt-2 ">


                                    <input   class="hidden peer" wire:click="setanswercheck_mcq({{ $i }})"  value="answerchecked.{{ $i }}" name="answer" id="answer{{ $i }}" type="radio" >
                                            <label for="answer{{ $i }}" class=" h-[300px]
                                             block items-center px-2 {{ $current_lang=='en'||$current_lang=='tl'?"text-left justify-start":"text-right justify-end" }} w-full  text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
                                            dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-400
                                            hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                                            <div class=" p-[2px] rounded-lg mt-2 flex justify-center  ">
                                                    <img  class=" h-[225px]"
                                                    src="{{ asset($answer['picture'])}}" alt="">
                                            </div>
                                            <div  class=" mt-2 flex justify-center  " >
                                                <span class="pointer-events-none"  >{{ $answer['answer_details'] }}</span>
                                            </div>


                                        </label>


                                </div>



                        @endforeach


                    </div>
            </div>
        @endif
        <div class="flex justify-between items-center px-10 fixed mb-10 w-full  bottom-0">
          <button class="bg-red-400 p-2 w-28 text-white">
            {{ __('Back') }}
          </button>
          <button wire:click="next()" {{ $current_question['optional']==0 &&  $countanswerchecked==0?"disabled":" " }} class=" disabled:bg-blue-200 bg-blue-500 p-2 w-28 text-white">
            {{ ($current_question['optional']==1&&$countanswerchecked==0)?"Skip":"Next" }}

            {{-- @if($current_question['optional']==0&& $countanswerchecked>=0) {{ __('Next') }}
            @elseif($current_question['optional']==1&& $countanswerchecked>0){{ __('Next') }}
            @elseif($current_question['optional']==1&& $countanswerchecked==0){{ __('Skip') }}
            @endif --}}
          </button>
        </div>
    @endif
    </div>




</div>


    @push('scripts')
    <script>

         window.addEventListener('refresh', event => {
            window.location.reload();
            console.log('ggg');

         });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // to start alarm no action message
        function start(){
        var idleTime = 0;
        var start=true;
        if(start==true){
        $(document).ready(function () {
            // Increment the idle time counter every minute.
            var idleInterval = setInterval(timerIncrement, 10000000); // 1 minute

            // Zero the idle timer on mouse movement.
            $(this).mousemove(function (e) {

                idleTime = 0;

            });
            $(this).keypress(function (e) {
                idleTime = 0;
            });

        });
         }
        function timerIncrement() {
            idleTime = idleTime + 1;

            if (idleTime == 2) {// 1 minutes
                let timerInterval
                Swal.fire({
                html: 'I will close in <b></b> seconds.',
                icon: 'warning',
                showConfirmButton:true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, I am here!',
                timer: 40000,
                timerProgressBar: true,
                didOpen: () => {
                    // Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent =parseInt(Swal.getTimerLeft()/1000)
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
                }).then((result) => {
                if (result.isConfirmed) {
                    idleTime=0;
                    start=true;

                }
                })


            }
            else if(idleTime == 6){
                // here i will save survey review if the user do not action for 40s idletime+=1 == 10s when idletime =6 -> 40s left with 20 to show message of issue
                window.location.reload();
            }
        }}

    </script>

    @endpush


