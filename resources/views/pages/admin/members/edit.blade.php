<x-app-layout>
    <div class="p-6 mx-auto mt-6 rounded-lg shadow-md">
        <h2 class="pb-2 mb-6 text-2xl font-bold text-gray-800 border-b">Edit Profile - {{ $member->user->username }}</h2>

        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-bladewind::input required="true" name="username" label="Username" error_message="Please enter your first name"
                        value="{{ old('username', $member->user->username) }}" />
                </div>
                <div>
                    <x-bladewind::input numeric="true" name="phone_number" label="Phone Number"
                        value="{{ old('phone_number', $member->phone_number) }}" />
                </div>
            </div>

            <div>
                <x-bladewind::input required="true" name="email" label="Email address" error_message="Please enter your email"
                    value="{{ old('email', $member->user->email) }}" />
            </div>

            <div class="flex justify-between pt-4 border-t">
                <a href="/dashboard/members"
                   class="px-6 py-2 font-medium text-gray-700 transition-colors duration-200 bg-gray-300 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Kembali
                </a>
                <button type="submit" id="updateBtn"
                        class="px-6 py-2 font-medium text-white transition-colors duration-200 bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Update Profile
                </button>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
                    icon: "error"
                });
            }
        });
    });
</script>
