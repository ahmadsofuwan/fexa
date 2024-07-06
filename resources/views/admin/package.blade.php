@extends('admin.template.master')

@section('content')
<div class="w-full mx-2">
    <div class="w-full py-2 pl-3 bg-[#343a40]">
        <div class="flex">
            <svg viewBox="0 0 512 512" class="w-7 h-7">
                <path fill="currentColor" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
            </svg>
            <span class="ml-2">Package</span>
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
                    <td>Price</td>
                    <td>Total Profit</td>
                    <td>Hours</td>
                    <td>Profit / Hours</td>
                    <td>Stock</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $package)
                <tr>
                    <td>{{ number_format($package->price) }}</td>
                    <td>{{ number_format($package->total_profit) }}</td>
                    <td>{{ number_format($package->hours) }}</td>
                    <td>{{ number_format($package->total_profit / $package->hours) }}</td> 
                    <td>{{ number_format($package->stock) }}</td>
                    <td>
                        <div class="flex justify-between px-2">
                            <button class="bg-green-500 hover:bg-green-600 focus:bg-green-600 py-1 px-2 rounded-lg btn-edit" data-id="{{ $package->id }}">Edit</button>
                            <button class="bg-red-500 hover:bg-red-600 focus:bg-red-600 py-1 px-2 rounded-lg btn-delete" data-link="{{ route('package.admin.delete',['id'=>$package->id]) }}">Delete</button>
                        </div>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });


        $('.btn-delete').click(function(){
            Swal.fire({
                title: "Do you want to Delete the data?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Cancel",
                denyButtonText: `Delete`
                }).then((result) => {
                if (result.isDenied) { //jadi delete warna merah
                    window.location.href = $(this).data('link');
                }
            });
        })


        $('.btn-edit').click(function() {
            let id = $(this).data('id');

            $.ajax({
                url: '{{ route("package.admin.get") }}',
                type: 'post',
                dataType: 'json',
                data: {id: id},
                
            })
            .done(function(data) {
                
                Swal.fire({
                    title: '<strong class="text-purple-500">Edit</strong>',
                    showConfirmButton: false,
                    showCloseButton: true,
                    html: `
                    <form action="{{ route('package.admin.update') }}" method="post" class="grid grid-cols-1 gap-3">
                        @csrf
                        <input type="hidden" name="id" value="${data.id}">
                        <div class="grid grid-cols-2 gap-2">

                            <div class="text-left">
                                <label>Price</label>
                                <input type="number" name="price" placeholder="Price" value="${data.price}" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                            </div>
                            <div class="text-left">
                                <label>Total Profit</label>
                                <input type="number" name="profit" placeholder="Profit" min="1" value="${data.total_profit}" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                            </div>

                            <div class="text-left">
                                <label>Hours</label>
                                <input type="number" name="hours" placeholder="Fee" min="1" value="${data.hours}" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                            </div>
                            <div class="text-left">
                                <label>Profit / Hours</label>
                                <input disabled type="number" name="profithours" id="profithours" placeholder="Stock" min="1" value="${data.total_profit/data.hours}" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                            </div>
                                <div class="text-left">
                                <label>Stock</label>
                                <input type="number" name="stock" placeholder="Fee" min="1" value="${data.stock}" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                            </div>

                        </div>

                        <button onclick="Swal.close()" class="bg-purple-500 hover:bg-blue-600 focus:bg-blue-800 w-ful rounded-2xl py-2 text-black">Submit</button>
                    </form>`,
                })

                $('input[name="hours"], input[name="profit"]').on('change keyup', function() {
                    let hours = $('input[name="hours"]').val();
                    let profit = $('input[name="profit"]').val();
                    let profithours = profit / hours;
                    $('#profithours').val(profithours);
                });



            })
            .fail(function() {
                console.log('error');
            })

            


            
        });

        $('#add').click(function() {
            
            Swal.fire({
                    title: '<strong class="text-purple-500">Edit</strong>',
                    showConfirmButton: false,
                    showCloseButton: true,
                    html: `
                    <form action="{{ route('package.admin.add') }}" method="post" class="grid grid-cols-1 gap-3">
                        @csrf
                        <div class="grid grid-cols-2 gap-2">

                            <div class="text-left">
                                <label>Price</label>
                                <input type="number" name="price" placeholder="Price" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                            </div>
                            <div class="text-left">
                                <label>Total Profit</label>
                                <input type="number" name="profit" placeholder="Profit" min="1" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                            </div>

                            <div class="text-left">
                                <label>Hours</label>
                                <input type="number" name="hours" placeholder="hours" min="1" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                            </div>
                            <div class="text-left">
                                <label>Profit / Hours</label>
                                <input disabled type="number" name="profithours" id="profithours" placeholder="profit" min="1" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                            </div>
                                <div class="text-left">
                                <label>Stock</label>
                                <input type="number" name="stock" placeholder="stock" min="1" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                            </div>

                        </div>

                        <button onclick="Swal.close()" class="bg-purple-500 hover:bg-blue-600 focus:bg-blue-800 w-ful rounded-2xl py-2 text-black">Submit</button>
                    </form>`,
                })
                $('input[name="hours"], input[name="profit"]').on('change keyup', function() {
                    let hours = $('input[name="hours"]').val();
                    let profit = $('input[name="profit"]').val();
                    let profithours = profit / hours;
                    $('#profithours').val(profithours);
                });

        })

    }
</script>



@endsection