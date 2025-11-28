<?php
include("db.php");
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: index.html?msg=not_logged_in");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT * FROM `user` WHERE `id` = '$user_id' LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $_SESSION['user_id'] ;
    $user_name = $_SESSION['name'];
    $user_email = $_SESSION['email'];
    $user_phone = $_SESSION['phone'];
    $user_role = $_SESSION['role'];
    $department = $_SESSION['department'] ;
} else {

    header("Location: login.html?msg=user_not_found");
    exit();
}
?>
