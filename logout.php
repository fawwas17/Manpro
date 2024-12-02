<!--
"Medika Store" adalah toko online alat kesehatan yang dikembangkan untuk keperluan akademis. Desain dan pengembangan oleh Achmad Sirajul Fahmi. (c) 2024 Hak Cipta Dilindungi.
-->
<?php

include "core.php";
include "koneksi.php";

//jika pengguna tidak login, redirect ke halaman utama
if (!isset($_SESSION['uid'])) {
	header("Location: index.php");
}

?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Keluar</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
	<script src="js/script.js" language="javascript" type="text/javascript"></script>
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
		<?php
			mainMenu();
			?>
			</div>
			<div class="container-top">
				<h2>Keluar</h2>
				<?php

				//logout
				setcookie("uid", "", time() - 1, "/"); //clear cookie
				session_destroy(); //destroy session
				echo '<div class="alert alert-success" role="alert"> Berhasil Keluar </div>';

				?>
			</div>
		</div>
	</div>
</body>

</html>