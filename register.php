<?php
include "header.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $userExists = checkUserExistsByUsername($username, $email);

    if ($userExists) {
        echo "<p>User with the provided username or email already exists.</p>";
        echo "<p>Please provide a different username or email.</p>";
    } else {
        $role = "";
        $allUsernames = getAllUsernames();
        $userIsFirst = !(sizeof($allUsernames) > 0);

        if ($userIsFirst) {
            $role = Role::ADMIN;
        }
        else {
            $role = Role::USER;
        }

        $user = new User($username, $email, $password, $name, $surname, $role, Department::BASIC);

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

