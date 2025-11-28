<?php
$stmnt="SELECT 
        tickets.title , 
        tickets.desc , 
        tickets.priority , 
        tickets.dept_id , 
        department.name ,
        tickets.status , 
        tickets.created_at 
    FROM tickets  
    JOIN department 
        ON tickets.dept_id = department.id
        WHERE   user_id  = $user_id 
    ORDER BY tickets.created_at DESC
";
$res = $conn->query($stmnt);
while ($row = $res->fetch_assoc()) {
?>  
                <li>
                    <span class="title"><?= $row["title"] ?></span>
                    <span class="meta">
                        <span class="time"><?= $row["created_at"] ?></span>
                        <?php if ($row["status"] == "Pending") {?>
                            <span class="badge warning"><?= $row["status"] ?></span>
                        <?php } elseif ($row["status"] == "Resolved") {?>
                            <span class="badge success"><?= $row["status"] ?></span>
                        <?php } elseif ($row["status"] == "In Progress") {?>
                            <span class="badge info"><?= $row["status"] ?></span>
                        <?php } elseif ($row["status"] == "canceled") {?>
                            <span class="badge warning" style="background-color: red;"><?= $row["status"] ?></span>
                        <?php } ?>
                    </span>
                </li>
                    
    <?php
}
?>