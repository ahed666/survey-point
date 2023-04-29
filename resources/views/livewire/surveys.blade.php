
@push('styles')
<link
  rel="stylesheet"
  href="{{ asset('/styles/index.min.css') }}" />


@endpush

<div wire:loading.class="disabled opacity-50">

        <div  class="grid grid-rows-12">
        {{-- surveys carousel --}}
           <div class="w-full h-full bg-white row-span-4 border-[2px] rounded-lg  " >
              <div class=" container bg-white w-full pt-2 px-2 " >
                <div class="mb-2 flex justify-between" >
                  <h1 class="font-bold text-lg" >{{ __('My surveys') }}</h1>
                 <div  >
                    @php
                    $active_num=0;
                    $inactive_num=0;
                    foreach($surveys as $survey)
                     $survey->active?$active_num+=1:$inactive_num+=1;
                    @endphp
                    <span class="text-btn text-sm mr-2 ml-2" >{{ __('Active:') }}{{ $active_num }}</span>
                    <span class="text-btn text-sm mr-2 ml-2 " >{{ __('InActive:') }}{{ $inactive_num }}</span>
                 </div>
                </div>

                <div class=" container w-full overflow-hidden h-full" >
                    <div  class="owl-survey owl-carousel owl-theme align-content-center  px-2">
                          @php
                              $count=count($surveys);
                          @endphp

                        @foreach($surveys as $survey)


                            <div  wire:key="{{ $survey->id }}"    class="{{ $count<7?"mb-20":"" }} {{ $survey->id==$current_survey_id?" shadow-2xl shadow-blue-500 z-40":"" }} item relative  w-full " >

                                        <div  class=" px-2 pb-2 border-4 rounded border-double border-gray-700 bg-blue-200 xs:w-full w-full " >
                                          <div class="  flex justify-between  " >
                                                    <div class="flex items-center justify-center col-span-3 m-1 rounded-full hover:bg-red-300 w-6 h-6" >
                                                        {{-- delete survey --}}
                                                        <a wire:click="deleteConfirmation({{ $survey->id }})" data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('Delete Survey') }}"><svg  class="w-4 h-4 text-red-400 hover:text-red-600 font-bold " fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg></a>
                                                    </div>
                                                <div wire:click="selectsurvey({{ $survey->id }})" class="col-span-9 w-100 " >
                                                 <div class=" flex justify-end ">
                                                    {{-- <div class="mr-1 pb-1 text-center text-xs  col-span-6 h-4 " >
                                                     <span class=" text-sm whitespace-nowrap {{ $i%3==0?'text-red-500':'text-green-600' }} " >  {{ $i%3==0?"offline":"online" }}</span>

                                                    </div> --}}
                                                    <div class="mr-1 pb-1 text-center text-xs  col-span-6 h-4 " >
                                                        <span class=" text-sm whitespace-nowrap text-bold {{ $survey->active!=true?'text-red-500':'text-green-600' }}" >{{ $survey->active!=true?"InActive":"Active" }}</span>
                                                       {{-- <div class="border-b-4 w-[40px] ml-1  {{ $i%2==0?'border-red-500':'border-green-600' }}  " ></div> --}}
                                                       </div>


                                                </div>
                                                </div>


                                          </div>
                                            <div class="  grid grid-cols-12 " >
                                                {{-- survey icon --}}
                                                <div  class="col-span-3" >

                                                    <svg wire:click="selectsurvey({{ $survey->id }})"   class=" w-full h-3/4" viewBox="0 0 48 48" version="1" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 48 48">
                                                        <path fill="#455A64" d="M36,4H26c0,1.1-0.9,2-2,2s-2-0.9-2-2H12C9.8,4,8,5.8,8,8v32c0,2.2,1.8,4,4,4h24c2.2,0,4-1.8,4-4V8 C40,5.8,38.2,4,36,4z"/>
                                                        <path fill="#ffffff" d="M36,41H12c-0.6,0-1-0.4-1-1V8c0-0.6,0.4-1,1-1h24c0.6,0,1,0.4,1,1v32C37,40.6,36.6,41,36,41z"/>
                                                        <g fill="#90A4AE">
                                                            <path d="M26,4c0,1.1-0.9,2-2,2s-2-0.9-2-2h-7v4c0,1.1,0.9,2,2,2h14c1.1,0,2-0.9,2-2V4H26z"/>
                                                            <path d="M24,0c-2.2,0-4,1.8-4,4s1.8,4,4,4s4-1.8,4-4S26.2,0,24,0z M24,6c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2 S25.1,6,24,6z"/>
                                                        </g>
                                                        <g fill="#CFD8DC">
                                                            <rect x="21" y="20" width="12" height="2"/>
                                                            <rect x="15" y="19" width="4" height="4"/>
                                                        </g>
                                                        <g fill="#03A9F4">
                                                            <rect x="21" y="29" width="12" height="2"/>
                                                            <rect x="15" y="28" width="4" height="4"/>
                                                        </g>
                                                    </svg>
                                                </div>
                                                <div wire:click="selectsurvey({{ $survey->id }})"  class="col-span-9" >
                                                    <div class=" xs-10 xs:p-2 xs:text-xs text-center   text-sm text-black ">

                                                        <div   class="group w-full whitespace-nowrap inline-block overflow-hidden text-ellipsis " >
                                                            <span>{{ $survey->survey_name }}</span>
                                                            <span  class="px-2 pointer-events-none absolute z-10 bg-white border-2 border-black  top-1/2 left-1/2 w-max opacity-0
                                                            transition-opacity group-hover:opacity-100">{{ $survey->survey_name }}</span>
                                                        </div>
                                                        <div   class="group w-full whitespace-nowrap inline-block overflow-hidden text-ellipsis " >
                                                            <span><span class="text-lg text-green-800" >{{ $this->questions_count($survey->id) }}</span> Questions</span>

                                                        </div>

                                                        <div class="group w-full whitespace-nowrap inline-block overflow-hidden text-ellipsis " >
                                                            <span> {{ ('Total Surveys: ') }}{{ $survey->id+1 }}</span>
                                                            <span  class="px-2 pointer-events-none absolute z-10 bg-white border-2 border-black
                                                            top-1/2 left-1/2 w-max opacity-0 transition-opacity group-hover:opacity-100">{{ ('Total Surveys: ') }}{{ $survey->id+1 }}</span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                            </div>

                        @endforeach
                        {{-- add survey --}}
                            <div  class="item relative  w-auto " >

                                        <div class=" px-2 pb-2  h-[134px] xs:h[150px]  xs:w-full w-full " >
                                              <div class="mt-2 flex justify-center" >
                                                  @php
                                                      $id=-1;
                                                  @endphp
                                                <button class="focus:outline-none "  type="button"
                                                wire:click="$emit('add_survey',{{ json_encode($main_languages)}},{{ json_encode($messages)}})"
                                                data-toggle="modal"
                                                data-target="#addsurvey"


                                                >
                                                    <svg class="w-16 h-16 text-blue-400 hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                              </div>
                                             <div  class="mt-2 flex justify-center " > <span class="text-blue-400" >{{ __('Add New') }}</span>
                                             </div>
                                        </div>

                            </div>


                    </div>
                </div>


            </div>
           </div>



            {{-- survey info --}}
        @if($current_survey!=null)
            <div class="w-full h-full bg-white row-span-8 mt-2 border-[2px] rounded-lg pl-[2px]  ">
                <div class="flex justify-center bg-blue-400 w-full h-10 p-2 border-[2px] rounded-lg " >
                    <span class="text-white" >{{ $current_survey->survey_name }}</span></div>
                <div class="grid xs:block 2xl:grid-cols-12 xl:grid-cols-12 lg:grid-cols-12 md:grid-cols-12  p-3  ">
                    {{-- survey settings --}}
                    <div class="col-span-3  py-2 " >


                        {{-- Survey Information --}}
                        <div class="row mb-4 text-black font-bold xs:ml-2 xs:mr-2 w-3/5 xs:w-full border-b-[2px] border-gray-400"  >
                            <span class="border-r-[1px] border-gray-200 px-1 mr-1" >Survey inforamtion</span>
                            <a class="text-sm cursor-pointer hover:text-black text-gray-300" wire:click="$emit('edit_survey',{{ json_encode($current_survey->survey_name)}},{{ json_encode($current_survey->business_name)}},{{ json_encode($current_survey->logo_url)}},{{ json_encode($current_survey->id)}})"  type="button"
                                data-toggle="modal"
                                data-target="#addsurvey"
                                >edit</a>

                        </div>
                        <div class="grid grid-cols-12 mb-4 " >
                            <div class="col-span-8">
                                {{-- survey name --}}
                                <div class="w-full m-1 flex  space-x-1 "  >


                                    <span class="whitespace-nowrap text-sm">
                                        <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('will show in survey') }}"><svg   class="inline-block text-gray-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                        </svg></a>
                                        {{ __('Survey Name:') }}</span>


                                        <span class="text-blue-400 text-sm">{{ $current_survey->survey_name }}</span>
                                </div>
                                {{-- bussines name --}}
                                <div class="w-full m-1 flex  space-x-1 "  >

                                    <span class="whitespace-nowrap text-sm">
                                        <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('will show in survey') }}"><svg   class="inline-block text-gray-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                        </svg></a>
                                        {{ __('Business Name:') }}</span>
                                        <span class="text-blue-400 text-sm">{{ $current_survey->business_name }}</span>
                                </div>
                            </div>

                            {{-- bussines logo --}}
                            <div  class=" col-span-4 mr-2 ml-2 " >
                                    <div class="felx justify-between space-x-[1px]">
                                    <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('will show in survey') }}"><svg   class="inline-block text-gray-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                </svg></a>
                                <span class="whitespace-nowrap text-sm">{{ __('Business Logo') }}</span></div>
                                <div class="border-2 rounded-lg border-gray-400  w-100  flex justify-center " >
                                <img  class="object-contain w-full h-full" src="{{ asset($current_survey->logo_url) }}" alt="">
                                </div>
                            </div>



                        </div>
                        {{-- end survey information --}}
                        {{-- web options --}}
                        <div class="row mb-4 mt-8   text-black font-bold xs:ml-2 xs:mr-2 w-3/5 xs:w-full border-b-[2px] border-gray-400"  >
                            <h1 class="whitespace-nowrap" >Web Options</h1>
                        </div>

                        <div class=" px-4 items-center " >
                            {{--terms--}}
                            <div class="row w-full   mt-8  flex align-center"  >

                                <div class="align-center" >
                                <span class="text-black  text-sm " >{{ __('Terms & Conditions') }}</span>
                                </div>

                                <div class="" >
                                        <label class="ml-2 relative inline-flex items-center cursor-pointer">

                                        <input type="checkbox"    wire:model="terms" value="" {{ $current_survey->terms?"checked":"" }} class="sr-only peer"

                                        >
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none  dark:peer-focus:ring-blue-800
                                        rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                                        after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                            dark:border-gray-600 peer-checked:bg-blue-600"></div>

                                        </label>
                                </div>
                            </div>
                            {{-- in service --}}
                            <div class="row w-full   mt-8  flex align-center"  >

                                <div class="align-center" >
                                <span class="text-black  text-sm " >{{ __('In Service') }}</span>
                                </div>

                                <div class="" >
                                        <label class="ml-2 relative inline-flex items-center cursor-pointer">

                                        <input type="checkbox" wire:model="service" value="" {{ $current_survey->active?"checked":"" }} class="sr-only peer"

                                        >
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none  dark:peer-focus:ring-blue-800
                                        rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                                        after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                            dark:border-gray-600 peer-checked:bg-blue-600"></div>

                                        </label>
                                </div>
                            </div>
                            {{-- expiry --}}
                            <div class="row w-full  mt-4  flex justify-between"  >
                                <div class="w-1/2 flex items-center" >
                                    <span class="text-black text-sm  " >
                                        {{ __('Expiry') }}</span>
                                    <label class="ml-4 relative inline-flex items-center cursor-pointer">

                                        <input type="checkbox" wire:model="surveyexpiry" value="" {{ $current_survey->expiry?"checked":"" }} class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none  dark:peer-focus:ring-blue-800
                                        rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                                        after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                            dark:border-gray-600 peer-checked:bg-blue-600"></div>

                                        </label>
                                </div>

                                <div class="w-1/2" >
                                    <input {{ $current_survey->expiry?"":"disabled" }} type="date" name="expiry-date" id="expiry-date" wire:model="surveyexpirydate" value="" class=" w-full h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                    focus:ring-blue-500 {{ $current_survey->expiry?"":"opacity-50" }}
                                            focus:border-blue-500 block  pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600
                                                dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500"/>
                                </div>
                            </div>
                            {{-- share --}}
                            <div class="row w-full   mt-4 ">

                                        <span class="text-black text-sm  " >{{ __('Share') }}</span>

                                        <a class="ml-4" href=""><svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 h-6
                                            " viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                                        </svg>
                                        </a>


                            </div>

                        </div>
                        {{-- end web options --}}
                        {{-- linked devices --}}
                        <div class="row mb-4 mt-8  text-black font-bold xs:ml-2 xs:mr-2 w-3/5 xs:w-full border-b-[2px] border-gray-400"  >
                            <h1 class="whitespace-nowrap" >Linked Devices</h1>
                        </div>
                        <div class="m-2 border-[1px] border-gray-200 p-1">
                            <ol class="p-2">

                                @if($current_survey_kiosks!=null)
                                @foreach ( $current_survey_kiosks as $kiosk)
                                <li>{{ $kiosk->device_name }}</li>
                                @endforeach
                                @else
                                <span>{{ __('No Devices') }}</span>
                                @endif


                            </ol>

                        </div>
                        {{-- link to device  --}}
                        <div class="mt-1 flex justify-center">
                          <a href="{{ route('kiosks') }}" class="text-blue-400" href="">Link To Device</a>
                        </div>
                        {{-- end linked devices --}}
                    </div>
                    {{-- survey questions --}}
                        <div  class="col-span-9 2xl:mr-2 2xl:ml-2 mt-[4px] border-2 border-gray-300 p-2 xs:p-0 rounded-lg   " style="height: 600px" >
                                <div class=" border-b border-gray-200 dark:border-gray-700 mb-4">
                                    <ul class="flex  -mb-px" id="tabs-tab3"
                                    role="tablist"
                                    data-te-nav-ref>


                                                @foreach ($surveylanguages as $lang )

                                                            @if($lang['code']=="en")

                                                                <li   class="  border-r-2 pt-1 ml-[2px] mr-[2px]"  role=" presentation">

                                                                    <a   href="#tabs-{{ $lang['code'] }}"   class=" block border-x-0 border-t-0 border-b-2 border-transparent  text-sm font-medium
                                                                    h-full leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent
                                                                    data-[te-nav-active]:border-blue-300 data-[te-nav-active]:text-blue-300 py-[1px] no-underline hover:no-underline focus:no-underline
                                                                    dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                                                                    id="{{ $lang['code'] }}-tab"  data-te-toggle="pill"  {{ $local==$lang['code']?"data-te-nav-active":"" }}    data-te-target="#tabs-{{ $lang['code'] }}"
                                                                        role="tab" aria-controls="tabs-{{ $lang['code'] }}" aria-selected="true"  >
                                                                    <div class="flex justify-between">
                                                                       {{-- wire:click="deletelang({{ $lang['id'] }})" --}}
                                                                        <svg wire:click="deletelanguageConfirmation({{ $lang['id'] }})"   class="{{  count($surveylanguages)==1?"hidden":"" }}  inline-block text-lg p-1    bg-red-200 hover:bg-red-400 hover:text-red-600 text-center rounded-2xl text-red-400 w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"></path>
                                                                        </svg>


                                                                        <span wire:click="changelocal({{ $lang['id'] }})" class="px-2 pt-2 pb-0.5">{{ $lang['name'] }}</span>
                                                                    </div>
                                                                    </a>



                                                                </li>
                                                            @else
                                                                <li class="  border-r-2 pt-1 ml-[2px] mr-[2px]"  role=" presentation">

                                                                    <a   href="#tabs-{{ $lang['code'] }}"    class=" block border-x-0 border-t-0 border-b-2 border-transparent  text-sm font-medium
                                                                    h-full leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent
                                                                    data-[te-nav-active]:border-blue-300 data-[te-nav-active]:text-blue-300 py-[1px] no-underline hover:no-underline focus:no-underline
                                                                    dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                                                                    id="{{ $lang['code'] }}-tab"  data-te-toggle="pill"
                                                                    data-te-target="#tabs-{{ $lang['code'] }}" {{ $local==$lang['code']?"data-te-nav-active":"" }}
                                                                        role="tab" aria-controls="tabs-{{ $lang['code'] }}" aria-selected="false"  >
                                                                        <div class="flex justify-between">
                                                                            <svg wire:click="deletelanguageConfirmation({{ $lang['id'] }})" class=" inline-block text-lg p-1   bg-red-200 hover:bg-red-400 hover:text-red-600 text-center rounded-2xl text-red-400 w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"></path>
                                                                            </svg>
                                                                        <span wire:click="changelocal({{ $lang['id'] }})" class="px-2 pt-2 pb-0.5">{{ $lang['name'] }}</span>
                                                                        </div>
                                                                    </a>

                                                                </li>

                                                            @endif
                                                @endforeach
                                                    {{-- add languages button --}}
                                                    <li data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('Add New Language') }}" class="{{  count($surveylanguages)==4?"hidden":"" }} m-1 xs:text-xs pt-2 "  >
                                                    <button id="dropdownRadioButton" data-dropdown-toggle="dropdownDefaultRadio" class=" text-white bg-blue-400
                                                        hover:bg-blue-200  font-medium  text-sm px-1 py-1 w-[20px] h-[20px] rounded-full focus:outline-none
                                                        text-center justify-center flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                        type="button"><span class="text-center text-lg">+</span> </button>
                                                        <div id="dropdownDefaultRadio" class="z-20 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                                                            <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200 border-[1px] rounded-lg border-gray-200" aria-labelledby="dropdownRadioButton">
                                                                @foreach ($main_languages as $main_lan )

                                                                @if(! $this->surveylang($main_lan['id']))

                                                                <li wire:click="addlang({{ $main_lan['id'] }})" class="hover:bg-gray-200 hover:cursor-pointer p-2 rounded-lg">
                                                                    <span>{{ $main_lan['name'] }}</span >
                                                                </li>
                                                                @endif
                                                                @endforeach


                                                            </ul>
                                                        </div>
                                                    </li>
                                                    {{-- end add languages btn  --}}
                                    </ul>
                                </div>
                                <div   class="overflow-y-auto   " style="height:500px" >
                                    @php
                                        $count=5;
                                    @endphp


                                    @if($current_message!=null)
                                    {{-- welcome message --}}
                                        <li   class="list-none mr-1 ml-1 bg-gray-50 p-4 mt-2 hover:bg-slate-100 hover:border-2 hover:border-blue-300  rounded-lg dark:bg-gray-800 " >
                                            <div class="flex justify-end" >

                                                <div class="flex justify-between" >
                                                    <a wire:click="$emit('edit_message',{{ json_encode('welcome') }},{{ json_encode($current_message) }})"  type="button"  data-te-toggle="modal"
                                                data-te-target="#editmessage"
                                                data-te-ripple-init
                                                    class="ml-1 mr-1" ><svg class="h-6 w-6 text-black"  viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" /></svg></a>
                                                </div>
                                            </div>
                                            <div class="flex justify-center">
                                                <h1> {{ $current_message->survey_start_header }}</h1>
                                            </div>
                                            <div class="mt-8 flex justify-center">
                                                <h1> {{ $current_message->survey_start_text }}</h1>
                                            </div>


                                        </li>
                                          {{-- terms --}}
                                        <li   class="{{ $current_survey->terms==true?"":"hidden" }} list-none mr-1 ml-1 bg-gray-50 p-4 mt-2 hover:bg-slate-100 hover:border-2 hover:border-blue-300  rounded-lg dark:bg-gray-800 " >
                                            <div class="flex justify-between " >
                                                 <div class="flex"><h1>{{ __('Terms & Conditions') }}</h1></div>
                                                <div class="flex justify-end" >

                                                    <a  wire:click="$emit('edit_terms',{{ json_encode($current_message) }})"  type="button"
                                                    data-toggle="modal"
                                                    data-target="#surveyterms"
                                                    class="ml-1 mr-1" ><svg class="h-6 w-6 text-black"  viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" /></svg></a>
                                                </div>
                                            </div>
                                            <div class="flex justify-center max-h-[100px] overflow-auto p-2">
                                                <p class=" {{ $local=='en'||$local=='tl'?"text-left justify-start":"text-right justify-end" }}">{!! $current_message->terms !!}</p>
                                            </div>


                                        </li>
                                    @endif
                                    {{-- end welcome message --}}

                                        @foreach ($surveylanguages as $lan )


                                                <ul   class="{{ $local==$lan['code']?" opacity-100 ":"hidden opacity-0 " }}
                                                  transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                                                  wire:sortable="updateQuestionOrder"
                                                                role="list" id="tabs-{{ $lan['code'] }}" role="tabpanel" aria-labelledby="{{ $lan['code'] }}-tab" {{ $local==$lan['code']?"data-te-nav-active":"" }}>

                                                    @foreach ($current_questions as $i=> $ques )
                                                                {{-- wire:sortable.item="{{ $ques['id'] }}" wire:key="question-{{ $current_survey_id }}-{{ $ques['id'] }}" --}}


                                                                <li wire:sortable.item="{{ $ques['id'] }}" wire:key="{{ $current_survey_id }}-{{ $lan['code'] }}-{{ $ques['id'] }}"   class="bg-gray-50 p-4 mt-2 hover:bg-slate-100 hover:border-2 hover:border-blue-300  rounded-lg dark:bg-gray-800 " >
                                                                    <div class="flex justify-between" >
                                                                        <div class="w-1/3 max-w-1/3">
                                                                        <span>{{ $ques['type'] }}</span>
                                                                        </div>
                                                                        <div class="w-1/3 max-w-1/3 justify-center flex items-center" >
                                                                            <span class="text-blue-900 text-bold  text-lg " >{{ $i+1}}</span>
                                                                        </div>
                                                                        <div class="max-w-1/3 w-1/3 space-x-1 flex justify-end" >
                                                                            {{-- re order question --}}
                                                                            <a  wire:sortable.handle class="ml-1 mr-1 ">
                                                                                <svg class="h-6 w-6 text-black hover:text-green-400 focus:text-green-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"></path>
                                                                                </svg>
                                                                            </a>
                                                                            {{-- delete question --}}
                                                                            <a wire:click="deletequestionConfirmation({{ $ques['id'] }})" class="ml-1 mr-1   hover:text-red-400" ><svg class="h-6 w-6 text-black hover:text-red-400 hover:cursor-pointer"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"
                                                                                stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                                                <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg></a>
                                                                            {{-- edit question --}}

                                                                            <a  wire:click="$emit('edit',{{ $ques['id'] }},{{ json_encode($local) }},{{ json_encode($surveylanguages) }})"  type="button"
                                                                            data-toggle="modal"
                                                                            data-target="#editquestion"
                                                                            class="ml-1 mr-1" ><svg class="h-6 w-6 text-black"  viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round"
                                                                            stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                                                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" /></svg></a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mt-2 mb-2" >
                                                                        <span class="ml-1 mr-1" >{{ __('Q') }}{{ $ques['id']+1 }}{{ __(')') }}</span><span>{{ $ques['details'] }}</span>
                                                                    </div>
                                                                    {{-- <div class="mr-4 ml-4 p-2" >
                                                                        <ul >
                                                                            <li>answer1</li>
                                                                            <li>answer2</li>
                                                                            <li>answer3</li>
                                                                        </ul>

                                                                    </div> --}}
                                                                </li>


                                                    @endforeach
                                                    {{-- add question  --}}
                                                    <div class="mt-4 mb-4  flex justify-center" >
                                                        <div>
                                                            <button wire:click="$emit('add',{{ json_encode($current_survey_id)}},{{ json_encode($local)}},{{ json_encode($this->surveylanguages) }})"  type="button"
                                                                data-toggle="modal"
                                                                data-target="#addquestion"
                                                             class="bg-blue-400 hover:bg-blue-200 p-2 text-white  text-center items-center rounded-full flex justify-center w-10 h-10 " ><span class="text-lg">+</span></button>

                                                        </div>

                                                    </div>
                                                </ul>


                                        @endforeach
                                        {{-- thanks message  --}}
                                        @if($current_message!=null)
                                        <li   class="list-none mr-1 ml-1 bg-gray-50 p-4 mt-2 hover:bg-slate-100 hover:border-2 hover:border-blue-300  rounded-lg dark:bg-gray-800 " >
                                            <div class="flex justify-end" >

                                                <div class="flex justify-between" >
                                                    <a wire:click="$emit('edit_message',{{ json_encode('thanks') }},{{ json_encode($current_message) }})"  type="button"  data-te-toggle="modal"
                                                    data-te-target="#editmessage"
                                                    data-te-ripple-init
                                                    class="ml-1 mr-1" ><svg class="h-6 w-6 text-black"  viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" /></svg></a>
                                                </div>
                                            </div>
                                            <div class="flex justify-center">
                                                <h1> {{ $current_message->survey_end_header }}</h1>
                                            </div>
                                            <div class="mt-8 flex justify-center">
                                                <h1> {{ $current_message->survey_end_text }}</h1>
                                            </div>


                                        </li>
                                        @endif
                                    {{-- end thanks message --}}
                                </div>



                        </div>


                </div>

            </div>
        @endif



                {{-- edit survey terms modal --}}
                <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="surveyterms" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[1000px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
                      <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
                      outline-none dark:bg-neutral-600">
                       @livewire('surveyterms')
                      </div>
                    </div>
                  </div>
                {{-- add question modal --}}
                <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="addquestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[1000px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
                      <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
                      outline-none dark:bg-neutral-600">
                       @livewire('add-question')
                      </div>
                    </div>
                  </div>
                {{-- edit question modal --}}
                    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="editquestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[1000px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
                        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
                        outline-none dark:bg-neutral-600">
                        @livewire('edit-question')
                        </div>
                        </div>
                    </div>
                  {{-- add survey --}}
                  <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " id="addsurvey" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
                      <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
                      outline-none dark:bg-neutral-600">
                       @livewire('addsurveys')
                      </div>
                    </div>
                  </div>
            {{-- edit messages --}}
            <div  data-te-modal-init class="fixed top-0 left-0 z-[1055] hidden h-full w-full  overflow-x-hidden outline-none"
                    id="editmessage" tabindex="-1" data-te-backdrop="static"
                    data-te-keyboard="false" aria-hidden="true" aria-labelledby="editmessage" aria-modal="true" role="dialog">
                        <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px]
                        items-center opacity-0 transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] ">
                            <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                            @livewire('edit-messages')
                        </div>
                </div>
            </div>


