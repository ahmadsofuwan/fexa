@extends('layout.index')
@section('content')

<div class="mx-5 mt-3 text-gray-200 rounded-xl bg-gray-700">
    <div class="text-center rounded-xl bg-gray-900 mt-2 pt-2">
        <div class="text-center w-fit bg-gray-800 mx-auto px-5 rounded-xl flex justify-center">
            <svg class="w-5 h-fit mr-2" fill="white" stroke="white" stroke-width="2" viewBox="0 0 640 512">
                <path d="M54.2 202.9C123.2 136.7 216.8 96 320 96s196.8 40.7 265.8 106.9c12.8 12.2 33 11.8 45.2-.9s11.8-33-.9-45.2C549.7 79.5 440.4 32 320 32S90.3 79.5 9.8 156.7C-2.9 169-3.3 189.2 8.9 202s32.5 13.2 45.2 .9zM320 256c56.8 0 108.6 21.1 148.2 56c13.3 11.7 33.5 10.4 45.2-2.8s10.4-33.5-2.8-45.2C459.8 219.2 393 192 320 192s-139.8 27.2-190.5 72c-13.3 11.7-14.5 31.9-2.8 45.2s31.9 14.5 45.2 2.8c39.5-34.9 91.3-56 148.2-56zm64 160a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z" />
            </svg>
            <span class="relative flex h-3 w-3 my-auto">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
            </span>
            <span class="ml-2">Connected</span>
        </div>
        <div class="svg flex justify-center">
            <svg width="122" class="stroke-slate-100" height="105" id="logo" viewBox="0 0 122 105" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path id="path1" d="M1 91C1 84.0964 7.37994 78.5 15.25 78.5H106.75C114.62 78.5 121 84.0964 121 91C121 97.9036 114.62 103.5 106.75 103.5H15.25C7.37994 103.5 1 97.9036 1 91Z" stroke="#f1f5f9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M26.0347 91C26.0347 93.7614 23.7884 96 21.0174 96C18.2463 96 16 93.7614 16 91C16 88.2386 18.2463 86 21.0174 86C23.7884 86 26.0347 88.2386 26.0347 91Z" stroke="#f1f5f9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M46.1042 91C46.1042 93.7614 43.8578 96 41.0868 96C38.3158 96 36.0695 93.7614 36.0695 91C36.0695 88.2386 38.3158 86 41.0868 86C43.8578 86 46.1042 88.2386 46.1042 91Z" stroke="#f1f5f9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M66.1736 91C66.1736 93.7614 63.9273 96 61.1563 96C58.3853 96 56.1389 93.7614 56.1389 91C56.1389 88.2386 58.3853 86 61.1563 86C63.9273 86 66.1736 88.2386 66.1736 91Z" stroke="#f1f5f9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M86.2431 91C86.2431 93.7614 83.9967 96 81.2257 96C78.4547 96 76.2084 93.7614 76.2084 91C76.2084 88.2386 78.4547 86 81.2257 86C83.9967 86 86.2431 88.2386 86.2431 91Z" stroke="#f1f5f9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M106.313 91C106.313 93.7614 104.066 96 101.295 96C98.5242 96 96.2778 93.7614 96.2778 91C96.2778 88.2386 98.5242 86 101.295 86C104.066 86 106.313 88.2386 106.313 91Z" stroke="#f1f5f9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M30.6428 58.3334H21V74.3334H30.6428M30.6428 58.3334H40.2856V74.3334H30.6428M30.6428 58.3334V74.3334M60.9996 58.3334H51.8924V74.3334H60.9996M60.9996 58.3334H70.1067V74.3334H60.9996M60.9996 58.3334V74.3334M91.3572 58.3334H81.7144V74.3334H91.3572M91.3572 58.3334H101V74.3334H91.3572M91.3572 58.3334V74.3334" stroke="#f1f5f9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path id="swing" transform="translate(-50, 0)" d="M74.6056 24.3333V20.3333H47.2278V24.3333M74.6056 24.3333H47.2278M74.6056 24.3333V32.3333M47.2278 24.3333V32.3333M67.7611 39H74.6056V32.3333M67.7611 39V45.6667H60.9167M67.7611 39H54.0722M54.0722 39H47.2278V32.3333M54.0722 39V45.6667H60.9167M60.9167 45.6667V52.3333M79.5833 1H67.027V9.66667L79.5833 16.3333V27.6667L76.669 32.3333H74.6056M42.25 1H54.8063V9.66667L42.25 16.3333V27.6667L45.1644 32.3333H47.2278" stroke="#f1f5f9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <animateTransform attributeName="transform" type="translate" values="-40;40;-40" dur="4s" repeatCount="indefinite" />
                </path>
            </svg>
        </div>
        <div class="mt-2">Mint XWDOGE</div>
    </div>
    <!-- buttom -->
    <div class="bg-gray-700 rounded-b-xl mt-2 pt-5 pb-2">
        <div class="text-center capitalize">tokens will be issued every hour</div>
        <div class="text-center mb-2" id="runningText">Running</div>
        
        <div class="flex justify-center ">
            <img src="{{ asset('img/logo.png') }}" alt="" class="w-10 h-fit">
            <input type="text" class="text-blue-500 bg-gray-500 text-center" disabled value="{{ number_format($minting) }}" id="val-minting">
        </div>
        <div class="text-center capitalize mt-2 ">Min Claim : 1 XWDOGE</div>
        <div class="text-center capitalize mt-2 text-blue-500">Minted results can be claimed at any time</div>
        <div class="text-center capitalize mt-2 text-red-500">Claim Fee 0.1 DOGE</div>
        <div class="px-3 mt-4 grid grid-cols-2 gap-4">
            <button class="w-full p-2 bg-blue-500 rounded-xl font-black mx-auto" id="claim_token">Claim</button>
            <button class="w-full p-2 bg-gray-900 rounded-xl font-black" id="detail">Detail</button>
        </div>
    </div>
