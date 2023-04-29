<nav x-data="{ open: false }" class="p-4  xs:bg-white    items-center dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <div class="flex justify-between " >
        <span
        class="ml-2 mt-2   flex w-16 h-12 text-white text-4xl top-5 left-5 cursor-pointer"
        onclick="openSidebar()">
            <svg class=" bg-gray-900 rounded-md"  fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
            </svg>

        </span>
        <a  class=" lg:hidden 2xl:hidden " href="{{ route('dashboard') }}">
            <img class="block h-16 w-32 object-contain text-gray-800 dark:text-gray-200" viewbox="0 0 58 58" fill="none" src="{{asset('images/logo_1_transparent.png')}}" alt="">

              </a>

    </div>
    {{-- <a  href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"  class="material-icons self-center ml-1 mr-1">
                        settings
                    </a> --}}
    <div class="sidebar fixed z-10 top-0 bottom-0 lg:left-0 p-2 xs:left-0 w-[300px] overflow-y-auto text-center bg-gray-900">
        <div class="text-gray-100 text-xl">
            <div class="">
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="ml-6 relative flex items-center justify-end mr-6">
                    {{-- settings --}}
                    {{-- <div class="relative" data-te-dropdown-ref>
                        <button
                            class="flex items-center whitespace-nowrap rounded  px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal
                            text-white  transition duration-150 ease-in-out
                            focus:outline-none
                            motion-reduce:transition-none"
                            type="button"
                            id="dropdownMenusettings"
                            data-te-dropdown-toggle-ref
                            aria-expanded="false"
                            data-te-ripple-init
                            data-te-ripple-color="light">

                            <span class="ml-2 w-6">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </span>
                        </button>
                        <ul class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                            aria-labelledby="dropdownMenusettings"
                            data-te-dropdown-menu-ref>
                            {{-- Account setting  --}}
                            {{-- <li><a
                                class="no-underline hover:no-underline focus:no-underline block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                                data-te-dropdown-item-ref
                                >{{ __('Account Setting') }}</a>
                            </li>
                             {{-- Profile Setting  --}}
                            {{-- <li>
                                <a
                                class="no-underline hover:no-underline focus:no-underline block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                href="{{ route('profile.edit') }}"
                                data-te-dropdown-item-ref
                                >{{ __('Profile Setting') }}</a>
                            </li> --}}
                             {{-- Billings  --}}
                            {{-- <li><a
                                class=" no-underline hover:no-underline focus:no-underline block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                href="{{ route('billings') }}"
                                data-te-dropdown-item-ref
                                >{{ __('Billings') }}</a>
                            </li> --}}
                            {{-- Subscriptions  --}}
                            {{-- <li><a
                                class="no-underline hover:no-underline focus:no-underline block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                href="{{ route('subscriptions') }}"
                                data-te-dropdown-item-ref
                                >{{ __('Subscriptions') }}</a>
                            </li>
                        </ul>
                    </div>  --}}
                    {{-- accounts --}}
                    <x-jet-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <span class="inline-flex  rounded-md">

                                <button type="button" class="no-underline hover:no-underline focus:no-underline focus:outline-none inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                      {{ Auth::user()->currentTeam->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-60">


                                <div class="border-t border-gray-100"></div>

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Switch Accounts') }}
                                </div>

                                @foreach (Auth::user()->allTeams() as $team)

                                    <x-jet-switchable-team :team="$team" />
                                @endforeach
                            </div>
                        </x-slot>
                    </x-jet-dropdown>


                </div>
                 @endif
            <svg onclick="openSidebar()"  class="cursor-pointer ml-28 w-8 h-8 lg:hidden 2xl:hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>

            </div>
            <div class="my-2 bg-gray-600 h-[1px]"></div>
        </div>
        <div class="p-2.5 flex items-center justify-center rounded-md px-4 duration-300 cursor-pointer  text-white">

             <a  href="{{ route('dashboard') }}">
            <img class="block h-16 w-32 fill-current text-gray-800 dark:text-gray-200" viewbox="0 0 58 58" fill="none" src="{{asset('images/logo_1_transparent.png')}}" alt="">

              </a>
        </div>
        {{-- dashboard --}}
        <div style="{{ (request()->is('dashboard')) ? 'background-color:#1976D2' : '' }}"  class="p-2.5 mt-20 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-blue-600 text-white">
            <svg class="w-10" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none">

                <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                <g id="SVGRepo_iconCarrier"> <path stroke="#ffffff" stroke-width="2" d="M4 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5ZM14 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V5ZM4 16a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3ZM14 13a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-6Z"/> </g>

            </svg>
            <x-dropdown-link  class="no-underline hover:no-underline focus:no-underline" :href="route('dashboard')" :active="request()->routeIs('dashboard')">

            <span class="text-[15px] ml-4 text-gray-200 text-center font-bold">  {{ __('Dashboard') }}</span></x-dropdown-link>
        </div>
        {{-- statistics --}}
        <div style="{{ (request()->is('statistics')) ? 'background-color:#1976D2' : '' }}" class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
            <svg class="w-10" version="1.1" id="STATISTICS" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  viewBox="0 0 1800 1800" enable-background="new 0 0 24 24" xml:space="preserve" fill="#ffffff" stroke="#ffffff">

                <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                <g id="SVGRepo_iconCarrier"> <g> <g> <g> <path fill="#ffffff" d="M152.728,528.008c-63.267,0-114.738-51.469-114.738-114.733c0-63.265,51.472-114.734,114.738-114.734 c63.262,0,114.729,51.469,114.729,114.734C267.457,476.539,215.99,528.008,152.728,528.008z M152.728,360.752 c-28.962,0-52.526,23.562-52.526,52.522s23.563,52.521,52.526,52.521c28.958,0,52.517-23.562,52.517-52.521 S181.686,360.752,152.728,360.752z"/> </g> <g> <path fill="#ffffff" d="M1124.017,703.674c-63.267,0-114.738-51.465-114.738-114.725c0-63.267,51.472-114.738,114.738-114.738 c63.262,0,114.729,51.472,114.729,114.738C1238.745,652.209,1187.278,703.674,1124.017,703.674z M1124.017,536.423 c-28.963,0-52.526,23.563-52.526,52.526c0,28.956,23.563,52.513,52.526,52.513c28.957,0,52.517-23.558,52.517-52.513 C1176.533,559.986,1152.974,536.423,1124.017,536.423z"/> </g> <g> <path fill="#ffffff" d="M638.373,391.099c-103.739,0-188.138-84.396-188.138-188.133S534.634,14.833,638.373,14.833 c103.733,0,188.125,84.396,188.125,188.133S742.106,391.099,638.373,391.099z M638.373,77.045 c-69.435,0-125.926,56.488-125.926,125.921c0,69.433,56.491,125.921,125.926,125.921c69.429,0,125.913-56.488,125.913-125.921 C764.286,133.533,707.802,77.045,638.373,77.045z"/> </g> <g> <path fill="#ffffff" d="M1609.674,391.099c-103.737,0-188.137-84.396-188.137-188.133s84.399-188.133,188.137-188.133 c103.733,0,188.129,84.396,188.129,188.133S1713.407,391.099,1609.674,391.099z M1609.674,77.045 c-69.437,0-125.925,56.488-125.925,125.921c0,69.433,56.488,125.921,125.925,125.921c69.429,0,125.917-56.488,125.917-125.921 C1735.591,133.533,1679.103,77.045,1609.674,77.045z"/> </g> <g> <rect x="332.296" y="178.864" transform="matrix(0.4637 0.886 -0.886 0.4637 480.4105 -149.1437)" fill="#ffffff" width="62.214" height="286.801"/> </g> <g> <rect x="721.561" y="398.765" transform="matrix(0.767 0.6417 -0.6417 0.767 488.2679 -484.7798)" fill="#ffffff" width="380.063" height="62.211"/> </g> <g> <polygon fill="#ffffff" points="1216.137,584.88 1176.993,536.524 1473.117,296.842 1512.26,345.197 "/> </g> </g> <g> <path fill="#ffffff" d="M223.333,1785.167H82.119c-44.068,0-79.922-36.348-79.922-81.023V761.958 c0-44.678,35.854-81.024,79.922-81.024h141.214c44.068,0,79.921,36.346,79.921,81.024v942.185 C303.254,1748.819,267.401,1785.167,223.333,1785.167z M82.119,743.146c-9.767,0-17.71,8.438-17.71,18.812v942.185 c0,10.371,7.943,18.812,17.71,18.812h141.214c9.766,0,17.709-8.44,17.709-18.812V761.958c0-10.374-7.944-18.812-17.709-18.812 H82.119z"/> </g> <g> <path fill="#ffffff" d="M708.974,1785.167H567.755c-44.066,0-79.917-38.839-79.917-86.578V651.512 c0-47.74,35.852-86.579,79.917-86.579h141.218c44.066,0,79.917,38.839,79.917,86.579v1047.077 C788.891,1746.328,753.04,1785.167,708.974,1785.167z M567.755,627.146c-9.597,0-17.706,11.159-17.706,24.367v1047.077 c0,13.209,8.108,24.366,17.706,24.366h141.218c9.597,0,17.705-11.157,17.705-24.366V651.512c0-13.208-8.108-24.367-17.705-24.367 H567.755z"/> </g> <g> <path fill="#ffffff" d="M1194.621,1785.167h-141.21c-44.072,0-79.926-31.604-79.926-70.452V972.037 c0-38.848,35.854-70.453,79.926-70.453h141.21c44.072,0,79.926,31.605,79.926,70.453v742.678 C1274.547,1753.563,1238.693,1785.167,1194.621,1785.167z M1053.411,963.796c-11.43,0-17.714,6.188-17.714,8.241v742.678 c0,2.053,6.284,8.24,17.714,8.24h141.21c11.431,0,17.714-6.188,17.714-8.24V972.037c0-2.053-6.283-8.241-17.714-8.241H1053.411z"/> </g> <g> <path fill="#ffffff" d="M1680.271,1785.167h-141.219c-44.067,0-79.917-38.839-79.917-86.578V651.512 c0-47.74,35.85-86.579,79.917-86.579h141.219c44.072,0,79.926,38.839,79.926,86.579v1047.077 C1760.196,1746.328,1724.343,1785.167,1680.271,1785.167z M1539.052,627.146c-9.599,0-17.705,11.159-17.705,24.367v1047.077 c0,13.209,8.106,24.366,17.705,24.366h141.219c9.604,0,17.714-11.157,17.714-24.366V651.512c0-13.208-8.11-24.367-17.714-24.367 H1539.052z"/> </g> </g> </g>

            </svg>
            <x-dropdown-link class="flex no-underline hover:no-underline focus:no-underline"  :href="route('statistics')" :active="request()->routeIs('statistics')">

            <span class="text-[15px] ml-4 text-gray-200 text-center font-bold">  {{ __('Statistics') }}</span></x-dropdown-link>
        </div>
        {{-- surveys --}}
        <div style="{{ (request()->is('surveys')) ? 'background-color:#1976D2' : '' }}" class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
            <svg class="w-10" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff">

                <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                <g id="SVGRepo_iconCarrier"> <g> <path fill="none" d="M0 0L24 0 24 24 0 24z"/> <path d="M17 2v2h3.007c.548 0 .993.445.993.993v16.014c0 .548-.445.993-.993.993H3.993C3.445 22 3 21.555 3 21.007V4.993C3 4.445 3.445 4 3.993 4H7V2h10zM7 6H5v14h14V6h-2v2H7V6zm2 10v2H7v-2h2zm0-3v2H7v-2h2zm0-3v2H7v-2h2zm6-6H9v2h6V4z"/> </g> </g>

                </svg>
            <x-dropdown-link class="flex no-underline hover:no-underline focus:no-underline"  :href="route('surveys')" :active="request()->routeIs('surveys')">

            <span class="text-[15px] ml-4 text-gray-200 text-center font-bold">  {{ __('My Surveys') }}</span></x-dropdown-link>
        </div>
        {{-- kiosks --}}
        <div  style="{{ (request()->is('kiosks')) ? 'background-color:#1976D2' : '' }}" class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300  cursor-pointer hover:bg-blue-600 text-white">
            <svg class="w-10" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">

                <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                <g id="SVGRepo_iconCarrier"> <title>device_line</title> <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Device" transform="translate(-288.000000, 0.000000)" fill-rule="nonzero"> <g id="device_line" transform="translate(288.000000, 0.000000)"> <path d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z" id="MingCute" fill-rule="nonzero"> </path> <path d="M17,4 C18.0543909,4 18.9181678,4.81587733 18.9945144,5.85073759 L19,6 L19,8 L20,8 C21.0543909,8 21.9181678,8.81587733 21.9945144,9.85073759 L22,10 L22,19 C22,20.0543909 21.18415,20.9181678 20.1492661,20.9945144 L20,21 L16,21 C15.3166462,21 14.713387,20.657297 14.3526403,20.1343876 L14.2676,20 L4,20 C2.94563773,20 2.08183483,19.18415 2.00548573,18.1492661 L2,18 L2,6 C2,4.94563773 2.81587733,4.08183483 3.85073759,4.00548573 L4,4 L17,4 Z M20,10 L16,10 L16,19 L20,19 L20,10 Z M17,6 L4,6 L4,18 L14,18 L14,10 C14,8.89543 14.8954,8 16,8 L17,8 L17,6 Z" id="形状" fill="#ffffff"> </path> </g> </g> </g> </g>

                </svg>
            <x-dropdown-link class="flex no-underline hover:no-underline focus:no-underline" :href="route('kiosks')" :active="request()->routeIs('kiosks')">

            <span class="text-[15px] ml-4 text-gray-200 text-center font-bold">  {{ __('My Kiosks') }}</span></x-dropdown-link>
        </div>
        {{-- Account Settings --}}
        <div style="{{ (request()->is('teams.show')) ? 'background-color:#1976D2' : '' }}"  class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer   hover:bg-blue-600 text-white">
            <svg class="w-10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

                <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                <g id="SVGRepo_iconCarrier"> <g id="style=doutone"> <g id="setting"> <path id="vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M12 9.75C10.7574 9.75 9.75 10.7574 9.75 12C9.75 13.2426 10.7574 14.25 12 14.25C13.2426 14.25 14.25 13.2426 14.25 12C14.25 10.7574 13.2426 9.75 12 9.75ZM8.25 12C8.25 9.92893 9.92893 8.25 12 8.25C14.0711 8.25 15.75 9.92893 15.75 12C15.75 14.0711 14.0711 15.75 12 15.75C9.92893 15.75 8.25 14.0711 8.25 12Z" fill="#0f2bff"/> <path id="vector (Stroke)_2" fill-rule="evenodd" clip-rule="evenodd" d="M9.60347 3.77018C9.3358 3.32423 8.77209 3.18551 8.35347 3.43457L8.34256 3.44105L6.61251 4.43096C6.06514 4.74375 5.8763 5.45289 6.1894 5.9948L5.54 6.37001L6.18888 5.99391C6.72395 6.91704 6.86779 7.92882 6.38982 8.75823C5.91192 9.58753 4.96479 9.97001 3.9 9.97001C3.26678 9.97001 2.75 10.4917 2.75 11.12V12.88C2.75 13.5084 3.26678 14.03 3.9 14.03C4.96479 14.03 5.91192 14.4125 6.38982 15.2418C6.86773 16.0711 6.72398 17.0827 6.18909 18.0058C5.87642 18.5476 6.06491 19.2561 6.6121 19.5688L8.35352 20.5654C8.77214 20.8144 9.33577 20.6758 9.60345 20.2299L9.71093 20.0442C10.2458 19.1214 11.052 18.4925 12.0087 18.4925C12.9662 18.4925 13.77 19.1219 14.3 20.0458C14.3002 20.0462 14.3004 20.0466 14.3007 20.047L14.4065 20.2298C14.6742 20.6758 15.2379 20.8145 15.6565 20.5655L15.6674 20.559L17.3975 19.5691C17.9434 19.2571 18.1351 18.5578 17.8198 18.0038C17.2858 17.0813 17.1426 16.0705 17.6202 15.2418C18.0981 14.4125 19.0452 14.03 20.11 14.03C20.7432 14.03 21.26 13.5084 21.26 12.88V11.12C21.26 10.4868 20.7384 9.97001 20.11 9.97001C19.0452 9.97001 18.0981 9.58753 17.6202 8.75824C17.1423 7.92899 17.286 6.91744 17.8208 5.99445C18.1336 5.45258 17.9451 4.74391 17.3979 4.43119L15.6565 3.43466C15.2379 3.1856 14.6742 3.32423 14.4065 3.77019L14.2991 3.95579C13.7642 4.8786 12.958 5.50751 12.0012 5.50751C11.0439 5.50751 10.2402 4.87825 9.71021 3.95455C9.70992 3.95403 9.70962 3.95352 9.70933 3.95301L9.60347 3.77018ZM7.59248 2.14193C8.75191 1.45656 10.2226 1.87704 10.8946 3.00654L10.8991 3.01421L11.0091 3.20423L11.0107 3.20701C11.3807 3.85247 11.7666 4.00751 12.0012 4.00751C12.237 4.00751 12.6259 3.85115 13.0009 3.20423C13.001 3.20412 13.0009 3.20434 13.0009 3.20423L13.1154 3.00651C13.7874 1.877 15.2581 1.45656 16.4175 2.14193L18.1421 3.12883C19.4147 3.85604 19.8463 5.48713 19.1194 6.74522L19.1189 6.74611C18.7439 7.39298 18.8028 7.8062 18.9198 8.00929C19.0369 8.21249 19.3648 8.47001 20.11 8.47001C21.5616 8.47001 22.76 9.65323 22.76 11.12V12.88C22.76 14.3317 21.5768 15.53 20.11 15.53C19.3648 15.53 19.0369 15.7875 18.9198 15.9907C18.8028 16.1938 18.7439 16.607 19.1189 17.2539L19.1212 17.2579C19.8444 18.5235 19.4157 20.1431 18.1425 20.871C18.1424 20.871 18.1426 20.8709 18.1425 20.871L16.4174 21.8581C15.258 22.5434 13.7874 22.123 13.1154 20.9935L13.1109 20.9858L13.0009 20.7958L12.9993 20.793C12.6293 20.1476 12.2434 19.9925 12.0087 19.9925C11.773 19.9925 11.3841 20.1489 11.0091 20.7958C11.009 20.7959 11.0091 20.7957 11.0091 20.7958L10.8946 20.9935C10.2226 22.123 8.75199 22.5434 7.59257 21.8581L5.8679 20.8712C5.86776 20.8711 5.86803 20.8713 5.8679 20.8712C4.59558 20.1439 4.16378 18.5128 4.8906 17.2548L4.89112 17.2539C5.26605 16.607 5.20721 16.1938 5.09018 15.9907C4.97308 15.7875 4.64521 15.53 3.9 15.53C2.43322 15.53 1.25 14.3317 1.25 12.88V11.12C1.25 9.66837 2.43322 8.47001 3.9 8.47001C4.64521 8.47001 4.97308 8.21249 5.09018 8.00929C5.20721 7.8062 5.26605 7.39298 4.89112 6.74611L4.8906 6.74522C4.16378 5.48726 4.59518 3.85639 5.86749 3.12906L7.59248 2.14193Z" fill="#ffffff"/> </g> </g> </g>

            </svg>
            <x-dropdown-link class="flex no-underline hover:no-underline focus:no-underline" :href="route('teams.show', Auth::user()->currentTeam->id)" >

            <span class="text-[15px] ml-4 text-gray-200 text-center whitespace-nowrap font-bold">  {{ __('Account Settings') }}</span></x-dropdown-link>
        </div>

        <div class="my-4 bg-gray-600 h-[1px]"></div>
        <div class="mt-40 pl-8">
            <div class=" mt-2 p-2   flex justify-between space-x-1  rounded-md  duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <svg class="w-6" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffffff" stroke="#ffffff">

                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                    <g id="SVGRepo_iconCarrier"> <title>profile [#ffffff]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-380.000000, -2159.000000)" fill="#ffffff"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M334,2011 C337.785,2011 340.958,2013.214 341.784,2017 L326.216,2017 C327.042,2013.214 330.215,2011 334,2011 M330,2005 C330,2002.794 331.794,2001 334,2001 C336.206,2001 338,2002.794 338,2005 C338,2007.206 336.206,2009 334,2009 C331.794,2009 330,2007.206 330,2005 M337.758,2009.673 C339.124,2008.574 340,2006.89 340,2005 C340,2001.686 337.314,1999 334,1999 C330.686,1999 328,2001.686 328,2005 C328,2006.89 328.876,2008.574 330.242,2009.673 C326.583,2011.048 324,2014.445 324,2019 L344,2019 C344,2014.445 341.417,2011.048 337.758,2009.673" id="profile-[#ffffff]"> </path> </g> </g> </g> </g>

                    </svg>
                <div>
                <x-dropdown-link class="flex px-0 no-underline hover:no-underline focus:no-underline"  :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">

                <span class="text-[15px] ml-4 whitespace-nowrap text-gray-200 text-center font-bold">  {{ __('Profile Settings') }}</span></x-dropdown-link>
                </div>
            </div>
            <div  class="   mt-2  p-2 flex justify-between space-x-1  rounded-md  duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <svg fill="#ffffff" class="w-8" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">

                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                    <g id="SVGRepo_iconCarrier"> <title>logout</title> <path d="M0 9.875v12.219c0 1.125 0.469 2.125 1.219 2.906 0.75 0.75 1.719 1.156 2.844 1.156h6.125v-2.531h-6.125c-0.844 0-1.5-0.688-1.5-1.531v-12.219c0-0.844 0.656-1.5 1.5-1.5h6.125v-2.563h-6.125c-1.125 0-2.094 0.438-2.844 1.188-0.75 0.781-1.219 1.75-1.219 2.875zM6.719 13.563v4.875c0 0.563 0.5 1.031 1.063 1.031h5.656v3.844c0 0.344 0.188 0.625 0.5 0.781 0.125 0.031 0.25 0.031 0.313 0.031 0.219 0 0.406-0.063 0.563-0.219l7.344-7.344c0.344-0.281 0.313-0.844 0-1.156l-7.344-7.313c-0.438-0.469-1.375-0.188-1.375 0.563v3.875h-5.656c-0.563 0-1.063 0.469-1.063 1.031z"/> </g>

                </svg>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link class="flex px-0 no-underline hover:no-underline focus:no-underline" :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                    <span class="text-[15px] ml-4 text-gray-200 text-center font-bold">  {{ __('Log Out') }}</span>
                    </x-dropdown-link>
                </form>
            </div>
            <div class=" mt-2  p-2 flex justify-between space-x-1  rounded-md  duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <svg fill="#ffffff" class="w-6" version="1.1" id="XMLID_275_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" xml:space="preserve" stroke="#ffffff">

                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                    <g id="SVGRepo_iconCarrier"> <g id="language"> <g> <path d="M12,24C5.4,24,0,18.6,0,12S5.4,0,12,0s12,5.4,12,12S18.6,24,12,24z M9.5,17c0.6,3.1,1.7,5,2.5,5s1.9-1.9,2.5-5H9.5z M16.6,17c-0.3,1.7-0.8,3.3-1.4,4.5c2.3-0.8,4.3-2.4,5.5-4.5H16.6z M3.3,17c1.2,2.1,3.2,3.7,5.5,4.5c-0.6-1.2-1.1-2.8-1.4-4.5H3.3 z M16.9,15h4.7c0.2-0.9,0.4-2,0.4-3s-0.2-2.1-0.5-3h-4.7c0.2,1,0.2,2,0.2,3S17,14,16.9,15z M9.2,15h5.7c0.1-0.9,0.2-1.9,0.2-3 S15,9.9,14.9,9H9.2C9.1,9.9,9,10.9,9,12C9,13.1,9.1,14.1,9.2,15z M2.5,15h4.7c-0.1-1-0.1-2-0.1-3s0-2,0.1-3H2.5C2.2,9.9,2,11,2,12 S2.2,14.1,2.5,15z M16.6,7h4.1c-1.2-2.1-3.2-3.7-5.5-4.5C15.8,3.7,16.3,5.3,16.6,7z M9.5,7h5.1c-0.6-3.1-1.7-5-2.5-5 C11.3,2,10.1,3.9,9.5,7z M3.3,7h4.1c0.3-1.7,0.8-3.3,1.4-4.5C6.5,3.3,4.6,4.9,3.3,7z"/> </g> </g> </g>

                    </svg>
                <div>
                <x-dropdown-link class="flex px-0 no-underline hover:no-underline focus:no-underline"  :href="route('dashboard')" :active="request()->routeIs('dashboard')">

                <span class="text-[15px] ml-4 text-gray-200 text-center font-bold">  {{ __('EN') }}</span></x-dropdown-link>
                </div>
            </div>
        </div>
    </div>

</nav>
