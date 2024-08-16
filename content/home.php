<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan PPKD Jakarta Pusat</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .bg {
            background-image: url('assets/image/perpustakaan.jpg');
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center items vertically */
            align-items: center; /* Center items horizontally */
            text-align: center;
            color: white;
            padding: 20px; /* Optional padding */
        }

        .logo {
            margin-bottom: 20px; /* Jarak bawah logo */
        }

        .logo img {
            width: 150px; /* Adjust size as needed */
            height: auto; /* Maintain aspect ratio */
        }

        .welcome-text {
            font-size: 2.5em;
            font-weight: bold;
            color: white; /* Dark Gray for contrast */
            margin: 20px 0; /* Jarak atas dan bawah */
        }

        .btn-custom {
            background-color: #ADD8E6; /* Light Blue Pastel */
            border-color: #ADD8E6;
            color: #000000; /* Black for contrast */
            margin-top: 20px; /* Jarak atas tombol */
        }

        .btn-custom:hover {
            background-color: #87CEEB; /* Slightly darker blue for hover effect */
            border-color: #87CEEB;
        }
    </style>
</head>

<body>
    <div class="bg">
        <div class="logo">
            <img src="assets/image/logo-Jakarta-Pusat.png" alt="Logo">
        </div>
        <div class="welcome-text">
            PPKD Jakarta Pusat
        </div>
        <a href="?pg=user" class="btn btn-primary btn-lg btn-custom">Masuk ke Halaman User</a>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
