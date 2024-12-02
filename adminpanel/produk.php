<?php
require "session.php";
require "../koneksi.php";

// Fungsi sanitasi input untuk mencegah SQL Injection
function validateInput($data) {
    global $mysqli; // Pastikan $con bisa digunakan dalam fungsi ini
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
    <title>Produk</title>
</head>

<style>
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
                    <i class=""></i> Produk
                </li>
            </ol>
        </nav>
    </div>

    <div class="contents">
        
        <?php
        // Hapus produk
        if (isset($_GET['deletepid']) && isset($_GET['imgurl'])) {
            $pid = validateInput($_GET['deletepid']);
            $file = "../" . validateInput($_GET['imgurl']);

            // Pastikan file gambar ada sebelum menghapus
            if (file_exists($file)) {
                $stmtdelete = $mysqli->prepare("DELETE FROM product WHERE pid=?");
                $stmtdelete->bind_param("i", $pid);

                if ($stmtdelete->execute()) {
                    if (unlink($file)) {
                        echo '<div class="alert alert-success" role="alert">Produk berhasil dihapus!</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error: Produk dihapus, tetapi gagal menghapus file gambar.</div>';
                    }
                } else {
                    echo "Error menghapus produk dari database.<br/>";
                }
            } else {
                echo "Error: File gambar tidak ditemukan.<br/>";
            }
        }
        ?>

        <div class="container">
        <h2>Tabel Produk</h2>
        <a href="produk-detail.php" class="btn btn-primary mb-3">Tambahkan Produk</a>
        <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID Produk</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Kategori</th>
                    <th scope="col" colspan="2">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Tampilkan produk
                $sql = "SELECT p.*, c.categoryname FROM product p LEFT JOIN kategori c ON p.category_id = c.cid ORDER BY p.pid DESC";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['pid'] . "</td>";
                        echo "<td>" . $row['productname'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>Rp. " . number_format($row['price'], 2, ',', '.') . "</td>";
                        echo "<td>" . $row['categoryname'] . "</td>";
                        echo "<td><a href=\"produk.php?deletepid=" . $row['pid'] . "&imgurl=" . $row['imgurl'] . "\" onclick=\"return confirmDelete()\">Hapus</a></td>";
                        echo "<td><a href=\"produk-edit.php?editpid=" . $row['pid'] . "\">Edit</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan=\"7\">Tidak ada record!</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
