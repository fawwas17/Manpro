<?php
    session_start();
    require "../koneksi.php";

    // Inisialisasi pesan alert kosong
    $alert = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../css/login.css">
   <link rel="stylesheet" href="../bootstrap/css/bootstrap-reboot.min.css">

   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   <title>Login Form</title>
</head>
<body>
<div class="center">
  <div class="ear ear--left"></div>
  <div class="ear ear--right"></div>
  <div class="face">
    <div class="eyes">
      <div class="eye eye--left">
        <div class="glow"></div>
      </div>
      <div class="eye eye--right">
        <div class="glow"></div>
      </div>
    </div>
    <div class="nose">
      <svg width="38.161" height="22.03">
        <path d="M2.017 10.987Q-.563 7.513.157 4.754C.877 1.994 2.976.135 6.164.093 16.4-.04 22.293-.022 32.048.093c3.501.042 5.48 2.081 6.02 4.661q.54 2.579-2.051 6.233-8.612 10.979-16.664 11.043-8.053.063-17.336-11.043z" fill="#243946"></path>
      </svg>
      <div class="glow"></div>
    </div>
    <div class="mouth">
      <svg class="smile" viewBox="-2 -2 84 23" width="84" height="23">
        <path d="M0 0c3.76 9.279 9.69 18.98 26.712 19.238 17.022.258 10.72.258 28 0S75.959 9.182 79.987.161" fill="none" stroke-width="3" stroke-linecap="square" stroke-miterlimit="3"></path>
      </svg>
      <div class="mouth-hole"></div>
      <div class="tongue breath">
        <div class="tongue-top"></div>
        <div class="line"></div>
        <div class="median"></div>
      </div>
    </div>
  </div>
  <div class="hands">
        <div class="hand hand--left">
          <div class="finger">
            <div class="bone"></div>
            <div class="nail"></div>
          </div>
          <div class="finger">
            <div class="bone"></div>
            <div class="nail"></div>
          </div>
          <div class="finger">
            <div class="bone"></div>
            <div class="nail"></div>
          </div>
        </div>
        <div class="hand hand--right">
          <div class="finger">
            <div class="bone"></div>
            <div class="nail"></div>
          </div>
          <div class="finger">
            <div class="bone"></div>
            <div class="nail"></div>
          </div>
          <div class="finger">
            <div class="bone"></div>
            <div class="nail"></div>
          </div>
        </div>
      </div>

  <!-- Mulai Form Login -->
  <form action="" method="POST" class="login">
    <label>
        <div class="fa fa-phone"></div>
        <input class="username" type="text" name="username" autocomplete="on" placeholder="Username" required/>
    </label>
    <label>
        <div class="fa fa-commenting"></div>
        <input class="password" type="password" name="password" autocomplete="off" placeholder="Password" required/>
        <button type="button" class="password-button"><i class='bx bx-show'></i></button>
    </label>
    <!-- Tambahkan name pada tombol submit -->
    <button type="submit" class="login-button" name="login-button">Login</button>
</form>
  <!-- Akhir Form Login -->

  <div class="alert-container">
            <?php
               if(isset($_POST['login-button'])){
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);
        
                $query = mysqli_query($mysqli, "SELECT * FROM admin WHERE username= '$username'");
                $countdata = mysqli_num_rows($query);
                $data = mysqli_fetch_array($query);
        
                if($countdata > 0){
                    // Logika jika login berhasil (jika ada)
                    if (password_verify($password, $data['password'])) {
                       $_SESSION['username'] = $data['username'];
                       $_SESSION['login'] = true;
                       header ('location:../adminpanel');
                    } else {
                        echo '<div class="alert alert-warning" role="alert">Password Salah :(</div>';
                    }
                } else {
                    // Pesan alert untuk user yang tidak ditemukan
                    echo '<div class="alert alert-warning" role="alert">Akun Tidak Terdaftar</div>';
                }
            }
            ?>
        </div>

    <script src="../js/login.js"></script>
</body>
</html>