<?php
$stmnt = "SELECT 
    tickets.id,
    tickets.title,
    tickets.`desc`,
    tickets.priority,
    tickets.dept_id,
    department.name,
    tickets.created_at  
FROM tickets  
JOIN department ON tickets.dept_id = department.id
WHERE tickets.user_id = ? 
  AND tickets.status IN ('Pending', 'In Progress')";

$stmt = $conn->prepare($stmnt);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
    $modalId        = "myIssueDetailsModal_" . $row["id"];
    $respondModalId = "respondToIssueModal_" . $row["id"]; // ← مهم جدًا: فريد لكل تذكرة
?>

<!-- Card (نفس الشكل القديم بالظبط) -->
<div class="col-12 col-md-6 col-lg-4 mb-4">
  <div class="card">
    <img src="Images/9318694.jpg" class="card-img-top" alt="...">
    <a href="php/cancel.php?id=<?= $row["id"] ?>">
      <div class="cancelBtn"><i class="fa-solid fa-xmark"></i></div>
    </a>
    <div class="card-body">
      <h5 class="card-title"><?= htmlspecialchars($row["title"]) ?></h5>
      <span class="badge statusBadge warning">Open</span>
      <p class="card-text"><?= htmlspecialchars($row["desc"]) ?></p>
      <div class="card-buttons">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">Details</a>
        
        <!-- زر Respond بيفتح المودال الخاص بالتذكرة دي فقط -->
        <a href="#" 
           class="btn btn-primary respondBtn" 
           data-bs-toggle="modal" 
           data-bs-target="#<?= $respondModalId ?>" 
           data-issue-id="<?= $row["id"] ?>">
           Respond
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Details Modal (نفس الشكل القديم) -->
<?php
$ticket_id = $row["id"];
$att_q = $conn->query("SELECT * FROM ticketattachments WHERE ticket_id = $ticket_id LIMIT 1");
$attachment = $att_q->fetch_assoc();
?>

<div class="modal fade" id="<?= $modalId ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">My Issue Details #<?= $row["id"] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p><strong>Issue Title:</strong> <?= htmlspecialchars($row["title"]) ?></p>
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row["desc"])) ?></p>
        <p><strong>Department:</strong> <?= htmlspecialchars($row["name"]) ?></p>
        <p><strong>Priority:</strong> <?= ucfirst($row["priority"]) ?></p>

        <p><strong>Attachment:</strong>
          <?php if ($attachment) { ?>
              <a href="<?= $attachment['file_path'] ?>" target="_blank">
                <?= htmlspecialchars($attachment['filename']) ?>
              </a>
          <?php } else { ?>
              <span>No attachment</span>
          <?php } ?>
        </p>

      </div>
    </div>
  </div>
</div>


<!-- Respond Modal (فريد لكل تذكرة + نفس الـ UI القديم بالمللي) -->
<div class="modal fade" id="<?= $respondModalId ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Respond to Issue</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <?php
        $commentsSql = "SELECT comments.*, user.name , user.id
                        FROM comments
                        JOIN user ON user.id = comments.user_id
                        WHERE comments.ticket_id = ?
                        ORDER BY comments.created_at ASC";

        $stmt_c = $conn->prepare($commentsSql);
        $stmt_c->bind_param("i", $row["id"]);
        $stmt_c->execute();
        $commentsRes = $stmt_c->get_result();
        ?>

        <?php while ($comment = $commentsRes->fetch_assoc()) { ?>
          <div class="modelRespondBody mb-3">
            <div class="d-flex align-items-center gap-4">
              <img src="Images/worker-using-digital-application.jpg" 
                   alt="user" width="50" height="50" class="rounded-circle">

              <div class="flex-grow-1">
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="mb-1"><?= htmlspecialchars($comment["name"]) ?></h5>
                  <span class="badge bg-secondary responseTag">Solution</span>
                </div>

                <p class="mb-2"><?= nl2br(htmlspecialchars($comment["text"])) ?></p>

                <small class="text-muted"><?= date("d M Y, h:i A", strtotime($comment["created_at"])) ?></small>
              </div>
            </div>

            <div class="responseActions mt-2">
              <button type="button" class="btn btn-light btn-sm replyBtn" data-comment-id="<?= $comment['id'] ?>">
                <i class="fa-solid fa-reply"></i> Reply
              </button>
              <form action="php/send_comment.php" method="post">
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                <input type="hidden" name="ticket_id" value="<?= $row["id"] ?>">
                <input type="hidden" name="from_user" value="<?= $comment["id"] ?>">
                <button type="submit" class="btn btn-outline-success btn-sm acceptSolutionBtn">
                  <i class="fa-solid fa-check"></i> Accept Solution
                </button>
              </form>
            </div>

            <form class="replyForm d-none mt-2" id="replyForm_<?= $comment['id'] ?>" action="php/send_comment.php" method="post">
              <input type="hidden" name="sender_id" value="<?= $user_id ?>">
              <input type="hidden" name="ticket_id" value="<?= $row["id"] ?>">
              <input type="hidden" name="reciever_id" value="<?= $comment["id"] ?>">
              <textarea class="form-control" name="text" placeholder="Write your reply here"></textarea>
              <div class="d-flex gap-2 justify-content-end mt-2">
                <button type="button" class="btn btn-secondary btn-sm cancelReplyBtn" data-comment-id="<?= $comment['id'] ?>">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm submitReplyBtn">Send Reply</button>
              </div>
            </form>
          </div>
        <?php } ?>
        
        <?php if ($commentsRes->num_rows == 0): ?>
          <p class="text-center text-muted mb-0">No responses yet.</p>
        <?php endif; ?>

        <?php $stmt_c->close(); ?>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <form action="php/send_comment.php" method="post">
          <input type="hidden" name="ticket_id" value="<?= $row["id"] ?>">
          <input type="hidden" name="user_id" value="<?= $user_id ?>">          
          <button type="submit" class="btn btn-success closeIssueBtn">
            <i class="fa-solid fa-circle-check"></i>
            Mark Issue Resolved
          </button>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
  // لما تدوس على زرار Reply → يظهر الفورم
document.addEventListener("click", function (e) {
    if (e.target.closest(".replyBtn")) {
        const btn = e.target.closest(".replyBtn");
        const commentId = btn.getAttribute("data-comment-id");

        const form = document.getElementById(`replyForm_${commentId}`);
        form.classList.remove("d-none");
    }

    // زرار Cancel
    if (e.target.closest(".cancelReplyBtn")) {
        const btn = e.target.closest(".cancelReplyBtn");
        const commentId = btn.getAttribute("data-comment-id");

        const form = document.getElementById(`replyForm_${commentId}`);
        form.classList.add("d-none");
    }
});

</script>

<?php } ?>
<?php $stmt->close(); ?>