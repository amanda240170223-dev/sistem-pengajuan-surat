<!DOCTYPE html>
<html>
<head>
    <title>Sistem Surat Mahasiswa</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            height:99vh;
            display:flex;
            justify-content:center;
            align-items:center;
            flex-direction:column;
            background:#f8fafc;
            font-family:Arial, sans-serif;
        }

        .logo{
            width:300px;
            margin-bottom:0px;

        }

        .topi{
            width:115px;
            margin-top:0px;
            margin-bottom:0px;
        }

        h1{
            font-size:19px;
            margin-bottom:9px;
            color:#1e293b;
        }

        p{
            font-size:13px;
            color:#64748b;
            margin-bottom:20px;
        }

        .btn{
            padding:13px 40px;
            background:#2563eb;
            color:white;
            text-decoration:none;
            border-radius:8px;
            font-size:12px;
        }

        .btn:hover{
            background:#1d4ed8;
        }
    </style>
</head>
<body>

    <img src="{{ asset('images/logo.png') }}" class="logo">
    <img src="{{ asset('images/topi.png') }}" alt="Topi" class="topi">


    <h1>SISTEM SURAT MAHASISWA</h1>

    <p>Pengajuan surat akademik secara online</p>

    <a href="/login" class="btn">MASUK</a>

</body>
</html>
