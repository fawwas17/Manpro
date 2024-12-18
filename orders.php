<?php

include "core.php";
include "koneksi.php";

// Redirect to homepage if user is not logged in
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
	<title>Pesanan</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
	<script src="js/myscript.js" language="javascript" type="text/javascript"></script>
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
</style>

<body>
	<div class="navigation">
		<?php mainMenu(); ?>
			</div>
			<div class="container-top">
				<h2>Pesanan</h2>
				<?php

				// Adding a new order
				if ($_SERVER['REQUEST_METHOD'] == "POST") {
					$price = validateInput($_POST['price']);
					$address = validateInput($_POST['txtAddress']);
					$method = validateInput($_POST['payment_method']);
					$uid = $_SESSION['uid'];
					$acc_number = null;
					$bank = null;

					// Check if the payment method is prepaid
					if ($method === 'prepaid') {
						$acc_number = validateInput($_POST['txtCredit']);
						$bank = validateInput($_POST['txtBank']);
					}

					// Start transaction
					$mysqli->begin_transaction();

					try {
						// Add a new order record
						$stmtorder = $mysqli->prepare("INSERT INTO `order` (price, acc_number, address, bank, payment_method, uid) VALUES (?, ?, ?, ?, ?, ?)");
						$stmtorder->bind_param("dssssi", $price, $acc_number, $address, $bank, $method, $uid);
						$stmtorder->execute();
						$lastoid = $stmtorder->insert_id;

						// Add cart items to orderitem
						$sql = "SELECT * FROM cartdetail WHERE cid = (SELECT cid FROM cart WHERE uid = ?)";
						$stmtcart = $mysqli->prepare($sql);
						$stmtcart->bind_param("i", $uid);
						$stmtcart->execute();
						$result = $stmtcart->get_result();

						while ($row = $result->fetch_assoc()) {
							$pid = $row['pid'];
							$qty = $row['qty'];
							$item_price = getItemPrice($pid); // Helper function to get product price
				
							$stmtorderitem = $mysqli->prepare("INSERT INTO orderitem (pid, oid, uid, qty, item_price) VALUES (?, ?, ?, ?, ?)");
							$stmtorderitem->bind_param("iiiii", $pid, $lastoid, $uid, $qty, $item_price);
							$stmtorderitem->execute();
						}

						// Clear the cart
						$stmt_clearcart = $mysqli->prepare("DELETE FROM cart WHERE uid = ?");
						$stmt_clearcart->bind_param("i", $uid);
						$stmt_clearcart->execute();

						// Commit transaction
						$mysqli->commit();
						echo '<div class="alert alert-warning" role="alert">Pesanan berhasil Dibuat</div>';
					} catch (Exception $e) {
						$mysqli->rollback();
						echo '<div class="alert alert-warning" role="alert">Eror membuat Pesanan</div>' . $e->getMessage() . "</p>";
					}
				}

				// Display existing orders for the logged-in user
				$sql = "SELECT oid, time, price, payment_method, address, valid FROM `order` WHERE uid = ? ORDER BY oid DESC";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param("i", $_SESSION['uid']);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows > 0) {
					echo "<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
					echo "<tr>
							<th>ID <br> Pesanan</th>
							<th>Waktu</th>
							<th>Metode <br>Pembayaran</th>
							<th>Alamat <br>Pengiriman</th>
							<th>Total</th>
							<th>Validasi</th>
							<th>Opsi</th>
						</tr>";

					while ($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td>" . htmlspecialchars($row['oid'] ?? '') . "</td>";
						echo "<td>" . htmlspecialchars($row['time'] ?? '') . "</td>";

						// Modify the payment method display
						$payment_method_display = ($row['payment_method'] === 'Prepaid') ? 'Debit' : 'COD';
						echo "<td>" . htmlspecialchars($payment_method_display) . "</td>";

						echo "<td>" . htmlspecialchars($row['address'] ?? '') . "</td>";
						echo "<td>Rp. " . htmlspecialchars(number_format($row['price'], 0, ',', '.') ?? '') . "</td>";
						echo "<td>" . htmlspecialchars($row['valid'] ?? '') . "</td>";
						echo "<td><a href=\"orderitems.php?oid=" . $row['oid'] . "\">Lihat</a></td>";
						echo "</tr>";
					}
					echo "</table>";
				} else {
					echo '<div class="alert alert-warning" role="alert">Tidak ada Pesanan</div>';
				}


				// Helper function to get the product price
				function getItemPrice($pid)
				{
					global $mysqli;
					$stmt = $mysqli->prepare("SELECT price FROM product WHERE pid = ?");
					$stmt->bind_param("i", $pid);
					$stmt->execute();
					$result = $stmt->get_result();
					$row = $result->fetch_assoc();
					return $row['price'];
				}
				?>
			</div>
</body>

</html>