</div>

@push('scripts')
<script src="{{ asset('js/index.min.js')}}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js')}}"></script>
<script defer src="{{ asset('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js')}}" defer></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11')}}"></script>
{{-- detect the start date of expiry  --}}
<script>
    var time = new Date();
    var localTimeStr = time.toLocaleString('en-US', { timeZone: 'Asia/Shanghai' });
    today = new Date(localTimeStr);
    tomorrow = new Date(today.setDate(today.getDate() + 1)).toISOString().split('T')[0];

    document.getElementsByName("expiry-date")[0].setAttribute('min', tomorrow);


</script>
{{-- sweet alert delete confirm --}}
<script>
    // to confirm delete survey
    window.addEventListener('show-delete-confirmation', event => {
        (async () => {

            const { value: accept } = await Swal.fire({
            text: "Deleting the survey will wipe all data,questions ,answers,reviews,scores,and statistics that belong to it, this action cannot be undone!!",
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
                Livewire.emit('deleteConfirmed');
            }

        })()
    });
    //  to confirm delete question
        window.addEventListener('show-question-delete-confirmation', event => {

            (async () => {

            const { value: accept } = await Swal.fire({
                text: "Deleting the question will wipe all data,answers,reviews,scores,and statistics that belong to it, this action cannot be undone!!",
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
                Livewire.emit('deleteQuestionConfirmed');
            }

            })()
        });
        //  to confirm delete language
        window.addEventListener('show-language-delete-confirmation', event => {

            (async () => {

            const { value: accept } = await Swal.fire({
                text: "Deleting the language will wipe all data,questions,answers,reviews,scores,and statistics that belong to it, this action cannot be undone!!",
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
                Livewire.emit('deleteLanguageConfirmed');
            }

            })()
        });
</script>

<script>
// //  close modal edit terms
window.addEventListener('close_modal_edit_terms', event => {
    $('#surveyterms').modal('hide').data('bs.modal', null);
        // $('.modal').remove();
        $('.modal-backdrop').remove();

});
//   close modal add survey
window.addEventListener('close_modal_add_survey', event => {
    //  $("#addsurvey").modal('hide');
     $('#addsurvey').modal('hide').data('bs.modal', null);
        // $('.modal').remove();
        $('.modal-backdrop').remove();
    // $('body').removeClass('modal-open');
    // $('body').removeAttr('style');


});
// end close modal add survey
//   close modal add question
window.addEventListener('close_modal_add_question', event => {
    //  $("#addsurvey").modal('hide');
     $('#addquestion').modal('hide').data('bs.modal', null);
    // $('.modal').remove();
    $('.modal-backdrop').remove();
    // $('body').removeClass('modal-open');


});
// end close modal add question
//   close modal edit question
window.addEventListener('close_modal_edit_question', event => {
    //  $("#addsurvey").modal('hide');
     $('#editquestion').modal('hide').data('bs.modal', null);
    // $('.modal').remove();
    $('.modal-backdrop').remove();
    // $('body').removeClass('modal-open');


});
// end close modal add question
// *******************
// re build carousel after each action
    window.addEventListener('languagesChanged', event => {

        var id="tabs-"+@this.local;
        var tab=document.getElementById(id);

        tab.classList.remove("hidden");
        tab.classList.remove("opacity-0");
        tab.classList.add("opacity-100");


    });

        window.addEventListener('contentChanged', event => {
            var $owl = $('.owl-survey');
            $owl.trigger('destroy.owl.carousel');

           $owl.find('.owl-stage-outer').removeClass('owl-loaded');
            //    $(owl).owlCarousel($(owl).data()); // Initialize Owl carousel once again with same config options

            $owl.owlCarousel({
                loop:false,
            margin:10,
            nav:true,
            responsiveClass:true,
            // navText: ["<div class=''><</div>", "<div class=''>></div>"],

            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:4
                },
                1800:{items:7}
            }
            });

        });

</script>


@endpush
