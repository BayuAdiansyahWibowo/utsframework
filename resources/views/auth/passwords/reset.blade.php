@extends('layouts.auth')

@section('content')
<style>
    body {
        background: #f4f7fe;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .reset-container {
        display: flex;
        height: 100vh;
        align-items: center;
        justify-content: center;
    }
    .reset-card {
        background: #fff;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        border-radius: 20px;
        padding: 60px 40px;
        max-width: 500px;
        width: 100%;
        text-align: center;
    }
    .form-control {
        border-radius: 30px;
        padding: 10px 20px;
        margin-bottom: 20px;
    }
    .btn-reset {
        background: #f9b233;
        color: #0a1e51;
        border-radius: 30px;
        padding: 10px;
        border: none;
        font-weight: bold;
    }
    a {
        color: #0a1e51;
        text-decoration: none;
        font-weight: 600;
    }
    a:hover {
        text-decoration: underline;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="reset-container">
    <div class="reset-card">
        <h2>Reset Password</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email', $email ?? '') }}" required autofocus>
            <input type="password" name="password" class="form-control" placeholder="Password Baru" required>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>

            <button type="submit" class="btn-reset w-100">Reset Password</button>
        </form>

        <p class="mt-3">
            <a href="{{ route('login') }}">Kembali ke Login</a>
        </p>
    </div>
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: "{{ session('success') }}",
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: false,
            background: '#d4edda',
            color: '#155724'
        });
    });
</script>
@endif

@if ($errors->any())
<div class="alert alert-danger mx-auto mt-3" style="max-width: 500px;">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@endsection
