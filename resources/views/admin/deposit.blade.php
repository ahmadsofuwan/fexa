@extends('admin.template.master')

@section('content')
<div class="w-full mx-2">
    <div class="w-full py-2 pl-3 bg-[#343a40]">
        <div class="flex">
            <svg viewBox="0 0 512 512" class="w-7 h-7">
                <path fill="currentColor" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
            </svg>
            <span class="ml-2">Deposits</span>
        </div>
        <div class="flex mt-2">
            <a href="#" class="flex" id="add">
                <svg class="w-10 mt-3 text-blue-500 stroke-2" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
                </svg>
            </a>
        </div>
    </div>
    <div class="bg-[#343a40] p-4 overflow-x-auto overflow-auto">
        <table id="dataTable" class="w-full table table-striped">
            <thead>
                <tr>
                    <td>User Wallet</td>
                    <td>Status</td>
                    <td>Date</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($deposits as $deposit)
                <tr>
                    <td>{{ $deposit->users->username }}</td>
                    <td>{{ $deposit->status }}</td>
                    <td>{{ $deposit->created_at }}</td>
                    <td>
                        @if ($deposit->status=='request')

                        <div class="flex justify-between px-2">
                            <a href="{{ route('deposit.reject.admin',['id'=>encrypt($deposit->id)]) }}">
                                <button class="bg-red-500 hover:bg-red-600 focus:bg-red-600 py-1 px-2 rounded-lg">Reject</button>
                            </a>
                            <button class="bg-green-500 hover:bg-green-600 focus:bg-green-600 py-1 px-2 rounded-lg btn-accept" data-id="{{ $deposit->id }}">Accept</button>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



</div>

<script>
    var table = $('#dataTable').DataTable({
        // Konfigurasi DataTable lainnya
        'drawCallback': function() {
            action()
        }
    });

    function action() {
        $('.btn-accept').click(function() {
            let id = $(this).data('id');
            Swal.fire({
                title: '<strong class="text-purple-500">Transfer</strong>',
                showConfirmButton: false,
                showCloseButton: true,
                html: `<form action="{{ route("deposit.accept.admin") }}" method="post" class="grid grid-cols-1 gap-3 text-purple-500">
                    @csrf
                    <input type="hidden" name="id" value="${id}">
                    <input type="number" id="usdt" placeholder="USDT" class="w-full h-10 text-gray-800 px-2 rounded-2xl" step="0.01">
                    <input type="number" id="saldo" name="saldo" placeholder="DOGE" class="w-full h-10 text-gray-800 px-2 rounded-2xl" step="0.01">
                    <button type="submit" onclick="Swal.close()" class="bg-purple-500 hover:bg-blue-600 focus:bg-blue-800 w-ful rounded-2xl py-2 text-black">Send</button>
                    </form>`,
            })
            // $("#submit").click(function() {
            //     let saldo = $("#saldo").val();
            //     let id = $("#id").val();
            //     console.log(id);
            //     return;
            //     $.ajax({
            //         url: "{{ route('deposit.accept.admin') }}",
            //         type: "POST",
            //         data: {
            //             id: id,
            //             saldo: saldo,
            //         },
            //         success: function(response) {
            //             Swal.fire({
            //                 icon: 'success',
            //                 title: 'Berhasil',
            //                 text: 'Deposit telah diterima.'
            //             }).then(function() {
            //                 location.reload();
            //             });
            //         },
            //         error: function(xhr, status, error) {
            //             Swal.fire({
            //                 icon: 'error',
            //                 title: 'Gagal',
            //                 text: 'Erro server.'
            //             });
            //         }
            //     });


            // })

            $("#usdt").keyup(function(e) {
                var usdt = $("#usdt").val();
                $("#saldo").val(usdt / {{doge_price()}} );
            });


        });

    }
</script>



@endsection