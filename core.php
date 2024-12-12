<?php
//start session when each page loads
session_start();

//set your site title and footer in here
$site_title = "Paw Store";
$site_footer = "Paw Store " . date("Y") . " &copy;  Fawwas Shafiq";

//retrieve cookies
if (isset($_COOKIE['uid'])) {
    $_SESSION['uid'] = $_COOKIE['uid'];
}

if (isset($_COOKIE['aid'])) {
    $_SESSION['aid'] = $_COOKIE['aid'];
}

//main navigation menu
function mainMenu()
{
    if (isset($_SESSION['uid'])) {
        echo '<header class="header">';
        echo '<div class="logo">';
        echo '<a href="#" class="logo" style="font-size:20px;"><i class="fas fa-cat"></i>Paw Store</a>';
        echo '</div>';
        echo '<nav class="navbar" id="navbar">';
        echo '<a href="index.php" name="home">Home</a>';
        echo '<a href="cart.php" name="contact">Keranjang</a>';
        echo '<a href="orders.php" name="home">Pesanan</a>';
        echo '<a href="about.php" name="about-us">About</a>';
        echo '<a href="logout.php" name="Team">Log out</a>';
        echo '</nav>';
        echo '</header>';
    } else {
        echo '<header class="header">';
        echo '<div class="logo">';
        echo '<a href="#" class="logo"><i class="fas fa-cat"></i>Paw Store</a>';
        echo '</div>';
        echo '<nav class="navbar" id="navbar">';
        echo '<a href="index.php" name="home">Home</a>';
        echo '<a href="login.php" name="Team">Log in</a>';
        echo '<a href="register.php" name="Team">Register</a>';
        echo '<a href="about.php" name="about-us">About</a>';
        echo '</nav>';
        echo '</header>';
    }
}

//site title
function showHeading()
{
    global $site_title;
    echo "<h1 id=\"titletext\" style=\"font-family: Arial, sans-serif; font-size: 36px; color: #FFFFFF; margin: auto; position: relative; top: 40px; right: 10px;\">$site_title</h1>";
}

//site footer
function showFooter()
{
    global $site_footer;
    echo "<p id=\"footertext\" style=\"font-family: Arial, sans-serif; font-size: 12px; color: #333333; position: relative; top: 10px;\">$site_footer</p>";
}

//validate user input against malicious code
function validateInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function sendConfirmEmail($email)
{
    $message = "Your order on Paw Store confirmed successfully. \n\n Thank you";
    $message = wordwrap($message, 70);
    $subject = "Order Confirmation";
    return mail($email, $subject, $message);
}

?>