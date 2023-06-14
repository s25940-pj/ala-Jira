<?php

function getAllCommentsForTicket(int $ticketId): mysqli_result|bool
{
    global $CONN;

    $query = "SELECT * FROM Comment WHERE ticket_id = $ticketId";

    return $CONN->query($query);
}

function addCommentToDb(Comment $comment) : void
{
    global $CONN;

    $query = "INSERT INTO Comment (user_id, ticket_id, body) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($CONN, $query);
    $userId = $comment->getUserId();
    $ticketId = $comment->getTicketId();
    $body = $comment->getBody();

    mysqli_stmt_bind_param(
        $stmt,
        "iis",
        $userId,
        $ticketId,
        $body,
    );
    mysqli_stmt_execute($stmt);

    if (!(mysqli_stmt_affected_rows($stmt) > 0)) {
        error_log("Error creating comment: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
}