<div>
    @php
      $count=count($surveys);
    @endphp
    <div class=" grid xs:grid-cols-1 h-full   sm:grid-cols-1 md:grid-cols-12 lg:grid-cols-12 xl:grid-cols-12 2xl:grid-cols-12   gap-4" >
        {{-- info section --}}
        <div class=" xs:row-span-6 sm:col-span-6 md:col-span-6  lg:col-span-6 xl:col-span-6 2xl:col-span-6 bg-white w-auto  p-6  " >
            <div class="container" >
             @if($current_subscribe!=null)
             @php

                 if($current_subscribe->expired_at<now())
                 { $status="Non Active";
                   $color="red";
                 }
                 else
                 { $status="Active";
                   $color="green";
                 }
             @endphp
             @endif

          <h1 class="font-bold text-lg" >{{ __('info') }}</h1>
            @if($current_subscribe!=null)
            <div class="mt-3" >
                <span class=" text-gray-400" >{{ __('My License: ') }} <span class="text-{{ $color }}-400">{{ $status }}</span><span>{{ __('(') }}{{$current_subscribe->type   }}{{ __(')-renewal on ') }}{{ $current_subscribe->expired_at }}</span>
                <a class="text-link" href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">{{ __('Renew now') }}</a>
            </div>
            @endif
            <div class="mt-3" >
                <span class="block text-gray-400" >{{ __('Total Sureys:  ') }}
                <span class="text-bold text-black" >{{ $count }}</span>
                </div>
                </span>
                <div class="mt-20 rounded shadow-xl overflow-hidden w-full xs:flex" style="max-width:600px" x-data="{stockTicker:stockTicker()}" x-init="stockTicker.renderChart()">
                    <div class="flex justify-center " >
                        <span class="text-blue-400" >{{__('Amount of Surveys Submmited')  }}</span>
                    </div>
                    <div  class="flex w-full justify-center  px-5 pb-4 pt-8 bg-btn text-white items-center">
                        <canvas id="chart" class="w-full"></canvas>
                    </div>
                </div>
                <div class=" mt-10" >
                    <span class=" text-black" >{{ __('What ....... ') }}

                </div>
                <div class="mt-20">
                            <h1 class=" font-bold text-lg text-black" > Quick Setup </h1>
                            <ul class="mt-2" >
                                <li class="flex mr-4 ml-4" >
                                    <svg class="p-2 w-10 mb-2" viewBox="0 0 48 48" version="1" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 48 48">
                                        <path fill="#546E7A" d="M44,30H4V11c0-2.2,1.8-4,4-4h32c2.2,0,4,1.8,4,4V30z"/>
                                        <path fill="#64B5F6" d="M40,27H8c-0.6,0-1-0.4-1-1V11c0-0.6,0.4-1,1-1h32c0.6,0,1,0.4,1,1v15C41,26.6,40.6,27,40,27z"/>
                                        <path fill="#78909C" d="M40,41H8c-2.2,0-4-1.8-4-4v-7h40v7C44,39.2,42.2,41,40,41z"/>
                                        <g fill="#37474F">
                                            <rect x="27" y="34" width="12" height="2"/>
                                            <rect x="9" y="34" width="12" height="2"/>
                                            <path d="M18,35c0,1.1-1.3,2-3,2s-3-0.9-3-2H18z"/>
                                        </g>
                                    </svg>
                                    <a href="{{ route('kiosks') }}" class=" p-2"  href=""> {{ __('Link Device') }} </a>
                                </li>
                                <li class="flex mr-4 ml-4">
                                    <svg class="p-2 mb-2 w-10" viewBox="0 0 48 48" version="1" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 48 48">
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
                                    <a href="{{ route('surveys') }}" class="p-2" href="">{{ __('Add Survey') }}</a>
                                </li>
                            </ul>


                </div>


            </div>
        </div>
        {{-- surveys and kiosks section --}}
        <div class="xs:row-span-6 sm:row-span-6 md:col-span-6  lg:col-span-6 xl:col-span-6 2xl:col-span-6   "  >
            {{-- Kiosks sections --}}
            <div class=" container bg-white w-full py-6 px-6 " >
                <div class="flex justify-between" >
                <h1 class="font-bold text-lg" >{{ __('Linked Kiosks') }}</h1>
                 <div class="" >
                     @php
                        $count_kiosks=count($kiosks);
                        $inservice=0;
                        $outofservice=0;
                        foreach ($kiosks as $kiosk) {
                        $kiosk->in_service?$inservice+=1:$outofservice+=1;
                        }

                     @endphp
                    <span class="text-btn text-sm mr-2 ml-2" >{{ __('In Service:') }}{{ $inservice }}</span>
                    <span class="text-btn text-sm mr-2 ml-2 " >{{ __('Out of Service:') }}{{ $outofservice }}</span>
                 </div>
                </div>

                <div class="mt-8 mb-4 container w-full overflow-hidden h-full" >
                    <div class= "mt-4 mb-4 {{ $count_kiosks<3?"h-[200px]":"" }} owl-dashboard owl-carousel owl-theme align-content-center  px-2">

                        @foreach($kiosks as $i => $kiosk)


                            <div  class="item relative  w-full " >

                                            <div class=" px-2 pb-2 border-4 rounded border-double border-gray-700 bg-gray-400 xs:w-full w-full " >
                                            <div class="  flex justify-between  " >
                                                    <div class="col-span-3" >
                                                        <nav @click.outside="open=false" x-data="{ open: false }">
                                                            <button class="text-gray-500 w-10 h-10 relative focus:outline-none " @click="open = !open">
                                                                <span class="sr-only">Open main menu</span>
                                                                <div class="block w-6 absolute left-1/2 top-1/2   transform  -translate-x-1/2 -translate-y-1/2">
                                                                    <span aria-hidden="true" class="block absolute h-0.5 w-6 bg-current transform transition duration-500 ease-in-out" :class="{'rotate-45': open,' -translate-y-1.5': !open }"></span>
                                                                    <span aria-hidden="true" class="block absolute  h-0.5 w-6 bg-current   transform transition duration-500 ease-in-out" :class="{'opacity-0': open } "></span>
                                                                    <span aria-hidden="true" class="block absolute  h-0.5 w-6 bg-current transform  transition duration-500 ease-in-out" :class="{'-rotate-45': open, ' translate-y-1.5': !open}"></span>
                                                                </div>
                                                            </button>
                                                            <ul  @click="open = !open" :class="{'block': open,' hidden': !open } "  class=" bg-yellow-50 border-2 border-black   p-1   overflow-visible absolute " >
                                                                {{-- edit kiosk --}}
                                                                <li class="hover:bg-btn hover:text-white  m-1  "  @click="open = !open">
                                                                   <a href="{{ route('kiosks') }}"  class="hover:text-white no-underline hover:no-underline focus:no-underline" href="">{{ __('Edit') }}</a>

                                                                </li>
                                                                <li class=" m-1 flex align-items-center  ">

                                                                {{ __('In Service') }}
                                                                <label class="ml-1 relative inline-flex items-center cursor-pointer">

                                                                    <input type="checkbox" wire:click="changekioskservice({{ $kiosk->id }})"  value="" {{ $kiosk->in_service?"checked":"" }} class="sr-only peer">
                                                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>

                                                                </label>

                                                                </li>
                                                                {{-- update status --}}
                                                                <li class="hover:bg-btn hover:text-white  m-1  ">
                                                                    <a  class="hover:text-white no-underline hover:no-underline focus:no-underline"  href="">{{ __('Update Status') }}</a>

                                                                </li>
                                                                {{-- change survey --}}
                                                                <li class="hover:bg-btn hover:text-white m-1  " >
                                                                    <a href="{{ route('kiosks') }}" class="hover:text-white no-underline hover:no-underline focus:no-underline"  href="">{{ __('Change Survey') }}</a>

                                                                </li>

                                                            </ul>
                                                        </nav>
                                                    </div>
                                                    <div class="col-span-9 w-100 " >
                                                    <div class=" grid grid-cols-12 ">
                                                        <div class="mr-1 pb-1 text-center text-xs  col-span-6 h-4 " >
                                                        <span class=" text-sm whitespace-nowrap {{ $kiosk->in_service==false?'text-red-500':'text-green-600' }} " >  {{ $kiosk->in_service==false?"offline":"online" }}</span>
                                                        {{-- <div class="border-b-4 w-[40px] ml-1  {{ $i%3==0?'border-red-500':'border-green-600' }} " ></div> --}}
                                                        </div>
                                                        <div class="mr-1 pb-1 text-center text-xs  col-span-6 h-4 " >
                                                            <span class=" text-sm whitespace-nowrap text-bold {{ $kiosk->in_service==false?'text-red-500':'text-green-600' }}" >{{ $kiosk->in_service==false?"out service":"in service" }}</span>
                                                        {{-- <div class="border-b-4 w-[40px] ml-1  {{ $i%2==0?'border-red-500':'border-green-600' }}  " ></div> --}}
                                                        </div>


                                                    </div>
                                                    </div>


                                            </div>
                                            <div class="  grid grid-cols-12 " >
                                                <div class="col-span-3" >

                                                    <svg class=" w-full h-3/4" viewBox="0 0 48 48" version="1" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 48 48">
                                                        <path fill="#546E7A" d="M44,30H4V11c0-2.2,1.8-4,4-4h32c2.2,0,4,1.8,4,4V30z"/>
                                                        <path fill="#64B5F6" d="M40,27H8c-0.6,0-1-0.4-1-1V11c0-0.6,0.4-1,1-1h32c0.6,0,1,0.4,1,1v15C41,26.6,40.6,27,40,27z"/>
                                                        <path fill="#78909C" d="M40,41H8c-2.2,0-4-1.8-4-4v-7h40v7C44,39.2,42.2,41,40,41z"/>
                                                        <g fill="#37474F">
                                                            <rect x="27" y="34" width="12" height="2"/>
                                                            <rect x="9" y="34" width="12" height="2"/>
                                                            <path d="M18,35c0,1.1-1.3,2-3,2s-3-0.9-3-2H18z"/>
                                                        </g>
                                                    </svg>
                                                </div>
                                            <div class="col-span-9" >
                                            <div class=" xs-10 xs:p-2 xs:text-xs text-center   text-sm text-black ">

                                                <div   class="group w-full whitespace-nowrap inline-block overflow-hidden text-ellipsis " >
                                                    <span>{{ $kiosk->device_name }}</span>
                                                    <span  class="px-2 pointer-events-none absolute z-10 bg-white border-2 border-black  top-1/2 left-1/2 w-max opacity-0
                                                    transition-opacity group-hover:opacity-100">{{ $kiosk->device_name }}</span>
                                                </div>
                                                <div   class="group w-full whitespace-nowrap inline-block overflow-hidden text-ellipsis " >
                                                    <span> @if($kiosk->survey_name!=null)
                                                        {{ $kiosk->survey_name }}
                                                        @else
                                                        {{ __('No Survey') }}
                                                        @endif</span>
                                                    <span  class="px-2 pointer-events-none absolute z-10 bg-white border-2 border-black  top-1/2 left-1/2 w-max opacity-0
                                                    transition-opacity group-hover:opacity-100">
                                                    @if($kiosk->survey_name!=null)
                                                    {{ $kiosk->survey_name }}
                                                    @else
                                                    {{ __('No Survey') }}
                                                    @endif
                                                </span>
                                            </div>

                                                <div class="group w-full whitespace-nowrap inline-block overflow-hidden text-ellipsis " >
                                                    <span> {{ ('Device Code: ') }}{{ $kiosk->device_code }}</span>
                                                    <span  class="px-2 pointer-events-none absolute z-10 bg-white border-2 border-black
                                                    top-1/2 left-1/2 w-max opacity-0 transition-opacity group-hover:opacity-100">{{ $kiosk->device_code }}</span>

                                                </div>
                                            </div>
                                            </div>
                                            </div>

                                        </div>

                            </div>
                        @endforeach
                        {{-- add device --}}
                            <div  class="item relative  w-auto " >

                                       <div class=" px-2 pb-2  h-[131px] xs:h[150px]  xs:w-full w-full " >
                                              <div class="mt-2 flex justify-center" >
                                                <a href="{{ route('kiosks') }}">
                                                    <svg class="w-16 h-16 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </a>
                                              </div>
                                             <div class="mt-2 flex justify-center" > <span class="text-blue-400" >{{ __('Add New') }}</span>
                                             </div>
                                       </div>

                            </div>


                    </div>
                </div>

                <div class="{{ $count_kiosks<3?"mt-2":"" }} flex xs:justify-center justify-end ">
                    <a href="{{ route('kiosks') }}" class="bg-btn text-white w-auto h-auto p-2 border-2 rounded-lg " >
                        {{ __('see all') }}
                    </a>
                </div>
            </div>
            {{-- surveys sections --}}
            <div class="mt-4 container bg-white w-auto py-6 px-6  " >
                    <div class="flex justify-between" >
                      <h1 class="font-bold text-lg" >{{ __('Surveys') }}</h1>
                      <div class="" >
                        @php
                            $active_num=0;
                            $inactive_num=0;
                            foreach($surveys as $survey)
                            $survey->active?$active_num+=1:$inactive_num+=1;
                        @endphp
                        <span class="text-btn text-sm mr-2 ml-2" >{{ __('Active:') }}{{ $active_num }}</span>
                        <span class="text-btn text-sm mr-2 ml-2 " >{{ __('Inactive:') }}{{ $inactive_num }}</span>
                       </div>
                    </div>
                    <div class="mt-8 mb-4 container w-full overflow-hidden h-full" >
                        <div class="mt-4 mb-4 owl-dashboard owl-carousel owl-theme align-content-center  px-2">



                        @foreach($surveys as $survey)


                            <div  wire:key="{{ $survey->id }}"    class="  item relative  w-full " >

                                        <div  class=" px-2 pb-2 border-4 rounded border-double border-gray-700 bg-blue-200 xs:w-full w-full " >
                                            <div class=" mb-2   flex justify-between  " >
                                                    <div class="flex items-center justify-center col-span-3 m-1 rounded-full hover:bg-red-300 w-6 h-6" >
                                                        {{-- delete survey
                                                        <a wire:click="deleteConfirmation({{ $survey->id }})" data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('Delete Survey') }}"><svg  class="w-4 h-4 text-red-400 hover:text-red-600 font-bold " fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg></a> --}}
                                                    </div>
                                                <div  class="col-span-9 w-100 " >
                                                 <div class=" flex justify-end ">

                                                    <div class="mr-1 pb-1 text-center text-xs m-1  col-span-6 h-4 " >
                                                        <span class=" text-sm whitespace-nowrap text-bold {{ $survey->active!=true?'text-red-500':'text-green-600' }}" >{{ $survey->active!=true?"InActive":"Active" }}</span>
                                                    </div>


                                                </div>
                                                </div>


                                            </div>
                                            <div class="  grid grid-cols-12 " >
                                                {{-- survey icon --}}
                                                <div  class="col-span-3" >

                                                    <svg   class=" w-full h-3/4" viewBox="0 0 48 48" version="1" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 48 48">
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
                                                <div   class="col-span-9" >
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

                                       <div class=" px-2 pb-2  h-[130px] xs:h[150px]  xs:w-full w-full " >
                                              <div class="mt-2 flex justify-center" >
                                                  @php
                                                      $id=-1;
                                                  @endphp
                                                <a href="{{ route('surveys') }}" class="focus:outline-none"  type="button"
                                                {{-- wire:click="$emit('add_survey',{{ json_encode($main_languages)}},{{ json_encode($messages)}})"
                                                data-toggle="modal"
                                                data-target="#addsurvey" --}}


                                                >
                                                    <svg class="w-16 h-16 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </a>
                                              </div>
                                             <div  class="mt-2 flex justify-center" > <span class="text-blue-400" >{{ __('Add New') }}</span>
                                             </div>
                                       </div>

                            </div>


                        </div>
                    </div>
                    <div class="{{ $count<3?"mt-16  ":"" }} flex xs:justify-center justify-end ">
                        <a href="{{ route('surveys')}}" class="bg-btn text-white w-auto h-auto p-2 border-2 rounded-lg   " >
                            {{ __('see all') }}
                        </a>

                    </div>
            </div>

        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js')}}"></script>
 <script>


            Number.prototype.m_formatter = function() {
                return this > 999999 ? (this / 1000000).toFixed(1) + 'M' : this
            };
            let stockTicker = function() {
                return {

                    chartData: {
                        labels: ['may/2022', '', 'June/2022', '', 'july/2022', '', 'Sep/2022', '', 'oct/2022']
                        , data: [500, 1000, 1500, 0, 0, 1000, 2200, 0, 3000]
                    , }
                    , renderChart: function() {
                        let c = false;

                        Chart.helpers.each(Chart.instances, function(instance) {
                            if (instance.chart.canvas.id == 'chart') {
                                c = instance;
                            }
                        });

                        if (c) {
                            c.destroy();
                        }

                        let ctx = document.getElementById('chart').getContext('2d');

                        let chart = new Chart(ctx, {
                            type: "line"
                            , data: {
                                labels: this.chartData.labels
                                , datasets: [{
                                    label: ''
                                    , backgroundColor: "rgba(255, 255, 255, 0.1)"
                                    , borderColor: "rgba(255, 255, 255, 1)"
                                    , pointBackgroundColor: "rgba(255, 255, 255, 1)"
                                    , data: this.chartData.data
                                , }, ]
                            , }
                            , layout: {
                                padding: {
                                    right: 10
                                }
                            }
                            , options: {
                                legend: {
                                    display: false
                                , }
                                , scales: {
                                    yAxes: [{
                                        ticks: {
                                            fontColor: "rgba(255, 255, 255, 1)"
                                        , }
                                        , gridLines: {
                                            display: false
                                        , }
                                    , }]
                                    , xAxes: [{
                                        ticks: {
                                            fontColor: "rgba(255, 255, 255, 1)"
                                        , }
                                        , gridLines: {
                                            color: "rgba(255, 255, 255, .2)"
                                            , borderDash: [5, 5]
                                            , zeroLineColor: "rgba(255, 255, 255, .2)"
                                            , zeroLineBorderDash: [5, 5]
                                        }
                                    , }]
                                }
                            }
                        });
                    }
                }
            }


     window.addEventListener('contentdashChanged', event => {
        //  carousel

            var $owl = $('.owl-dashboard');
            $owl.trigger('destroy.owl.carousel');
           $owl.find('.owl-stage-outer').removeClass('owl-loaded');
            $owl.owlCarousel({
            loop:false,
            margin:10,
            nav:true,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                },
                1800:{items:3}
            }
            });
            // chart

        });

 </script>
@endpush
