<?php
include "header.php";

global $USER;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $newPassword = $_POST['new_password'];
    resetUserPassword(getUserId($USER), $newPassword);
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
<h2>Reset Password</h2>

<form method="post" action="reset_password.php">
    <div>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
    </div>
    <button type="submit" name="reset_password">Reset</button>
</form>
</body>
</html>
