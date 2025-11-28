<?php
include("db.php");


if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "UPDATE `tickets` SET `status`='canceled' WHERE id= $id ";
    $result = $conn->query($sql);
    if ($result) {
        header("location: ../dashboard.php?msg=success");
    } else {
        header("location: ../dashboard.php?msg=failed");
    }
    
}

else {
    header("location: ../dashboard.php?msg=failed");
}