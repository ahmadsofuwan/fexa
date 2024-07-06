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

<body class="bg-gray-900">
    <main>
        <section class="absolute w-full h-full">
            <div class="container mx-auto px-4 h-full">
                <div class="flex content-center items-center justify-center h-full ">
                    <div class="w-full lg:w-4/12 px-4">
                        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0">
                            <div class="mt-3">
                                <div class="text-purple-500 font-black text-center">Register Now!!!</div>

                            </div>
                            <div class="flex-auto px-4 lg:px-10 py-10">
                                <form method="post" action="{{ route('register.save') }}">
                                    @csrf
                                    {{-- <span class="text-red-500 font-bold capitalize">please enter the correct data, the data cannot be edited after registration</span> --}}
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="grid-password">WALLET (DOGEchain/DRC-20)</label>
                                        <input type="text" name="wallet" value="{{ old('wallet') }}" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" placeholder="Wallet Addrress" style="transition: all 0.15s ease 0s;" />
                                        @error('wallet') <span class="text-red-500">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="grid-password">Password</label>
                                        <input type="password" name="password" value="{{ old('password') }}" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" placeholder="Password" style="transition: all 0.15s ease 0s;" />
                                        @error('password') <span class="text-red-500">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="grid-password">whatsapp Number</label>
                                        <input type="text" name="phone" value="{{ old('phone') }}" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" placeholder="Phone" style="transition: all 0.15s ease 0s;" />
                                        @error('phone') <span class="text-red-500">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="grid-password">Agent</label>
                                        <input type="text" name="reff" value="{{ empty(old('reff'))?$request->reff:old('reff') }}" class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" placeholder="Agent" style="transition: all 0.15s ease 0s;" />
                                        @error('reff') <span class="text-red-500">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="text-center mt-6">
                                        <button type="submit" class="bg-blue-500 text-white active:bg-blue-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full" type="button" style="transition: all 0.15s ease 0s;">
                                            Register
                                        </button>
                                    </div>
                                    <div class="mt-3 text-blue-500 font-bold">
                                        <a href="{{ route('login') }}">Back to Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('input[name="username"]').on('input', function() {
            var noSpace = $(this).val().replace(/\s+/g, '');
            $(this).val(noSpace);
        });
    });
</script>

@include('sweetalert::alert')

</html>