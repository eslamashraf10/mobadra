<?php
include("get_user_info.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Title = trim($_POST['Title']);
    $Description = trim($_POST['Description']);
    $Priority = trim($_POST['Priority']);
    $department = trim($_POST['department']);

    if (!empty($Title) && !empty($Description) && !empty($Priority) && !empty($department)) {

        // --- Get Department ----
        $dept_stmt = $conn->prepare("SELECT `id`, `name` FROM `department` WHERE `name` = ?");
        $dept_stmt->bind_param("s", $department);
        $dept_stmt->execute();
        $dept_result = $dept_stmt->get_result();

        if ($dept_result->num_rows == 0) {
            header("Location: ../dashboard.php?msg=invalid_department");
            exit();
        }

        $dept_row = $dept_result->fetch_assoc();
        $department_id = $dept_row['id'];
        $dept_stmt->close();

        // --- Insert Ticket ---
        $insert_stmt = $conn->prepare("INSERT INTO `tickets`(`title`, `desc`, `priority`, `user_id`, `dept_id`) VALUES (?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("sssii", $Title, $Description, $Priority, $user_id, $department_id);

        if ($insert_stmt->execute()) {

            // Get last inserted ticket id
            $ticket_id = $insert_stmt->insert_id;
            $insert_stmt->close();

            // =============================
            //   FILE UPLOAD (if available)
            // =============================
            if (!empty($_FILES['file']['name'])) {

                $filename = $_FILES['file']['name'];
                $tmp = $_FILES['file']['tmp_name'];

                // create uploads folder if not exists
                $upload_dir = "../uploads/";
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $target_path = $upload_dir . basename($filename);

                // Move uploaded file
                if (move_uploaded_file($tmp, $target_path)) {
                    $target = "uploads/" . basename($filename);
                    // save file info in ticketattachments
                    $att_stmt = $conn->prepare("
                        INSERT INTO `ticketattachments`(`ticket_id`, `user_id`, `filename`, `file_path`)
                        VALUES (?, ?, ?, ?)
                    ");
                    $att_stmt->bind_param("iiss", $ticket_id, $user_id, $filename, $target);
                    $att_stmt->execute();
                    $att_stmt->close();
                }
            }

            header("Location: ../dashboard.php?msg=success");
            exit();

        } else {
            header("Location: ../dashboard.php?msg=error");
            exit();
        }

    } else {
        header("Location: ../dashboard.php?msg=empty_fields");
        exit();
    }
} else {
    header("Location: ../index.html");
    exit();
}
?>
