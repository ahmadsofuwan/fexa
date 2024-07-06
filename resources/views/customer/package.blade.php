@extends('layout.index')

@section('content')
<div class="container mx-auto p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($packages as $package)
        <div class="text-white p-4 rounded-lg shadow-md flex justify-between items-center border-blue-500 border-2">
            <div class="flex items-center">
                <img src="{{ asset('img/doge.png') }}" alt="{{ $package->name }}" class="w-12 h-12 mr-4">
                <div>
                    <h3 class="text-lg font-semibold text-white">{{  convers($package->price) }} Doge</h3>
                    <p class="text-sm">{{ $package->description }}</p>
                    <p class="text-sm text-green-400 animate-pulse font-black">10 % speed for {{ convers($package->hours) }} hours</p>
                </div>
            </div>
            <div class="text-right">
                <button class="btn-buy bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" data-id="{{ $package->id }}">RUN</button>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function () {
        $('.btn-buy').click(function () {
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
            confirmButtonColor: 'rgb(132 204 22)',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            background: '#000000',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    return new Promise(function(resolve, reject) {
                        $.ajax({
                            url: '{{ route("packages.buy") }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id,
                                password: login
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

    });
</script>
@endpush
