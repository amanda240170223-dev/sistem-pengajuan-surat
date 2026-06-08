<!DOCTYPE html>
<html lang="en">
<head>
<style>
body{
    background-color:#f8f9fa;
}

/* Logo sebagai background */
.logo-bg{
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    width:1000px;
    opacity:0.85;
    pointer-events:none;
    z-index:0;
}

/* Form login berada di atas logo */
.login-card{
    position:relative;
    z-index:1;
}
</style>

    <meta charset="UTF-8">
 <body class="admin-background"></body>
<img src="{{ asset('images/logo.png') }}"
     class="logo-bg"
     alt="Logo">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="background:#f4f6f9;">

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h3 class="text-center mb-4">
                        Login Admin
                    </h3>

                    @if(session('error'))

                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>

                    @endif

                    <form method="POST" action="/admin/login">

                        @csrf

                        <div class="mb-3">

                            <label>Email</label>

                            <input type="email"
                            name="email"
                            class="form-control">

                        </div>

                        <div class="mb-3">

                            <label>Password</label>

                            <input type="password"
                            name="password"
                            class="form-control">

                        </div>

                        <button class="btn btn-primary w-100">

                            Login

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
