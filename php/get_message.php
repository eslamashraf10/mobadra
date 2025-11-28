<?php
include("db.php");

$sql100 = "SELECT * FROM admin_message";
$res = $conn->query($sql100);

if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
?>
            <div class="message-card">
                <div class="message-header">
                    <div>
                      <div class="message-name"><?= $row['username'] ?></div>
                      <div class="message-email"><?= $row['email'] ?></div>
                    </div>
                    <span class="message-dept"><?= $row['department'] ?></span>
                </div>
                <div class="message-text"><?= $row['message'] ?></div>
            </div>
<?php

    }
}
?>
