@extends('layout.index')
@section('content')


<div class="grid grid-cols-1 gap-4 mb-3 mt-4 mx-3 text-white">
    <div class="p-4 rounded-lg flex items-center justify-between border-blue-500 border-2">
        <div class="flex items-center">
            <img src="{{ asset('img/logo.png') }}" alt="Tron Logo" class="w-8 h-8 mr-2">
            <div>
                <p class="text-white">Network Matching</p>
                <p class="text-white text-xl">{{ number_format($user->networks->network_matching) }}  <span class="text-blue-500 text-xs uppercase">Fexa</span></p>
            </div>
        </div>
        
        <button class="bg-blue-500 px-3 py-1 rounded-md text-sm w-fit font-black" id="claim-network-matching">Claim</button>
    </div>
    <div class="p-4 rounded-lg flex items-center justify-between border-blue-500 border-2">
        <div class="flex items-center">
            <img src="{{ asset('img/doge.png') }}" alt="Tron Logo" class="w-8 h-8 mr-2">
            <div>
                <p class="text-white">Network Boost</p>
                <p class="text-white text-xl">{{ number_format($user->networks->network_boost) }} <span class="text-blue-500 text-xs uppercase">Doge</span></p>

            </div>
        </div>
        <button class="bg-blue-500 px-3 py-1 rounded-md text-sm w-fit font-black" id="claim-network-boost">Claim</button>
    </div>
</div>

<div class="flex justify-center items-center w-full">
    <img src="{{ asset('img/fan.gif') }}" alt="" class="w-3/4 mx-auto">
</div>
<div class="text-center text-white mt-4 mb-4">
    <p class="text-2xl text-blue-500"><span class=" text-white font-black" id="perscon">{{ number_format($user->staking_token, 8) }}</span> DOGE</p>
    <p class="text-lg">{{ convers($totalHours) }} Hours <span class="animate-pulse">⚡</span> </p>
</div>

<div class="grid grid-cols-2 gap-4 font-black text-white">
    <div>
        <button class="bg-blue-500 px-3 py-1 rounded-md text-sm w-full h-12" id="claim-staking">Claim</button>
    </div>
    <div>
        <button class="bg-blue-500 px-3 py-1 rounded-md text-sm w-full h-12" id="detail">Detail</button>
    </div>
</div>
<div class="grid grid-cols-1 gap-4 mb-3 mt-4 mx-3 text-white ">
    <div class="p-4 rounded-lg flex items-center justify-between border-blue-500 border-2">
        <div class="flex items-center">
            <img src="{{ asset('img/logo.png') }}" alt="Tron Logo" class="w-8 h-8 mr-2">
            <div>
                <p class="text-white">Boost Matching</p>
                <p class="text-white text-xl">{{ number_format($user->networks->boost_matching,4) }} <span class="text-blue-500 text-xs uppercase">Fexa</span></p>
               

            </div>
        </div>
        <button class="bg-blue-500 px-3 py-1 rounded-md text-sm w-fit font-black" id="claim-boost-matching">Claim</button>
    </div>


</div>

@endsection

@push('script')
    <script>

        let perscon = parseFloat({{ $perscon }});
        setInterval(function() {
            let perscontxt = parseFloat($("#perscon").text());
            $("#perscon").text((perscontxt + perscon).toFixed(8));
        }, 1000);



       $('#claim-network-boost').click(function() {
        Swal.fire({
            title: '<span class="text-red-500">Confirmation</span>',
            html: '<span class="text-blue-500">0.1 Doge will be deducted from your balance. Enter your password to proceed:</span>',
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off',
            },
            showCancelButton: true,
            confirmButtonColor: 'rgb(132 204 22)',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            background: '#000000',
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                $.ajax({
                    url: '{{ route("claim_network_boost") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        password: result.value
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Failed!',
                                response.message,
                                'error'
                            ).then(() => {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(response) {
                        Swal.fire(
                            'Failed!',
                            'An error occurred while processing your claim.',
                            'error'
                        );
                    }
                });
            }
        });



       });
       $('#claim-network-matching').click(function() {
        Swal.fire({
            title: '<span class="text-red-500">Confirmation</span>',
            html: '<span class="text-blue-500">0.1 Doge will be deducted from your balance. Enter your password to proceed:</span>',
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            showCancelButton: true,
            confirmButtonColor: 'rgb(132 204 22)',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            background: '#000000',
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                $.ajax({
                    url: '{{ route("claim_network_matching") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        password: result.value
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Failed!',
                                response.message,
                                'error'
                            ).then(() => {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(response) {
                        Swal.fire(
                            'Failed!',
                            'An error occurred while processing your claim.',
                            'error'
                        );
                    }
                });
            }
        });



       });
       $('#claim-boost-matching').click(function() {
        Swal.fire({
            title: '<span class="text-red-500">Confirmation</span>',
            html: '<span class="text-blue-500">0.1 Doge will be deducted from your balance. Enter your password to proceed:</span>',
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            showCancelButton: true,
            confirmButtonColor: 'rgb(132 204 22)',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            background: '#000000',
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                $.ajax({
                    url: '{{ route("claim_boost_matching") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        password: result.value
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Failed!',
                                response.message,
                                'error'
                            ).then(() => {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(response) {
                        Swal.fire(
                            'Failed!',
                            'An error occurred while processing your claim.',
                            'error'
                        );
                    }
                });
            }
        });



       });

       $('#claim-staking').click(function() {
        Swal.fire({
            title: 'Confirmation',
            text: '0.1 Doge will be deducted from your balance. Enter your password to proceed:',
            
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                $.ajax({
                    url: '{{ route("claim_staking") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        password: result.value
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Failed!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(response) {
                        Swal.fire(
                            'Failed!',
                            'An error occurred while processing your claim.',
                            'error'
                        );
                    }
                });
            }
        });



       });
       $('#detail').click(function(){
                $.ajax({
                    type: "POST",
                    url: "{{ route('minting.detail') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: "html",
                    success: function(response) {
                        Swal.fire({
                            html: response,
                            showCloseButton: true,
                            showConfirmButton: false,
                            background: '#000000',
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



    </script>
    


@endpush