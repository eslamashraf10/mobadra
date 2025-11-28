<?php
include("db.php");
header("Content-Type: application/json; charset=utf-8");

// action
$action = $_GET['action'] ?? '';

// ------------------ DELETE ------------------
if ($action === 'delete') {
    $id = intval($_GET['id'] ?? 0);
    $stmt = $conn->prepare("DELETE FROM user WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "msg" => $conn->error]);
    }
    exit;
}

// ------------------ UPDATE ------------------
if ($action === 'update') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        echo json_encode(["success" => false, "msg" => "Invalid input JSON"]);
        exit;
    }

    $id = intval($data['id'] ?? 0);
    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $department = $data['department'] ?? '';
    $role = $data['role'] ?? '';

    // تأكد من اسم القسم → id
    $stmtDept = $conn->prepare("SELECT id FROM department WHERE name=?");
    $stmtDept->bind_param("s", $department);
    $stmtDept->execute();
    $resDept = $stmtDept->get_result();
    $rowDept = $resDept->fetch_assoc();

    if (!$rowDept) {
        echo json_encode(["success" => false, "msg" => "Department not found"]);
        exit;
    }

    $dept_id = $rowDept['id'];

    $stmt = $conn->prepare("UPDATE user SET name=?, email=?, dept_id=?, role=? WHERE id=?");
    $stmt->bind_param("ssisi", $name, $email, $dept_id, $role, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "msg" => $conn->error]);
    }
    exit;
}

// fallback
echo json_encode(["success" => false, "msg" => "Invalid action"]);
?>
