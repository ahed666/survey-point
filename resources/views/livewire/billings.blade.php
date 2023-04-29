<div>
{{-- table of kiosk --}}
<div class="max-h-screen min-h-screen overflow-y-auto">
    {{-- search --}}
    <div class="h-10 mb-2 flex justify-between w-full">
        <div class="relative" data-te-dropdown-ref>
            <a
              class="no-underline focus:no-underline hover:no-underline flex items-center whitespace-nowrap rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
              type="button"
              id="dropdownMenuButton2"
              data-te-dropdown-toggle-ref
              aria-expanded="false"
              data-te-ripple-init
              data-te-ripple-color="light">
              {{ __('Filter') }}
              <span class="ml-2 w-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  class="h-5 w-5">
                  <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd" />
                </svg>
              </span>
            </a>
            <ul
              class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
              aria-labelledby="dropdownMenuButton2"
              data-te-dropdown-menu-ref>
              <li wire:click="setfilter('Paid')">
                <a
                  class="cursor-pointer hover:cursor-pointer no-underline focus:no-underline hover:no-underline block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                  data-te-dropdown-item-ref
                  >Paid</a
                >
              </li>
              <li wire:click="setfilter('notpaid')">
                <a  class="cursor-pointer hover:cursor-pointer no-underline focus:no-underline hover:no-underline block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                  data-te-dropdown-item-ref
                  >Another Status</a>
              </li>
            </ul>
        </div>
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative w-[250px]">
            <div class="absolute inset-y-0 right-0 flex items-center pr-1 pointer-events-none">
                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input wire:model="searchtext"  type="text" id="default-search" class="block w-full p-1 h-full text-sm text-gray-900 border
             border-gray-300 rounded-lg
             focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500
             bg-gray-50" placeholder="Invoice Number,Description,Total,Date" required>
        </div>
    </div>

    {{-- table --}}
    <table class=" table-auto w-full   " >
    {{-- head of table --}}
    <thead class="h-14">
    <tr class="border-b-[1px] border-t-[1px] p-1  bg-blue-400 ">
        <th class="ml-1 mr-1 w-10 "></th>
        <th sortable   class="ml-1 mr-1 w-1/5 xs:text-xs">Invoice Number
        <svg wire:click="sortBy('invoice_no')" class="w-5 h-5 inline-block" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
          </svg>
        </th>
        <th sortable data-order="desc" data-column="invoice_desc" class="ml-1 mr-1 w-1/5 xs:text-xs">Invoice Description
            <svg wire:click="sortBy('invoice_description')" class="w-5 h-5 inline-block" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
            </svg>
        </th>
        <th sortable data-order="desc" data-column="total" class="ml-1 mr-1 w-1/5 xs:text-xs">Total
            <svg wire:click="sortBy('price_ex_tax')" class="w-5 h-5 inline-block" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
            </svg>
        </th>
        <th sortable class="ml-1 mr-1 w-1/5 xs:text-xs">Invoice Date
            <svg wire:click="sortBy('invoice_date')" class="w-5 h-5 inline-block" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
            </svg>
        </th>
        <th sortable class="ml-1 mr-1 w-1/5 xs:text-xs">Status
            <svg wire:click="sortBy('status')" class="w-5 h-5 inline-block" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
            </svg>
        </th>
        <th  class="ml-1 mr-1 w-1/5 xs:text-xs">Options</th>
        {{-- <th class="ml-1 mr-1 w-1/5 xs:text-xs">Device Code</th>
        < --}}
    </tr>
    </thead>
    {{-- bdy of table --}}
    <tbody class="bg-white " >



    @foreach ($invoices as $i=> $invoice )
    <tr class="h-10 min-h-10 max-h-10 w-full {{ ($i)%2==0?"bg-white":"bg-slate-50" }} p-1 border-b-[1px] border-gray-200">
    <td class="  mr-[10px]"><span >{{ $i+1 }}{{ __(')') }}</span></td>
    <td >
        <span class="xs:text-xs">{{ $invoice->invoice_no }}</span>

    </td>
    <td><span  class="xs:text-xs">{{ $invoice->invoice_description }}</span></td>
    <td><span class=" xs:text-xs">{{ $invoice->price_ex_tax }}</span></td>
    {{-- device code --}}
    <td><span  class="xs:text-xs">{{ $invoice->invoice_date }}</span></td>
    {{-- status --}}
    <td> <span class="{{ $invoice->status=="Paid"?"text-green-400":"text-yellow-400" }}  xs:text-xs whitespace-nowrap">{{ $invoice->status }}</span>
    </td>
    {{-- options of Kiosks (delete and survey) --}}
    <td class="  ">
        <div class="flex justify-center items-center 2xl:mr-40 md:mr-30">
            {{-- print invoice --}}
            <a   class="ml-1 mr-1  " >
                <svg class="h-6 w-6 text-black hover:text-green-400 hover:cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 17H5C3.89543 17 3 16.1046 3 15V11C3 9.34315 4.34315 8 6 8H7M7 17V14H17V17M7 17V18C7 19.1046 7.89543 20 9 20H15C16.1046 20 17 19.1046 17 18V17M17 17H19C20.1046 17 21 16.1046 21 15V11C21 9.34315 19.6569 8 18 8H17M7 8V6C7 4.89543 7.89543 4 9 4H15C16.1046 4 17 4.89543 17 6V8M7 8H17M15 11H17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>

        </div>
    </td>
    </tr>
    @endforeach


    </tbody>
    </table>
</div>
</div>
@push('scripts')
    {{-- <script>
        $('th').on('click',function(){
            var column=$(this).data('column')
            var order=$(this).data('order')
            if(order=='asc')
            {$(this).data("order","desc")}
            else
            {$(this).data("order","asc")}
        })
    </script> --}}
@endpush
