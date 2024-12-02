<?php
require "session.php";
require "../koneksi.php";
require_once "functions.php"; // Mengimpor fungsi dari file terpisah

if (!isset($_GET['editpid'])) {
    header("Location: produk.php");
}

$pid = validateInput($_GET['editpid']);
$product = [];
$categories = [];

// Fetch the product details
$productSql = "SELECT * FROM product WHERE pid = ?";
$stmt = $mysqli->prepare($productSql);
$stmt->bind_param("i", $pid);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    header("Location: produk.php");
}

// Fetch categories for dropdown
$catSql = "SELECT * FROM kategori";
$catResult = $mysqli->query($catSql);
if ($catResult->num_rows > 0) {
    while ($catRow = $catResult->fetch_assoc()) {
        $categories[] = $catRow;
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Sanitize inputs and validate
    $productname = validateInput($_POST['txtName']);
    $description = validateInput($_POST['txtDescription']);
    $price = validateInput($_POST['txtPrice']);
    $cid = validateInput($_POST['txtCategory']);

    // Prepare and execute the update query
    $stmt = $mysqli->prepare("UPDATE product SET productname=?, description=?, price=?, category_id=? WHERE pid=?");
    $stmt->bind_param("ssdii", $productname, $description, $price, $cid, $pid);

    if ($stmt->execute()) {
        // Redirect to produk.php after successful update
        header("Location: produk.php?success=1");
        exit(); // Pastikan untuk menghentikan eksekusi skrip setelah redirect
    } else {
        $error = "Gagal memperbarui produk.";
    }
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
        body {
            background-color: #f8f9fa; /* Warna latar belakang halaman */
        }

        .container-top {
            margin-top: 100px; /* Jarak dari atas */
            margin-left: 50px; /* Jarak dari kiri */
            margin-right: 50px; /* Jarak dari kanan */
        }

        h2 {
            color: #343a40; /* Warna judul */
            text-align: center; /* Pusatkan teks judul */
            margin-bottom: 20px; /* Jarak bawah judul */
        }

        .contents {
            background-color: #ffffff; /* Warna latar belakang konten */
            border-radius: 10px; /* Membulatkan sudut */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Bayangan kotak */
            padding: 30px; /* Jarak dalam konten */
            max-width: 600px; /* Lebar maksimal konten */
            margin: 0 auto; /* Pusatkan konten */
        }

        label {
            font-weight: bold; /* Tebalkan teks label */
            display: block; /* Tampilkan label sebagai blok */
            margin-bottom: 5px; /* Jarak bawah label */
        }

        input[type="text"], input[type="number"], textarea, select {
            width: 100%; /* Lebar penuh */
            padding: 10px; /* Jarak dalam */
            border: 1px solid #ced4da; /* Warna border */
            border-radius: 5px; /* Membulatkan sudut input */
            margin-bottom: 20px; /* Jarak bawah input */
        }

        button[type="submit"] {
            background-color: #28a745; /* Warna latar belakang tombol */
            color: #ffffff; /* Warna teks tombol */
            border: none; /* Hilangkan border */
            border-radius: 5px; /* Membulatkan sudut tombol */
            padding: 10px 20px; /* Jarak dalam tombol */
            cursor: pointer; /* Ubah kursor saat hover */
        }

        button[type="submit"]:hover {
            background-color: #218838; /* Warna tombol saat hover */
        }

        a {
            text-decoration: none; /* Hilangkan garis bawah */
            color: #007bff; /* Warna tautan */
        }

        a:hover {
            text-decoration: underline; /* Garis bawah saat hover */
        }

        .error-message {
            color: #dc3545; /* Warna merah untuk pesan kesalahan */
            margin-bottom: 20px; /* Jarak bawah pesan kesalahan */
        }

        .success-message {
            color: #28a745; /* Warna hijau untuk pesan sukses */
            margin-bottom: 20px; /* Jarak bawah pesan sukses */
        }

        .button-back {
            background-color: #007bff; /* Warna latar belakang tombol kembali */
            color: #ffffff; /* Warna teks tombol kembali */
            border: none; /* Hilangkan border */
            border-radius: 5px; /* Membulatkan sudut tombol kembali */
            padding: 10px 20px; /* Jarak dalam tombol kembali */
            text-decoration: none; /* Hilangkan garis bawah pada tautan */
            cursor: pointer; /* Ubah kursor saat hover */
            margin-left: 10px; /* Jarak kiri untuk memisahkan tombol dari tombol submit */
            display: inline-block; /* Agar bisa memiliki margin dan padding */
        }

        .button-back:hover {
            background-color: #0056b3; /* Warna tombol kembali saat hover */
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
                    <a href="produk.php" class="no-decoration text-muted">
                        <i class=""></i> Produk
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class=""></i> Edit Produk
                </li>
            </ol>
        </nav>
    </div>

    <div class="contents">
        <h2>Edit Produk</h2>
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php elseif (isset($success)): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
        <form action="produk-edit.php?editpid=<?php echo $pid; ?>" method="post" enctype="multipart/form-data"
            name="form1" id="form1" onsubmit="return validateAddProduct()">
            <p>
                <label>Nama Produk:<br />
                    <input name="txtName" type="text" id="txtName"
                        value="<?php echo $product['productname']; ?>" size="50" maxlength="200" required />
                </label>
            </p>
            <p>
                <label>Deskripsi Produk:<br />
                    <textarea name="txtDescription" id="txtDescription" rows="10" cols="50"
                        required><?php echo $product['description']; ?></textarea>
                </label>
            </p>
            <p>
                <label>Harga:<br />
                    <input name="txtPrice" type="number" id="txtPrice" value="<?php echo $product['price']; ?>"
                        required />
                </label>
            </p>
            <p>
                <label>Kategori:<br />
                    <select name="txtCategory" required>
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['cid']; ?>" <?php echo ($category['cid'] == $product['category_id']) ? 'selected' : ''; ?>>
                                <?php echo $category['categoryname']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </p>
            <p>
                <button type="submit" name="Submit">Perbarui Produk</button>
                <a href="produk.php" class="button-back">Kembali</a>
            </p>
        </form>
    </div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
