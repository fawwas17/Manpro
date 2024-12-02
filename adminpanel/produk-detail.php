<?php
require "session.php";
require "../koneksi.php";


// Tambahkan fungsi validateInput
function validateInput($data) {
    global $mysqli; // Menggunakan variabel mysqli yang sudah dideklarasikan
    return htmlspecialchars(mysqli_real_escape_string($mysqli, trim($data)));
}

// Mendapatkan data kategori
$categories = [];
$catSql = "SELECT * FROM kategori";
$catResult = $mysqli->query($catSql);
if ($catResult->num_rows > 0) {
    while ($catRow = $catResult->fetch_assoc()) {
        $categories[] = $catRow;
    }
}

// Cek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validasi input
    $productname = validateInput($_POST['txtName']);
    $description = validateInput($_POST['txtDescription']);
    $price = validateInput($_POST['txtPrice']);
    $cid = validateInput($_POST['txtCategory']);
    $file = $_FILES['fileImage'];
    
    // Pengaturan upload file
    $uploadpath = "../image/products/" . basename($file['name']);
    $imagepath = "image/products/" . basename($file['name']);
    $temppath = $file['tmp_name'];
    $filesize = $file['size'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    // Validasi file gambar
    if (!in_array($file['type'], $allowedTypes)) {
        $error = "Format gambar harus JPEG, PNG, atau GIF.";
    } elseif ($filesize > 2000000) {
        $error = "Ukuran gambar harus kurang dari 2MB.";
    } elseif (!move_uploaded_file($temppath, $uploadpath)) {
        $error = "Gagal mengunggah gambar.";
    } else {
        // Masukkan produk ke database
        $stmt = $mysqli->prepare("INSERT INTO product (productname, description, imgurl, price, category_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $productname, $description, $imagepath, $price, $cid);

        if ($stmt->execute()) {
            // Setelah berhasil, redirect ke halaman produk
            header("Location: produk.php");
            exit; // Menghentikan eksekusi script setelah redirect
        } else {
            $error = "Gagal menambahkan produk.";
        }
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
    input[type="text"],
    textarea,
    input[type="number"],
    select {
        background-color: #f9f9f9; /* Memberikan warna abu-abu muda untuk input */
        border: 1px solid #ccc; /* Border abu-abu */
        padding: 10px; /* Memberikan jarak dalam input */
        border-radius: 5px; /* Membuat sudut input melengkung */
        width: 100%; /* Membuat input mengisi lebar penuh */
        box-sizing: border-box; /* Memastikan padding tidak melebihi lebar */
        font-size: 16px; /* Ukuran font yang lebih nyaman */
    }

    input[type="text"]:focus,
    textarea:focus,
    input[type="number"]:focus,
    select:focus {
        background-color: #fff; /* Warna lebih putih saat difokuskan */
        border-color: #0d6efd; /* Memberikan efek border biru saat difokuskan */
        outline: none; /* Menghilangkan outline default pada browser */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Efek bayangan saat fokus */
    }

    textarea {
        resize: vertical; /* Membatasi pengubahan ukuran hanya vertikal */
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

    /* Menyelaraskan form ke tengah halaman */
    .contents {
        display: block; /* Membuat konten ditampilkan vertikal */
        justify-content: center;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 10px;
        height: auto; /* Mengatur tinggi otomatis agar sesuai dengan konten */
        padding: 40px 0; /* Memberi jarak di atas dan bawah konten */
        background-color: #6c757d; /* Warna background konten */
    }

    form {
        background-color: white; /* Warna latar belakang form */
        border: 1px solid #ddd; /* Memberikan border di sekitar form */
        padding: 20px; /* Jarak dalam form */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Efek bayangan */
        border-radius: 10px; /* Sudut melengkung */
        width: 80%;
        max-width: 600px; /* Batas lebar form */
        margin: 0 auto; /* Membuat form berada di tengah */
    }

    /* Mengatur judul H2 agar berada di tengah */
    h2 {
        text-align: center; /* Posisi teks di tengah */
        margin-bottom: 30px; /* Jarak antara judul dan form */
        font-size: 28px; /* Ukuran font judul */
    }

    /* Style untuk button */
    button {
        background-color: #0d6efd; /* Warna latar belakang biru */
        color: white; /* Warna teks putih */
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0a58ca; /* Warna latar belakang lebih gelap saat dihover */
    }

    /* Style untuk link kembali */
    .kembali-btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-left: 10px;
        transition: background-color 0.3s ease;
    }

    .kembali-btn:hover {
        background-color: #5a6268;
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
                    <i class=""></i> Tambah Produk
                </li>
            </ol>
        </nav>
    </div>

    <div class="contents">
    <h2>Tambah Produk</h2> <!-- Memindahkan di luar form agar berada di atas -->
    <?php if (isset($error)): ?>
      <div class="error-message"><?php echo $error; ?></div>
    <?php elseif (isset($success)): ?>
      <div class="success-message"><?php echo $success; ?></div>
    <?php endif; ?>
    <form action="produk-detail.php" method="post" enctype="multipart/form-data" name="form1" id="form1"
      onsubmit="return validateAddProduct()">
      <p>
        <label>Nama Produk:<br />
          <input name="txtName" type="text" id="txtName" size="50" maxlength="200" required />
        </label>
      </p>
      <p>
        <label>Deskripsi Produk:<br />
          <textarea name="txtDescription" id="txtDescription" rows="10" cols="50" required></textarea>
        </label>
      </p>
      <p>
        <label>Gambar:<br />
          <input name="fileImage" type="file" id="fileImage" required />
        </label>
      </p>
      <p>
        <label>Harga:<br />
          <input name="txtPrice" type="number" id="txtPrice" required />
        </label>
      </p>
      <p>
        <label>Kategori:<br />
          <select name="txtCategory" required>
            <option value="">Pilih Kategori</option>
            <?php foreach ($categories as $category): ?>
              <option value="<?php echo $category['cid']; ?>"><?php echo $category['categoryname']; ?></option>
            <?php endforeach; ?>
          </select>
        </label>
      </p>
      <p>
        <button type="submit" name="Submit">Tambah Produk</button>
        <a href="produk.php" class="kembali-btn">Kembali</a>
      </p>
    </form>
</div>



<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>