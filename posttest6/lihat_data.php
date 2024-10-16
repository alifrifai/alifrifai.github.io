<?php
require "koneksi.php";

$sql = "SELECT * FROM regis";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Data Pengguna</title>
    <link rel="stylesheet" href="lihat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <section>
        <div class="data-container">
            <h1>Data Pengguna</h1>
            <table border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama Pengguna</th>
                        <th>Kata Sandi</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Foto</th> 
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama_pengguna']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['kata_sandi']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['no_telp']) . "</td>";
                            echo "<td>";
                            if (!empty($row['foto'])) {
                                echo "<img src='" . htmlspecialchars($row['foto']) . "' alt='Foto' style='width: 50px; height: 50px; border-radius: 50%;'>";
                            } else {
                                echo "No photo";
                            }
                            echo "</td>";
                            echo "<td>
                                    <a href='update.php?id=" . $row['id'] . "' title='Update'><i class='fas fa-pen' style='color: orange;'></i></a> 
                                    <a href='delete.php?id=" . $row['id'] . "' title='Trash' onclick='return confirm(\"Are you sure you want to delete this record?\")'><i class='fas fa-trash-can' style='color: red;'></i></a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Tidak ada data yang ditemukan.</td></tr>";
                    }
                ?>
                </tbody>
            </table>
            <a href="login.php" class="home">Kembali ke Halaman Login</a>
        </div>
    </section>
</body>
</html>
