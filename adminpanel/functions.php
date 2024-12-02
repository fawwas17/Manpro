<?php
function validateInput($data) {
    global $mysqli;
    return htmlspecialchars(mysqli_real_escape_string($mysqli, trim($data)));
}
?>
