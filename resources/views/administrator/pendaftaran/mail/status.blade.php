<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mailData['title'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }

        h3 {
            color: #333;
            margin-bottom: 20px;
        }

        h5 {
            color: #333;
            margin-top: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        span {
            display: inline-block;
            width: 120px;
            margin-right: 10px;
        }

        a {
            color: #1E88E5;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h3>{{ $mailData['title'] }}</h3>
    <p>{{ $content }}</p>

    <h5>Informasi Pendaftar:</h5>
    <ul>
        <li><span>Nama </span>: {{$nama}}</li>
        <li><span>Nis </span>: {{$nis}}</li>
        <li><span>Kelas </span>: {{$kelas}} - {{$jurusan}}</li>
        <li><span>E-Mail </span>: {{$email}}</li>
        <li><span>No Telepon </span>: {{$telepon}}</li>
        <li><span>Alasan Daftar </span>: {!!$alasan_masuk!!}</li>
    </ul>

    @if ($status == 'reject')
    <p style="color: red;">Coba kembali mendaftar ke ekstrakurikuler yang lain!</p>
    @else
    <p>Tunggu informasi dari admin kami!</p>
    @endif

    <h5>Contact Information:</h5>
    <p>Phone: (0262) 233316</p>
    <p>Email: webex2223@gmail.com</p>
    <p>Address: SMK NEGERI 1 GARUT JALAN CIMANUK NO 309 A Kecamatan Tarogong Kidul Kabupaten Garut Provinsi Jawa Barat</p>
    <p><a href="#" style="color: #1E88E5; text-decoration: none;">WEBEX</a></p>
</body>
</html>
