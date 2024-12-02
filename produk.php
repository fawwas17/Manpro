<?php
include "core.php";
include "koneksi.php";

// Check if product id (pid) is provided in the URL
if (!isset($_GET['pid'])) {
    echo "Produk tidak ditemukan!";
    exit;
}

$pid = validateInput($_GET['pid']);

// Fetch product details from the database
$stmt = $mysqli->prepare("SELECT p.*, c.categoryname AS category_name FROM product p 
                        JOIN kategori c ON p.category_id = c.cid 
                        WHERE p.pid = ?");
$stmt->bind_param("i", $pid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Produk tidak ditemukan!";
    exit;
}
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Detail Produk - <?php echo htmlspecialchars($product['productname']); ?></title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="page">
        <div class="header">
            <?php showHeading(); ?>
        </div>
        <div class="wrapper">
            <div class="navigation">
                <?php mainMenu(); ?>
            </div>
            <div class="contents">
                <h2><?php echo htmlspecialchars($product['productname']); ?></h2>

                <div class="product-details">
                    <div class="product-image" style="float: left; margin-right: 20px;">
                        <img src="<?php echo htmlspecialchars($product['imgurl']); ?>" height="200" width="200"
                            alt="<?php echo htmlspecialchars($product['productname']); ?>" />
                    </div>
                    <div class="product-info">
                        <p><strong>Deskripsi:</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                        <p><strong>Kategori:</strong> <?php echo htmlspecialchars($product['category_name']); ?></p>
                        <p><strong>Harga:</strong> Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                        <p><a href="addtocart.php?pid=<?php echo $product['pid']; ?>" class="add-to-cart-btn">Tambahkan
                                ke Keranjang</a></p>
                    </div>
                    <div style="clear: both;"></div>
                </div>

                <p><a href="index.php" class="back-to-list-btn">Kembali ke Daftar Produk</a></p>
            </div>
        </div>
        <div class="footer">
            <?php showFooter(); ?>
        </div>
    </div>
</body>

</html>