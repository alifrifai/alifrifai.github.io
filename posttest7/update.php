<?php
require "koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM regis WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("User not found.");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_pengguna = $_POST['nama_pengguna'];
        $kata_sandi = $_POST['kata_sandi'];
        $email = $_POST['email'];
        $no_telp = $_POST['no_telp'];

        $fotoPath = $row['foto']; 

        if (!empty($_FILES["foto"]["name"])) { 
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["foto"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if ($check !== false) {
                if ($_FILES["foto"]["size"] > 5000000) {
                    echo "<script>alert('Maaf, file anda kebesaran.');</script>";
                    $uploadOk = 0;
                }

                if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                    echo "<script>alert('Maaf, hanya JPG, JPEG, PNG & GIF.');</script>";
                    $uploadOk = 0;
                }
            } else {
                echo "<script>alert('File tidak ada di image.');</script>";
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                    $fotoPath = $target_file; 
                } else {
                    echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                }
            }
        }

        $update_sql = "UPDATE regis SET nama_pengguna = ?, kata_sandi = ?, email = ?, no_telp = ?, foto = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssssi", $nama_pengguna, $kata_sandi, $email, $no_telp, $fotoPath, $id);

        if ($update_stmt->execute()) {
            header("Location: lihat_data.php");
            exit();
        } else {
            die("Update failed: " . $conn->error);
        }
    }
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Pengguna</title>
    <link rel="stylesheet" href="update.css">
</head>
<body>
    <section>
        <div class="data-container">
            <h1>Update Data Pengguna</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="nama_pengguna">Nama Pengguna:</label>
                <input type="text" id="nama_pengguna" name="nama_pengguna" value="<?php echo htmlspecialchars($row['nama_pengguna']); ?>" required>

                <label for="kata_sandi">Kata Sandi:</label>
                <input type="password" id="kata_sandi" name="kata_sandi" value="<?php echo htmlspecialchars($row['kata_sandi']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>

                <label for="no_telp">No. Telp:</label>
                <input type="text" id="no_telp" name="no_telp" value="<?php echo htmlspecialchars($row['no_telp']); ?>" required>

                <label for="foto">Upload Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*">

                <button type="submit">Update</button>
                <a href="lihat_data.php" class="cancel">Batal</a>
            </form>
            <?php if (!empty($row['foto'])): ?>
                <h3>Current Photo:</h3>
                <img src="<?php echo htmlspecialchars($row['foto']); ?>" alt="Current Photo" style="width: 100px; height: 100px; border-radius: 50%;">
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
