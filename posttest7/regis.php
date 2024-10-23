<?php
session_start();
require "koneksi.php";

$uploadedFileName = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama_pengguna']);
    $kata_sandi = htmlspecialchars($_POST['kata_sandi']); 
    $email = htmlspecialchars($_POST['email']);
    $no_telp = htmlspecialchars($_POST['no_telp']);

  
    $target_dir = "uploads/"; 

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); 
    }

    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File is not an image.');</script>";
        $uploadOk = 0;
    }

    if ($_FILES["foto"]["size"] > 5000000) {
        echo "<script>alert('Sorry, your file is too large.');</script>";
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.');</script>";
    } else {
      
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $uploadedFileName = htmlspecialchars(basename($_FILES["foto"]["name"]));

            $sql = "INSERT INTO regis (nama_pengguna, kata_sandi, email, no_telp, foto) 
                    VALUES ('$nama', '$kata_sandi', '$email', '$no_telp', '$target_file')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<script>
                        alert('Berhasil Registrasi!');
                        document.location.href = 'lihat_data.php'; // Redirect to lihat_data.php after registration
                      </script>";
            } else {
                echo "<script>
                        alert('Gagal Registrasi: " . mysqli_error($conn) . "');
                      </script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
    }
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
            <form action="" method="POST" class="register-form" enctype="multipart/form-data">
                <label for="nama_pengguna">Nama Pengguna:</label>
                <input type="text" id="nama_pengguna" name="nama_pengguna" required>

                <label for="kata_sandi">Kata Sandi:</label>
                <input type="password" id="kata_sandi" name="kata_sandi" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="no_telp">No. Telp:</label>
                <input type="tel" id="no_telp" name="no_telp" required>

                <label for="foto">Upload Foto:</label>
                <div class="custom-file-upload">
                    <input type="file" id="foto" name="foto" accept="image/*" required>
                </div>
                <?php if ($uploadedFileName): ?>
                    <p>File Chosen: <?php echo $uploadedFileName; ?></p>
                <?php endif; ?>

                <input type="submit" value="Register">
            </form>
            <button onclick="window.location.href='lihat_data.php'">Lihat Data</button>
        </div>
    </section>
</body>
</html>
