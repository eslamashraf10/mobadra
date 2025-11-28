<?php
$stmnt = "
SELECT 
    feedback.id AS feedback_id,
    feedback.ticket_id,
    feedback.satisfied,
    feedback.from_user,
    feedback.created_at AS feedback_date,

    tickets.title,
    tickets.desc,
    tickets.priority,
    tickets.dept_id,
    tickets.status,
    tickets.created_at AS ticket_date

FROM feedback
LEFT JOIN tickets ON feedback.ticket_id = tickets.id
WHERE from_user = $user_id
ORDER BY feedback.created_at DESC
";

$res = $conn->query($stmnt);
while ($row = $res->fetch_assoc()) {
?>  
                <li>
                    <span class="title"><?= $row["title"] ?></span>
                </li>
                    
    <?php
}
?>