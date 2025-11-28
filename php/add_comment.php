<?php
include("db.php");

if (isset($_POST["solve"])) {
  $solve = $_POST["solve"];
  $user_id = $_POST["user_id"];
  $ticket_id = $_POST["ticket_id"];

  // 1) UPDATE status → in_progress
  $update = $conn->prepare("UPDATE tickets SET status = 'In Progress' WHERE id = ?");
  $update->bind_param("i", $ticket_id);
  $update->execute();

  // 2) Insert comment
  $stmt = $conn->prepare("INSERT INTO `comments`(`ticket_id`, `user_id`, `text`) VALUES (?, ?, ?)");
  $stmt->bind_param("iis", $ticket_id, $user_id, $solve );

  if ($stmt->execute()) {
    header("location: ../dashboard.php");
    exit;
  } else {
    echo "Error: " . $stmt->error;
  }
}
