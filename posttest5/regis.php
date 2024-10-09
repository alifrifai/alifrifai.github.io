<?php
session_start();
require "koneksi.php";

if (isset($_POST['tambah'])) {
    $nama = htmlspecialchars($_POST['nama_pengguna']);
    $kata_sandi = htmlspecialchars($_POST['kata_sandi']);
    $email = htmlspecialchars($_POST['email']);
    $no_telp = htmlspecialchars($_POST['no_telp']);

    $sql = "INSERT INTO regis (nama_pengguna, kata_sandi, email, no_telp) VALUES ('$nama', '$kata_sandi', '$email', '$no_telp')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "
            <script>
                alert('Berhasil Registrasi!');
                document.location.href = 'lihat_data.php';
            </script>";
    } else {
        echo "
            <script>
                alert('Gagal Registrasi: " . mysqli_error($conn) . "');
                document.location.href = 'lihat_data.php';
            </script>";
    }
}

function showRegistrationForm() {
    echo '
    <form action="" method="POST" class="register-form">
        <label for="nama_pengguna">Nama Pengguna:</label>
        <input type="text" id="nama_pengguna" name="nama_pengguna" required>

        <label for="kata_sandi">Kata Sandi:</label>
        <input type="password" id="kata_sandi" name="kata_sandi" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="no_telp">No. Telp:</label>
        <input type="tel" id="no_telp" name="no_telp" required>

        <input type="submit" name="tambah" value="Register">
    </form>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="regis.css">
</head>
<body>
    <section>
        <div class="register-container">
            <?php
            if (!isset($_SESSION['users'])) {
                $_SESSION['users'] = [];
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);
                $email = htmlspecialchars($_POST['email']);
                $phone = htmlspecialchars($_POST['phone']);

                $_SESSION['users'][$username] = [
                    'password' => $password,
                    'email' => $email,
                    'phone' => $phone,
                ];

                echo "<h2>Halo, " . $username . "!</h2>";
                echo "<p>Anda telah berhasil registrasi.</p>";
                echo "<p>Email: " . $email . "</p>";
                echo "<p>No. Telp: " . $phone . "</p>";
                echo '<a href="login.php" class="home">Pergi ke Halaman Login</a>';
            } else {
                showRegistrationForm();
            }
            ?>
        </div>
    </section>
</body>
</html>
