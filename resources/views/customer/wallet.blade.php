@extends('layout.index')
@section('content')

<div class="w-1/2 mx-auto ">
    <img src="{{ asset('img/logo.png') }}" alt="">
</div>
<div class="flex justify-center items-center text-white font-black">
    <span>Power By </span>
    <img src="{{ asset('img/doge.png') }}" alt="" class="w-5 mx-1">
    <span>Doge Chain (DRC20)</span>
</div>
<div class="mt-3">
    <div class="text-center flex justify-center bg-gray-600 p-2 w-fit mx-auto rounded-xl">
        <span class="text-blue-600">
            {{ substr($users->wallet, 0, 10) . '....' . substr($users->wallet, -10) }}
        </span>
        <button class="btn-cpy" data-link="{{ $users->wallet }}">
            <img src="{{ asset('img/copy.png') }}" alt="" class="w-5 ml-2">
        </button>
    </div>
</div>
<div class="flex justify-center items-center mt-3 ">
    <span class="text-white text-xl font-black"> $ {{ number_format($total, 2) }}</span>
</div>
<div class="w-fit mx-auto my-5 grid grid-cols-3 gap-4 ">
    <button class="bg-red-500 text-white px-4 py-2 rounded-xl w-full" id="wd">
        Withdraw
    </button>
    <button class="bg-blue-500 text-white px-4 py-2 rounded-xl w-full" id="send">
        Transfer
    </button>
    <button class="bg-blue-500 text-white px-4 py-2 rounded-xl w-full" id="hystori">
        History
    </button>
</div>

<div class="grid grid-cols-1 gap-4 mx-3 mt-4 text-white">
    <div class=" rounded-3xl p-2 flex items-center border-blue-500 border-2">
        <div class="rounded-full overflow-hidden bg-gray-400 w-10 h-10">
            <img src="{{ asset('img/doge.png') }}" alt="User Profile" class="w-10 h-10 object-cover">
        </div>
        <div class="ml-2 flex-1">
            <div class="flex justify-between">
                <div>
                    <div class="text-lg text-white">${{ number_format($users->doge * doge_price() , 2) }}</div>
                    <div class="text-xs font-normal text-gray-400">{{ number_format($users->doge, 2) }} <span class="text-blue-500 uppercase">Doge</span></div>
                </div>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold px-2 rounded w-fit mr-2" id="deposit">
                    Deposit
                </button>
            </div>
        </div>
    </div>

    <div class=" rounded-3xl p-2 flex items-center border-blue-500 border-2">
        <img src="{{ asset('img/logo.png') }}" alt="User Profile" class="w-12 h-12 object-cover">
        <div class="ml-2 flex-1">
            <div class="flex justify-between">
                <div>
                    <div class="text-lg text-white">${{ number_format($users->saldo * $Fexa , 2) }}</div>
                    <div class="text-xs font-normal text-gray-400">{{ number_format($users->saldo, 2) }} <span class="text-blue-500 uppercase">Fexa</span></div>
                </div>

            </div>
        </div>
    </div>

    <div class=" rounded-3xl p-2 flex items-center border-blue-500 border-2">
        <div class="rounded-full overflow-hidden bg-gray-400 w-10 h-10">
            <img src="{{ asset('img/usdt.png') }}" alt="User Profile" class="w-10 h-10 object-cover">
        </div>
        <div class="ml-2 flex-1">
            <div class="flex justify-between">
                <div>
                    <div class="text-lg">${{ number_format($users->usdt, 2) }}</div>
                    <div class="text-xs font-normal text-gray-400">{{ number_format($users->usdt, 2) }} <span class="text-green-500 uppercase">usdt</span></div>
                </div>
            </div>
        </div>
    </div>


    {{-- @if ($user->status == 'active') --}}
    <div class=" rounded-3xl p-2 flex items-center border-blue-500 border-2">
        <img src="{{ asset('img/logo.png') }}" alt="User Profile" class="w-12 h-12 object-cover">
        <div class="ml-2 flex-1">
            <div class="flex justify-between">
                <div>
                    <div class="text-lg uppercase">${{ number_format(1000 * Fexa_price() , 2) }}</div>
                    <div class="text-xs font-normal text-gray-400">{{ number_format(1000, 2) }} <span class="text-blue-500 uppercase">Fexa</span> </div>
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded w-fit mr-2">
                    Lock
                </button>
            </div>
        </div>
    </div>
    {{-- @endif --}}
