<x-app-layout>

    <header class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Manajemen Peminjaman Buku Perpustakaan</h1>

    </header>
    <div>
        <input type="text" id="searchInput" placeholder="Search..."
            class="w-full px-4 py-2 mb-4 border-none rounded shadow" onkeyup="showResult(this.value)">
    </div>
    <main id="booksContainer" class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($borrowedBook as $b)
            <div class="p-1 bg-gray-200 rounded-lg">
                <x-bladewind::card class="overflow-hidden transition-shadow duration-300 rounded-lg hover:shadow-lg">

                    <!-- Header -->
                    <header class="px-4 pt-3 pb-2 mb-6">
                        <h3 class="text-lg font-semibold truncate" title="{{ $b->book->title }}">
                            {{ $b->book->title }}
                        </h3>
                        <p class="text-sm truncate" title="{{ $b->book->author }}">
                            Peminjam: {{ $b->member->user->username }}
                        </p>
                    </header>

                    <!-- Cover Image -->
                    <img src="{{ $b->book->cover ? asset('storage/' . $b->book->cover) : asset('assets/illustrations/book.jpg') }}"
                        alt="{{ $b->book->title }}" class="object-cover w-full h-48 " />

                    <!-- Footer -->
                    <footer class="flex flex-col justify-between gap-4 p-4 mt-2 flex-colr">
                        <div class="flex space-x-2">
                            <span class="text-sm text-gray-600">Category: {{ $b->book->category ?? '-' }}</span>
                        </div>
                        <div>
                            @can('admin')
                                <button class="px-3 py-1 text-white bg-blue-500 rounded editBtn"
                                    data-id="{{ $b->id_borrowed_book }}">
                                    Edit
                                </button>
                                <button class="px-3 py-1 text-white bg-red-500 rounded deleteBtn"
                                    data-id="{{ $b->id_borrowed_book }}">
                                    Delete
                                </button>
                            @endcan

                            <button class="px-3 py-1 text-white bg-green-500 rounded showDetailBtn"
                                data-borrowed="{{ $b }}">
                                Detail
                            </button>
                        </div>
                    </footer>

                </x-bladewind::card>
            </div>
        @empty
            <p class="text-center text-gray-500 col-span-full">No books available.</p>
        @endforelse
    </main>
    <div class="flex justify-end mt-4">
        {{ $borrowedBook->links() }}
    </div>

    <!-- Modal sederhana -->
    <div id="deleteModal" class="fixed inset-0 z-10 flex items-center justify-center hidden bg-opacity-50">

        <div class="p-6 bg-white rounded shadow-lg w-96">
            <h2 class="mb-4 text-lg font-bold">Confirm Delete</h2>
            <p>Are you sure you want to delete this book?</p>
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
                    url: "/dashboard/borrows/" + selectedId + "/destroy",
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
            url: "/dashboard/borrows",
            type: "GET",
            data: {
                str: str
            },
            success: function(res) {
                const container = $('#booksContainer');
                container.html(''); // kosongkan

                if (!res.borrowedBooks || res.borrowedBooks.length === 0) {
                    container.html(
                        '<p class="text-center text-gray-500 col-span-full">No books found.</p>'
                    );
                    return;
                }

                res.borrowedBooks.forEach(b => {
                    let cover = b.book.cover ? `/storage/${b.book.cover}` :
                        '/assets/illustrations/book.jpg';
                    let bookHtml = `
                <div class="p-1 bg-gray-200 rounded-lg">
                    <div class="overflow-hidden transition-shadow duration-300 bg-white rounded-lg hover:shadow-lg">
                        <header class="px-4 pt-3 pb-2 mb-6">
                            <h3 class="text-lg font-semibold truncate" title="${b.book.title}">${b.book.title}</h3>
                            <p class="text-sm truncate" title="Peminjam: ${b.member.user.username}">
                                Peminjam: ${b.member.user.username}
                            </p>
                        </header>
                        <img src="${cover}" alt="${b.book.title}" class="object-cover w-full h-48" />
                        <footer class="flex flex-col justify-between gap-4 p-4 mt-2 flex-colr">
                            <div class="flex space-x-2">
                                <span class="text-sm text-gray-600">Category: ${b.book.category ?? '-'}</span>
                            </div>
                            <div>
                                <a href="/dashboard/books/${b.id_borrowed_book}/edit">
                                    <button class="px-3 py-1 text-white bg-blue-500 rounded">Edit</button>
                                </a>
                                <button class="px-3 py-1 text-white bg-red-500 rounded deleteBtn" data-id="${b.book.id_book}">
                                    Delete
                                </button>
                                <button class="px-3 py-1 text-white bg-green-500 rounded showDetailBtn" data-borrowed='${JSON.stringify(b)}'>
                                    Detail
                                </button>
                            </div>
                        </footer>
                    </div>
                </div>`;
                    container.append(bookHtml);
                });
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


    $(document).on('click', '.showDetailBtn', function() {
        selectedBook = $(this).data('borrowed');
        showDetail(selectedBook)
    })

    function showDetail(selectedBook) {
        console.log(selectedBook);

        Swal.fire({
            title: `<strong>${selectedBook.book.title}</strong>`,
            icon: "info",
            html: `
                    <ul>
                        <li>Tanggal Peminjaman: ${selectedBook.borrowed_date}</li>
                        <li>Tanggal Pengembalian: ${selectedBook.due_date}</li>
                        <li>Status Peminjaman: ${selectedBook.status == 'borrowed' ? "Dipinjam" : "Dikembalikan"}</li>
                    </ul>
                `,
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
        });

    }

    $(document).on('click', '.editBtn', function() {
        const borrowedId = $(this).data('id'); // ambil id peminjaman

        Swal.fire({
            title: 'Update Status Peminjaman',
            input: 'select',
            inputOptions: {
                'Dipinjam': 'Dipinjam',
                'Dikembalikan': 'Dikembalikan'
            },
            inputPlaceholder: 'Pilih status',
            showCancelButton: true,
            confirmButtonText: 'Update',
            showLoaderOnConfirm: true,
            preConfirm: (status) => {
                if (!status) {
                    Swal.showValidationMessage('Pilih status terlebih dahulu!');
                    return false;
                }

                const state = status == 'Dipinjam' ? 'borrowed' :
                'returned'; // 'Dipinjam' atau 'Dikembalikan'

                // kembalikan Promise AJAX agar Swal menunggu
                return $.ajax({
                    url: `/dashboard/borrows/${borrowedId}/update`,
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: state
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
</script>
