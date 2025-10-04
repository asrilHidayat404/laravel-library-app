<x-app-layout>

    <header class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Manajemen Buku Perpustakaan</h1>
        <a href="{{ route('dashboard.books.create') }}">
            <x-bladewind::button>Tambah Buku</x-bladewind::button>
        </a>
    </header>
    <div>
        <input type="text" id="searchInput" placeholder="Search..."
            class="w-full px-4 py-2 mb-4 border-none rounded shadow" onkeyup="showResult(this.value)">
    </div>
    <main id="booksContainer" class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($books as $b)
            <div class="p-1 bg-gray-200 rounded-lg">
                <x-bladewind::card class="overflow-hidden transition-shadow duration-300 rounded-lg hover:shadow-lg">

                    <!-- Header -->
                    <header class="px-4 pt-3 pb-2 mb-6">
                        <h3 class="text-lg font-semibold truncate" title="{{ $b->title }}">
                            {{ $b->title }}
                        </h3>
                        <p class="text-sm truncate" title="{{ $b->author }}">
                            {{ $b->author }}
                        </p>
                    </header>

                    <!-- Cover Image -->
                    <img src="{{ $b->cover ? asset('storage/' . $b->cover) : asset('assets/illustrations/book.jpg') }}"
                        alt="{{ $b->title }}" class="object-cover w-full h-48 " />

                    <!-- Footer -->
                    <footer class="flex flex-col justify-between gap-4 p-4 mt-2 flex-colr">
                        <div class="flex space-x-2">
                            <span class="text-sm text-gray-600">Category: {{ $b->category ?? '-' }}</span>
                        </div>
                        @can("admin")
                            <div>
                            <a href="{{ route('dashboard.books.edit', $b->id_book) }}">
                                <button class="px-3 py-1 text-white bg-blue-500 rounded"">
                                    Edit
                                </button>
                            </a>
                            <button class="px-3 py-1 text-white bg-red-500 rounded deleteBtn"
                                data-id="{{ $b->id_book }}">
                                Delete
                            </button>
                        </div>
                        @endcan
                        @can('member')
                             <button class="px-3 py-1 text-white bg-yellow-500 rounded pinjamBtn"
                                data-id="{{ $b->id_book }}">
                                Pinjam Buku
                            </button>
                        @endcan
                    </footer>

                </x-bladewind::card>
            </div>
        @empty
            <p class="text-center text-gray-500 col-span-full">No books available.</p>
        @endforelse
    </main>
    <div class="flex justify-end mt-4">
        {{ $books->links() }}
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
    $(document).on('click', '.pinjamBtn', function() {
        selectedId = $(this).data('id');
        Swal.fire({
            title: "Apakah ada ingin meminjam buku ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "/dashboard/borrows/" + selectedId + "/store",
                    type: "POST",
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
            url: "/dashboard/books",
            type: "GET",
            data: {
                str: str
            },
            success: function(res) {
                const container = $('#booksContainer');
                container.html(''); // kosongkan

                if (!res.books || res.books.length === 0) {
                    container.html(
                        '<p class="text-center text-gray-500 col-span-full">No books found.</p>');
                    return;
                }

                console.log(res);

                res.books.forEach(b => {
                    let cover = b.cover ? `/storage/${b.cover}` : '/assets/illustrations/book.jpg';
                    let bookHtml = `
                    <div class="p-1 bg-gray-200 rounded-lg book-card" data-id="${b.id_book}">
                        <div class="overflow-hidden transition-shadow duration-300 bg-white rounded-lg hover:shadow-lg">
                            <header class="px-4 pt-3 pb-2">
                                <h3 class="text-lg font-semibold truncate" title="${b.title}">${b.title}</h3>
                                <p class="text-sm truncate" title="${b.author}">${b.author}</p>
                            </header>
                            <img src="${cover}" alt="${b.title}" class="object-cover w-full h-48" />
                            <footer class="flex items-center justify-between p-4 mt-2">
                                <span class="text-sm text-gray-600">Category: ${b.category ?? '-'}</span>
                                <div>
                                    <button class="px-3 py-1 text-white bg-blue-500 rounded updateBtn" data-id="${b.id_book}">Update</button>
                                    <button class="px-3 py-1 text-white bg-red-500 rounded deleteBtn" data-id="${b.id_book}">Delete</button>
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
</script>
