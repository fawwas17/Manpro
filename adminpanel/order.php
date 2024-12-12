<?php
// require "session.php";
require "../koneksi.php";
require_once "laporan.php";

include "send_email.php";
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
    <title>Order</title>
</head>

<style>
    .kotak {
        border: solid;
    }

    .summary-kategori {
        background-color: #0a6b4a;
        border-radius: 15px;
    }

    .summary-produk {
        background-color: #0a516b;
        border-radius: 15px;
    }

    .no-decoration {
        text-decoration: none;
    }

    .container-top {
        margin-top: 100px;
        margin-left: 100px;
        margin-right: 100px;
    }

    .kategori-input-besar {
        height: 60px; /* Mengatur tinggi input box */
        font-size: 18px; /* Mengatur ukuran teks */
        padding: 10px; /* Menambahkan jarak di dalam input box */
    }

    .table-order-container {
        width: 80%; /* Mengatur lebar tabel menjadi 80% dari lebar halaman */
        margin: 0 auto; /* Membuat tabel berada di tengah dengan jarak otomatis di kiri dan kanan */
        padding: 20px 0; /* Jarak atas dan bawah */
    }

    /* Gaya untuk tabel order */
    .table-order {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        text-align: center; /* Posisikan teks di tengah secara horizontal */
    }

    .table-order th, .table-order td {
        border: 1px solid #ddd;
        padding: 10px;
        vertical-align: middle; /* Posisikan teks di tengah secara vertikal */
    }

    .table-order th {
        background-color: #0a6b4a;
        color: white;
        text-align: center; /* Teks header juga di tengah */
    }

    .table-order tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table-order tr:hover {
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
                    <i class=""></i> Order
                </li>
            </ol>
        </nav>
    </div>

    <div class="contents">
        <?php
        //validasi pesanan
        if (isset($_GET['validateoid'])) {
            $oid = validateInput($_GET['validateoid']);

            $stmtvalidate = $mysqli->prepare("UPDATE `order` SET valid='Yes' WHERE oid=?");
            $stmtvalidate->bind_param("i", $oid);

            if ($stmtvalidate->execute()) {
                echo "Pesanan berhasil divalidasi!<br/>";

                // Query for user email
                $stmtEmail = $mysqli->prepare("SELECT user.email, user.username FROM user INNER JOIN `order` ON user.uid=`order`.uid WHERE `order`.oid=?");
                $stmtEmail->bind_param("i", $oid);
                $stmtEmail->execute();
                $result = $stmtEmail->get_result();
                $row = $result->fetch_assoc();

                $userEmail = $row['email'];
                $userName = $row['username'];

                // Generate laporan dan mengirimkan email
                $pdfContent = generateLaporanPdf($oid, true);

                if (sendEmailWithAttachment(
                    $userEmail, 
                    "Pesanan - " . $userName . " Berhasil Dikonfirmasi!", 
                    "Pesanan Anda telah dikonfirmasi, berikut merupakan lampiran pesanan Anda:", 
                    $pdfContent, 
                    "laporan_$oid.pdf"
                )) {
                    echo "Detail pesanan terkirim ke email pengguna: " . $userEmail . "<br/>";
                } else {
                    echo "Gagal mengirim email laporan!<br/>";
                }
            } else {
                echo "Error memvalidasi pesanan<br/>";
            }
        }
        ?>

        <div class="table-order-container">
            <table class="table-order">
            <h2>Pesanan</h2>
                <tr>
                    <th scope="col">ID <br>Pesanan </th>
                    <th scope="col">ID <br>Pengguna </th>
                    <th scope="col">Waktu</th>
                    <th scope="col">Metode <br>Pembayaran </th>
                    <th scope="col">Alamat <br>Pengiriman </th>
                    <th scope="col">Total</th>
                    <th scope="col">Validasi</th>
                    <th scope="col" colspan="3">Opsi</th>
                </tr>
                <?php
                // tampilkan pesanan
                $sql = "SELECT * FROM `order` ORDER BY oid DESC";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['oid'] . "</td>";
                        echo "<td>" . $row['uid'] . "</td>";
                        echo "<td>" . $row['time'] . "</td>";

                        $payment_method_display = ($row['payment_method'] === 'Prepaid') ? 'Debit' : 'COD';
                        echo "<td>" . htmlspecialchars($payment_method_display) . "</td>";

                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . number_format($row['price'], 0, ',', '.') . "</td>";
                        echo "<td>" . $row['valid'] . "</td>";
                        echo "<td><a href=\"orderitems.php?oid=" . $row['oid'] . "\">Detail</a></td>";

                        if ($row['valid'] !== 'Yes') {
                            echo "<td><a href=\"order.php?validateoid=" . $row['oid'] . "\" onclick=\"return confirmValidate()\">Validasi</a></td>";
                        } else {
                            echo "<td><a href=\"laporan-cetak.php?oid=" . $row['oid'] . "\">Cetak</a></td>";
                        }

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan=\"10\">Tidak ada pesanan!</td></tr>";
                }
                ?>
            </table>
        </div>

    </div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
