@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
@endphp
<div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item {{ $nav=='Dashboard'?'menu-open':'' }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <img src="{{ asset('img/dashboard.png') }}" alt="" class="w-7 h-fit mr-3">
                    <p>
                        Home Page
                    </p>
                </a>

            </li>
            <li class="nav-item {{ $nav=='Packages'?'menu-open':'' }}">
                <a href="{{ route('packages') }}" class="nav-link">
                    <img src="{{ asset('img/cheese.png') }}" alt="" class="w-7 h-fit mr-3">
                    <p class="text-teal-500">
                        Stake
                    </p>
                </a>

            </li>
            <li class="nav-item {{ $nav=='Wallet'?'menu-open':'' }}">
                <a href="{{ route('wallet') }}" class="nav-link">
                    <img src="{{ asset('img/binance.png') }}" alt="" class="w-7 h-fit mr-3">

                    <p class="">
                        Wallet
                    </p>
                </a>

            </li>

            <li class="nav-item {{ $nav=='Profile'?'menu-open':'' }}">
                <a href="{{ route('profile') }}" class="nav-link">
                    <img src="{{ asset('img/user.png') }}" alt="" class="w-7 h-fit mr-3">
                    <p>
                        Profile
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ env('telegram','https://t.me/POODLEDRC20TOKEN') }}" class="nav-link">
                    <img src="{{ asset('img/telegram.png') }}" alt="" class="w-7 h-fit mr-3">
                    <p>
                        PoodlePet community
                    </p>
                </a>
            </li>
            <li class="nav-item {{ $nav=='Swap'?'menu-open':'' }}">
                <a href="{{ route('swap') }}" class="nav-link">
                    <img src="{{ asset('img/swap.png') }}" alt="" class="w-7 h-fit mr-3">
                    <p>
                        Swap <span class="text-red-500">(coming soon)</span>
                    </p>
                </a>

            </li>
            <li class="nav-item ">
                <a href="#" class="nav-link" id="nft">
                    <img src="{{ asset('img/nft.png') }}" alt="" class="w-7 h-fit mr-3">
                    <p>
                        PoodlePet NFT <span class="text-red-500">(coming soon)</span>
                    </p>
                </a>

            </li>
            <li class="nav-item ">
                <a href="{{ route('logout') }}" class="nav-link" id="nft">
                    <img src="{{ asset('img/switch.png') }}" alt="" class="w-7 h-fit mr-3">
                    <p>Exit</p>
                </a>

            </li>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<script>
    $('#nft').click(function() {
        Swal.fire('PoodlePet NFT coming soon')
    })
</script>