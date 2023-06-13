<?php
require_once "User.php";
require_once "Ticket.php";

session_start();

$userIsLoggedIn = isset($_SESSION['user']);
$hostname = "localhost:3306";
$username = "root";
$password = "";
$database = "alajiradb";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

echo "<a href='index.php'>Home</a>";

if (!$userIsLoggedIn) {
    echo "<a href='login.php'>Login</a>";
    echo "<a href='register.php'>Register</a>";
} else {
    $user = $_SESSION['user'];
    echo "<a href='logout.php'>Logout</a>";
    echo "<br>";
    echo "<a href='add_ticket.php'>Add Ticket</a>";
}
