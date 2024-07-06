<div class="toolbar tabbar tabbar-labels toolbar-bottom elevation-6 bg-blue-500">
    <div class="toolbar-inner">
        <a href="{{ route('packages') }}" class="tab-link {{ request()->is('packages*') ? 'tab-link-active' : '' }}">
            <span class="mt-0">
                <img src="{{ asset('img/flash.png') }}" alt="" class="w-7">
            </span>
            <span class="tabbar-label">Boost</span>
        </a>
        <a href="{{ route('wallet') }}" class="tab-link {{ request()->is('wallet*') ? 'tab-link-active' : '' }}">
            <span class="mt-0">
                <img src="{{ asset('img/wallet-filled-money-tool.png') }}" alt="" class="w-7">
            </span>
            <span class="tabbar-label">Wallet</span>
        </a>
        <a href="{{ route('dashboard') }}" class="tab-link {{ request()->is('dashboard*') ? 'tab-link-active' : '' }}">
            <span class="mt-0">
                <img src="{{ asset('img/pickaxe.png') }}" alt="" class="w-7">
            </span>
            <span class="tabbar-label">Mine</span>
        </a>

        <a href="{{ route('profile') }}" class="tab-link {{ request()->is('profile*') ? 'tab-link-active' : '' }}">
            <span class="mt-0">
                <img src="{{ asset('img/add-user.png') }}" alt="" class="w-7">
            </span>
            <span class="tabbar-label">Refer</span>
        </a>
        <a href="{{ route('logout') }}" class="tab-link">
            <span class="mt-0">
                <img src="{{ asset('img/logout.png') }}" alt="" class="w-7">
            </span>
            <span class="tabbar-label">Exit</span>
        </a>
    </div>
</div>