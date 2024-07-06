@extends('layout.index')

@section('content')

<div class="mt-2">
    <img src="{{ asset('img/logo.png') }}" alt="" class="mx-auto w-40">
</div>
<div class="text-center mt-2 font-bold text-xl text-blue-500 mb-5">Fexa</div>

<div class="p-4 rounded-lg shadow-md flex justify-between items-center border-blue-500 border-2 mt-5">
    <div class="flex items-center">
        <div>
            <h3 class="text-lg font-semibold text-white">Invite Link</h3>
            <a href="https://t.me/supermeo" class="text-blue-400 underline">{{ route('register', ['ref' => $user->username]) }}</a>
            <p class="text-sm text-blue-500 mt-2">Get 1,000 Fexa for each New invited.</p>
        </div>
    </div>
    <div class="text-right">
        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded btn-cpy" data-link="{{ route('register', ['ref' => $user->username]) }}">
            <ion-icon name="copy-outline"></ion-icon>
        </button>
    </div>
</div>

<div class="text-center mt-5">
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded text-xl">
        Invited ({{ number_format($downline->count()) }})
    </button>
</div>

<div class="mt-4">
    <ul class="list-disc list-inside text-white">
        @foreach($downline as $down)
        <li>{{ $down->username }}</li>
        @endforeach
    </ul>
</div>

<div class="w-full">
    <div class="grid grid-cols-2 gap-2 text-center ">
        <div id="btn-downline" class="border-b-4 border-solid border-green-500">Downline</div>
        <div id="btn-socialmedia" class="">Social Media</div>
    </div>
    <div class="mt-4 mx-5" id="downline">
        <ul class="list-disc list-inside text-white">
            @foreach($downline as $down)
            <li>{{ $down->username }}</li>
            @endforeach
        </ul>
    </div>
    <div class="grid grid-cols-1 gap-2 text-center mt-5 font-semibold" id="socialmedia" style="display: none">
        <div>
            <a href="#" class="flex items-left justify-left mx-5">
                <img src="{{ asset('img/telegram.png') }}" alt="" class="w-5 mr-2">
                <span class="text-blue-500">Telegram</span>
            </a>
        </div>
    </div>
</div>






@include('layout.ajax_setup')
@push('script')
<script>
    function copyToClipboard(text) {
        if (navigator.share) {
            navigator.share({
                text: text  
            })
        }else{
            navigator.clipboard.writeText(text);
        }
    }

    $(document).ready(function() {
        $('#btn-downline').click(function() {
            $('#downline').show();
            $('#socialmedia').hide();
            $('#btn-socialmedia').removeClass('border-b-4 border-solid border-green-500');
            $('#btn-downline').addClass('border-b-4 border-solid border-green-500');
        });
        $('#btn-socialmedia').click(function() {
            $('#socialmedia').show();
            $('#downline').hide();
            $('#btn-downline').removeClass('border-b-4 border-solid border-green-500');
            $('#btn-socialmedia').addClass('border-b-4 border-solid border-green-500');
        });

        $("#btn-claim").click(function() {
            $.ajax({
                type: "POST",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                url: "{{ route('profile.claim') }}",
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message
                        });
                    }
                }
            });



        });


    });
</script>

@endpush



@endsection