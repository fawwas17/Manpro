<?php
    require "session.php";
    require "../koneksi.php";

    function validateInput($data) {
        global $mysqli; // Pastikan variabel $mysqli tersedia
        return htmlspecialchars(mysqli_real_escape_string($mysqli, trim($data)));
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

    /* Gaya khusus untuk form tambah admin */
    .form-container {
        width: 60%;
        margin: 0 auto; /* Agar form berada di tengah */
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 15px;
        background-color: #f9f9f9;
    }

    .form-label {
        font-weight: bold;
    }

    .form-control {
        margin-bottom: 15px;
        height: 45px;
        font-size: 16px;
    }

    .btn-submit {
        width: 100%;
        padding: 10px;
        font-size: 18px;
        background-color: #0a6b4a;
        color: white;
        border: none;
        border-radius: 5px;
    }

    .btn-submit:hover {
        background-color: #094b36;
    }

    .h2-name {
        text-align: center;
        margin-bottom: 20px;
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
                    <a href="admin.php" class="no-decoration text-muted">
                        Admin
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Tambah Admin
                </li>
            </ol>
        </nav>
    </div>

    <div class="contents">
        <div class="form-container">
            <h2 class="h2-name">Tambah Admin</h2>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
              $username = validateInput($_POST['txtName']);
              $address = validateInput($_POST['txtAddress']);
              $email = validateInput($_POST['txtEmail']);
              $password = validateInput($_POST['txtPassword']);
              $confPassword = validateInput($_POST['txtConfPassword']);

              // Cek apakah email sudah ada di database
              $stmtCheck = $mysqli->prepare("SELECT * FROM admin WHERE email = ?");
              $stmtCheck->bind_param("s", $email);
              $stmtCheck->execute();
              $result = $stmtCheck->get_result();

              if ($result->num_rows > 0) {
                // Jika email sudah ada, tampilkan pesan error
                echo "<div class='alert alert-danger' role='alert'>Email telah digunakan!</div>";
              } else {
                // Cek apakah password dan konfirmasi password cocok
                if ($password === $confPassword) {
                  // Hash password menggunakan bcrypt
                  $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                  // Masukkan admin baru ke dalam database
                  $stmt = $mysqli->prepare("INSERT INTO admin (username, address, email, password) VALUES (?, ?, ?, ?)");
                  $stmt->bind_param("ssss", $username, $address, $email, $hashed_password); 
                  if ($stmt->execute()) {
                    // Redirect ke halaman admin jika berhasil
                    header("Location: admin.php");
                    exit(); // Pastikan script berhenti setelah redirect
                  } else {
                    echo "<div class='alert alert-danger' role='alert'>Gagal menambahkan admin</div>";
                  }
                } else {
                  echo "<div class='alert alert-danger' role='alert'>Password dan konfirmasi password tidak cocok!</div>";
                }
              }
            }
            ?>
            <form id="form1" name="form1" method="post" action="admin-detail.php" onsubmit="return validateRegister()">
                <div class="mb-3">
                    <label for="txtName" class="form-label">Nama:</label>
                    <input type="text" name="txtName" id="txtName" class="form-control" required />
                </div>

                <div class="mb-3">
                    <label for="txtAddress" class="form-label">Alamat:</label>
                    <input type="text" name="txtAddress" id="txtAddress" class="form-control" required />
                </div>

                <div class="mb-3">
                    <label for="txtEmail" class="form-label">Email:</label>
                    <input type="email" name="txtEmail" id="txtEmail" class="form-control" required />
                </div>

                <div class="mb-3">
                    <label for="txtPassword" class="form-label">Password:</label>
                    <input type="password" name="txtPassword" id="txtPassword" class="form-control" required />
                </div>

                <div class="mb-3">
                    <label for="txtConfPassword" class="form-label">Konfirmasi Password:</label>
                    <input type="password" name="txtConfPassword" id="txtConfPassword" class="form-control" required />
                </div>

                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </div>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
