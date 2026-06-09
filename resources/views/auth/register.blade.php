@extends('layout.app')

@section('content')

<style>
body {
    background-color: #f5f5f5;

    /* Logo sebagai background */
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 400px;

}

.logo-bg{
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 1000px;
    opacity: 0.80;
    z-index: -1;
    pointer-events: none;
}
</style>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
    <body class="admin-background"></body>
<img src="{{ asset('images/logo.png') }}"
     class="logo-bg"
     alt="Logo">


        <div class="card">
            <div class="card-header text-center">
                <h4>Register Mahasiswa</h4>
            </div>

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="/register" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>NIM</label>
                        <input type="text" name="nim" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Register
                    </button>

                    <div class="text-center mt-3">
                        <a href="/">Sudah punya akun? Login</a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
