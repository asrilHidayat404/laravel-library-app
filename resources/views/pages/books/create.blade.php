<x-app-layout>
    <div class="p-6 mx-auto mt-6 bg-white rounded-lg shadow-md ">
        <h2 class="pb-2 mb-6 text-2xl font-bold text-gray-800 border-b">Tambah Buku Baru</h2>

        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-bladewind::input required="true" name="title" label="Nama Buku" error_message="Masukkan nama" />
                </div>
                <div>
                    <x-bladewind::input required="true" name="author" label="Penulis" error_message="Masukkan penulis" />
                </div>
            </div>

            <div class="w-full md:w-1/2">
                <x-bladewind::input name="published_year" label="Tahun terbit" />
            </div>

            <div class="mt-4">
                <label class="block mb-2 font-medium text-gray-700">Kategori Buku</label>
                <select id="categorySelect" name="categories[]" multiple
                        class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id_category }}" class="p-2">{{ $category->category_name }}</option>
                    @endforeach
                </select>
                <small class="block mt-1 text-sm text-gray-500">
                    Gunakan Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu kategori.
                </small>
            </div>

            <div class="flex justify-end pt-4 border-t">
                <button type="submit" id="createBtn"
                        class="px-6 py-2 font-medium text-white transition-colors duration-200 bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Simpan Buku
                </button>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#createBtn').click(function(e) {
        e.preventDefault();
        let data = {
            _token: "{{ csrf_token() }}",
            title: $('input[name="title"]').val(),
            author: $('input[name="author"]').val(),
            published_year: $('input[name="published_year"]').val(),
            categories: $('#categorySelect').val(),
        };

        console.log(data);

        $.ajax({
            url: "{{ route('dashboard.books.store') }}",
            type: "POST",
            data: data,
            success: function(res) {
                if (res.success) {
                    window.location.href = "/dashboard/books"

                    Swal.fire({
                        title: "Berhasil!",
                        text: res.message,
                        icon: "success"
                    });
                }

            },
            error: function(err) {
                console.log(err);

                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan",
                    icon: "error"
                });
            }
        });
    });
</script>
