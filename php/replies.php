<?php

$sql = "
SELECT 
    replay.id AS replay_id,
    replay.text,
    replay.created_at,

    sender_user.id   AS sender_id,
    sender_user.name AS sender_name,

    rec_user.id      AS receiver_id,
    rec_user.name    AS receiver_name,

    tickets.id       AS ticket_id,
    tickets.title    AS ticket_title,
    tickets.user_id  AS ticket_owner_id,

    department.id    AS dept_id,
    department.name  AS dept_name

FROM replay
LEFT JOIN user AS sender_user
    ON replay.sender = sender_user.id
LEFT JOIN user AS rec_user
    ON replay.reciever = rec_user.id
LEFT JOIN tickets
    ON replay.ticket_id = tickets.id
LEFT JOIN department
    ON tickets.dept_id = department.id

WHERE replay.reciever = $user_id
ORDER BY replay.created_at DESC
";

$res = $conn->query($sql);


?>

<div class="repliesList">
<?php while ($row = $res->fetch_assoc()) { ?>

  <div class="replyCard <?= ($row["ticket_owner_id"] == $user_id ? 'reply-read' : '') ?>" 
       data-issue-id="ticket-<?= $row['ticket_id'] ?>">

    <div class="replyCardHeader">
      <div>
        <h5><?= htmlspecialchars($row["ticket_title"]) ?></h5>
        <span class="replyMeta">
          <i class="fa-solid fa-building"></i> 
          <?= htmlspecialchars($row["dept_name"]) ?>
        </span>
      </div>

      <span class="badge <?= ($row["ticket_owner_id"] == $user_id ? 'success' : 'info') ?> replyStatus">
        <?= ($row["ticket_owner_id"] == $user_id ? "Read" : "New Reply") ?>
      </span>
    </div>

    <p class="replySummary">
      <strong><?= htmlspecialchars($row["sender_name"]) ?>:</strong>
      <?= nl2br(htmlspecialchars($row["text"])) ?>
    </p>

    <div class="userReplyPreview d-none">
      <strong>Your reply:</strong>
      <span class="userReplyPreviewText"></span>
    </div>

    <div class="replyFooter">
      <span class="replyTime">
        <i class="fa-regular fa-clock"></i>
        <?= date("d M Y h:i A", strtotime($row["created_at"])) ?>
      </span>

      <!-- <div class="replyActions">
        <button type="button" class="btn btn-primary btn-sm replyInlineToggle">
          <i class="fa-solid fa-comments"></i> Reply
        </button>
      </div> -->
    </div>

    <form 
    action="php/send_comment.php" 
    method="post"
    >
    <!-- class="replyInlineForm d-none"  -->
        
        <input type="hidden" name="sender_id" value="<?= $user_id ?>">
        <input type="hidden" name="reciever_id" value="<?= $row['sender_id'] ?>">
        <input type="hidden" name="ticket_id" value="<?= $row['ticket_id'] ?>">
        
        <textarea class="form-control" name="text" placeholder="Type your reply here"></textarea>
        
        <div class="replyInlineActions">
            <!-- <button type="button" class="btn btn-secondary btn-sm cancelReplyInlineBtn">Cancel</button> -->
            <button type="submit" class="btn btn-primary btn-sm submitReplyInlineBtn">Send Reply</button>
        </div>
    </form>

  </div>

<?php } ?>
</div>
