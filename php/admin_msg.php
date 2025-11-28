<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $message = $_POST['message'];
    $stmt = $conn->prepare("INSERT INTO admin_message (username, email, department, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $department, $message );

    if ($stmt->execute()) {
        header("Location: ../index.html?message_sent=success");
    } else {
        header("location: ../index.html?message_sent=failed");
    }

    $stmt->close();
    $conn->close();
} else {
    header("location: ../index.html?message_sent=invalid_request");
}