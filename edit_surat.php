<?php
include 'db.php';

// Ambil data surat berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM surat WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $surat = $result->fetch_assoc();
    $stmt->close();
}

// Proses pengeditan data surat
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alamat_pengirim = $_POST['alamat_pengirim'];
    $tanggal_surat = $_POST['tanggal_surat'];
    $nomor_surat = $_POST['nomor_surat'];
    $perihal = $_POST['perihal'];
    $nomor_disposisi = $_POST['nomor_disposisi'];
    $lampiran = $_POST['lampiran'];

    $stmt = $conn->prepare("UPDATE surat SET alamat_pengirim=?, tanggal_surat=?, nomor_surat=?, perihal=?, nomor_disposisi=?, lampiran=? WHERE id=?");
    $stmt->bind_param("ssssssi", $alamat_pengirim, $tanggal_surat, $nomor_surat, $perihal, $nomor_disposisi, $lampiran, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: lihat_surat.php"); // Redirect setelah mengedit
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Surat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
        }
        label {
            font-weight: bold;
        }
        button {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Surat</h1>
        <form method="POST">
            <div class="form-group">
                <label>Alamat Pengirim:</label>
                <input type="text" class="form-control" name="alamat_pengirim" value="<?= isset($surat['alamat_pengirim']) ? $surat['alamat_pengirim'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label>Tanggal Surat:</label>
                <input type="date" class="form-control" name="tanggal_surat" value="<?= isset($surat['tanggal_surat']) ? $surat['tanggal_surat'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label>Nomor Surat:</label>
                <input type="text" class="form-control" name="nomor_surat" value="<?= isset($surat['nomor_surat']) ? $surat['nomor_surat'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label>Perihal:</label>
                <input type="text" class="form-control" name="perihal" value="<?= isset($surat['perihal']) ? $surat['perihal'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label>Nomor Disposisi:</label>
                <input type="text" class="form-control" name="nomor_disposisi" value="<?= isset($surat['nomor_disposisi']) ? $surat['nomor_disposisi'] : '' ?>" required>
            </div>
            <div class="form-group">
                <label>Lampiran:</label>
                <input type="text" class="form-control" name="lampiran" value="<?= isset($surat['lampiran']) ? $surat['lampiran'] : '' ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>