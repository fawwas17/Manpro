<!--
"Paws Store" adalah toko online alat kesehatan yang dikembangkan untuk keperluan akademis. Desain dan pengembangan oleh Achmad Sirajul Fahmi. (c) 2024 Hak Cipta Dilindungi.
-->
<?php

include "core.php";

?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Tentang Kami</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
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
    .about-title{
        font-size: 20px;
        font-weight: semibold;
        margin-bottom: 20px;
    }
    .about-description{
        font-size: 14px;
        margin-bottom: 20px;
    }
</style>

<body>
	<div class="navigation">
	<?php
    mainMenu();
    ?>
	</div>
    
    <div class="container-top">
        <h2 class="about-title">Tentang Paws Store</h2>
        <p class="about-description">Paws Store adalah toko online alat kesehatan yang dikembangkan untuk keperluan akademis, dengan
		tujuan untuk menyediakan akses yang mudah dan cepat kepada pelanggan kami untuk mendapatkan berbagai
		jenis alat kesehatan yang berkualitas tinggi dan harga yang kompetitif.</p>
		<p class="about-description">Kami berkomitmen untuk memberikan pelayanan yang terbaik kepada pelanggan kami, dengan menyediakan
		produk yang aman, efektif, dan mudah digunakan. Kami juga berusaha untuk memastikan bahwa semua
		produk yang kami jual telah memenuhi standar kualitas yang tinggi dan telah diuji secara menyeluruh
		sebelum dijual.</p>
		<p class="about-description">Paws Store juga berusaha untuk menjadi toko online alat kesehatan yang paling terpercaya dan
		dipercaya oleh pelanggan kami. Kami berusaha untuk membangun hubungan yang baik dengan pelanggan
		kami dan memberikan pelayanan yang memuaskan.</p>
			</div>
		</div>
	</div>
</body>

</html>