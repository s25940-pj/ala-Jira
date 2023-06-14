<?php
function getTicketCreatorUsername(int $ticketId) : string
{
    global $CONN;

    $query = "SELECT * FROM User WHERE id = $ticketId";
    $result = $CONN->query($query);
    $userData = $result->fetch_assoc();

    return $userData['username'];
}

function checkTicketIsClosed(int $intValue) : bool
{
    return (bool)$intValue;
}

function setTicketDateClosed($ticketId): void
{
    global $CONN;

    $dateClosed = new DateTime();
    $dateClosedAsStr = $dateClosed->format('Y-m-d H:i:s');
    $query = "UPDATE Ticket SET date_closed = '$dateClosedAsStr' WHERE id = $ticketId";
    $CONN->query($query);
}

function markTicketAsClosed(int $ticketId) : void
{
    global $CONN;

    $query = "UPDATE Ticket SET is_closed = 1 WHERE id = $ticketId";
    $CONN->query($query);
    setTicketDateClosed($ticketId);
}

function saveTicketToDb(Ticket $ticket): void
{
    global $CONN;

    $query = "INSERT INTO Ticket (user_id, title, priority, department, assignee, attachment, date_added, deadline, is_closed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($CONN, $query);
    $userId = $ticket->getUserId();
    $title = $ticket->getTitle();
    $priority = $ticket->getPriority()->value;
    $department = $ticket->getDepartment()->value;
    $assignee = $ticket->getAssignee();
    $attachment = $ticket->getAttachment();
    $dateAdded = $ticket->getDateAdded()->format('Y-m-d');
    $deadline = $ticket->getDeadline()->format('Y-m-d');
    $isClosed = 0;

    mysqli_stmt_bind_param(
        $stmt,
        "isiissssi",
        $userId,
        $title,
        $priority,
        $department,
        $assignee,
        $attachment,
        $dateAdded,
        $deadline,
        $isClosed
    );
    mysqli_stmt_execute($stmt);

    if (!(mysqli_stmt_affected_rows($stmt) > 0)) {
        error_log("Error creating ticketData: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
}

function checkTicketExists(int $ticketId) : bool
{
    global $CONN;

    $query = "SELECT * FROM Ticket WHERE id = $ticketId";
    $result = $CONN->query($query);

    return $result->num_rows > 0;
}