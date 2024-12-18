<?php
include "core.php";
include "koneksi.php";

if (!isset($_SESSION['uid'])) {
	header("Location: index.php");
	exit;
}

// Fetch user details (assuming user ID is passed via GET)
$uid = $_SESSION['uid'];

$sql = "SELECT * FROM user WHERE uid = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found");
}

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Paw Store</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/index.css">
  <script src="js/myscript.js" language="javascript" type="text/javascript"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size:14px;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .details {
            margin-top: 20px;
        }
        .details div {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="navigation">
        <?php mainMenu(); ?>
    </div>

    <div class="container">
        <h1>User Profile</h1>
        <div class="details">
            <div><span class="label">Username:</span> <?php echo htmlspecialchars($user['username']); ?></div>
            <div><span class="label">Address:</span> <?php echo htmlspecialchars($user['address']); ?></div>
            <div><span class="label">Email:</span> <?php echo htmlspecialchars($user['email']); ?></div>
            <div><span class="label">Date of Birth:</span> <?php echo htmlspecialchars($user['date_of_birth']); ?></div>
            <div><span class="label">Gender:</span> <?php echo htmlspecialchars($user['gender']); ?></div>
            <div><span class="label">City:</span> <?php echo htmlspecialchars($user['city']); ?></div>
            <div><span class="label">Contact No:</span> <?php echo htmlspecialchars($user['contact_no']); ?></div>
        </div>
    </div>
</body>
</html>
