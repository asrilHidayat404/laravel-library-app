<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="mb-4 text-xl font-bold">Tes API Buku</h2>

                <div class="mb-4 space-x-3">
                    <button id="btnBooks" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                        GET /api/books
                    </button>

                    <button id="btnBorrow" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">
                        POST /api/borrow
                    </button>

                    <button id="btnBorrowShow" class="px-4 py-2 text-white bg-purple-600 rounded hover:bg-purple-700">
                        GET /api/borrow/{id}
                    </button>
                </div>

                <pre id="result" class="p-4 text-sm bg-gray-100 border rounded"></pre>
            </div>
        </div>
    </div>

    {{-- jQuery CDN --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // GET /api/books
        $('#btnBooks').on('click', function() {
            $.get('/api/books')
                .done(function(data) {
                    $('#result').text(JSON.stringify(data, null, 2));
                })
                .fail(function(xhr) {
                    $('#result').text('Error: ' + xhr.status + ' - ' + xhr.responseText);
                });
        });


        $('#btnBorrow').on('click', function() {
            $.ajax({
                url: '/api/borrow',
                type: 'POST',
                data: {
                    book_id: 1, // ubah sesuai data kamu
                    member_id: 1, // ubah sesuai data kamu
                    borrow_date: '2025-10-04',
                    due_date: '2025-10-10',
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#result').text(JSON.stringify(data, null, 2));
                },
                error: function(xhr) {
                    $('#result').text('Error: ' + xhr.status + ' - ' + xhr.responseText);
                }
            });
        });

        // GET /api/borrow/{id}
        $('#btnBorrowShow').on('click', function() {
            const id = prompt('Masukkan ID peminjaman:', 1);
            if (!id) return;

            $.get(`/api/borrow/${id}`)
                .done(function(data) {
                    $('#result').text(JSON.stringify(data, null, 2));
                })
                .fail(function(xhr) {
                    $('#result').text('Error: ' + xhr.status + ' - ' + xhr.responseText);
                });
        });
    </script>
</x-app-layout>
