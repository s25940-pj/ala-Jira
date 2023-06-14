<?php
function getUserId(User $user) : int
{
    global $CONN;

    $username = $user->getUsername();
    $query = "SELECT * FROM User WHERE username = '$username'";
    $userData = $CONN->query($query)->fetch_assoc();

    return $userData['id'];
}

function getUserIdByUsername(string $username) : int
{
    global $CONN;

    $query = "SELECT * FROM User WHERE username = '$username'";
    $userData = $CONN->query($query)->fetch_assoc();

    return $userData['id'];
}

function getAllUsernames(): array
{
    global $CONN;

    $query = "SELECT * FROM User";
    $users = $CONN->query($query);
    $usernames = [];

    while ($user = $users->fetch_assoc()) {
        $usernames[] = $user['username'];
    }

    return $usernames;
}

function getUsernameById($userId) : string
{
    global $CONN;

    $query = "SELECT * FROM User WHERE id = $userId";
    $userData = $CONN->query($query)->fetch_assoc();

    return $userData["username"];
}

function saveUserToDb(User $user): void
{
    global $CONN;

    $query = "INSERT INTO User (username, email, `password`, `name`, surname, `role`, department) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($CONN, $query);
    $username = $user->getUsername();
    $email = $user->getEmail();
    $password = $user->getPassword();
    $name = $user->getName();
    $surname = $user->getSurname();
    $role = $user->getRole()->value;
    $department = $user->getDepartment()->value;

    mysqli_stmt_bind_param(
        $stmt,
        "sssssii",
        $username,
        $email,
        $password,
        $name,
        $surname,
        $role,
        $department
    );
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION['user'] = $user;
    } else {
        error_log("Error creating user: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
}

function checkUserExists(string $username, string $email): bool
{
    global $CONN;

    $query = "SELECT * FROM User WHERE username = '$username' OR email = '$email'";
    $result = $CONN->query($query);

    return $result->num_rows > 0;
}

function validateUser($username, $password): bool
{
    global $CONN;

    $query = "SELECT * FROM User WHERE username = '$username' AND password = '$password'";
    $result = $CONN->query($query);

    return $result->num_rows > 0;
}

function checkUserExistsByUsername(string $username): bool
{
    global $CONN;

    $query = "SELECT * FROM User WHERE username = '$username'";
    $matchingUsers = $CONN->query($query);

    return $matchingUsers->num_rows > 0;
}