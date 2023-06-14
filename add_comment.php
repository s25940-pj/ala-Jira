<?php
include "header.php";

global $USER;

if (isset($_GET['ticket_id'])) {
    $ticketId = $_GET['ticket_id'];
    $ticketExists = checkTicketExists(intval($ticketId));

    if (!$ticketExists) {
        echo "Cannot add comment to non existing ticket.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $body = $_POST['body'];
        $comment = new Comment(getUserId($USER),$ticketId, $body);

        addCommentToDb($comment);
        header("Location: ticket_details.php?id=$ticketId");
    }
} else {
    echo "Cannot add comment to non existing ticket.";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Comment</title>
</head>
<body>
<h2>Add Comment</h2>
<?php
$ticketId = $_GET['ticket_id'];

echo "<form action='add_comment.php?ticket_id=$ticketId' method='POST' enctype='multipart/form-data'>"
?>
    <label for="body">Body:</label><br>
    <input type="text" id="body" name="body" required><br><br>

    <input type="submit" value="Add Comment">
</form>
</body>
</html>
