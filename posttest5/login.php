<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <section>
        <div class="login-container">
            <?php
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                if (isset($_SESSION['users'][$username]) && 
                    $_SESSION['users'][$username]['password'] === $password) {
                    $_SESSION['loggedin'] = true;
                    echo "<h2>Yoo, " . $username . "!</h2>";
                    echo "<p>Anda Berhasil login.</p>";
                    echo '<a href="index.html" class="home">Kembali ke Beranda</a>';
                } else {
                    echo "<p style='color: red;'>Username atau password salah, coba lagi.</p>";
                    showLoginForm();
                }
            } else {
                showLoginForm();
            }

            function showLoginForm() {
                echo '
                <form action="" method="POST" class="sign-in-form">
                    <label for="username">Nama Pengguna:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Kata Sandi:</label>
                    <input type="password" id="password" name="password" required>

                    <input type="submit" value="Sign In">
                </form>
                <p>Belum punya akun? <a href="regis.php">Registrasi di sini</a></p>';
            }
            ?>
        </div>
    </section>
</body>
</html>
