<?php
session_start();
include "core.php";
include "koneksi.php";

// Redirect to homepage if user is not logged in
if (!isset($_SESSION['uid'])) {
	header("Location: index.php");
	exit;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Keranjang Belanja</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
	<script src="js/myscript.js" language="javascript" type="text/javascript"></script>
	<script type="text/javascript">
        function togglePaymentFields() {
            const paymentMethod = document.querySelector('select[name="payment_method"]').value;
            const cardFields = document.getElementById('cardFields');
            const qrImage = document.getElementById('qrImage');

            if (paymentMethod === 'postpaid') {
                cardFields.style.display = 'none';
                qrImage.style.display = 'none'; // Sembunyikan QR untuk COD
            } else {
                cardFields.style.display = 'block';
                qrImage.style.display = 'block'; // Tampilkan QR untuk kartu debit
            }
        }

        window.onload = function () {
            togglePaymentFields();
        }

        function validateOrder() {
            const paymentMethod = document.querySelector('select[name="payment_method"]').value;
            const cardNumber = document.getElementById('txtCredit').value;
            const bankName = document.getElementById('txtBank').value;

            if (paymentMethod === 'prepaid' && (cardNumber === '' || bankName === '')) {
                alert("Please fill out credit card and bank fields for prepaid payment.");
                return false;
            }
            return true;
        }
    </script>
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
		<h2>Keranjang Belanja</h2>

		<?php
    if (isset($_GET['addqty'])) {
      $cdid = validateInput($_GET['addqty']);
      $stmt = $mysqli->prepare("UPDATE cartdetail SET qty = qty + 1 WHERE cdid = ?");
      $stmt->bind_param("i", $cdid);
      $stmt->execute();
    }

    if (isset($_GET['reduceqty'])) {
      $cdid = validateInput($_GET['reduceqty']);
      $stmt = $mysqli->prepare("UPDATE cartdetail SET qty = qty - 1 WHERE cdid = ? AND qty > 1");
      $stmt->bind_param("i", $cdid);
      $stmt->execute();
    }

    if (isset($_GET['deleteid'])) {
      $deleteid = validateInput($_GET['deleteid']);
      $stmt = $mysqli->prepare("DELETE FROM cartdetail WHERE cdid = ?");
      $stmt->bind_param("i", $deleteid);
      $stmt->execute();
    }

    $sql = "SELECT product.productname, product.description, product.price, cartdetail.cdid, cartdetail.qty FROM product INNER JOIN cartdetail ON product.pid = cartdetail.pid INNER JOIN cart ON cartdetail.cid = cart.cid WHERE cart.uid = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION["uid"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $totalAmount = 0;
      echo "<table class='table-responsive'>";
      echo "<table class='table table-bordered cart-table'>";
      echo "<thead class='thead-dark'><tr>
              <th>Nama Produk</th>
              <th>Deskripsi</th>
              <th>Harga</th>
              <th>Qty</th>
              <th>Total</th>
              <th>Aksi</th>
            </tr></thead>";
      echo "<tbody>";

      while ($row = $result->fetch_assoc()) {
        $totalItem = $row['price'] * $row['qty'];
        $totalAmount += $totalItem;
        echo "<tr>
                <td>" . htmlspecialchars($row['productname']) . "</td>
                <td>" . htmlspecialchars($row['description']) . "</td>
                <td>Rp. " . number_format($row['price'], 0, ',', '.') . "</td>
                <td>" . htmlspecialchars($row['qty']) . "</td>
                <td>Rp. " . number_format($totalItem, 0, ',', '.') . "</td>
                <td>
                  <a href='cart.php?addqty=" . $row['cdid'] . "' class='btn btn-primary btn-sm'>Tambah</a> 
                  <a href='cart.php?reduceqty=" . $row['cdid'] . "' class='btn btn-warning btn-sm'>Kurangi</a> 
                  <a href='cart.php?deleteid=" . $row['cdid'] . "' class='btn btn-danger btn-sm'>Hapus</a>
                </td>
              </tr>";
      }
      echo "</tbody></table>";

      echo "<p class='cart-total'>Total Belanja: Rp. " . number_format($totalAmount, 0, ',', '.') . "</p>";

      // Payment form
      echo "<div class='payment-details'>
              <form action='orders.php' method='post' onsubmit='return validateOrder()'>
                <fieldset>
                  <legend>Detail Pemesanan</legend>
                  <div class='form-group'>
                    <label for='txtAddress'>Alamat Pengiriman:</label>
                    <input id='txtAddress' type='text' name='txtAddress' class='form-control' required />
                  </div>
                  <div class='form-group'>
                    <label for='payment_method'>Metode Pembayaran:</label>
                    <select name='payment_method' class='form-control' required onchange='togglePaymentFields()'>
                      <option value='prepaid'>Bayar dengan Qris</option>
                      <option value='postpaid'>COD</option>
                    </select>
                  </div>
                  <div id='cardFields'>
                    <div class='form-group'>
                      <label for='txtCredit'>Nomor Kartu / No E-Wallet:</label>
                      <input id='txtCredit' type='text' name='txtCredit' class='form-control' />
                    </div>
                    <div class='form-group'>
                      <label for='txtBank'>Bank / E-Wallet:</label>
                      <input id='txtBank' type='text' name='txtBank' class='form-control' />
                    </div>
                  </div>
                  <div id='qrImage' style='display: none; margin-top: 20px;'> <!-- Awalnya disembunyikan -->
                    <h5>Scan QR untuk menyelesaikan pembayaran:</h5>
                    <img src='image/Qris.jpg' alt='Kode QR Pembayaran' width='200px' height='200px' />
                </div>
                  <input name='price' type='hidden' value='" . $totalAmount . "' />
                  <button type='submit' class='btn btn-checkout btn-lg btn-block'>Checkout</button>
                </fieldset>
              </form>
            </div>";
    } else {
      echo "<p class='text-center'>Tidak ada item di keranjang</p>";
    }
    ?>
			</div>
		</div>
	</div>
</body>

</html>