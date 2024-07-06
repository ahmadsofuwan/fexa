<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/creativetimofficial/tailwind-starter-kit/compiled-tailwind.min.css" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/OneMonBot.png') }}">
    <title>Xwdoge</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('sweetalert::alert')


</head>

<body class="text-gray-800 antialiased">
    <nav class="top-0 absolute z-50 w-full flex flex-wrap items-center justify-between px-2 py-3 ">
        <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
            <div class="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start">
                <span class="flex">
                    <img src="{{ asset('assets/img/OneMonBot.png') }}" alt="" class="w-10">
                    <span class="my-auto ml-1 text-blue-500 font-black hidden">Xwdoge</span>
                </span>
            </div>

        </div>
    </nav>
    <main>
        <section class="absolute w-full h-full">
            <div class="absolute top-0 w-full h-full bg-gray-900" style="background-size: 100%; background-repeat: no-repeat;"></div>
            <div class="container mx-auto px-4 h-full">
                <div class="flex content-center items-center justify-center h-full">
                    <div class="w-full lg:w-4/12 px-4">
                        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0">
                            <div class="mt-3">
                                <img src="{{ asset('img/logo.png') }}" alt="Justdoit logo" class="w-20 mx-auto">
                                <div class="text-blue-500 font-black text-center">XWDOGE</div>

                            </div>
                            <div class="flex-auto px-4 lg:px-10 py-10">
                                <form method="post" action="{{ route('forget.change') }}">
                                    @csrf
                                    <span class="text-red-500 font-bold capitalize">Update Your New Password</span>
                                    <div class="relative w-full mb-3">
                                        <input type="hidden" name="username" value="{{ $user->username }}">
                                        <input type="hidden" name="otp" value="{{ $user->otp }}">
                                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="grid-password">WALLET (DOGEchain/DRC-20)</label>
                                        <input  value="{{ $user->username }}" type="text" disabled class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" style="transition: all 0.15s ease 0s;" />
                                        @error('username') <span class="text-red-500">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="grid-password">New Password</label>
                                        <input type="password" name="password" value="{{ old('password') }}" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" placeholder="New Password" style="transition: all 0.15s ease 0s;" />
                                        @error('password') <span class="text-red-500">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="grid-password">Password Confirm</label>
                                        <input type="password" name="password2" value="" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" placeholder="Password Confirm" style="transition: all 0.15s ease 0s;" />
                                        @error('password2') <span class="text-red-500">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="text-center mt-6">
                                        <button type="submit" class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full" type="button" style="transition: all 0.15s ease 0s;">
                                            verification
                                        </button>
                                    </div>
                                    <div class="mt-3 text-blue-500 font-bold">
                                        <a href="{{ route('login') }}">Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('sweetalert::alert')
</body>

</html>