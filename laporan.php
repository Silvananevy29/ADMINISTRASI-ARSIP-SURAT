<?php
include 'db.php';

// Mengambil data surat untuk laporan
$laporan = [];
if (isset($_GET['bulan']) && isset($_GET['tahun'])) {
    $bulan = $_GET['bulan'];
    $tahun = $_GET['tahun'];

    if (is_numeric($bulan) && is_numeric($tahun)) {
        $stmt = $conn->prepare("SELECT * FROM surat WHERE MONTH(tanggal_surat) = ? AND YEAR(tanggal_surat) = ?");
        $stmt->bind_param("ii", $bulan, $tahun);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $laporan[] = $row;
        }
        $stmt->close();
    } else {
        echo "Bulan dan tahun harus berupa angka.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat Masuk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .content {
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        table {
            margin-top: 20px;
        }
        th, td {
            text-align: center;
        }
        @media print {
            .no-print {
                display: none; /* Sembunyikan elemen dengan kelas no-print saat mencetak */
            }
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="content">
            <h1 class="text-center">Laporan Surat Masuk</h1>
            <?php if (!empty($laporan)): ?>
                <table id="laporan-table" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Alamat Pengirim</th>
                            <th>Tanggal Surat</th>
                            <th>Nomor Surat</th>
                            <th>Perihal</th>
                            <th>Nomor Disposisi</th>
                            <th>Lampiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($laporan as $item): ?>
                            <tr>
                                <td><?= $item['id'] ?></td>
                                <td><?= $item['alamat_pengirim'] ?></td>
                                <td><?= $item['tanggal_surat'] ?></td>
                                <td><?= $item['nomor_surat'] ?></td>
                                <td><?= $item['perihal'] ?></td>
                                <td><?= $item['nomor_disposisi'] ?></td>
                                <td><?= $item['lampiran'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-center no-print">
                    <a href="generate_laporan.php" class="btn btn-custom">Kembali</a> <!-- Tombol Kembali -->
                    <button class="btn btn-custom" onclick="window.print()">Cetak Laporan</button> <!-- Tombol Cetak -->
                    <button class="btn btn-success" onclick="exportToExcel()">Export to Excel</button>
                </div>
            <?php else: ?>
                <p class="text-center">Tidak ada data untuk bulan dan tahun yang dipilih.</p>
                <div class="text-center no-print">
                    <a href="generate_laporan.php" class="btn btn-custom">Kembali</a> <!-- Tombol Kembali -->
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script>
    // JavaScript function to export table to Excel
    function exportToExcel() {
        // Get the table element
        var table = document.getElementById("laporan-table");

        // Convert table to worksheet
        var ws = XLSX.utils.table_to_sheet(table);

        // Create a new workbook and append the worksheet
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Laporan Surat Masuk");

        // Export the workbook to Excel file
        XLSX.writeFile(wb, "laporan_surat_masuk.xlsx");
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>