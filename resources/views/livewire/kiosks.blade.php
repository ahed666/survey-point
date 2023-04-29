@push('styles')
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
    </style>
@endpush
{{-- wire:loading.class="disabled opacity-50" --}}
<div >
   <div class="grid 2xl:grid-cols-12 xs:grid-rows-12 gap-1 ">
    {{-- list of kiosks  --}}
    <div class="2xl:col-span-9 xs:row-span-8 border-[1px] border-gray-300 rounded-lg  p-[1px] ">
         {{-- Add kiosks & info panel  --}}
         <div class="mt-4 mb-4  flex justify-between pl-4 pr-4" >
            <div>
                <button  type="button"
                data-toggle="modal"
                data-target="#adddevice"

                 class="ml-3 focus:outline-none bg-blue-400 hover:bg-blue-200 p-2 text-white
                  text-center items-center rounded-full flex justify-center w-10 h-10 " ><span class="text-lg">+</span></button>
                <div class="flex justify-center">
                    <span class="mt-1 text-black">{{ __('Add New') }}</span>
                </div>
            </div>
            {{-- Info Panel --}}
            <div class="flex xs:block">
                {{-- total kiosks --}}
                @php
                    $total=count($kiosks);
                    $inservice=0;
                    $outofservice=0;
                    foreach ($kiosks as $kiosk) {
                       $kiosk->in_service?$inservice+=1:$outofservice+=1;
                    }



                @endphp
              <div class="ml-2 mr-2   h-16 w-32 border-[1px] border-gray-300 rounded-lg bg-yellow-400">
                <div class="flex justify-center  items-center"><span class=" font-bold ">Total</span></div>
                <div class="flex justify-center  items-center mt-1"><span>{{ $total }}</span></div>
              </div>
                {{-- in service --}}
               <div class="ml-2 mr-2  h-16 w-32 border-[1px] border-gray-300 rounded-lg bg-green-400">
                 <div class="flex justify-center  items-center"><span class=" font-bold ">In Service</span></div>
                 <div class="flex justify-center  items-center mt-1"><span>{{ $inservice }}</span></div>
               </div>
               {{-- out of service --}}
               <div class="ml-2 mr-2   h-16 w-32 border-[1px] border-gray-300 rounded-lg bg-red-400">
                <div class="flex justify-center  items-center"><span class=" font-bold ">Out Of Service</span></div>
                <div class="flex justify-center  items-center mt-1"><span>{{ $outofservice }}</span></div>
              </div>


            </div>

        </div>
        {{-- table of kiosk --}}
        <div class="max-h-screen min-h-screen xs:min-h-min overflow-y-auto">
            <table class=" table-auto w-full   " >
            {{-- head of table --}}
            <thead class="h-14">
            <tr class="border-b-[1px] border-t-[1px] p-1  bg-blue-400 ">
                <th class="ml-1 mr-1 w-10 "></th>
                <th  class="ml-1 mr-1 w-1/5 xs:text-xs">Device Name</th>
                <th class="ml-1 mr-1 w-1/5 xs:text-xs">Survey Name</th>
                <th class="ml-1 mr-1 w-1/5 xs:text-xs">Status</th>
                <th class="ml-1 mr-1 w-1/5 xs:text-xs">Service</th>
                <th class="ml-1 mr-1 w-1/5 xs:text-xs">Device Code</th>
                <th class="ml-1 mr-1 w-1/5 xs:text-xs">Options</th>
            </tr>
            </thead>
            {{-- bdy of table --}}
            <tbody class="bg-white " >



            @foreach ($kiosks as $i=> $kiosk )
            <tr class="h-10 min-h-10 max-h-10 w-full {{ ($i)%2==0?"bg-white":"bg-slate-50" }} p-1 border-b-[1px] border-gray-200">
            <td class="  mr-[10px]"><span >{{ $i+1 }}{{ __(')') }}</span></td>
            <td >
                <span class="xs:text-xs">{{ $kiosk->device_name }}</span>

            </td>
            <td><span  class="xs:text-xs">{{ $kiosk->survey_name }}{{ $kiosk->survey_name }}{{ $kiosk->survey_name }}{{ $kiosk->survey_name }}</span></td>
            <td><button wire:click="$emitTo('SurveyTemplate','refresh',{{ $kiosk->id }})">refresh</button></td>
            <td><span class="{{ $kiosk->in_service?"text-green-400":"text-red-400" }} font-bold xs:text-xs">
                {{ $kiosk->in_service?"In Service":"Out Of Service" }}</span></td>
            {{-- device code --}}
            <td><span  class="xs:text-xs">{{ $kiosk->device_code }}</span></td>
            {{-- options of Kiosks (delete and survey) --}}
            <td class="  mr-[10px]">
                <div class="flex justify-center items-center">
                    {{-- delete kiosks --}}
                    <a wire:click="deletedeviceConfirmation({{ $kiosk->id }})"  class="ml-1 mr-1   hover:text-red-400" ><svg class="h-6 w-6 text-black hover:text-red-400 hover:cursor-pointer"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"
                        stroke-linejoin="round">  <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" /></svg></a>
                    {{-- edit kiosks --}}

                    <a    type="button"
                    wire:click="edit({{ $kiosk->id }})"
                    class="ml-1 mr-1" ><svg class="h-6 w-6 text-black"  viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                    <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" /></svg></a>
                </div>
            </td>
            </tr>
            @endforeach


            </tbody>
            </table>
        </div>
    </div>
    {{-- Kiosk info  --}}
    <div wire:loading.class="opacity-50" wire:target="editdevice" class="2xl:col-span-3 xs:row-span-4 border-[1px] border-gray-300 rounded-lg  p-[1px] mb-1">
            {{-- header  --}}
            <div class="flex justify-center p-2">
                <span class="text-md font-bold">{{ __('Device Information') }}</span>
            </div>
            @if($ifedit==true)

            {{-- button of check --}}
            {{-- <div class="flex justify-center">
                <button {{ $validcode?"":"disabled" }}  wire:click="checkdevicecode"
                class="{{ $showmessage?"hidden":"" }} text-white bg-blue-400  hover:bg-blue-500 font-medium rounded-lg
                text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 ">Check</button>
            </div> --}}
            <form wire:submit.prevent="editdevice">
                @csrf
                <div >

                    {{-- Device Name --}}
                    <div class="w-full p-2 "  >
                        <label  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="device_name">{{ __('Device Name') }}
                            <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('will show in survey') }}">
                                <svg   class="inline-block text-blue-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                            </svg>
                            </a>

                        </label>
                        <input  type="text"  wire:model="currentNameDevice" class=" w-full  mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                        dark:text-white dark:focus:ring-blue-500
                        dark:focus:border-blue-500 px-2" minlength="2" maxlength="25"   placeholder="device name" required>
                        {{-- error on device name --}}
                        @error('deviceName') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror


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

                        <select  id="" name="" class=" w-full mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                        dark:text-white dark:focus:ring-blue-500
                        dark:focus:border-blue-500 px-2" wire:model="currentSurveyId"  >
                            <option value="" >{{ __('Please select') }}</option>
                            @if($surveys!=null)
                            @foreach ($this->surveys as $survey)
                                <option value="{{ $survey->id }}">{{ $survey->survey_name}}</option>
                            @endforeach
                            @endif

                        </select>
                         {{-- {{ $test }}
                        <select name="" id="" wire:model="currentSurveyId">
                            <option value="" >{{ __('Please select') }}</option>
                            @if($surveys!=null)
                            @foreach ($this->surveys as $survey)
                                <option value="{{ $survey->id }}">{{ $survey->survey_name}}</option>
                            @endforeach
                            @endif
                        </select> --}}



                    </div>
                    {{-- In service --}}
                    <div class="w-full p-2 mt-4"  >

                        <div class="flex justify-start space-x-1" >
                        <span class="text-black  text-sm " >{{ __('In Service') }}</span>



                                <label class="ml-2 relative inline-flex items-center cursor-pointer">

                                <input {{ $currentSurveyId!=""?"":"disabled" }}  type="checkbox"  value=""  class="sr-only peer"
                                {{ $currentInService?"checked":"" }} wire:model="currentInService">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none  dark:peer-focus:ring-blue-800
                                rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute
                                after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all
                                    dark:border-gray-600 peer-checked:bg-blue-600"></div>

                                </label>
                        </div>
                    </div>
                </div>
                {{-- button of save  --}}
                <div class="flex justify-center">
                    <button wire:click="resetvalues"  type="button"
                    class="text-white bg-red-400 hover:bg-red-500  font-medium rounded-lg
                    text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 ml-2 mr-2 ">Cancel</button>
                    <button  type="submit"
                    class=" text-white bg-blue-400  hover:bg-blue-500 font-medium rounded-lg
                    text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700  ml-2 mr-2">Save</button>
                </div>
            </form>

         @endif
    </div>
   </div>
   {{-- add device modal --}}

    <div  class="modal fade fixed top-0 left-0 z-[1055]  h-full w-full  " data-backdrop="static" data-keyboard="false" id="adddevice" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  min-h-[calc(100%-1rem)] w-full max-w-[800px] translate-y-[-50px] items-center  transition-all duration-10 ease-out-in min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)]" role="document">
        <div class="modal-content  w-full flex-col rounded-md border-none  bg-clip-padding text-current shadow-lg
        outline-none dark:bg-neutral-600">

          @livewire('add-device')

        </div>
        </div>
    </div>

  {{-- end add device modal --}}
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    //  to confirm delete language
    window.addEventListener('show-device-delete-confirmation', event => {

        (async () => {

        const { value: accept } = await Swal.fire({
            text: "You will no longer have control of this kiosk(device),this kiosk will be factory reset",
        input: 'checkbox',
        inputValue: 0,
        icon:'question',
        confirmButtonColor: '#3085d6',
        showCancelButton: true,
        inputPlaceholder:
        'Are you sure you want to delete it',
        confirmButtonText:
            'Delete ',
        inputValidator: (result) => {
            return !result && 'Checkbox is required'
        }
        })

        if (accept) {
            Livewire.emit('deleteDeviceConfirmed');
        }

        })()
    });
    //   close modal add device
    window.addEventListener('close_modal_add_device', event => {
        $('#adddevice').modal('hide').data('bs.modal', null);
        $('.modal-backdrop').remove();
    });
    </script>
@endpush
