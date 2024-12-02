<?php
    require "session.php";
    require "../koneksi.php";

    $queryKategori = mysqli_query($mysqli, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);

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
    <title>Document</title>
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

</style>

<body>
    <!-- Navbar Section -->
    <?php require "navbar.php";?>
    <!-- Navbar Section -->

    <!-- Breadcrumb Section -->
    <div class="container-top">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class=""></i> Kategori
                </li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Katergori</h3>

            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" id="kategori" name="kategori" placeholder="input kategori"
                    class="form-control">
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpanKategori">Simpan</button>
                </div>
            </form>

            <?php
            if(isset($_POST['simpanKategori'])){
                $kategori = htmlspecialchars($_POST['kategori']);
                $queryExist = mysqli_query($mysqli, "SELECT categoryname FROM kategori WHERE categoryname='$kategori'");
                $jumlahKategoriBaru = mysqli_num_rows($queryExist);

                if($jumlahKategoriBaru > 0){
                    ?>
                    <div class="alert alert-warning mt-3" role="alert">
                     Kategori Sudah Ada
                    </div>
                    <?php
                }
                else{
                    $querySimpan = mysqli_query($mysqli, "INSERT INTO kategori (categoryname) VALUES ('$kategori')");
                    if($querySimpan){
                        ?>
                        <div class="alert alert-success mt-3" role="alert">
                         Berhasil Menambahkan Kategori
                        </div>
                        <meta http-equiv="refresh" content="0.5"; url="kategori.php">
                        <?php

                    }
                    else{
                        echo mysqli_error($mysqli);
                    }
                }
            }
            ?>
        </div>

        <div class="mt-3">
            <h2>List Kategori</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                            if($jumlahKategori==0){
                        ?>
                            <tr>
                                <td colspan=3 class="text-center">Data Kategori Belum Ada</td>
                            </tr>
                        <?php
                            }
                            else{
                                $jumlah = 1;
                                while($data=mysqli_fetch_array($queryKategori)){
                        ?>
                                <tr>
                                    <td><?php echo $jumlah; ?></td>
                                    <td><?php echo $data['categoryname']; ?></td>
                                    <td>
                                    <a href="kategori-detail.php?cid=<?php echo $data['cid'] ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                                    </td>
                                </tr>
                        <?php
                                $jumlah++;
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>