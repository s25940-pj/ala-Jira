<?php
include "header.php";



global $CONN;
global $USER;
global $USER_IS_LOGGED_IN;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clear_all_filters'])) {
        $query = "SELECT * FROM Ticket";
    }
    else if (isset($_POST['view_user_assigned'])) {
        $username = getUsernameById(getUserId($USER));
        $query = "SELECT * FROM Ticket WHERE assignee = '$username'";
        echo "<p>KUTAS</p>";
    }
    else {
        $priority = intval($_POST['priority']);
        $department = intval($_POST['department']);
        $userId = getUserIdByUsername($_POST['created_by']);
        $deadline = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['deadline'])->format('Y-m-d');
        $query = "SELECT * FROM Ticket WHERE department = '$department' AND priority = '$priority' AND user_id = $userId AND deadline = '$deadline'";
    }
}
else {
    $query = "SELECT * FROM Ticket";
}

if ($USER_IS_LOGGED_IN && getRoleName($USER->getRole()->value) == "Admin") {
    echo "<a href='admin_panel.php'>Admin Panel</a>";
}

?>

<h1>
    Tickets
</h1>

<form action="index.php" method="POST" enctype="multipart/form-data">
    <label for="created_by">Created by:</label><br>
    <select id="created_by" name="created_by" required>
        <?php
        foreach (getAllUsernames() as $username) {
            echo "<option value='$username'>$username</option>";
        }
        ?>
    </select><br><br>

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

    <label for="deadline">Deadline:</label><br>
    <input type="datetime-local" id="deadline" name="deadline" required><br><br>

    <input type="submit" value="Filter">
</form>

<form method="post" action="index.php">
    <p>Click the button below to view your assigned tickets:</p>
    <button type="submit" name="view_user_assigned" value="1">View Assigned Tickets</button>
</form>

<form method="post" action="index.php">
    <p>Click the button below to clear all filters:</p>
    <button type="submit" name="clear_all_filters" value="1">Clear</button>
</form>


<table style="text-align: left; border-spacing: 10px">

    <?php
    $tickets = $CONN->query($query);

    if ($tickets->num_rows > 0) {
        $rowNum = 0;

        echo "<tr><th></th><th>Title</th><th>Department</th></tr>";

        while ($row = $tickets->fetch_assoc()) {
            $ticketDepartment = getDepartmentName($row["department"]);
            $rowNum++;
            echo "<tr>";
            echo "<td><a href='ticket_details.php?id=". $row['id'] ."'>" . $rowNum . "</a></td>" .
                "<td>" . $row["title"] . "</td>" .
                "<td>" . $ticketDepartment . "</td>";

            if ($USER_IS_LOGGED_IN) {
                $userRole = getRoleName($USER->getRole()->value);
                $userDepartment = getDepartmentName($USER->getDepartment()->value);

                if ($userRole == "Admin" || ($userRole == "Head of Department" && $userDepartment == $ticketDepartment)) {
                    echo "<td><a href='delete_ticket.php?ticket_id=" . $row['id'] . "'>Delete</a></td>";
                }
            }

            echo "</tr>";
        }
    }
    else {
        echo "<h3>No data available.</h3>";
    }

    ?>
</table>
