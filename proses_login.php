<?php
// Menghubungkan ke database
$servername = "localhost";
$db_username = "root";  // Ganti dengan username database
$db_password = "";      // Ganti dengan password database
$dbname = "administrasi"; // Nama database yang kamu buat

// Buat koneksi
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data yang dikirimkan dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan username
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    // Cek apakah username dan password cocok
    if ($result->num_rows > 0) {
        header("Location: home.php");
    } else {
        echo "Username atau Password salah.";
    }
}

$conn->close();
?>
