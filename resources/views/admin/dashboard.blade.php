@extends('admin.template.master')

@section('content')




<div class="grid grid-cols-1 xl:grid-cols-4 md:grid-cols-2 gap-3 w-full">

    {{-- customer --}}
    <div class="mb-3 bg-zinc-700 py-3 rounded-lg">
        <div class="w-full flex justify-center px-5">
            <div class="my-auto">
                <div class="w-full text-center">
                    <span class="w-full mx-auto font-black text-xl text-yellow-500">{{ number_format($customer) }}</span>
                </div>
                <div class="w-full text-center mt-2">
                    <span class="w-full mx-auto font-black text-xl">User</span>
                </div>
            </div>
        </div>
    </div>

    {{-- saldo --}}
    <div class="mb-3 bg-zinc-700 py-3 rounded-lg">
        <div class="w-full flex justify-center px-5">
            <div class="my-auto">
                <div class="w-full text-center">
                    <span class="w-full mx-auto font-black text-xl text-yellow-500">{{ number_format($saldo) }}</span>
                </div>
                <div class="w-full text-center mt-2">
                    <span class="w-full mx-auto font-black text-xl">Fexa</span>
                </div>
            </div>
        </div>
    </div>
    {{-- saldo --}}
    <div class="mb-3 bg-zinc-700 py-3 rounded-lg">
        <div class="w-full flex justify-center px-5">
            <div class="my-auto">
                <div class="w-full text-center">
                    <span class="w-full mx-auto font-black text-xl text-yellow-500">{{ number_format($usdt) }}</span>
                </div>
                <div class="w-full text-center mt-2">
                    <span class="w-full mx-auto font-black text-xl">USDT</span>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 bg-zinc-700 py-3 rounded-lg">
        <div class="w-full flex justify-center px-5">
            <div class="my-auto">
                <div class="w-full text-center">
                    <span class="w-full mx-auto font-black text-xl text-yellow-500">{{ number_format($doge) }}</span>
                </div>
                <div class="w-full text-center mt-2">
                    <span class="w-full mx-auto font-black text-xl">DOGE</span>
                </div>
            </div>
        </div>
    </div>




</div>

@endsection