
<?php

require_once "core.php";
require_once "koneksi.php";

// Redirect to homepage if the user is not logged in
if (!isset($_SESSION['uid'])) {
	header("Location: index.php");
	exit;
}

?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Item Pesanan</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
	<script src="js/myscript.js" language="javascript" type="text/javascript"></script>
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
			<div class="navigation">
				<?php mainMenu(); ?>
			</div>
			<div class="container-top">
				<h2>Item Pesanan</h2>
				<table width="100%" border="1" cellspacing="0" cellpadding="0">
					<tr>
						<th scope="col">Nama Produk</th>
						<th scope="col">Jumlah</th>
						<th scope="col">Sub Total</th>
					</tr>
					<?php

					// Display order items
					if (isset($_GET['oid'])) {
						$oid = validateInput($_GET['oid']);

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
							echo '<div class="alert alert-Danger" role="alert">Tidak ada Item Pesanan</div>';
						}

						$stmt->close();
					} else {
						echo '<div class="alert alert-Danger" role="alert">Pesanan tidak Tersedia</div>';
					}

					?>
				</table>
			</div>
	</div>
</body>

</html>