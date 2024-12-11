<?php
    require "session.php";
    require "../koneksi.php";
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
    <title>Order Items</title>
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
                    <a href="order.php" class="no-decoration text-muted">
                        <i class=""></i> Order
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class=""></i> Order Items
                </li>
            </ol>
        </nav>
    </div>

    <div class="contents">
				<h2>Item Pesanan</h2>
				<table width="100%" border="1" cellspacing="0" cellpadding="0">
					<tr>
						<th scope="col">Nama Produk </th>
						<th scope="col">Jumlah </th>
						<th scope="col">Sub </th>
					</tr>
					<?php

					// Display order items
					if (isset($_GET['oid'])) {
						$oid = $_GET['oid'];

						$sql = "SELECT product.productname, orderitem.qty, orderitem.item_price 
								FROM orderitem 
								INNER JOIN product ON orderitem.pid = product.pid 
								WHERE orderitem.oid = ? 
								ORDER BY orderitem.oiid DESC";

						$stmt = $mysqli->prepare($sql);
						$stmt->bind_param("i", $oid);
						$stmt->execute();
						$result = $stmt->get_result();

						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								$quantity = (int) $row['qty'];
								$price = (float) $row['item_price'];
								$subtotal = $quantity * $price;

								echo "<tr>";
								echo "<td>" . htmlspecialchars($row['productname']) . "</td>";
								echo "<td>" . htmlspecialchars($quantity) . "</td>";
								echo "<td>Rp. " . htmlspecialchars(number_format($subtotal, 2)) . "</td>";
								echo "</tr>";
							}
						} else {
							echo "<tr><td colspan=\"3\">Tidak ada item pesanan!</td></tr>";
						}

						$stmt->close();
					} else {
						echo "<tr><td colspan=\"3\">ID Pesanan tidak tersedia!</td></tr>";
					}


					?>
				</table>

			</div>


<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>