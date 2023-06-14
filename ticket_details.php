<?php
include "header.php";
?>

<h1>
    Ticket Details
</h1>

<?php
global $CONN;
global $USER;
global $USER_IS_LOGGED_IN;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        markTicketAsClosed($id);
    }

    $query = "SELECT * FROM Ticket WHERE id = $id";
    $ticket = $CONN->query($query);

    if ($ticket->num_rows > 0) {
        $ticketData = $ticket->fetch_assoc();
        echo "<strong>Created by: </strong>" . getTicketCreatorUsername($ticketData['user_id']) . "<br>";
        echo "<strong>Title: </strong>" . $ticketData['title'] . "<br>";
        echo "<strong>Priority: </strong>" . getPriorityName($ticketData['priority']) . "<br>";
        echo "<strong>Department: </strong>" . getDepartmentName($ticketData['department']) . "<br>";
        echo "<strong>Assignee: </strong>" . $ticketData['assignee'] . "<br>";
        echo "<strong>Attachment: </strong>" . $ticketData['attachment'] . "<br>";
        echo "<strong>Date added: </strong>" . $ticketData['date_added'] . "<br>";

        $ticketIsClosed = checkTicketIsClosed($ticketData['is_closed']);

        if ($ticketIsClosed) {
            echo "<strong>Date closed: </strong>" . $ticketData['date_closed'] . "<br>";
        }

        echo "<strong>Deadline: </strong>" . $ticketData['deadline'] . "<br>";

        if (!$ticketIsClosed && $USER->getUsername() === $ticketData['assignee']) {
            echo "
                <form method='post' action='ticket_details.php?id=$id'>
                    <button type='submit' name='mark_as_complete' value='1'>Mark as Closed</button>
                </form>
            ";
        }

        if ($USER_IS_LOGGED_IN && !$ticketIsClosed) {
            echo "<a href='add_comment.php?ticket_id=$id'>Add Comment</a>";
        }

        echo "
            <h1>
                Comments
            </h1>
        ";

        $comments = getAllCommentsForTicket($id);

        if ($comments->num_rows > 0) {
            $rowNum = 0;

            while ($comment = $comments->fetch_assoc()) {
                $rowNum++;
                echo "<strong>Created by: </strong><br>";
                echo getUsernameById($comment['user_id']);
                echo "<br>";
                echo "<p>" . $comment['body'] . "</p><br>";
            }
        }

    } else {
        echo "No ticket data info available.";
    }
} else {
    echo "Ticket does not exist.";
}


