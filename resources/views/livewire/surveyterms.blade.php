<div>
    {{-- header --}}
    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            {{ __(' Edit Terms ') }}
        </h3>
        <button   type="button" wire:click="resetvalue()"  class="close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
            items-center dark:hover:bg-gray-600 dark:hover:text-white"  data-dismiss="modal" aria-label="Close">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
            011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </div>
{{-- end header --}}
      {{-- body --}}
       <form wire:submit.prevent="editterms"   >

           <div class="flex items-center justify-center p-2 max-h-[600px]  ">
               <textarea class="max-h-[500px] overflow-auto {{ $local=='en'||$local=='tl'?"text-left":"text-right " }}" wire:model="terms" name="" id="" cols="80" rows="200">

                </textarea>

           </div>
           {{-- end body --}}
           {{-- footer --}}

           <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
               <button data-dismiss="modal" aria-label="Close" wire:click="resetvalue()"  type="button"
               class="text-white bg-red-400 hover:bg-red-500  font-medium rounded-lg
               text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 ">Cancel</button>
               <button  type="submit"
               class="text-white bg-blue-400  hover:bg-blue-500 font-medium rounded-lg
               text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 ">Save</button>


           </div>
           {{-- end footer --}}
       </form>


</div>
