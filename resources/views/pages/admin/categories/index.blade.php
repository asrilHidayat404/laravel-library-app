<x-app-layout>
    <div class="p-6">
        <header class="flex justify-between">
            <h1 class="mb-4 text-2xl font-bold">Daftar Kategori</h1>

            <x-bladewind::button class="px-2 py-1 text-white bg-blue-600 rounded addBookBtn">
                Tambah Kategori
            </x-bladewind::button>
        </header>

        @if (session('success'))
            <div class="p-3 mt-3 text-green-700 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

    </div>
    <x-bladewind::table compact="true" id="membersTable" divider="thin">
        <x-slot name="header" class="text-white">
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Jumlah Buku</th>
            <th>Aksi</th>
        </x-slot>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}.</td>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $category->books_count ?? '-' }}</td>
                    <td>
                        <button data-id="{{ $category->id_category }}" data-name="{{ $category->category_name }}"
                            class="px-3 py-1 text-white bg-blue-500 rounded editBtn">
                            Edit
                        </button>

                        <button class="px-3 py-1 text-white bg-red-500 rounded deleteBtn"
                            data-id="{{ $category->id_category }}">
                            Hapus
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-4 text-center">Belum ada kategori</td>
                </tr>
            @endforelse
        </tbody>
    </x-bladewind::table>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.addBookBtn', function() {
        Swal.fire({
            title: 'Tambah Kategori',
            input: "text",
            inputAttributes: {
                autocapitalize: "off"
            },
            inputPlaceholder: 'Nama Kategori..',
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            showLoaderOnConfirm: true,
            preConfirm: (kategori) => {
                if (!kategori) {
                    Swal.showValidationMessage('Input tidak boleh kosong');
                    return false;
                }
                // kembalikan Promise AJAX agar Swal menunggu
                return $.ajax({
                    url: `/dashboard/categories/store`,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        category_name: kategori
                    }
                }).then(res => {
                    if (!res.success) {
                        Swal.showValidationMessage(res.message || 'Terjadi kesalahan!');
                    }
                    return res;
                }).catch(err => {
                    Swal.showValidationMessage(`Request failed: ${err.responseText}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: `Status berhasil diubah menjadi ${result.value.status}`,
                    icon: 'success'
                });


                // opsional: reload page atau update elemen HTML
                setTimeout(() => location.reload(), 1000);
            }
        });
    });

    let selectedId = null;
    $(document).on('click', '.editBtn', function() {
        const id = $(this).data('id');
        const category_name = $(this).data('name');

        Swal.fire({
            title: 'Update Kategori',
            input: "text",
            inputValue: category_name,
            inputAttributes: {
                autocapitalize: "off"
            },
            inputPlaceholder: 'Nama Kategori..',
            showCancelButton: true,
            confirmButtonText: 'Update',
            showLoaderOnConfirm: true,
            preConfirm: (kategori) => {
                if (!kategori) {
                    Swal.showValidationMessage('Input tidak boleh kosong');
                    return false;
                }
                // kembalikan Promise AJAX agar Swal menunggu
                return $.ajax({
                    url: `/dashboard/categories/${id}/update`,
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        category_name: kategori
                    }
                }).then(res => {
                    if (!res.success) {
                        Swal.showValidationMessage(res.message || 'Terjadi kesalahan!');
                    }
                    return res;
                }).catch(err => {
                    Swal.showValidationMessage(`Request failed: ${err.responseText}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: `Status berhasil diubah menjadi ${result.value.status}`,
                    icon: 'success'
                });


                // opsional: reload page atau update elemen HTML
                setTimeout(() => location.reload(), 1000);
            }
        });
    });

    // Confirm delete
    // Klik tombol delete → buka modal
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
                    url: "/dashboard/categories/" + selectedId + "/destroy",
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
</script>
