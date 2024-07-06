@extends('admin.template.master')

@section('content')

<div class="w-full mx-2">
    <div class="w-full py-2 pl-3 bg-[#343a40]">
        <div class="flex">
            <svg viewBox="0 0 640 512" class="w-7 h-7">
                <path fill="currentColor" d="M72 88a56 56 0 1 1 112 0A56 56 0 1 1 72 88zM64 245.7C54 256.9 48 271.8 48 288s6 31.1 16 42.3V245.7zm144.4-49.3C178.7 222.7 160 261.2 160 304c0 34.3 12 65.8 32 90.5V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V389.2C26.2 371.2 0 332.7 0 288c0-61.9 50.1-112 112-112h32c24 0 46.2 7.5 64.4 20.3zM448 416V394.5c20-24.7 32-56.2 32-90.5c0-42.8-18.7-81.3-48.4-107.7C449.8 183.5 472 176 496 176h32c61.9 0 112 50.1 112 112c0 44.7-26.2 83.2-64 101.2V416c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32zm8-328a56 56 0 1 1 112 0A56 56 0 1 1 456 88zM576 245.7v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM320 32a64 64 0 1 1 0 128 64 64 0 1 1 0-128zM240 304c0 16.2 6 31 16 42.3V261.7c-10 11.3-16 26.1-16 42.3zm144-42.3v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM448 304c0 44.7-26.2 83.2-64 101.2V448c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V405.2c-37.8-18-64-56.5-64-101.2c0-61.9 50.1-112 112-112h32c61.9 0 112 50.1 112 112z" />
            </svg>
            <span class="ml-2">Users</span>
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
                    <td>Wallet Address</td>
                    <td>Date</td>
                    <td>USDT</td>
                    <td>Fexa</td>
                    <td>Doge</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
               @foreach ($users as $user)
                   <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ number_format($user->usdt,2) }}</td>
                    <td>{{ number_format($user->saldo) }}</td>
                    <td>{{ number_format($user->doge,2) }}</td>
                    <td class="flex justify-between px-1 lg:px-5">
                        <button class="mx-1 btn-edit" title="Edit" link="{{ route('users.admin.edit',['id'=>encrypt($user->id)]) }}"
                            data-id="{{ encrypt($user->id) }}"
                            data-username="{{ $user->username }}"
                            data-saldo="{{ $user->saldo }}"
                            data-role="{{ $user->role }}"
                            data-phone="{{ $user->phone }}"
                            data-wallet="{{ $user->wallet }}"
                            data-usdt="{{ $user->usdt }}"
                            data-saldo="{{ $user->saldo }}"
                            >
                            <svg viewBox="0 0 640 512" class="w-5 text-green-500">
                                <path fill="currentColor" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H322.8c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1H178.3zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z"/>
                            </svg>
                        </button>
                        <button class="mx-1 btn-delete" title="Delete" link="{{ route('users.admin.delete',['id'=>encrypt($user->id)]) }}">
                            <svg viewBox="0 0 448 512" class="w-5 text-red-500">
                                <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                            </svg>
                        </button>
                        <button class="mx-1 btn-login" title="Login" link="{{ route('users.admin.login',['id'=>encrypt($user->id)]) }}">
                            <svg viewBox="0 0 512 512" class="w-5 text-blue-500">
                                <path fill="currentColor" d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/>
                            </svg>
                        </button>

                    </td>
                   </tr>
               @endforeach
            </tbody>
        </table>
    </div>



</div>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $('.btn-delete').click(function () { 
            var link = $(this).attr('link');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            })
            
        });
        $('.btn-login').click(function () { 
            var link = $(this).attr('link');
            Swal.fire({
                title: 'Are you sure?',
                text: "want to login to this account!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Login it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            })
            
        });

        $('.btn-edit').click(function(){
            var username = $(this).attr('data-username');
            var id = $(this).attr('data-id');
            var saldo = $(this).attr('data-saldo');
            var role = $(this).attr('data-role');
            var phone = $(this).attr('data-phone');
            var wallet = $(this).attr('data-wallet');
            var usdt = $(this).attr('data-usdt');
            var saldo = $(this).attr('data-saldo');

            Swal.fire({
                title: '<strong>Edit Data User</strong>',
                html:`
                    <form action="{{ route('users.admin.edit') }}" method="post" class="grid grid-cols-1 gap-4">
                        @csrf
                        <input type="hidden" name="id" value="${id}">
                        <div class="text-left">
                            <label>Username</label>
                            <input type="text" name="username" placeholder="Username" value="${username}" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                        </div>
                        <div class="text-left">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Password" value="" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                        </div>
                        <div class="text-left">
                            <label>Phone</label>
                            <input type="text" name="phone" placeholder="Phone" value="${phone}" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                        </div>
                        <div class="text-left">
                            <label>Wallet</label>
                            <input type="text" name="wallet" placeholder="Wallet" value="${wallet}" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5"> 
                        </div>
                        <div class="text-left">
                            <label>USDT</label>
                            <input type="number" name="usdt" step="0.001" placeholder="USDT" value="${usdt}" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5" > 
                        </div>
                        <div class="text-left">
                            <label>Fexa</label>
                            <input type="number" name="saldo" step="0.001" placeholder="Fexa" value="${saldo}" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5" > 
                        </div>
                        <div class="text-left">
                            <label>Role</label>
                            <select name="role" class="bg-[#454d55] border border-black rounded-lg focus:ring-blue-800 focus:border-blue-900 w-full p-2.5">
                                    <option value="admin" ${role=='admin'?'selected':''}>Admin</option>
                                    <option value="customer" ${role=='customer'?'selected':''}>Customer</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-indigo-800 hover:bg-indigo-900 focus:ring-4 focus:outline-none focus:ring-indigo-500 font-medium rounded-lg px-5 py-2.5">Submit</button>
                    </form>
                `,
                showCloseButton: true,
                showCancelButton: false,
                showConfirmButton: false,
            })
        })




        var table = $('#dataTable').DataTable();

        



       
        

      
        @if ($errors->any())
        @php
            $number=1;
        @endphp
        Swal.fire({
            icon: 'error',
            title: 'Maaf',
            html: `
            <ul class="list-decimal">
                @foreach ($errors->all() as $error)
                <li class="text-left text-red-500 font-semibold">{{ $number++ }}.{{ $error }}</li>
                @endforeach
            </ul>
            `,
        })
        @endif

    });
</script>

@endsection