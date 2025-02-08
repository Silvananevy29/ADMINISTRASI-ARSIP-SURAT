<?php
include 'db.php';

// Menghapus surat
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM surat WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Redirect setelah menghapus
    header("Location: lihat_surat.php"); 
    exit();
}

// Pencarian surat
$search_term = '';

if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
    $stmt = $conn->prepare("CALL search_surat(?)");
    $stmt->bind_param("s", $search_term);
} else {
    // Mengambil data surat dan mengurutkan berdasarkan tanggal surat
    $stmt = $conn->prepare("SELECT * FROM v_surat ORDER BY tanggal_surat DESC");
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Surat</title>
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
        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
        .table td {
            background-color: #e9ecef;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 class="text-white text-center">
            <img src="logo.jpg" alt="Arsip Surat Masuk" style="max-width: 70%; height: auto; border-radius: 50%; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);" />
        </h2>
        <a href="home.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="tambah_surat.php"><i class="fas fa-plus"></i> Tambah Surat</a>
        <a href="generate_laporan.php"><i class="fas fa-file-alt"></i> Generate Laporan</a>
        <a href="lihat_surat.php" class="active"><i class="fas fa-eye"></i> Lihat Surat</a>
    </div>

    <div class="content">
        <h1 class="mt-4 text-center">Data Surat Masuk</h1>
        <form method="POST" class="mb-3">
            <div class="input-group">
                <input type="text" name="search_term" class="form-control" placeholder="Cari berdasarkan alamat pengirim, nomor surat, perihal, atau nomor disposisi" value="<?= htmlspecialchars($search_term) ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="search">Cari</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Alamat Pengirim</th>
                    <th>Tanggal Surat</th>
                    <th>Nomor Surat</th>
                    <th>Perihal</th>
                    <th>Nomor Disposisi</th>
                    <th>Lampiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['alamat_pengirim'] ?></td>
                        <td><?= $row['tanggal_surat'] ?></td>
                        <td><?= $row['nomor_surat'] ?></td>
                        <td><?= $row['perihal'] ?></td>
                        <td><?= $row['nomor_disposisi'] ?></td>
                        <td><?= $row['lampiran'] ?></td>
                        <td>
                            <a href="edit_surat.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>