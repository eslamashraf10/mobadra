<?php
include("db.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newPassword = trim($_POST['newPassword']);
    $confirmPassword = trim($_POST['oldPassword']); // Note: 'oldPassword' is actually confirm password in the form

    if (!empty($newPassword) && !empty($confirmPassword)) {
        if ($newPassword !== $confirmPassword) {
            header("Location: ../newPassword.html?msg=password_mismatch");
            exit();
        }

        if (!isset($_SESSION['reset_email'])) {
            header("Location: ../forgetPassword.html?msg=session_expired");
            exit();
        }

        $email = $_SESSION['reset_email'];

        // Use prepared statement to update password
        $stmt = $conn->prepare("UPDATE `user` SET `password` = ? WHERE `email` = ?");
        $stmt->bind_param("ss", $newPassword, $email);
        $result = $stmt->execute();

        if ($result) {
            // Password updated successfully
            unset($_SESSION['reset_email']);
            $stmt->close();
            header("Location: ../login.html?msg=password_reset_success");
            exit();
        } else {
            $stmt->close();
            header("Location: ../newPassword.html?msg=update_failed");
            exit();
        }

    } else {
        header("Location: ../newPassword.html?msg=empty_fields");
        exit();
    }

} else {
    header("Location: ../newPassword.html");
    exit();
}
?>
