<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Laporan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
            transition: all 0.3s;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
        }
        .sidebar a {
            color: #ffffff;
            padding: 15px 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #007bff;
            border-radius: 5px;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .content {
            margin-left: 260px; /* Space for the sidebar */
            padding: 20px;
        }
        button {
            background-color: #007bff;
            color: white;
        }
        .sidebar img {
            max-width: 70%; /* Ensure the image is responsive */
            height: auto; /* Maintain aspect ratio */
            display: block; /* Center the image */
            margin: 0 auto; /* Center the image horizontally */
            border-radius: 50%; /* Make the image circular */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add shadow to the image */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 class="text-white text-center">
            <img src="logo.jpg" alt="Arsip Surat Masuk" />
        </h2>
        <a href="home.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="tambah_surat.php"><i class="fas fa-plus"></i> Tambah Surat</a>
        <a href="generate_laporan.php" class="active"><i class="fas fa-file-alt"></i> Generate Laporan</a>
        <a href="lihat_surat.php"><i class="fas fa-eye"></i> Lihat Surat</a>
    </div>

    <div class="content">
        <h1 class="mt-4 text-center">Generate Laporan</h1>
        <form method="GET" action="laporan.php" class="mt-4">
            <div class="form-group">
                <label for="bulan">Bulan</label>
                <input type="number" class="form-control" id="bulan" name="bulan" placeholder="Bulan (1-12)" min="1" max="12" required>
            </div>
            <div class="form-group">
                <label for="tahun">Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Tahun" required>
            </div>
            <button type="submit" class="btn btn-primary">Generate Laporan</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>