@php
use Illuminate\Support\Facades\Auth;
@endphp
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <img src="{{ asset('img/burger-menu.png') }}" alt="">
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link animate-pulse">{{ !empty($nav)?$nav:''  }}</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="flex">
            <!-- <h1 class="mx-auto text-center text-4xl  font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-purple-600 animate-pulse" style="font-family: Impact, Charcoal, sans-serif;">PoodlePet</h1> -->
        </li>


    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        {{-- <li class="flex">
            <a href="{{ route('logout') }}" class="flex">
                <img src="{{ asset('img/switch.png') }}" alt="wallet" class="w-5 h-fit">
                <span class="text-yellow-500 ml-2">
                    Exit
                </span>
            </a>
        </li> --}}
        <li class="flex">
            <a href="#" class="flex">
                <span class="text-blue-500 ml-2 comingsoon">
                    Connect Wallet
                </span>
            </a>
        </li>


    </ul>
</nav>
<script>
    $('.comingsoon').click(function(){
        Swal.fire("coming soon!");
    })
</script>
