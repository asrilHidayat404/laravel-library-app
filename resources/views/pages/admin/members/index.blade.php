<x-app-layout>

    <header class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Manajemen Anggota Perpustakaan</h1>
        <a href="{{ route('dashboard.members.create') }}">
            <x-bladewind::button>Create User</x-bladewind::button>
        </a>
    </header>
    <div>
        <input type="text" id="searchInput" placeholder="Search..." class="w-full px-4 py-2 mb-4 border rounded"
            onkeyup="showResult(this.value)">
    </div>
    <x-bladewind::table compact="true" id="membersTable" divider="thin">
        <x-slot name="header" class="text-white">
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Telepon/ WA</th>
            <th>Aksi</th>
        </x-slot>
        <tbody id='tbody'>
            @forelse ($members as $m)
                <tr id="row-{{ $m->id_member }}" class="border-b">
                    <td class="px-4 py-2">{{ $loop->iteration }}.</td>
                    <td class="flex items-center gap-2 px-4 py-2">
                        <img src="{{ asset('storage/' . $m->user->avatar) }}" width="40" alt=""
                            class="rounded-full">

                        {{ $m->user->username }}
                    </td>
                    <td class="px-4 py-2">{{ $m->user->email }}</td>
                    <td class="px-4 py-2">{{ $m->phone_number }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('dashboard.members.edit', $m->id_member) }}">
                            <button class="px-3 py-1 text-white bg-blue-500 rounded"">
                                Edit
                            </button>
                        </a>
                        <button class="px-3 py-1 text-white bg-red-500 rounded deleteBtn" data-id="{{ $m->id_member }}">
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-4 text-center">No members found.</td>
                </tr>
            @endforelse
        </tbody>
    </x-bladewind::table>

    <div class="flex justify-end mt-4">
        {{ $members->links() }}
    </div>

</x-app-layout>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let selectedId = null;


    // Confirm delete
     $(document).on('click', '.deleteBtn', function() {
        selectedId = $(this).data('id');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "/dashboard/members/" + selectedId + "/destroy",
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {

                        $("#row-" + selectedId).remove();
                        $('#deleteModal').addClass('hidden');
                        selectedId = null;
                        if (res.success) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: res.message,
                                icon: "success"
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                        console.log(res);


                    },
                    error: function(err) {
                        console.log(err);

                        Swal.fire({
                            title: "Gagal!",
                            text: "Terjadi kesalahan!",
                            icon: "failed"
                        });
                    }
                });
            }
        });
    });

    function showResult(str) {
        $.ajax({
            url: "/dashboard/members",
            type: "GET",
            data: {
                str: str // harus sesuai dengan controller
            },
            success: function(res) {
                // kosongkan tbody

                $('#tbody').html('');

                if (!res.members) {
                    $('#tbody').html(
                        '<tr><td colspan="5" class="py-4 text-center">No members found.</td></tr>');
                } else {

                    $.each(res.members, function(index, m) {
                        let row = `<tr id="row-${m.id_member}">
                                        <td>${index+1}</td>
                                        <td class="flex items-center gap-2">
                                            <img src="/storage/${m.user.avatar}" width="40" class="rounded-full">
                                            ${m.user.username}
                                        </td>
                                        <td>${m.user.email}</td>
                                        <td>${m.phone_number}</td>
                                        <td>
                                            <a href="/dashboard/members/${m.id_member}/edit">
                                                <button class="px-3 py-1 text-white bg-blue-500 rounded">Update</button>
                                            </a>
                                            <button class="px-3 py-1 text-white bg-red-500 rounded deleteBtn" data-id="${m.id_member}">Delete</button>
                                        </td>
                                    </tr>`;
                        $('#tbody').append(row);
                    });

                }
            },
            error: function(err) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan!",
                    icon: "error"
                });
            }
        });
    }
</script>
