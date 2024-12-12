<!--
"Paw Store" adalah sebuah website e-commerce yang dikembangkan untuk keperluan akademis. Website ini merupakan contoh sederhana dari sebuah keranjang belanja dan mungkin mengandung kesalahan atau bug.

Didesain dan dikembangkan oleh Achmad Sirajul Fahmi. (c) 2024 Hak Cipta Dilindungi.
-->
<?php

include "core.php";
include "koneksi.php";

//if user not logged in, redirect to home page
if (isset($_SESSION['uid'])) {
  header("Location: index.php");
}

?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Daftar</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/index.css">
  <script src="js/myscript.js" language="javascript" type="text/javascript"></script>
</head>

<style>
body {
    background-color: #eef2f7; /* Latar belakang dengan warna yang lembut */
    font-family: 'Arial', sans-serif; /* Font umum */
    color: #333; /* Warna teks yang mudah dibaca */
}

.container-top, .contents {
    width: 100%;
    max-width: 500px; /* Batasi lebar maksimum form register */
    margin: 80px auto; /* Form di tengah */
    padding: 20px;
    background-color: #fff; /* Warna putih untuk kontainer */
    border-radius: 10px; /* Sudut melengkung */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bayangan lembut */
}

h2 {
    text-align: center;
    color: #0a516b; /* Warna teks heading */
    margin-bottom: 20px;
}

label {
    display: block;
    font-size: 16px;
    margin-bottom: 8px;
}

input[type="text"],
input[type="password"],
input[type="date"],
select {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

input[type="radio"] {
    margin-right: 5px;
}

input[type="submit"],
input[type="reset"] {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    background-color: #28a745; /* Warna hijau untuk tombol */
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover,
input[type="reset"]:hover {
    background-color: #218838; /* Warna tombol saat hover */
}

.gender-container {
    margin-bottom: 15px;
}

select {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
}

.error-message {
    color: red;
    font-size: 14px;
    margin-top: -10px;
    margin-bottom: 15px;
    display: none;
}

@media (max-width: 600px) {
    .container-top, .contents {
        margin: 40px 15px;
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
      <div class="contents">
        <h2>Daftar</h2>
        <?php

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
          $username = validateInput($_POST['txtUsername']);
          $password = validateInput($_POST['txtPassword']);
          $retypePassword = validateInput($_POST['txtRetypePassword']);
          $email = validateInput($_POST['txtEmail']);
          $dateOfBirth = validateInput($_POST['txtDateOfBirth']);
          $gender = validateInput($_POST['txtGender']);
          $address = validateInput($_POST['txtAddress']);
          $city = validateInput($_POST['txtCity']);
          $contactNo = validateInput($_POST['txtContactNo']);
          if ($password == $retypePassword) {
            $hashed_password = md5($password);
            $stmt = $mysqli->prepare("INSERT INTO user (username, password, email, date_of_birth, gender, address, city, contact_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $username, $hashed_password, $email, $dateOfBirth, $gender, $address, $city, $contactNo);
            if ($stmt->execute()) {
              echo '<div class="alert alert-success" role="alert"> Pendaftaran Berhasil </div>';
            } else {
              echo '<div class="alert alert-danger" role="alert"> Pendaftaran Gagal </div>';
            }
          } else {
            echo '<div class="alert alert-warning" role="alert"> Password Tidak Cocok </div>';
          }
        }
        ?>
        <form id="form1" name="form1" method="post" action="register.php" onsubmit="return validateRegister()">
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
            <label>Retype Password:
              <br />
              <input name="txtRetypePassword" type="password" id="txtRetypePassword" />
            </label>
          </p>
          <p>
            <label>E-mail:
              <br />
              <input name="txtEmail" type="text" id="txtEmail" />
            </label>
          </p>
          <p>
            <label>Date of Birth:
              <br />
              <input name="txtDateOfBirth" type="date" id="txtDateOfBirth" />
            </label>
          </p>
          <p>
            <label>Gender:
              <br />
              <input type="radio" name="txtGender" value="male" /> Male
              <input type="radio" name="txtGender" value="female" /> Female
            </label>
          </p>
          <p>
            <label>Address:
              <br />
              <input name="txtAddress" type="text" id="txtAddress" />
            </label>
          </p>
          <p>
            <label>City:
              <br />
              <select name="txtCity" id="txtCity">
                <option value=" Jakarta">Jakarta</option>
                <option value="Bandung">Bandung</option>
                <option value="Surabaya">Surabaya</option>
                <option value="Yogyakarta">Yogyakarta</option>
                <option value="Lain-lain">Lain-lain</option>
              </select>
            </label>
          </p>
          <p>
            <label>Contact No:
              <br />
              <input name="txtContactNo" type="text" id="txtContactNo" />
            </label>
          </p>
          <p>
            <input type="submit" name="Submit" value="Daftar" />
            <input type="reset" name="Clear" value="Clear" />
          </p>
        </form>
      </div>
  </div>
</body>

</html>