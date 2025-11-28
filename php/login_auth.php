<?php
include("db.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT `id`, `name`, `phone`, `email`, `role`, `dept_id` FROM `user` WHERE `email` = ? AND `password` = ? LIMIT 1");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['dept_id'] = $user['dept_id'];

            // Get department name for session
            $dept_stmt = $conn->prepare("SELECT `name` FROM `department` WHERE `id` = ?");
            $dept_stmt->bind_param("i", $user['dept_id']);
            $dept_stmt->execute();
            $dept_result = $dept_stmt->get_result();
            if ($dept_result->num_rows > 0) {
                $dept_row = $dept_result->fetch_assoc();
                $_SESSION['department'] = $dept_row['name'];
            }
            $dept_stmt->close();

            $stmt->close();

            if ($user['role'] == 'admin') {
                header("Location: ../adminDashboard.php");
                exit();
            } elseif ($user['role'] == 'user') {
                header("Location: ../dashboard.php?msg=success");
                exit();
            } else {
                header("Location: ../index.html?msg=unknown_role");
                exit();
            }

        } else {
            $stmt->close();
            header("Location: ../login.html?msg=invalid_credentials");
            exit();
        }

    } else {
        header("Location: ../login.html?msg=empty_fields");
        exit();
    }

} else {
    header("Location: ../login.html");
    exit();
}
?>
