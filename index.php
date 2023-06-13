<?php
include "header.php";

global $conn;

function getDepartmentName(int $departmentValue): string
{
    return match ($departmentValue) {
        0 => "Development",
        1 => "Marketing",
        2 => "Finance",
        default => "None",
    };
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $department = intval($_POST['department']);
    $query = "SELECT * FROM Ticket WHERE department = '$department'";
}
else {
    $query = "SELECT * FROM Ticket";
}

?>

<h1>
    Tickets
</h1>

<form action="index.php" method="POST" enctype="multipart/form-data">
    <label for="department">Department:</label><br>
    <select id="department" name="department" required>
        <option value="0">Development</option>
        <option value="1">Marketing</option>
        <option value="2">Finance</option>
    </select><br><br>

    <input type="submit" value="Filter">
</form>

<table style="text-align: left; border-spacing: 10px">

    <?php
    $tickets = $conn->query($query);
    $rowNum = 0;

    if ($tickets->num_rows > 0) {
        echo "<tr><th></th><th>Title</th><th>Department</th></tr>";

        while ($row = $tickets->fetch_assoc()) {
            $rowNum++;
            echo "<tr>";
            echo "<td><a href='ticket_details.php?id=".$row['id']."'>" . $rowNum . "</a></td>" .
                "<td>" . $row["title"] . "</td>" .
                "<td>" . getDepartmentName($row["department"]) . "</td>";
            echo "</tr>";
        }
    }
    else {
        echo "<h3>No data available...</h3>";
    }

    ?>
</table>
