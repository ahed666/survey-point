<div>
   {{-- header --}}
   <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
        {{ __(' Add Device ') }}
    </h3>
    <button   type="button"  class="close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
        items-center dark:hover:bg-gray-600 dark:hover:text-white" wire:click="resetvalues()" data-dismiss="modal" aria-label="Close">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
        011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </button>
</div>
{{-- end header --}}

    <form wire:submit.prevent="adddevice">
        @csrf
        {{-- body --}}
        {{-- device code --}}
        <div class="w-full p-2 "  >
            <label  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="device_code">{{ __('Device Code') }}
                <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('will show in survey') }}">
                    <svg   class="inline-block text-blue-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                </svg>
                </a>

            </label>
            <input type="number" id="device_code" name="device_code" wire:model="deviceCode" class=" w-full  mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
            focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
            dark:text-white dark:focus:ring-blue-500
            dark:focus:border-blue-500 px-2" minlength="6" maxlength="6"   placeholder="000000" required>
            {{-- error on device code --}}
            @error('deviceCode') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror


        </div>
        {{-- end of device code --}}
        <div class="{{ $showmessage?"block":"hidden" }}">
            <div class="flex justify-between p-2">
                <span class="{{$isavilable?"block":"hidden"  }} text-green-400">{{ __('Avilable') }}</span>
                <span class="{{$isavilable==false?"block":"hidden"  }} text-red-400">{{ __('Not Avilable') }}</span>
                {{-- <button wire:click="resetdevicecode" class="text-white bg-blue-400  hover:bg-blue-500 font-medium rounded-lg
                text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700">Reset</button> --}}
            </div>

        </div>
        <div {{$isavilable==false?"disabled ":""  }} class="{{$isavilable==false?"opacity-50 ":""  }}">
            {{-- Device Name --}}
            <div class="w-full p-2 "  >
                <label  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="device_name">{{ __('Device Name') }}
                    <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('will show in survey') }}">
                        <svg   class="inline-block text-blue-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                    </svg>
                    </a>

                </label>
                <input {{$isavilable==false?"disabled":""}} type="text" id="device_name" name="device_name" wire:model="currentNameDevice" class=" w-full  mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-blue-500
                dark:focus:border-blue-500 px-2" minlength="2" maxlength="25"   placeholder="device name" required>
                {{-- error on device code --}}
                @error('currentNameDevice') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror


            </div>
            {{--Survey  --}}
            <div class="w-full p-2 "  >
                <label  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="device_code">{{ __('Survey') }}
                    <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('will show in survey') }}">
                        <svg   class="inline-block text-blue-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                    </svg>
                    </a>

                </label>

                <select {{$isavilable==false?"disabled ":""  }} id="survey" name="survey" class=" w-full mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-blue-500
                dark:focus:border-blue-500 px-2" wire:model="currentSurveyId"  >
                    <option value="" >{{ __('Please select') }}</option>
                    @if($surveys!=null)
                    @foreach ($this->surveys as $survey)
                    <option value="{{ $survey->id }}" wire:key="survey-{{$survey->id}}" >{{ $survey->survey_name}}</option>
                    @endforeach
                    @endif

                </select>



            </div>
            {{-- In service --}}
            <div class="w-full p-2 mt-4"  >

                <div class="flex justify-start space-x-1" >
                    <span class="text-black  text-sm " >{{ __('In Service') }}</span>



                    <label class="ml-2 relative inline-flex items-center cursor-pointer">

                    <input {{ $currentSurveyId!=""?"":"disabled" }} {{$isavilable==false?"disabled ":""  }} type="checkbox"  value=""  class="sr-only peer"
                    {{ $currentInService?"checked":"" }} wire:model="currentInService">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none  dark:peer-focus:ring-blue-800
                    rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                    after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                        dark:border-gray-600 peer-checked:bg-blue-600"></div>

                    </label>
                </div>
            </div>
        </div>

    {{-- end body  --}}
    {{-- footer --}}

        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button  type="button" wire:click="resetvalues()" data-dismiss="modal" aria-label="Close"
            class="text-white bg-red-400 hover:bg-red-500  font-medium rounded-lg
            text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 ">Cancel</button>
            <button  type="submit"
            class="text-white bg-blue-400  hover:bg-blue-500 font-medium rounded-lg
            text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 ">Save</button>


        </div>
    </form>
{{-- end footer --}}
</div>
