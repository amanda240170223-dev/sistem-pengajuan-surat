@extends('layout.app')

@section('content')

<div class="row justify-content-center">

<div class="col-md-4">

<div class="card">

<div class="card-header text-center">
Login Mahasiswa
</div>

<div class="card-body">

<form method="POST" action="/login">

@csrf

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control">
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control">
</div>

<button class="btn btn-primary w-100">
Login
</button>

</form>

</div>

</div>

</div>

</div>

@endsection
