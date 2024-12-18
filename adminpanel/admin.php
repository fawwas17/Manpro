<?php
    require "session.php";
    require "../koneksi.php";
    function validateInput($data) {
        global $mysqli; // Pastikan variabel $mysqli tersedia
        return htmlspecialchars(mysqli_real_escape_string($mysqli, trim($data)));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Admin</title>
</head>

<style>
    body{
        font-size:14px;
    }
    .kotak {
        border: solid;
    }

    .summary-kategori{
        background-color: #0a6b4a;
        border-radius: 15px;
    }

    .summary-produk{
        background-color: #0a516b;
        border-radius: 15px;
    }

    .no-decoration{
        text-decoration: none;
    }

    .container-top{
        margin-top: 100px;
        margin-left: 100px;
        margin-right: 100px;
    }

    .h2-name{
        margin-left: 20px;
    }

    .kategori-input-besar {
        height: 60px; /* Mengatur tinggi input box */
        font-size: 18px; /* Mengatur ukuran teks */
        padding: 10px; /* Menambahkan jarak di dalam input box */
    }

    .table-admin-container {
        width: 80%; /* Mengatur lebar tabel menjadi 80% dari lebar halaman */
        margin: 0 auto; /* Membuat tabel berada di tengah dengan jarak otomatis di kiri dan kanan */
        padding: 20px 0; /* Jarak atas dan bawah */
    }

    /* Gaya untuk tabel admin */
    .table-admin {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        text-align: center; /* Posisikan teks di tengah secara horizontal */
    }

    .table-admin th, .table-admin td {
        border: 1px solid #ddd;
        padding: 10px;
        vertical-align: middle; /* Posisikan teks di tengah secara vertikal */
    }

    .table-admin th {
        background-color: #0a6b4a;
        color: white;
        text-align: center; /* Teks header juga di tengah */
    }

    .table-admin tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table-admin tr:hover {
        background-color: #d1e7dd;
    }


</style>

<body>
    <?php require "navbar.php";?>

    <div class="container-top">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class=""></i> Admin
                </li>
            </ol>
        </nav>
    </div>

    <div class="contents">
				<?php

				//hapus admin
				if (isset($_GET['deleteaid'])) {
                    $deleteAid = validateInput($_GET['deleteaid']); // Simpan hasil ke variabel
                    $stmtdelete = $mysqli->prepare("DELETE FROM admin WHERE aid=?");
                    $stmtdelete->bind_param("i", $deleteAid); // Menggunakan variabel di sini
                    if ($stmtdelete->execute()) {
                        echo "<div class='alert alert-success' role='alert'>Admin berhasil dihapus!</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Error menghapus admin.</div>";
                    }
                }                

				?>
			<div class="table-admin-container">
            <h2>Admin</h2>

            <a href="admin-detail.php" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Tambah Admin
            </a>
                <table class="table-admin">
                    <tr>
                        <th scope="col">ID Pengguna</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Email</th>
                        <th scope="col">Opsi</th>
                    </tr>
                    <?php
                    // tampilkan admin
                    $sql = "SELECT * FROM admin ORDER BY aid DESC";
                    $result = $mysqli->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['aid'] . "</td>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td><a href=\"admin.php?deleteaid=" . $row['aid'] . "\" onclick=\"return confirmDelete()\">Hapus</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan=\"5\">Tidak ada record!</td></tr>";
                    }
                    ?>
                </table>
            </div>

			</div>


<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>