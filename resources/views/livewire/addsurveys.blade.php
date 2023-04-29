<div>
    {{-- header --}}
     <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
         <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
             {{ __(' Add Survey ') }}
         </h3>
         <button  wire:click="resetvalue()" type="button"  class="close text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
             items-center dark:hover:bg-gray-600 dark:hover:text-white"  data-dismiss="modal" aria-label="Close">
             <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0
             011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
         </button>
     </div>
 {{-- end header --}}
       {{-- body --}}
        <form wire:submit.prevent="addsurvey">
            @csrf
            <div class="grid grid-cols-12 p-4 gap-2 ">

                    <div class="col-span-8">
                        {{-- survey name --}}
                        <div class="w-full "  >
                            <label  class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap" for="survey-name">Survey Name <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('will show in survey') }}"><svg   class="inline-block text-blue-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                            </svg></a></label>
                            <input type="text" id="survey-name" name="survey_name" class=" w-full  mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                            focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                            dark:text-white dark:focus:ring-blue-500
                            dark:focus:border-blue-500 px-2"  wire:model="survey_Name"  placeholder="NetCore IT Solutions" required>
                            {{-- error on survey name --}}
                            @error('survey_Name') <span class="text-sm text-red-400 error">{{ $message }}</span> @enderror

                            {{-- end on survey name --}}
                        </div>
                        {{-- bussines name --}}
                        <div class="w-full " >
                            <label class="text-black text-sm  xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="branch-name">Business Name
                                <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('will show in survey') }}"><svg   class="inline-block text-blue-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                </svg></a>
                            </label>
                            <input type="text" id="branch-name" name="survey_bname" class=" w-full mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                            focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                            dark:text-white dark:focus:ring-blue-500
                            dark:focus:border-blue-500 px-2" wire:model="survey_BusinessName" placeholder="NetCore IT Solutions" required>

                            {{-- error on business name --}}
                            @error('survey_BusinessName') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
                           {{-- end on business name --}}
                        </div>
                        @if($languages!=null&&$isadd)
                        <div class="w-full " >
                            <label class="text-black text-sm  xs:ml-2 xs:mr-2 w-20 whitespace-nowrap " for="deft_lang">Defult Language
                                <a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __(' add initial language to this survey') }}"><svg   class="inline-block text-blue-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                </svg></a>
                            </label>


                            <select id="deft_lang" name="deft_lang" class=" w-full mr-2  h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                            focus:border-blue-500 block    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                            dark:text-white dark:focus:ring-blue-500
                            dark:focus:border-blue-500 px-2" wire:model="survey_DefultLanguage"  required>
                                <option value="null" >{{ __('Please select') }}</option>
                                @foreach ($this->languages as $lang)
                                    <option value="{{ $lang['code'] }}" wire:key="lang-{{ $lang['id'] }}">{{ $lang['name'] }}</option>
                                @endforeach
                            </select>
                            {{-- error on defult language --}}
                            @error('survey_DefultLanguage') <li class="text-red-400"><span class="text-sm text-red-400 error">{{ $message }}</span></li> @enderror
                             {{-- end on defult language --}}

                        </div>
                        @endif
                    </div>

                <div class="col-span-4 " >


                    {{-- bussines logo --}}
                    <div class=" mr-6 ml-6 " >
                        <label class="text-black text-sm xs:ml-2 xs:mr-2 w-20 whitespace-nowrap" for="branch-name">
                            Business Logo<a data-bs-toggle="tooltip"  data-bs-html="true" title="{{ __('will show in survey') }}"><svg   class="inline-block text-blue-400 w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                            </svg></a></label>
                        <div class="border-2 rounded-lg border-gray-400   max-w-15 w-auto h-auto p-1 pb-0  " >


                        <img  class="object-contain max-h-28 max-w-15" src="{{asset($survey_logo) }}" alt="">
                        <label class="items-center w-6 relative top-[32px] flex   right-[15px]  bg-green-300 border-[1px] rounded-2xl" for="logo">
                            <svg  class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                            </svg>
                        <input   wire:model="logo" class="image opacity-0 absolute -z-10" type="file" name="logo" id="logo" /></label>
                        {{-- <input type="hidden" value={{ $logo }} name="logo_url"> --}}
                        </div>
                    </div>



                </div>
            </div>
            {{-- end body --}}
            {{-- footer --}}

            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button  type="button"
                class="text-white bg-red-400 hover:bg-red-500  font-medium rounded-lg
                text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 ">Cancel</button>
                <button  type="submit"
                class="text-white bg-blue-400  hover:bg-blue-500 font-medium rounded-lg
                text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 ">Save</button>


            </div>
            {{-- end footer --}}
        </form>

        {{-- crop modal --}}
        <div  id="cropimage-survey" data-backdrop="static" class="modal absolute z-[100px] top-[0px] border-[1px] rounded-t-xl border-transparent    h-auto min-h-[calc(100%-1rem)] w-full bg-white  {{ $modal?"block":"hidden" }}">

            <div class="bg-blue-300 h-10 border-[1px] rounded-t-xl border-transparent p-2 flex justify-end modal-header">
            <a wire:click="closemodal" class="hover:bg-red-600 w-10 h-6 cursor-pointer flex justify-center" > <span  class="text-white close ">&times;</span></a>

            </div>
            <!-- Modal content -->
            <div class="box-2  overflow-y-scroll max-h-[400px]">
                <div class=" resultupload w-auto h-auto flex justify-center"></div>
            </div>
            <!--rightbox-->

            <!-- input file -->
            <div class="box flex justify-center bg-white border-t border-gray-200 rounded-b p-6">
                <!-- save btn -->
                <button wire:click="closemodal" class="cursor-pointer ml-2 mr-2 p-2 border-[2px] border-transparent hover:bg-blue-400  rounded-xl bg-blue-500 w-auto">close</button>
                <a wire:click="cropingimage"   class="btn save hide cursor-pointer ml-2 mr-2 p-2 border-[2px] border-transparent hover:bg-blue-400 rounded-xl bg-blue-500 w-auto">Save</a>
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
<script >

   document.addEventListener('survey-image-updated', event =>  {

  result = document.querySelector('.resultupload');
 save = document.querySelector('.save');
 upload = document.querySelector('.image');
 cropper = '';
 var finalCropWidth = 400;
 var finalCropHeight = 200;
 var finalAspectRatio = finalCropWidth / finalCropHeight;
 // on change show image with crop options

         // start file reader
     const reader = new FileReader();
     let img = document.createElement('img');
     img.id = 'image';
     console.log(result);
     img.src = @this.logosrc;
    console.log(img);
                 // clean result before
     result.innerHTML = '';

                 // append new image
     result.appendChild(img);
     console.log(result);
                 // show save btn and options

                 // init cropper
     cropper = new Cropper(img, {
         dragMode: 'move',
         aspectRatio: 2/1,
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
 document.addEventListener('saving',(e)=>{
     e.preventDefault();
     // get result to data uri
     let imgSrc = cropper.getCroppedCanvas({
         width:400,
         height:200
         }).toDataURL();



         @this.SavImage(imgSrc);
         @this.closemodalwithsave();
     // dwn.classList.remove('hide');
     // dwn.download = 'imagename.png';
     // dwn.setAttribute('href',imgSrc);
     });
</script>
@endpush
