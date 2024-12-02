<?php

include "core.php";
include "koneksi.php";

//jika pengguna sudah login, redirect ke halaman beranda
if (isset($_SESSION['uid'])) {
	header("Location: index.php");
}

?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Login User</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
	<script src="js/script.js" language="javascript" type="text/javascript"></script>
</head>

<style>
    body {
    background-color: #f0f8ff; /* Warna latar belakang yang lembut */
    font-family: 'Arial', sans-serif; /* Font untuk keseluruhan halaman */
}

.container-top {
    width: 100%;
    max-width: 400px; /* Batasi lebar maksimum untuk form login */
    margin: 100px auto; /* Biar form di tengah */
    padding: 20px;
    background-color: white; /* Warna latar belakang putih untuk form */
    border-radius: 10px; /* Sudut melengkung */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bayangan lembut */
}

h2 {
    text-align: center;
    color: #0a516b; /* Warna untuk heading */
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-size: 16px;
    color: #333;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc; /* Garis batas input */
    border-radius: 5px; /* Sudut melengkung untuk input */
    box-sizing: border-box; /* Biar padding dan width rapi */
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #0a516b; /* Warna tombol */
    border: none;
    border-radius: 5px; /* Tombol dengan sudut melengkung */
    color: white;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease; /* Animasi untuk hover */
}

input[type="submit"]:hover {
    background-color: #08495c; /* Warna tombol saat hover */
}

p {
    text-align: center;
    margin-top: 20px;
}

@media (max-width: 600px) {
    .container-top {
        margin: 50px 20px; /* Lebih kecil untuk mobile */
        padding: 15px;
    }
}

</style>

<body>
	<div class="navigation">
		<?php
			mainMenu();
		?>
			</div>
			<div class="container-top">
				<h2>Login User</h2>
				<?php

				if ($_SERVER['REQUEST_METHOD'] == "POST") {
					$username = validateInput($_POST['txtUsername']);
					$password = md5(validateInput($_POST['txtPassword']));
					$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
					$result = $mysqli->query($sql);
					if ($result->num_rows > 0) {
						//login sukses
						$row = $result->fetch_assoc();
						$_SESSION["uid"] = $row['uid']; //set session
						setcookie("uid", $row['uid'], time() + (86400 * 30), "/"); //set cookie
						header("Location: index.php");
					} else {
						//login gagal
						echo '<div class="alert alert-warning" role="alert"> Login tidak Valid</div>';
					}
				}

				?>
				<form id="form1" name="form1" method="post" action="login.php" onsubmit="return validateLogin()">
					<p>
						<label>Username:
							<br />
							<input name="txtUsername" type="text" id="txtUsername" />
						</label>
					</p>
					<p>
						<label>Password:
							<br />
							<input name="txtPassword" type="password" id="txtPassword" />
						</label>
					</p>
					<p>
						<input type="submit" name="Submit" value="Submit" />
					</p>
				</form>
			</div>
		</div>
	</div>
</body>

</html>