<?php
// session_start(); // Pastikan session dimulai
include "core.php";
include "koneksi.php";

// Logika untuk menambahkan produk ke keranjang
if (isset($_GET['pid'])) {
    if (isset($_SESSION['uid'])) {
        $pid = validateInput($_GET['pid']);
        
        // Cek apakah produk sudah ada di keranjang
        $uid = $_SESSION['uid'];
        $sql = "SELECT cid FROM cart WHERE uid = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $cart = $result->fetch_assoc();
            $cid = $cart['cid'];

            // Cek apakah produk sudah ada di dalam cartdetail
            $sql = "SELECT * FROM cartdetail WHERE cid = ? AND pid = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ii", $cid, $pid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Jika sudah ada, tambahkan qty
                $sql = "UPDATE cartdetail SET qty = qty + 1 WHERE cid = ? AND pid = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ii", $cid, $pid);
                $stmt->execute();
            } else {
                // Jika belum ada, tambahkan ke cartdetail
                $sql = "INSERT INTO cartdetail (cid, pid, qty) VALUES (?, ?, 1)";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ii", $cid, $pid);
                $stmt->execute();
            }
        } else {
            // Jika cart tidak ditemukan, buat cart baru untuk user
            $sql = "INSERT INTO cart (uid) VALUES (?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $uid);
            $stmt->execute();
            $cid = $stmt->insert_id;

            // Masukkan produk ke cartdetail
            $sql = "INSERT INTO cartdetail (cid, pid, qty) VALUES (?, ?, 1)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ii", $cid, $pid);
            $stmt->execute();
        }

        // Redirect ke halaman keranjang atau tampilkan pesan berhasil
        header("Location: cart.php");
        exit();
    } else {
        echo "Anda harus login untuk menambahkan produk ini ke keranjang";
    }
}

if (isset($_GET['reset']) && $_GET['reset'] == 1) {
  header("Location: index.php");
  exit;
}

