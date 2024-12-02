<?php
    require "session.php";
    require "../koneksi.php";

    $queryKategori = mysqli_query($mysqli, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);

    
    $queryproduct = mysqli_query($mysqli, "SELECT * FROM product");
    $jumlahproduct = mysqli_num_rows($queryproduct);
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
    <title>Home</title>
</head>

<style>
    .kotak {
        border: solid;
    }

    .summary-kategori{
        background-color: #0a6b4a;
        border-radius: 15px;
    }

    .summary-product{
        background-color: #0a516b;
        border-radius: 15px;
    }

    .no-decoration{
        text-decoration: none;
    }

    .container-top{
        margin-top: 100px;
        margin-left: 10px;
    }

    .h2-name{
        margin-left: 20px;
    }


</style>

<body>
<!-- Navbar Section -->
    <?php require "navbar.php";?>
<!-- Navbar Section -->

<!-- Breadcrumb Section -->
    <div class="container-top mt-100">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-home"></i> Home
                </li>
            </ol>
        </nav>

    <h2 class="h2-name">Halo <?php echo $_SESSION['username'] ?></h2>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-kategori p-4">
                    <div class="row">
                        <div class="col-6">
                            <i class="fas fa-align-justify fa-7x text-black-50"></i>
                        </div>
                        <div class="col-6 text-white">
                            <h3 class="fs-2">Kategori</h3>
                            <p class="fs-3"><?php echo $jumlahKategori; ?> Kategori</p>
                            <p><a href="kategori.php" class="text-white no-decoration">Lihat Detail</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-product p-4">
                    <div class="row">
                        <div class="col-6">
                            <i class="fas fa-box fa-7x text-black-50"></i>
                        </div>
                        <div class="col-6 text-white">
                            <h3 class="fs-2">product</h3>
                            <p class="fs-3"><?php echo $jumlahproduct; ?> product</p>
                            <p><a href="product.php" class="text-white no-decoration">Lihat Detail</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<!-- Breadcrumb Section -->

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
