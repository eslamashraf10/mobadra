<?php
$stmnt = "
    SELECT 
        tickets.id,
        tickets.title,
        tickets.`desc`,
        tickets.priority,
        tickets.dept_id,
        department.name,
        tickets.created_at
    FROM tickets
    JOIN department 
        ON tickets.dept_id = department.id
    WHERE tickets.user_id != $user_id 
      AND tickets.status IN ('Pending', 'In Progress')
";

$res = $conn->query($stmnt);

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {

        $modalId = "allissueDetailsModal_" . $row["id"]; // UNIQUE MODAL ID

        $ticket_id = $row["id"];

        // Fetch attachment for this ticket
        $att_q = $conn->query("SELECT * FROM ticketattachments WHERE ticket_id = $ticket_id LIMIT 1");
        $attachment = $att_q->fetch_assoc();


?>
  <div class="col-12 col-md-6 col-lg-4 mb-4">
    <div class="card">
      <img src="Images/9318694.jpg" class="card-img-top" alt="...">
      
      <div class="department"><?= $row["name"] ?></div>
      
      <div class="card-body">
        <h5 class="card-title"><?= $row["title"] ?></h5>
        <p class="card-text"><?= $row["desc"] ?></p>

        <!-- FORM START -->
        <form action="php/add_comment.php" method="post">
          <input type="hidden" name="user_id" value="<?= $user_id ?>">
          <input type="hidden" name="ticket_id" value="<?= $row["id"] ?>">

          <textarea 
            class="form-control mb-2" 
            name="solve" 
            placeholder="Enter the solution to the issue"
            required
          ></textarea>

          <div class="card-buttons mt-2">

            <!-- DETAILS BUTTON -->
            <a 
              href="#" 
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#<?= $modalId ?>"
            >
              Details
            </a>

            <button type="submit" class="btn solveBtn btn-success">
              <i class="fa-solid fa-check"></i> Solve
            </button>
          </div>
        </form>
        <!-- FORM END -->

      </div>
    </div>
  </div>

  <!-- UNIQUE DETAILS MODAL -->
<div class="modal fade" id="<?= $modalId ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Issue Details #<?= $row["id"] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p><strong>Issue Title:</strong> <?= $row["title"] ?></p>
        <p><strong>Description:</strong> <?= $row["desc"] ?></p>
        <p><strong>Department:</strong> <?= $row["name"] ?></p>
        <p><strong>Priority:</strong> <?= $row["priority"] ?></p>

        <p><strong>Attachment:</strong>
          <?php if ($attachment) { ?>
              <a href="<?= $attachment['file_path'] ?>" target="_blank">
                <?= $attachment['filename'] ?>
              </a>
          <?php } else { ?>
              <span>No attachment</span>
          <?php } ?>
        </p>

        <form action="php/add_comment.php" method="post">
          
          <!-- important hidden values -->
          <input type="hidden" name="user_id" value="<?= $user_id ?>">
          <input type="hidden" name="ticket_id" value="<?= $row["id"] ?>">
          <input type="hidden" name="solve" value="1"> 

          <textarea 
            class="form-control mt-2"
            name="solve"
            placeholder="Enter the solution to the issue"
            required
          ></textarea>

          <div class="modal-footer mt-3">
            <button type="submit" class="btn btn-success">
              <i class="fa-solid fa-check"></i> Solve
            </button>
          </div>

        </form>

      </div>

    </div>
  </div>
</div>


<?php
    }
} else {
    echo "<p>No pending tickets found.</p>";
}
?>
