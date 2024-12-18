<?php
include "core.php";
include "koneksi.php";

if (!isset($_SESSION['uid'])) {
	header("Location: index.php");
	exit;
}

// Fetch user details (assuming user ID is passed via GET)
$pid = $_GET['pid'];

$sql = "SELECT p.*, k.categoryname FROM product p
        LEFT JOIN kategori k ON p.category_id = k.cid
        WHERE p.pid = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $pid);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("product not found");
}

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Paw Store</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/index.css">
  <script src="js/myscript.js" language="javascript" type="text/javascript"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size:14px;
            line-height: 1.6;
        }
        .container {
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .details {
            margin-top: 20px;
            text-align:center;
            display: flex;
            gap: 20px;
        }
        .details div {
            margin-bottom: 10px;
        }
        .detail-product{
            display: flex;
            flex-direction: column;
            height:100%;
            width: 40rem;
        }
        .label {
            font-weight: bold;
        }
        .product-name{
            font-size:2rem;
            margin-top:1rem;
            font-weight:bold;
        }
        .price {
            font-size:1.75rem;
            font-weight:bold;
        }
        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        
        .button-container {
            display: flex;
            justify-content: flex-end;
        }

        .bg-blue{
            background-color: #007bff;
        }

        .bg-blue:hover{
            background-color: #0056b3;
        }

        .description{
            margin-bottom: auto;
        }
    </style>
</head>
<body>
    <div class="navigation">
        <?php mainMenu(); ?>
    </div>

    <div class="container">
        <div>
            <a href="index.php" class="btn btn-primary">Back to Home</a>
        </div>
        <div class="product-name"> <?= htmlspecialchars($product['productname']); ?></div>
        <div class="details">
            <div>
                <div><img src="<?= htmlspecialchars($product['imgurl']); ?>" alt="<?= htmlspecialchars($product['productname']); ?>" class="product-image" /></div>
                <div class="price">Rp. <?= number_format($product['price'], 0, ',', '.'); ?></div>
            </div>
            <div class="detail-product">
                <div>Category:<br/><span class="label"> <?= htmlspecialchars($product['categoryname']); ?></span></div>
                <div class="description"><?= htmlspecialchars($product['description']); ?></div>
                <div class="button-container">
                    <a href="index.php?pid=<?= htmlspecialchars($product['pid']); ?>" class="btn">Add To Cart</a>
              </div>
            </div>
        </div>
    </div>

</body>
</html>
