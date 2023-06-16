<?php
require_once "User.php";
require_once "Ticket.php";
require_once "Comment.php";

include "enum_utils.php";
include "ticket_utils.php";
include "comment_utils.php";
include "user_utils.php";

session_start();

$USER_IS_LOGGED_IN = isset($_SESSION['user']);
$hostname = "localhost:3306";
$username = "root";
$password = "";
$database = "alajiradb";

$CONN = new mysqli($hostname, $username, $password, $database);

if ($CONN->connect_error) {
    die("Connection error: " . $CONN->connect_error);
}

echo "<a href='index.php'>Home</a>";

if (!$USER_IS_LOGGED_IN) {
    echo "<a href='login.php'>Login</a>";
    echo "<a href='register.php'>Register</a>";
} else {
    $USER = $_SESSION['user'];
    echo "<a href='logout.php'>Logout</a>";
    echo "<a href='reset_password.php'>Reset Password</a>";
    echo "<br>";
    echo "<a href='add_ticket.php'>Add Ticket</a>";
    echo "<p><strong>User: </strong>" . $USER->getUsername() .  "</p>";
    echo "<p><strong>Role: </strong>" . getRoleName($USER->getRole()->value) .  "</p>";
}
