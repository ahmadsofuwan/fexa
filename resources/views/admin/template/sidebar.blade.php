@php
use Illuminate\Support\Str;
@endphp
<div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item {{ $nav=='Dashboard'?'menu-open':'' }}">
                <a href="{{ route('dashboard.admin') }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>

            </li>
            <li class="nav-item {{ $nav=='Users'?'menu-open':'' }}">
                <a href="{{ route('users.admin') }}" class="nav-link">
                    <svg viewBox="0 0 640 512" class="w-6 mr-1.5">
                        <path fill="currentColor" d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" />
                    </svg>
                    <p>
                        Users
                    </p>
                </a>

            </li>
            <li class="nav-item {{ $nav=='Deposit'?'menu-open':'' }}">
                <a href="{{ route('deposit.admin') }}" class="nav-link">
                    <svg viewBox="0 0 512 512" class="w-6 mr-1.5">
                        <path fill="currentColor" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                    </svg>
                    <p>
                        Deposit
                    </p>
                </a>

            </li>
            <li class="nav-item {{ $nav=='Package'?'menu-open':'' }}">
                <a href="{{ route('package.admin') }}" class="nav-link">
                    <svg viewBox="0 0 512 512" class="w-6 mr-1.5">
                        <path fill="currentColor" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                    </svg>
                    <p>
                        Boost
                    </p>
                </a>

            </li>
            <li class="nav-item {{ $nav=='Witdraw'?'menu-open':'' }}">
                <a href="{{ route('witdraw.admin') }}" class="nav-link">
                    <svg viewBox="0 0 640 512" class="w-6 mr-1.5">
                        <path fill="currentColor" d="M96 96V320c0 35.3 28.7 64 64 64H576c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H160c-35.3 0-64 28.7-64 64zm64 160c35.3 0 64 28.7 64 64H160V256zM224 96c0 35.3-28.7 64-64 64V96h64zM576 256v64H512c0-35.3 28.7-64 64-64zM512 96h64v64c-35.3 0-64-28.7-64-64zM288 208a80 80 0 1 1 160 0 80 80 0 1 1 -160 0zM48 120c0-13.3-10.7-24-24-24S0 106.7 0 120V360c0 66.3 53.7 120 120 120H520c13.3 0 24-10.7 24-24s-10.7-24-24-24H120c-39.8 0-72-32.2-72-72V120z" />
                    </svg>
                    <p>
                        WD Fexa
                    </p>
                </a>

            </li>
            <li class="nav-item {{ $nav=='WitdrawUsdt'?'menu-open':'' }}">
                <a href="{{ route('witdraw.admin.usdt') }}" class="nav-link">
                    <svg viewBox="0 0 640 512" class="w-6 mr-1.5">
                        <path fill="currentColor" d="M96 96V320c0 35.3 28.7 64 64 64H576c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H160c-35.3 0-64 28.7-64 64zm64 160c35.3 0 64 28.7 64 64H160V256zM224 96c0 35.3-28.7 64-64 64V96h64zM576 256v64H512c0-35.3 28.7-64 64-64zM512 96h64v64c-35.3 0-64-28.7-64-64zM288 208a80 80 0 1 1 160 0 80 80 0 1 1 -160 0zM48 120c0-13.3-10.7-24-24-24S0 106.7 0 120V360c0 66.3 53.7 120 120 120H520c13.3 0 24-10.7 24-24s-10.7-24-24-24H120c-39.8 0-72-32.2-72-72V120z" />
                    </svg>
                    <p>
                        WD USDT
                    </p>
                </a>

            </li>
            <li class="nav-item {{ $nav=='WitdrawDoge'?'menu-open':'' }}">
                <a href="{{ route('witdraw.admin.doge') }}" class="nav-link">
                    <svg viewBox="0 0 640 512" class="w-6 mr-1.5">
                        <path fill="currentColor" d="M96 96V320c0 35.3 28.7 64 64 64H576c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H160c-35.3 0-64 28.7-64 64zm64 160c35.3 0 64 28.7 64 64H160V256zM224 96c0 35.3-28.7 64-64 64V96h64zM576 256v64H512c0-35.3 28.7-64 64-64zM512 96h64v64c-35.3 0-64-28.7-64-64zM288 208a80 80 0 1 1 160 0 80 80 0 1 1 -160 0zM48 120c0-13.3-10.7-24-24-24S0 106.7 0 120V360c0 66.3 53.7 120 120 120H520c13.3 0 24-10.7 24-24s-10.7-24-24-24H120c-39.8 0-72-32.2-72-72V120z" />
                    </svg>
                    <p>
                        WD DOGE
                    </p>
                </a>

            </li>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>