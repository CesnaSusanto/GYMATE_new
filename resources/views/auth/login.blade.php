<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Fitness</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-300 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden max-w-3xl w-full flex">
        <div class="bg-red-600 flex-1 flex items-center justify-center p-12">
            <h1 class="text-white text-4xl font-bold tracking-wider">GYMATE</h1>
        </div>
        <div class="flex-1 p-12 flex flex-col justify-center">
            <div class="max-w-sm mx-auto w-full">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center uppercase">Login</h2>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <span class="block sm:inline">{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" name="username" id="username" class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:outline-none" value="{{ old('username') }}" required autofocus>
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <input type="password" name="password" id="password" class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:outline-none" required autocomplete="current-password">
                    </div>

                    <!-- <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="form-checkbox">
                            <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                        </label>
                        {{-- <a href="#" class="text-sm text-blue-500 hover:text-blue-800">Lupa Password?</a> --}}
                    </div> -->

                    <div class="flex items-center justify-between">
                        <button type="submit" class="w-full bg-red-500 text-white py-3 px-4 rounded-lg font-semibold text-lg hover:bg-red-600 transition-colors uppercase">
                            Login
                        </button>
                    </div>

                    <p class="text-center text-sm text-gray-600 mt-4">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-800">Daftar di sini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>