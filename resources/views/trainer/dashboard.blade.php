<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard trainer</title>
</head>
<body>
    ini dashboard trainer
    @auth {{-- Pastikan user sudah login sebelum menampilkan tombol logout --}}
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf {{-- Wajib untuk form POST di Laravel --}}
        <button type="submit" class="nav-link">Logout</button>
    </form>
@endauth
</body>
</html>