<?php
include("db.php");

header('Content-Type: application/json; charset=utf-8');

$sql = "SELECT 
    user.id,
    user.name,
    user.email,
    user.phone,
    user.role,
    department.name AS department_name
FROM user
JOIN department 
    ON user.dept_id = department.id;
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => $conn->error], JSON_UNESCAPED_UNICODE);
    exit;
}

$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'email' => $row['email'],
        'phone' => $row['phone'],
        'department' => $row['department_name'],
        'role' => $row['role']
    ];
}

echo json_encode($users, JSON_UNESCAPED_UNICODE);
?>
