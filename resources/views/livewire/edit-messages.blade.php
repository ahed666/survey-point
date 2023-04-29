<div>
        {{-- header --}}
        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ __(' edit ') }}{{ $type }}{{ __(' message') }}
            </h3>
            <button  wire:click="resetvalue()" type="button"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                items-center dark:hover:bg-gray-600 dark:hover:text-white" data-te-modal-dismiss
                aria-label="Close">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
                011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
    {{-- end header --}}
          {{-- body --}}
        <form wire:submit.prevent="edit">
           @csrf
            <div class="grid grid-cols-12 p-4 gap-2 ">

                    <div class="col-span-12">
                        {{-- header --}}
                        <div class="w-full "  >
                            <label  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 " for="survey-name">{{ __('Header') }}<a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('will show in survey') }}"><svg   class="inline-block text-blue-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                            </svg></a></label>
                            <input type="text" id="survey-name" name="survey_name" class=" w-full  mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                            focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                            dark:text-white dark:focus:ring-blue-500
                            dark:focus:border-blue-500 px-2"  wire:model="header"  placeholder="NetCore IT Solutions" required>
                        </div>
                        {{-- text --}}
                        <div class="w-full " >
                            <label class="text-black text-sm  xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="branch-name">{{ __('Text') }}
                                <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('will show in survey') }}"><svg   class="inline-block text-blue-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                </svg></a>
                            </label>
                            <input type="text" id="branch-name" name="survey_bname" class=" w-full mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                            focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                            dark:text-white dark:focus:ring-blue-500
                            dark:focus:border-blue-500 px-2" wire:model="text" placeholder="NetCore IT Solutions" required>
                        </div>

                    </div>


            </div>
            {{-- end body --}}
            {{-- footer --}}

            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-te-modal-dismiss
                aria-label="Close" type="button"
                class="text-white bg-red-400 hover:bg-red-500  font-medium rounded-lg
                text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 ">Cancel</button>
                <button type="submit" data-te-modal-dismiss
                aria-label="Close"
                class="text-white bg-blue-400  hover:bg-blue-500 font-medium rounded-lg
                text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 ">Save</button>


            </div>
            {{-- end footer --}}
        </form>
</div>
