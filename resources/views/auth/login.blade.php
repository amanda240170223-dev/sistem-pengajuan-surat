@extends('layout.app')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-4">

        <div class="card shadow">

<style>
body {
    background-color: #f5f5f5;
    background-image: url('{{ asset("images/logo.png") }}');
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 1099px;
    background-attachment: fixed;
}
</style>

            <div class="card-header text-center">
                <h4>Login Mahasiswa</h4>
            </div>

            <div class="card-body">

                {{-- Pesan sukses setelah register --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Pesan error login --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Error validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-3">
                        <label>NIM</label>
                        <input type="text"
                               name="nim"
                               class="form-control"
                               placeholder="Masukkan NIM"
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Masukkan Password"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Login
                    </button>
                </form>

                <div class="text-center mt-3">
                    Belum punya akun?
                    <a href="/register">Register</a>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
