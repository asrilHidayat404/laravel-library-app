<x-app-layout>
    <div class="p-6 mx-auto mt-6 rounded-lg shadow-md">
        <h2 class="pb-2 mb-6 text-2xl font-bold text-gray-800 border-b">Tambah User Baru</h2>

        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <x-bladewind::input required="true" name="username" label="Username" error_message="Masukkan username" />
                </div>
                <div>
                    <x-bladewind::input numeric="true" name="phone_number" label="Phone Number" />
                </div>
            </div>

            <div>
                <x-bladewind::input required="true" name="email" label="Email address" error_message="Masukkan email" />
            </div>

            <div class="w-full md:w-1/2">
                <x-bladewind::input name="password" label="Password" type="password" />
            </div>

            <div class="flex justify-end pt-4 border-t">
                <button type="submit" id="createBtn"
                        class="px-6 py-2 font-medium text-white transition-colors duration-200 bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Simpan User
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
            username: $('input[name="username"]').val(),
            email: $('input[name="email"]').val(),
            password: $('input[name="password"]').val(),
            phone_number: $('input[name="phone_number"]').val()
        };

        $.ajax({
            url: "{{ route('dashboard.members.store') }}",
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
