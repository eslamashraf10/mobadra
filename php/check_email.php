<?php
include("db.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    if (!empty($email)) {
        // Use prepared statement to check if email exists
        $stmt = $conn->prepare("SELECT `id` FROM `user` WHERE `email` = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            // Email exists, store in session for password reset
            $_SESSION['reset_email'] = $email;
            $stmt->close();
            header("Location: ../newPassword.html");
            exit();
        } else {
            $stmt->close();
            header("Location: ../forgetPassword.html?msg=email_not_found");
            exit();
        }

    } else {
        header("Location: ../forgetPassword.html?msg=empty_email");
        exit();
    }

} else {
    header("Location: ../forgetPassword.html");
    exit();
}
?>
