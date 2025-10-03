<x-app-layout>


    <b>Create User</b>
    <div class="grid grid-cols-2 gap-4 mt-6">
        <x-bladewind::input required="true" name="username" label="Username" error_message="Masukkan username" />
    </div>

    <x-bladewind::input required="true" name="email" label="Email address" error_message="Masukkan email" />

    <x-bladewind::input name="password" label="password" type="password" />
    <x-bladewind::input numeric="true" name="phone_number" label="Phone Number" />


    <button type="submit" id="createBtn">Submit</button>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#createBtn').click(function(e) {

        e.preventDefault();
        let data = {
            _token: "{{ csrf_token() }}",
            username: $('input[name="username"]').val(),
            email: $('input[name="email"]').val(),
            password: $('input[name="password"]').val(),
            phone_number: $('input[name="phone_number"]').val()
        };


        $.ajax({
            url: "{{ route("dashboard.members.store") }}",
            type: "POST",
            data: data,
            success: function(res) {
                if (res.success) {
                    window.location.href = "/dashboard/members"

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
