<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $priority = Priority::from(intval($_POST['priority']));
    $department = Department::from(intval($_POST['department']));
    $assignee = $_POST['assignee'];
    $attachment = $_POST['attachment'];
    $deadline = DateTime::createFromFormat('Y-m-d', $_POST['deadline']);
    $ticket = new Ticket(getUserId($USER), $title, $priority, $department, $assignee, $attachment, $deadline);

    saveTicketToDb($ticket);
    header("Location: index.php");

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Ticket</title>
</head>
<body>
<h2>Add Ticket</h2>
<form action="edit_ticket.php" method="POST" enctype="multipart/form-data">
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
    <select id="assignee" name="assignee" required>
        <?php
        foreach (getAllUsernames() as $username) {
            echo "<option value='$username'>$username</option>";
        }
        ?>
    </select><br><br>

    <label for="attachment">Attachment:</label><br>
    <input type="string" id="attachment" name="attachment"><br><br>

    <label for="deadline">Deadline:</label><br>
    <input type="date" id="deadline" name="deadline" required><br><br>

    <input type="submit" value="Add Ticket">
</form>
</body>
</html>
