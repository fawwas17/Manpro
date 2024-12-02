<?php
    require "session.php";
    require "../koneksi.php";

    // Mengambil nilai 'cid' dari parameter URL
    $id = $_GET['cid'];

    // Mengambil data kategori berdasarkan 'cid'
    $query = mysqli_query($mysqli, "SELECT * FROM kategori WHERE cid = '$id'");
    $data = mysqli_fetch_array($query);
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
    <title>Detail Kategori</title>
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
                    <a href="kategori.php" class="no-decoration text-muted">
                        <i class=""></i> Kategori
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class=""></i> Detail Kategori
                </li>
            </ol>
        </nav>
    </div>

    <div class="container mt-5">
        <h1>Detail Kategori</h1>
        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control kategori-input-besar" value="<?php echo $data['categoryname']; ?>">
                </div>


                <div class="mt-5 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>

            <?php
                // Proses edit kategori
                if(isset($_POST['editBtn'])){
                    $kategori = htmlspecialchars($_POST['kategori']);

                    if($data['categoryname'] == $kategori){
                        echo "<meta http-equiv='refresh' content='0.5; url=kategori.php'>";
                    } else {
                        $query = mysqli_query($mysqli, "SELECT * FROM kategori WHERE categoryname='$kategori'");
                        $jumlahData = mysqli_num_rows($query);
                    
                        if($jumlahData > 0){
                            echo "<div class='alert alert-warning mt-3' role='alert'>Kategori Sudah Ada</div>";
                        } else {
                            $querySimpan = mysqli_query($mysqli, "UPDATE kategori SET categoryname='$kategori' WHERE cid='$id'");
                            if($querySimpan){
                                echo "<div class='alert alert-success mt-3' role='alert'>Berhasil Mengupdate Kategori</div>";
                                echo "<meta http-equiv='refresh' content='0.5; url=kategori.php'>";
                            } else {
                                echo mysqli_error($mysqli);
                            }
                        }
                    }
                }

                // Proses delete kategori
                if(isset($_POST['deleteBtn'])){
                    $queryDelete = mysqli_query($mysqli, "DELETE FROM kategori WHERE cid='$id'");

                    if($queryDelete){
                        echo "<div class='alert alert-success mt-3' role='alert'>Berhasil di Hapus</div>";
                        echo "<meta http-equiv='refresh' content='0.5; url=kategori.php'>";
                    } else {
                        echo mysqli_error($mysqli);
                    }
                }
            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
