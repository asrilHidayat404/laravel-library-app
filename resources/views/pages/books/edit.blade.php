<x-app-layout>


    <b>Edit {{ $book->title }} Profile</b>
    <div class="grid grid-cols-1 gap-4 mt-6">
        <x-bladewind::input required="true" name="title" label="Judul Buku" error_message="Please enter a title"
            value="{{ old('title', $book->title) }}" />
        <x-bladewind::input required="true" name="author" label="Penulis" error_message="Please enter an author"
            value="{{ old('author', $book->author) }}" />
        <x-bladewind::input required="true" name="published_year" label="Tahun Terbit"
            error_message="Please enter published year" value="{{ old('published_year', $book->published_year) }}" />
        <button type="submit" id="updateBtn" class="py-2 font-semibold text-white bg-blue-500 rounded-xl">Submit</button>
    </div>



</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Confirm delete
    $('#updateBtn').click(function(e) {
        e.preventDefault();
        let data = {
            _token: "{{ csrf_token() }}",
            title: $('input[name="title"]').val(),
            author: $('input[name="author"]').val(),
            published_year: $('input[name="published_year"]').val(),
        };

        $.ajax({
            url: "/dashboard/books/{{ $book->id_book }}/update",
            type: "PUT",
            data: data,
            success: function(res) {
                selectedId = null;
                if (res.success) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: res.message,
                        icon: "success"
                    });
                    setTimeout(() => {
                        window.location.href = "/dashboard/books/"
                    }, 1500);

                }

            },
            error: function(err) {
                console.log(err);


                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan, " + err.responseJSON.message,
                    icon: "error"
                });
            }
        });
    });
</script>
