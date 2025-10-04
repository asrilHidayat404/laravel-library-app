<x-app-layout>


    <b>Tambah Buku</b>
    <div class="grid grid-cols-2 gap-4 mt-6">
        <x-bladewind::input required="true" name="title" label="Nama Buku" error_message="Masukkan nama" />
    </div>

    <x-bladewind::input required="true" name="author" label="Penulis" error_message="Masukkan penulis" />

    <x-bladewind::input name="published_year" label="Tahun terbit" />


    <button type="submit" id="createBtn">Submit</button>
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
        };


        $.ajax({
            url: "{{ route("dashboard.books.store") }}",
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
