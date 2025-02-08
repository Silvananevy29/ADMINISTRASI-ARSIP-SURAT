<?php
include 'db.php';

// Menambah surat
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_surat'])) {
    $alamat_pengirim = $_POST['alamat_pengirim'];
    $tanggal_surat = $_POST['tanggal_surat'];
    $nomor_surat = $_POST['nomor_surat'];
    $perihal = $_POST['perihal'];
    $nomor_disposisi = $_POST['nomor_disposisi'];
    $lampiran = $_POST['lampiran'];

    // Validasi input
    if (empty($alamat_pengirim) || empty($tanggal_surat) || empty($nomor_surat) || empty($perihal)) {
        $error = "Semua field yang wajib diisi harus diisi.";
    } else {
        // Prepared statement untuk menyimpan data ke database
        $stmt = $conn->prepare("INSERT INTO surat (alamat_pengirim, tanggal_surat, nomor_surat, perihal, nomor_disposisi, lampiran) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $alamat_pengirim, $tanggal_surat, $nomor_surat, $perihal, $nomor_disposisi, $lampiran);

        if ($stmt->execute()) {
            $success = "Surat berhasil ditambahkan.";
        } else {
            $error = "Terjadi kesalahan saat menambahkan surat: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Surat</title>
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
        .sidebar img {
            max-width: 70%; /* Ensure the image is responsive */
            height: auto; /* Maintain aspect ratio */
            display: block; /* Center the image */
            margin: 0 auto; /* Center the image horizontally */
            border-radius: 50%; /* Make the image circular */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add shadow to the image */
        }
 button {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 class="text-white text-center">
            <img src="logo.jpg" alt="Arsip Surat Masuk" />
        </h2>
        <a href="home.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="tambah_surat.php" class="active"><i class="fas fa-plus"></i> Tambah Surat</a>
        <a href="generate_laporan.php"><i class="fas fa-file-alt"></i> Generate Laporan</a>
        <a href="lihat_surat.php"><i class="fas fa-eye"></i> Lihat Surat</a>
    </div>

    <div class="content">
        <h1 class="mt-4 text-center">Tambah Surat</h1>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="form-group">
                <label for="alamat_pengirim">Alamat Pengirim</label>
                <input type="text" class="form-control" id="alamat_pengirim" name="alamat_pengirim" placeholder="Alamat Pengirim" required>
            </div>
            <div class="form-group">
                <label for="tanggal_surat">Tanggal Surat</label>
                <input type="date" class="form-control" id="tanggal_surat" name ="tanggal_surat" required>
            </div>
            <div class="form-group">
                <label for="nomor_surat">Nomor Surat</label>
                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" placeholder="Nomor Surat" required>
            </div>
            <div class="form-group">
                <label for="perihal">Perihal</label>
                <input type="text" class="form-control" id="perihal" name="perihal" placeholder="Perihal" required>
            </div>
            <div class="form-group">
                <label for="nomor_disposisi">Nomor Disposisi</label>
                <input type="text" class="form-control" id="nomor_disposisi" name="nomor_disposisi" placeholder="Nomor Disposisi">
            </div>
            <div class="form-group">
                <label for="lampiran">Lampiran</label>
                <input type="text" class="form-control" id="lampiran" name="lampiran" placeholder="Lampiran">
            </div>
            <button type="submit" name="add_surat" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>