<?php

include 'includes/header.php';
include('database_connection.php');
$user_id = $_SESSION['id'];

$statement = $connect->prepare("
        SELECT chat.id,
        accounts.username,
        chat.user_id,
        chat.message,
        chat.timestamp
        FROM chat
        JOIN accounts
        ON chat.user_id = accounts.id
        ORDER BY timestamp
    ");

$statement->execute();

$all_result = $statement->fetchAll();

$total_rows = $statement->rowCount();
if ($total_rows > 0) {
    foreach ($all_result as $row) {
        if ($row["user_id"] == $_SESSION['id']) {
            $class = "message me";
            $text = "text me";
        }else{
            $class = "message";
            $text = "text";
        }
        echo '
                    <div class="' . $class . '">';
                    if ($row["user_id"] != $_SESSION['id']) {
                        echo '<img class="avatar-md" src="img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="' . $row['username'] . '" alt="avatar">';
                    }
                        echo '
                        <div class="text-main">
                            <div class="' . $text . '">
                                <div class="">
                                    <p>' . $row['username']. '</p>
                                    <p>' . nl2br($row['message']) . '</p>
                                </div>
                            </div>
                            <span>' . date('g:i A', strtotime($row['timestamp'])) . '</span>
                        </div>
                    </div>
                    ';
    }
}
