<?php
include "header.php";

function checkUserExists($username): bool
{
    global $conn;

    $query = "SELECT * FROM User WHERE username = '$username'";
    $matchingUsers = $conn->query($query);

    return $matchingUsers->num_rows > 0;
}

function validateUser($username, $password): bool
{
    global $conn;

    $query = "SELECT * FROM User WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    return $result->num_rows > 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userExists = checkUserExists($username);

    if (!$userExists) {
        header("Location: register.php");
        exit;
    }

    $userIsValid = validateUser($username, $password);

    if ($userIsValid) {
        $query = "SELECT * FROM User WHERE username = '$username' AND password = '$password'";
        $userData = $conn->query($query)->fetch_assoc();
        $user = new User($userData['username'], $userData['email'], $userData['password'], $userData['name'], $userData['surname']);
        $_SESSION['user'] = $user;

        header("Location: index.php");
        exit;
    } else {
        echo "<p>Invalid username or password. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>

<form method="post" action="login.php">
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" name="login">Log In</button>
</form>
</body>
</html>
