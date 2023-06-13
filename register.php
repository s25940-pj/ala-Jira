<?php
include "header.php";

function checkUserExists($username, $email): bool
{
    global $conn;

    $query = "SELECT * FROM User WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($query);

    return $result->num_rows > 0;
}

function saveUserToDb(User $user): void
{
    global $conn;

    $query = "INSERT INTO User (username, email, `password`, `name`, surname) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    $username = $user->getUsername();
    $email = $user->getEmail();
    $password = $user->getPassword();
    $name = $user->getName();
    $surname = $user->getSurname();

    mysqli_stmt_bind_param(
            $stmt,
            "sssss",
            $username,
            $email,
            $password,
            $name,
            $surname
    );
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION['user'] = $user;
    } else {
        error_log("Error creating user: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $userExists = checkUserExists($username, $email);

    if ($userExists) {
        echo "<p>User with the provided username or email already exists.</p>";
        echo "<p>Please provide a different username or email.</p>";
    } else {
        $user = new User($username, $email, $password, $name, $surname);

        saveUserToDb($user);
        header("Location: index.php");
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h2>Registration Form</h2>
<form method="post" action="register.php">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <label for="name">Name:</label>
    <input type="text" name="name" required><br>

    <label for="surname">Surname:</label>
    <input type="text" name="surname" required><br>

    <input type="submit" value="Register">
</form>
</body>
</html>

