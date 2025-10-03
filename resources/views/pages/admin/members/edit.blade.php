<x-app-layout>


    <b>Edit {{ $member->user->username }} Profile</b>
    <div class="grid grid-cols-2 gap-4 mt-6">
        <x-bladewind::input required="true" name="username" label="Username" error_message="Please enter your first name"
            value="{{ old('username', $member->user->username) }}" />
    </div>

    <x-bladewind::input required="true" name="email" label="Email address" error_message="Please enter your email"
        value="{{ old('email', $member->user->email) }}" />

    <x-bladewind::input numeric="true" name="phone_number" label="Phone Number"
        value="{{ old('phone_number', $member->phone_number) }}" />

    <button type="submit" id="updateBtn">Submit</button>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Confirm delete
    $('#updateBtn').click(function(e) {
        e.preventDefault();
        let data = {
            _token: "{{ csrf_token() }}",
            username: $('input[name="username"]').val(),
            email: $('input[name="email"]').val(),
            phone_number: $('input[name="phone_number"]').val()
        };

        $.ajax({
            url: "/dashboard/members/{{ $member->id_member }}/update",
            type: "PUT",
            data: data,
            success: function(res) {
                selectedId = null;
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
                Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan",
                        icon: "failed"
                    });
            }
        });
    });
</script>