</div>


@endsection
@include('layout.ajax_setup')
@push('script')
<script>
    $('#send').click(function(e) {
        Swal.fire({
            title: '<span class="text-blue-500"> Transfer </span>',
            html: `
                    <div class="grid grid-cols-1 gap-2">
                        <button id="doge"  class="bg-blue-500 text-white px-4 py-2 rounded-xl flex items-center">
                            <img src="{{ asset('img/doge.png') }}" alt="DOGE" class="w-10 h-10 object-cover">
                            <span class="ml-2">DOGE</span>
                        </button>
                    </div>
                `,
            showCancelButton: false,
            showCloseButton: true,
            showConfirmButton: false,
            background: '#000000',
            confirmButtonColor: 'rgb(132 204 22)',
            preConfirm: () => {
                return document.getElementById('wallet').value;
            }
        })
        $('#Fexa, #usdt, #doge').click(function(e) {
            let id = $(this).attr('id');
            Swal.fire({
                title: '<span class="text-blue-500"> Transfer </span>',
                html: `
                        <form class="bg-gray-100 p-2 rounded-xl">
                            <input type="hidden" id="type" value="${id}">
                            <div class="mb-4">
                                <label for="xwdogeAmount" class="block text-sm font-medium text-gray-700"><span class="uppercase">${id}</span> Amount</label>
                                <input type="number" id="xwdogeAmount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                            </div>
                            <div class="mb-4">
                                <label for="walletAddress" class="block text-sm font-medium text-gray-700">Wallet Address</label>
                                <input type="text" id="walletAddress" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                            </div>
                            <div class="mb-4">
                                <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" id="confirmPassword" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                            </div>
                        </form>
                    `,
                showCancelButton: false,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Submit',
                background: '#000000',
                confirmButtonColor: 'rgb(132 204 22)',
                preConfirm: () => {
                    let amount = $("#xwdogeAmount").val()
                    let walletAddress = $("#walletAddress").val()
                    let confirmPassword = $("#confirmPassword").val()
                    let type = $("#type").val()

                    $.ajax({
                        type: "POST",
                        url: "{{ route('transfer') }}",
                        data: {
                            type: type,
                            amount: amount,
                            wallet: walletAddress,
                            password: confirmPassword
                        },

                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: response.success,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    window.location.href = window.location.href;
                                });

                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: xhr.responseJSON.error,
                            });
                        }
                    });

                    return Swal.close();
                }
            })



        });






    });

    $('#wd').click(function(e) {
        Swal.fire({
            title: '<span class="text-red-500"> Withdraw</span>',
            html: `
                    <div class="grid grid-cols-1 gap-2">
                        <button id="doge" class="bg-blue-500 text-white px-4 py-2 rounded-xl flex items-center">
                            <img src="{{ asset('img/doge.png') }}" alt="DOGE" class="w-10 h-10 object-cover">
                            <span class="ml-2">DOGE</span>
                        </button>
                        <button id="Fexa" class="bg-blue-500 text-white px-4 py-2 rounded-xl flex items-center">
                            <img src="{{ asset('img/logo.png') }}" alt="XWDoge" class="w-10 h-10 object-cover">
                            <span class="ml-2">Fexa</span>
                        </button>
                        <button id="usdt" class="bg-white text-green-500 px-4 py-2 rounded-xl flex items-center">
                            <img src="{{ asset('img/usdt.png') }}" alt="USDT" class="w-10 h-10 object-cover">
                            <span class="ml-2">USDT</span>
                        </button>
                        
                    </div>
                `,
            showCancelButton: false,
            showCloseButton: true,
            showConfirmButton: false,
            background: '#000000',
            preConfirm: () => {
                return document.getElementById('wallet').value;
            }
        })
        $('#Fexa, #usdt, #doge').click(function(e) {
            let id = $(this).attr('id');
            Swal.fire({
                title: `<span class="text-red-500"> Withdraw </span>`,
                html: `
                        <form class="bg-gray-100 p-2 rounded-xl bg-black">
                            <input type="hidden" id="type" value="${id}">
                            <div class="mb-4">
                                <label for="xwdogeAmount" class="block text-sm font-medium text-gray-700"><span class="uppercase">${id}</span> Amount</label>
                                <input type="number" id="amount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                            </div>
                            ${id === 'usdt' ? `
                            <div class="mb-4">
                                <label for="walletAddress" class="block text-sm font-medium text-gray-700">Wallet Address (BEP20)</label>
                                <input type="text" id="walletAddress" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                            </div>
                            ` : ''}
                            <div class="mb-4">
                                <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" id="confirmPassword" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                            </div>
                        </form>
                    `,
                showCancelButton: false,
                showCloseButton: true,
                showConfirmButton: true,
                background: '#000000',
                confirmButtonText: 'Submit',
                confirmButtonColor: 'rgb(132 204 22)',
                preConfirm: () => {
                    let amount = $("#amount").val()
                    let confirmPassword = $("#confirmPassword").val()
                    let type = $("#type").val()

                    let requestData = {
                        token: type,
                        amount: amount,
                        password: confirmPassword
                    };

                    if (type === 'usdt') {
                        requestData.wallet = $('#walletAddress').val();
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{ route('wallet.witdraw') }}",
                        data: requestData,

                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: response.success,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    window.location.href = window.location.href;
                                });

                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseJSON);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: xhr.responseJSON.error ? xhr.responseJSON.error : 'Something wrong',
                            });
                        }
                    });

                    return Swal.close();
                }
            })



        });






    });

    $('#swap').click(function(e) {
        Swal.fire({
            title: 'P2P Trading',
            html: `
                    <div class="grid grid-cols-1 gap-2">
                        <button id="xwdoge" class="bg-blue-500 text-white px-4 py-2 rounded-xl flex items-center">
                            <img src="{{ asset('img/logo.png') }}" alt="XWDoge" class="w-10 h-10 object-cover">
                            <span class="ml-2">XWDOGE</span>
                        </button>
                        <button id="doge"  class="bg-blue-500 text-white px-4 py-2 rounded-xl flex items-center">
                            <img src="{{ asset('img/doge.png') }}" alt="DOGE" class="w-10 h-10 object-cover">
                            <span class="ml-2">DOGE</span>
                        </button>
                    </div>
                `,
            showCancelButton: false,
            showCloseButton: true,
            showConfirmButton: false,
            preConfirm: () => {
                return document.getElementById('wallet').value;
            }
        })
        $('#xwdoge, #doge').click(function(e) {
            let id = $(this).attr('id');
            Swal.fire({
                title: `Swap to <span class="uppercase"> ${id}</span>`,
                html: `
                        <form class="bg-gray-100 p-2 rounded-xl">
                            <input type="hidden" id="type" value="${id}">
                            <div class="mb-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700"><span class="uppercase">USDT</span> Amount</label>
                                <input type="number" id="amount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                            </div>
                            <div class="mb-4">
                                <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" id="confirmPassword" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                            </div>
                        </form>
                    `,
                showCancelButton: false,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Submit',
                preConfirm: () => {
                    let amount = $("#amount").val()
                    let confirmPassword = $("#confirmPassword").val()
                    let token = $("#type").val()

                    $.ajax({
                        type: "POST",
                        url: "{{ route('wallet.convers') }}",
                        data: {
                            token: token,
                            password: confirmPassword,
                            amount: amount,
                        },

                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: response.success,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    window.location.href = window.location.href;
                                });

                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: xhr.responseJSON.error,
                            });
                        }
                    });

                    return Swal.close();
                }
            })



        });






    });

    $('#deposit').click(function() {
        Swal.fire({
            title: 'Network DogeChain',
            html: `
                    <div class="grid grid-cols-1 gap-2">
                        <div class="mx-auto"><img src="https://quickchart.io/qr?text={{ env('HAST_ID') }}&size=200" alt=""></div>
                        <div class="font-black btn-cpy" data-link"{{ env('HAST_ID') }}">{{ env('HAST_ID') }}</div>

                        <div>
                            <button id="request" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-xl">Confirm</button>
                        </div>
                    </div>
                `,
            showCancelButton: false,
            showCloseButton: true,
            showConfirmButton: false,
            confirmButtonColor: 'rgb(132 204 22)',
            preConfirm: () => {
                return true
            }
        })
        cpy()
        $("#request").click(function() {
            Swal.fire({
                title: '<span class="text-green-500"> Deposit </span>',
                html: `
                        <form class="bg-gray-100 p-2 rounded-xl">
                            <div class="mb-4">
                                <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" id="confirmPassword" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                            </div>
                        </form>
                    `,
                showCancelButton: false,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Submit',
                confirmButtonColor: 'rgb(132 204 22)',
                background: '#000000',
                preConfirm: () => {
                    let confirmPassword = $("#confirmPassword").val()
                    $.ajax({
                        type: "POST",
                        url: "{{ route('wallet.deposit') }}",
                        data: {
                            password: confirmPassword,
                        },

                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: response.success,
                                    showConfirmButton: false,
                                    timer: 1500
                                })

                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: xhr.responseJSON.error,
                            });
                        }
                    });

                    return Swal.close();
                }
            })




        })


    });

    $("#hystori").click(function() {


        $.ajax({
            type: "POST",
            url: "{{ route('wallet.history') }}",
            dataType: "html",
            success: function(response) {
                Swal.fire({
                    html: `<div class="bg-black text-blue-500">${response}</div>`,
                    showCloseButton: true,
                    showConfirmButton: false,
                    background: '#000000',
                    width: '100%',
                    height: '100%',
                });
                navigasion_logs()
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: xhr.responseJSON.error,
                });
            }
        });

        function navigasion_logs() {
            $('#hstake').click(function() {
                $('#hgeneral').removeClass('border-b-4 border-solid border-green-500');
                $('#general').hide();

                $('#hstake').addClass('border-b-4 border-solid border-green-500');
                $('#stake').show();
            })
            $('#hgeneral').click(function() {
                $('#hstake').removeClass('border-b-4 border-solid border-green-500');
                $('#stake').hide();

                $('#hgeneral').addClass('border-b-4 border-solid border-green-500');
                $('#general').show();
            })
        }

        return
        Swal.fire({
            title: 'Hystori',
            html: `
                    <div class="grid grid-cols-1 gap-2">
                        <button id="general" class="bg-blue-500 text-white px-4 py-2 rounded-xl flex items-center">
                            <span class="ml-2">General</span>
                        </button>
                        <button id="staking" class="bg-blue-500 text-white px-4 py-2 rounded-xl flex items-center">
                            <span class="ml-2">Staking</span>
                        </button>
                    </div>
                `,
            showCancelButton: false,
            showCloseButton: true,
            showConfirmButton: false,
            preConfirm: () => {
                return document.getElementById('wallet').value;
            }
        })
        $('#general, #staking').click(function(e) {
            let type = $(this).attr('id');
            $.ajax({
                type: "POST",
                url: "{{ route('wallet.history') }}",
                data: {
                    type: type,
                },
                dataType: "html",
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.responseJSON.error,
                    });
                }
            });



        });



    });

    $('.swap-usdt').click(function(e) {
        let token = $(this).data('token')
        Swal.fire({
            title: `Swap <span class="capitalize"> ${token}</span> `,
            showConfirmButton: false,
            showCloseButton: true,
            html: `
                    <div action="" method="post" class="grid grid-cols-1 gap-3">
                        <input type="hidden" id="token" value="${token}">
                        <input id="swap_amount" type="number" name="amount" placeholder="amount" class="w-full h-10 text-gray-800 px-2 rounded-2xl">
                        <input id="swap_password" type="password" name="password" placeholder="Confirm password" class="w-full h-10 text-gray-800 px-2 rounded-2xl">
                        <button id="submit_swap" class="bg-blue-500 hover:bg-blue-600 focus:bg-blue-800 w-full rounded-2xl py-2 text-black">Swap</button>
                    </div>
                `,
        });
        $('#submit_swap').click(function() {
            let password = $('#swap_password').val();
            let amount = $('#swap_amount').val()
            let token = $('#token').val()

            $.ajax({
                type: "POST",
                url: "{{ route('wallet.convers') }}",
                data: {
                    token: token,
                    password: password,
                    amount: amount,
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.success,
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            window.location.href = window.location.href;
                        });

                    }
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

    $('#claim').click(function() {
        Swal.fire({
            icon: 'info',
            title: 'Coming Soon!',
            text: 'This feature will be available soon.',
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    });
</script>
@endpush