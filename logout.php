<?php
session_start();
session_destroy(); // Menghentikan sesi
header("Location: index.php"); // Arahkan ke halaman login
exit();
?>