<html>
    <head></head>
    <body>
        <div   style="margin:0px"  class="p-10 justify-end flex">

        <div   class="items-center	 flex flex-warp  justify-end ">

            <img style="width:25px;height:25px" src="/images/world.png" alt="" >

            @if (App::isLocale('en'))
                <a class=" mr-1  ml-1 text-lg text-black-600 hover:text-gray-900" href="">
                    {{ __('AR') }}
                </a>

            @elseif (App::isLocale('ar'))
                <a class=" mr-1  ml-1 text-lg text-black-600 hover:text-gray-900" href="">
                    {{ __('EN') }}
                </a>

          @endif

    </div>

 </div>

<x-guest-layout>
    <x-jet-validation-errors class="mb-4" />
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @if (session('error'))
    <div id="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <span class="font-bold">{{ __('Oops!') }}</span>
        <span>{{ __('Too many attempts,you can try again in:') }}</span> <span id="count" ></span>
    </div>
@endif
    @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

    @livewire('loginform')
</x-guest-layout>
<script>

    // for disable resend button for 2 minutes
    var btn = document.getElementById("login");

var count=120;
    var timer = null;  // For referencing the timer

    (function countDown(){
           // Display counter and start counting down


      // Run the function again every second if the count is not zero
      if(count !== 0){
        timer = setTimeout(countDown, 1000);
        count--; // decrease the timer
      } else {
        // Enable the button
        btn.removeAttribute("disabled");


      }
    }());
            </script>

@if(Session::has('error'))
<script>

     var btn = document.getElementById("login");
    var div=document.getElementById("error");

    var count = {{ Session::get('error') }};
var spn = document.getElementById("count");
    // Set count
var timer = null;  // For referencing the timer

(function countDown(){
    var m = Math.floor(count/60);
var s = count - m * 60;
var mDisplay = m > 0 ? (m < 10 ? "0" + m  : m ) : "00";
var sDisplay = s > 0 ? (s < 10 ? "0" + s : s) : "00";
       // Display counter and start counting down

       spn.textContent = mDisplay+":"+sDisplay;

  // Run the function again every second if the count is not zero
  if(count !== 0){
    btn.setAttribute("disabled","");
    timer = setTimeout(countDown, 1000);
     // decrease the timer
  } else {
    // Enable the button
    div.classList.add("hidden");
    btn.removeAttribute("disabled");
    spn.textContent ="";

  }
}());
</script>
@endif
@livewireScripts()

</body>
</html>
