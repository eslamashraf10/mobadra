<?php
include("db.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $department = trim($_POST['department']);
    $role = 'user';

    if (!empty($name) && !empty($email) && !empty($phone) && !empty($password) && !empty($department)) {
        // Get department_id and name from department table
        $dept_stmt = $conn->prepare("SELECT `id`, `name` FROM `department` WHERE `name` = ?");
        $dept_stmt->bind_param("s", $department);
        $dept_stmt->execute();
        $dept_result = $dept_stmt->get_result();

        if ($dept_result->num_rows == 0) {
            $dept_stmt->close();
            header("Location: ../register.html?msg=invalid_department");
            exit();
        }
        $dept_row = $dept_result->fetch_assoc();
        $department_id = $dept_row['id'];
        $department_name = $dept_row['name'];
        $dept_stmt->close();

        // Check if email already exists
        $check_stmt = $conn->prepare("SELECT id FROM `user` WHERE `email` = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $check_stmt->close();
            header("Location: ../register.html?msg=email_exists");
            exit();
        }
        $check_stmt->close();

        // Insert new user
        $insert_stmt = $conn->prepare("INSERT INTO `user` (`name`, `phone`, `email`, `password`, `role`, `dept_id`) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("sssssi", $name, $phone, $email, $password, $role, $department_id);

        if ($insert_stmt->execute()) {
            $user_id = $conn->insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['role'] = $role;
            $_SESSION['department'] = $department;

            $insert_stmt->close();
            header("Location: ../index.html?msg=success");
            exit();
        } else {
            $insert_stmt->close();
            header("Location: ../register.html?msg=error");
            exit();
        }
    } else {
        header("Location: ../register.html?msg=empty_fields");
        exit();
    }
} else {
    header("Location: ../index.html");
    exit();
}
?>
