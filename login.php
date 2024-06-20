<?php
// Memulai sesi
session_start();

// Menghubungkan ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nama_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mencegah SQL injection (sebaiknya gunakan prepared statements di produksi)
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Query untuk memeriksa kredensial pengguna
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Menyimpan data pengguna ke sesi
        $_SESSION['username'] = $username;
        echo "Login berhasil! Selamat datang, " . $username;
    } else {
        echo "Nama pengguna atau kata sandi salah.";
    }
}

$conn->close();
?>
