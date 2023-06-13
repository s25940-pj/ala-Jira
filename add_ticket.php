<?php
include "header.php";

global $user;

function getUserId(User $user) : int
{
    global $conn;

    $username = $user->getUsername();
    $query = "SELECT * FROM User WHERE username = '$username'";
    $userData = $conn->query($query)->fetch_assoc();

    return $userData['id'];
}

function saveTicketToDb(Ticket $ticket): void
{
    global $conn;

    $query = "INSERT INTO Ticket (user_id, title, priority, department, assignee, attachment, date_added, deadline) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    $userId = $ticket->getUserId();
    $title = $ticket->getTitle();
    $priority = $ticket->getPriority()->value;
    $department = $ticket->getDepartment()->value;
    $assignee = $ticket->getAssignee();
    $attachment = $ticket->getAttachment();
    $dateAdded = $ticket->getDateAdded()->format('Y-m-d H:i:s');
    $deadline = $ticket->getDeadline()->format('Y-m-d H:i:s');

    mysqli_stmt_bind_param(
        $stmt,
        "isiissss",
        $userId,
        $title,
        $priority,
        $department,
        $assignee,
        $attachment,
        $dateAdded,
        $deadline
    );
    mysqli_stmt_execute($stmt);

    if (!(mysqli_stmt_affected_rows($stmt) > 0)) {
        error_log("Error creating ticket: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $priority = Priority::from(intval($_POST['priority']));
    $department = Department::from(intval($_POST['department']));
    $assignee = $_POST['assignee'];
    $attachment = $_POST['attachment'];
    $deadline = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['deadline']);

    $ticket = new Ticket(getUserId($user), $title, $priority, $department, $assignee, $attachment, $deadline);

    saveTicketToDb($ticket);
    header("Location: index.php");

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Ticket</title>
</head>
<body>
<h2>Add Ticket</h2>
<form action="add_ticket.php" method="POST" enctype="multipart/form-data">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="priority">Priority:</label><br>
    <select id="priority" name="priority" required>
        <option value="0">Low</option>
        <option value="1">Medium</option>
        <option value="2">High</option>
    </select><br><br>

    <label for="department">Department:</label><br>
    <select id="department" name="department" required>
        <option value="0">Development</option>
        <option value="1">Marketing</option>
        <option value="2">Finance</option>
    </select><br><br>

    <label for="assignee">Assignee:</label><br>
    <input type="text" id="assignee" name="assignee" required><br><br>

    <label for="attachment">Attachment:</label><br>
    <input type="string" id="attachment" name="attachment"><br><br>

    <label for="deadline">Deadline:</label><br>
    <input type="datetime-local" id="deadline" name="deadline" required><br><br>

    <input type="submit" value="Add Ticket">
</form>
</body>
</html>

