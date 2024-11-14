<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        .container {
            text-align: center;
            color: #333;
        }

        .container h1 {
            font-size: 10em;
            margin: 0;
            color: #dc3545;
        }

        .container h2 {
            font-size: 2em;
            margin: 0.5em 0;
        }

        .container p {
            font-size: 1.2em;
            color: #666;
        }

        .container a {
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1em;
            margin-top: 20px;
            display: inline-block;
        }

        .container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><i class="fas fa-ban"></i> 403</h1>
        <h2>Akses Ditolak</h2>
        <p>Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ route('home') }}">Kembali ke Beranda</a>
    </div>
</body>

</html>