</div>

<div class="mt-5 text-gray-100 rounded-xl bg-gray-700 mx-5">

    <div class="rounded-xl bg-gray-900 mx-auto">
        <div class="mx-auto text-center pt-2"><span class="capitalize">Add More Users to get more results </span></div>
        <div class="flex justify-center items-center">
            <button class="bg-blue-500 w-fit p-2 mx-auto rounded-xl mt-5 btn-cpy flex" data-link="{{ route('register',['reff'=> $users->username]) }}">
                <img src="{{ asset('img/person.png') }}" alt="" class="w-5 h-fit mr-2">
                Invite Link
            </button>
        </div>

        <div class="flex justify-center mt-2 pb-2">
            <span>Sponsored</span>
            <span class="ml-2">{{ number_format($downline) }}</span>
        </div>
    </div>
    <div class="text-gray-300">
        <div class="ml-3 text-center">Total Nerwork Mint</div>
        <div class="flex justify-center">
            <img src="{{ asset('img/logo.png') }}" alt="" class="w-10 h-fit">
            <input type="text" class="text-center" disabled value="{{ number_format($users->bonus) }}" id="val-minting-bonus">
        </div>
        <div class="text-center capitalize mt-2 ">Max Claim : {{ number_format(env('MAX_CLAIM', 300)) }} XWDOGE</div>
        <div class="text-center capitalize mt-2 text-blue-500">Minted results can be claimed at any time</div>
        <div class="text-center capitalize mt-2 text-red-500">Claim Fee 100 DOGE</div>

        <div class="flex justify-center mt-2">
            <button class="text-gray-300 bg-blue-500 w-fit p-2 rounded-xl font-black" id="claim_bonus">Claim</button>
        </div>
    </div>


</div>

@endsection

@include('layout.ajax_setup')
@push('script')
    <script>
        let jumlahTitik = 0;
        setInterval(() => {
            jumlahTitik = (jumlahTitik + 1) % 5;
            $('#runningText').html('Running' + '.'.repeat(jumlahTitik));
        }, 1000);
    </script>

    <script>
        $(document).ready(function () {
            $('#claim_token').click(function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Confirm Password',
                    icon: 'question',
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off',
                        placeholder: 'Confirm Password',
                        class: 'px-5 bg-gray-500' // Adding class px-3 and bg-gray-500
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit!',
                    cancelButtonText: 'Cancel',
                    showLoaderOnConfirm: true,
                    preConfirm: (input) => {
                        return new Promise(function(resolve, reject) {
                            $.ajax({
                                url: '{{ route("minting.claim") }}',
                                type: 'POST',
                                data: {
                                    password: input
                                },
                                success: function(response) {
                                    if(response.error){
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: response.error,
                                        });
                                    }else if(response.success){
                                        resolve(response)
                                        Swal.fire({
                                            position: "top-end",
                                            icon: "success",
                                            title: response.success,
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                    return resolve(response);
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'An error occurred on the server!',
                                    });
                                }
                            });
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(id);
                    }
                })
            });
            $('#claim_bonus').click(function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Confirm Password',
                    icon: 'question',
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off',
                        placeholder: 'Confirm Password',
                        class: 'px-5 bg-gray-500' // Adding class px-3 and bg-gray-500
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit!',
                    cancelButtonText: 'Cancel',
                    showLoaderOnConfirm: true,
                    preConfirm: (input) => {
                        return new Promise(function(resolve, reject) {
                            $.ajax({
                                url: '{{ route("minting.claim.bonus") }}',
                                type: 'POST',
                                data: {
                                    password: input
                                },
                                success: function(response) {
                                    if(response.error){
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: response.error,
                                        });
                                    }else if(response.success){
                                        resolve(response)
                                        Swal.fire({
                                            position: "top-end",
                                            icon: "success",
                                            title: response.success,
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                    return resolve(response);
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'An error occurred on the server!',
                                    });
                                }
                            });
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(id);
                    }
                })
            });
            $('#detail').click(function(){
                $.ajax({
                    type: "POST",
                    url: "{{ route('minting.detail') }}",
                    dataType: "html",
                    success: function(response) {
                        Swal.fire({
                            html: response,
                            showCloseButton: true,
                            showConfirmButton: false,
                            width: '100%',
                            height: '100%',
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON.error,
                        });
                    }
                });
            })

        });
    </script>
@endpush