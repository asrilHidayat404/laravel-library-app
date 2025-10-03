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
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="flex items-center gap-2 px-4 py-2">
                        <img src="{{ asset('assets/' . $m->user->avatar) }}" width="40" alt=""
                            class="rounded-full">

                        {{ $m->user->username }}
                    </td>
                    <td class="px-4 py-2">{{ $m->user->email }}</td>
                    <td class="px-4 py-2">{{ $m->phone_number }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('dashboard.members.edit', $m->id_member) }}">
                            <button class="px-3 py-1 text-white bg-blue-500 rounded"">
                                Update
                            </button>
                        </a>
                        <button class="px-3 py-1 text-white bg-red-500 rounded deleteBtn" data-id="{{ $m->id_member }}">
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-4 text-center">No members found.</td>
                </tr>
            @endforelse
        </tbody>
    </x-bladewind::table>

    <div class="flex justify-end mt-4">
        {{ $members->links() }}
    </div>

    <!-- Modal sederhana -->
    <div id="deleteModal" class="fixed inset-0 z-10 flex items-center justify-center hidden bg-opacity-50">

        <div class="p-6 bg-white rounded shadow-lg w-96">
            <h2 class="mb-4 text-lg font-bold">Confirm Delete</h2>
            <p>Are you sure you want to delete this member?</p>
            <div class="flex justify-end mt-4 space-x-2">
                <button id="cancelBtn" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button id="confirmDeleteBtn" class="px-4 py-2 text-white bg-red-500 rounded">Yes,
                    Delete</button>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let selectedId = null;

    // Klik tombol delete → buka modal
    $(document).on('click', '.deleteBtn', function() {
        selectedId = $(this).data('id');
        $('#deleteModal').removeClass('hidden');
    });
    // Cancel → tutup modal
    $('#cancelBtn').click(function() {
        $('#deleteModal').addClass('hidden');
        selectedId = null;
    });

    // Confirm delete
    $('#confirmDeleteBtn').click(function() {
        if (!selectedId) return;
        console.log(selectedId);


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
                }

            },
            error: function(err) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan!",
                    icon: "failed"
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