$categories = [];
$catSql = "SELECT * FROM kategori";
$catResult = $mysqli->query($catSql);
if ($catResult->num_rows > 0) {
    while ($catRow = $catResult->fetch_assoc()) {
        $categories[] = $catRow;
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Paw Store</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/index.css">
  <script src="js/myscript.js" language="javascript" type="text/javascript"></script>
</head>

<!-- Styles and HTML content continues as per your original code -->

<style>
  body {
    background-color: #f5f5f5;
    font-size: 14px;
  }

  .kotak {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
  }

  .container-top {
    margin-top: 80px;
    margin-left: 50px;
    margin-right: 50px;
  }

  .product-container {
    display: flex;
    margin-top:1rem;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
  }

  .product-item {
    flex-basis: 23%;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: center;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
  }

  .product-item:hover {
    transform: scale(1.05);
  }

  .product-item img {
    max-width: 100%;
    height: auto;
    max-height: 150px;
    object-fit: contain;
    margin-bottom: 15px;
    border-radius: 10px;
  }

  .product-item h5 {
    margin: 10px 0;
    font-size: 18px;
  }

  .product-item p {
    margin-bottom: 5px;
    font-weight: bold;
    color: #28a745;
  }

  .btn {
    background-color: #28a745;
    color: white;
    padding: 10px;
    border-radius: 5px;
    border-color: #0003;
    text-decoration: none;
    font-size: 12px;
  }

  .pagination{
    display: flex;
    justify-content: center;
    margin-top: 20px;
    align-items: center;
    gap: 1rem;
    text-align:center;
  }

  .btn:hover {
    background-color: #218838;
    color: white;
  }

  .navigation {
    margin-bottom: 50px;
  }

  .hero-title {
    font-size: 20px;
    margin-top: 100px;
  }
  .hero-description{
    font-size: 16px;
    margin-bottom: 20px;
  }
  .price {
    font-size: 16px;
    font-weight: bold;
  }

  .dropdown-filter{
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-left: 10px;
  }

  .btn-reset {
    margin-left: 10px;
    padding: 5px 10px;
    background-color: #f44336;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .btn-reset:hover {
    background-color: #d32f2f;
  }

  .button-container {
    display: flex;
    justify-content: space-between;
  }

  .bg-blue{
    background-color: #007bff;
  }

  .bg-blue:hover{
    background-color: #0056b3;
  }
</style>

<body>
    <div class="navigation">
        <?php mainMenu(); ?>
    </div>

    <div class="container-top">
        <h2 class="hero-title">Selamat Datang di Paw Store!</h2>
        <p class="hero-description">Kami menyediakan berbagai jenis peralatan kesehatan yang berkualitas tinggi dan harga yang kompetitif. Kami
            berkomitmen untuk memberikan pelayanan yang terbaik kepada pelanggan kami.</p>
        <form method="GET" action="index.php">
            <label>Filter Produk Berdasarkan:</label>
            <select name="category" class="dropdown-filter" onchange="this.form.submit()">
              <option value=""><?= isset($_GET['category']) && !empty($_GET['category']) 
              ? array_column($categories, 'categoryname', 'cid')[$_GET['category']] 
              : 'Pilih Kategori'; ?>
              </option>
              <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['cid']; ?>">
                  <?php echo (isset($_GET['category']) && $_GET['category'] == $category['cid']) ? 'selected' : ''; ?>>
                  <?php echo $category['categoryname']; ?>
                </option>
                <?php endforeach; ?>
              </select>
              <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>">
              <button type="submit" class="btn-reset" name="reset" value="1">Reset</button>
        </form>

        <div class="product-container">
          <?php
          $category = isset($_GET['category']) ? $_GET['category'] : null;
          
          // Pagination settings
          $page = null;
          $items_per_page = 4;
          if (isset($_GET["page"])) $page = validateInput($_GET["page"]);
          if ($page == "" || $page <= 0) $page = 1;

          // Count products
          $query = "SELECT COUNT(*) AS num FROM product";
          $stmt = $mysqli->prepare($query);
          $stmt->execute();
          $row = $stmt->get_result()->fetch_assoc();
          $num_items = $row['num'];
          $num_pages = ceil($num_items / $items_per_page);
          if (($page > $num_pages) && $page != 1) $page = $num_pages;
          $limit_start = ($page - 1) * $items_per_page;

          if ($category) {
            $sql = "SELECT * FROM product WHERE category_id = ? ORDER BY pid DESC LIMIT ?, ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("iii", $category, $limit_start, $items_per_page);
          } else {
            $sql = "SELECT * FROM product ORDER BY pid DESC LIMIT ?, ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ii", $limit_start, $items_per_page);
          }

          $stmt->execute();
          $result = $stmt->get_result();
          ?>
          <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-item">
              <img src="<?= htmlspecialchars($row['imgurl']); ?>" alt="<?= htmlspecialchars($row['productname']); ?>" />
              <h5><?= htmlspecialchars($row['productname']); ?></h5>
              <p class="price">Rp. <?= number_format($row['price'], 0, ',', '.'); ?></p>
              <div class="button-container">
                <a href="produk-detail.php?pid=<?= htmlspecialchars($row['pid']); ?>" class="btn bg-blue">Lihat Detail</a>
                <a href="index.php?pid=<?= htmlspecialchars($row['pid']); ?>&page=<?= $page; ?>" class="btn">Add To Cart</a>
              </div>
            </div>
          <?php endwhile; ?>
          <?php else: ?>
            <p>Tidak ada produk yang tersedia</p>
          <?php endif; ?>
        </div>
        <div class="pagination">
          <?php
        // Page navigation links
        if ($num_pages > 1) {
          echo "<div class='pagination'>";
          if ($page > 1) {
            $ppage = $page - 1;
            echo "<a href=\"index.php?page=$ppage\" class='btn'>Prev</a> ";
          }
          echo "<span>Halaman $page dari $num_pages</span>";
          if ($page < $num_pages) {
            $npage = $page + 1;
            echo " <a href=\"index.php?page=$npage\" class='btn'>Next</a>";
          }
          echo "</div>";
        }
        ?>
        </div>

      </div>
</body>

</html>
