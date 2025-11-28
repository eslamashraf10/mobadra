<?php
include("db.php");

if (isset($_POST["reciever_id"])) {

    $sender   = $_POST["sender_id"];
    $reciever = $_POST["reciever_id"];
    $ticket   = $_POST["ticket_id"];
    $text     = $_POST["text"];

    $sql = "INSERT INTO `replay`(`sender`, `reciever`, `ticket_id`, `text`) 
            VALUES ('$sender', '$reciever', '$ticket', '$text')";

    if ($conn->query($sql)) {
        header("location: ../dashboard.php?msg=success");
    } else {
        header("location: ../dashboard.php?msg=error");
    }
}

if (isset($_POST["from_user"])) {

    $user_id   = $_POST["user_id"];
    $from_user = $_POST["from_user"];
    $ticket    = $_POST["ticket_id"];

    $sql = "INSERT INTO `feedback`(`ticket_id`, `user_id`, `satisfied`, `from_user`) 
            VALUES ('$ticket', '$user_id', '1', '$from_user')";

    

    if ($conn->query($sql)) {
        $sql2 = "UPDATE `tickets` SET `status`='Resolved' WHERE id= $ticket ";
        $result2 = $conn->query($sql2);
        if ($result2) {
            header("location: ../dashboard.php?msg=success");
        } else {
            header("location: ../dashboard.php?msg=error");
        }
    } else {
        header("location: ../dashboard.php?msg=error");
    }
}


if(isset($_POST["user_id"])){
    $user = $_POST["user_id"];
    $ticket = $_POST["ticket_id"];

    $sql2 = "UPDATE `tickets` SET `status`='Resolved' WHERE id= $ticket ";
    $result2 = $conn->query($sql2);
    if ($result2) {
        header("location: ../dashboard.php?msg=success");
    } else {
        header("location: ../dashboard.php?msg=error");
    }
}
