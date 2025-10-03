<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Bladewind UI -->
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full px-4">
        <div class="flex flex-col items-center justify-center gap-6 ">
            <x-bladewind::card class="p-0 overflow-hidden ">
                <div class="flex w-full p-10">
                    <!-- Form -->
                    <form method="POST" action="{{ route('login') }}" class="flex flex-col flex-1"
                        @submit="loading=true" x-data="{ showPassword: false, loading: false }">
                        @csrf

                        <div class="flex flex-col items-center mb-4 text-center ">
                            <h1 class="text-2xl font-bold">E-Library</h1>
                            <p class="text-gray-500">Login to your account</p>
                        </div>

                        <!-- Email -->
                        <div class="flex flex-col gap-1 mb-4">
                            <x-bladewind::input name="email" type="email" label="Email" placeholder="m@example.com"
                                required="true" />
                            @error('email')
                                <p class="text-[10px] text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="flex flex-col gap-1 mb-4">
                            <x-bladewind::input x-bind:type="showPassword ? 'text' : 'password'" name="password"
                                class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-indigo-200" required
                                label="Password" />
                            @error('password')
                                <p class="text-[10px] text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Show Password + Forgot -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox" x-on:click="showPassword = ! showPassword"
                                    class="w-4 h-4 border rounded" />
                                Show Password
                            </label>
                        </div>

                        <!-- Submit -->
                        <div x-data="{ loading: false }" class="mt-4">
                            <x-bladewind::button uppercasing="false"  class="w-full"
                                @click="loading=true; $el.closest('form').submit()"
                                x-text="loading ? 'Authenticating...' : 'Login'" />
                        </div>

                        <!-- Footer links -->
                        <div class="flex justify-between mt-2">
                            <a href="{{ url('/') }}" class="flex items-center gap-1 text-sm hover:underline">⬅
                                Back</a>
                        </div>

                    </form>

                    <!-- Right side illustration -->
                    <div class="flex items-center justify-center flex-1 md:block">
                        <img src="{{ asset('assets/illustrations/login-bg.png') }}" alt="Login illustration"
                            class="object-contain p-6 max-h-[450px]" />
                    </div>
                </div>
            </x-bladewind::card>
        </div>
    </div>

</body>

</html>
