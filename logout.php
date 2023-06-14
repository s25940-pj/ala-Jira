<?php
include "header.php";

global $USER_IS_LOGGED_IN;

if ($USER_IS_LOGGED_IN) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_logout'])) {
        session_unset();
        session_destroy();

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
</head>
<body>
<h2>Logout</h2>
<form method="post" action="logout.php">
    <p>Click the button below to log out:</p>
    <p>Are you sure you want to log out?</p>
    <button type="submit" name="confirm_logout" value="1">Log Out</button>
</form>
</body>
</html>