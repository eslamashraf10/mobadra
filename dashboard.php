<?php
include("php/get_user_info.php");
$slq_t_i = "SELECT COUNT(*) AS total_tickets FROM tickets";
$res_t_i = $conn->query($slq_t_i);

$row100 = $res_t_i->fetch_assoc();  // important!
$res1 = $row100["total_tickets"];

$slq_r_i = "SELECT COUNT(*) AS total_tickets FROM feedback WHERE from_user = $user_id";
$res_r_i = $conn->query($slq_r_i);

$row200 = $res_r_i->fetch_assoc();  // important!
$res2 = $row200["total_tickets"];


$slq_m_i = "SELECT COUNT(*) AS total_tickets FROM tickets WHERE user_id = $user_id";
$res_m_i = $conn->query($slq_m_i);

$row300 = $res_m_i->fetch_assoc();  // important!
$res3 = $row300["total_tickets"];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Font Awesome CDN -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    <!-- Bootstrap CSS CDN -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/dashboard.css" />
    <title>Employee Dashboard</title>
  </head>
  <body>
    <div class="container">
      <aside class="">
        <div class="asideToggle">
          <i class="fa-solid fa-angles-right toggleIcon"></i>
        </div>
        <div class="asideContent">
          <div class="logo">
            <img
              src="Images/teamwork_544543.png"
              alt="logo"
              width="30"
              height="30"
            />
            <span>Mobadra</span>
          </div>
          <div class="menu">
            <ul>
              <li class="active" data-target="home">
                <i class="fa-solid fa-house"></i> Home
              </li>
              <li class="" data-target="allIssues">
                <i class="fa-solid fa-layer-group"></i> All Issues
              </li>
              <li data-target="myIssues">
                <i class="fa-solid fa-user-check"></i> My Issues
              </li>
              <li data-target="myReplies">
                <i class="fa-solid fa-comments"></i> My Replies
              </li>
              <li data-target="resolvedIssues">
                <i class="fa-solid fa-user-check"></i> resolved Issues
              </li>
            </ul>
          </div>
        </div>
        <div class="asideFooter" >
         <a href="profile.php" class="profileLink">
           <img
            src="Images/worker-using-digital-application.jpg"
            alt="footer"
            width="100%"
            height="100%"
          />
          <h2><?= $user_name ?></h2>
         </a>
        </div>
        <button data-target="logout" class="logoutBtn" data-bs-toggle="modal" data-bs-target="#logoutModal">
          <i class="fa-solid fa-right-from-bracket"></i> Logout
        </button>
      </aside>
      <main>
        <div class="mainTitle">
          <h1>Welcome Back, <?= $user_name ?></h1>
          <button
            class="primaryBtn"
            data-bs-toggle="modal"
            data-bs-target="#createIssueModal"
          >
            Create Issue
          </button>
        </div>
        <div id="mainContent">
          <!-- Home -->
          <div class="Home page" id="home">
            <div class="mainHomeContent">
              <div class="mainHomeContentCard">
                <p><?= $res1 ?></p>
                <h2>Total Issues</h2>
              </div>
              <div class="mainHomeContentCard">
                <p><?= $res3 ?></p>
                <h2>Belongs to ME</h2>
              </div>
              <div class="mainHomeContentCard">
                <p><?= $res2 ?></p>
                <h2>Resolved Issues</h2>
              </div>
              <!-- <div class="mainHomeContentCard">
                <p>5</p>
                <h2>Belongs to IT</h2>
              </div> -->
            </div>
            <div class="quickActions">
              <button
                class="primaryBtn"
                data-bs-toggle="modal"
                data-bs-target="#createIssueModal"
              >
                <i class="fa-solid fa-plus"></i> Create Issue
              </button>
              <!-- <button class="secondaryBtn"><i class="fa-solid fa-magnifying-glass"></i> Search</button> -->
              <button class="secondaryBtn">
                <i class="fa-solid fa-book"></i> My Tickets
              </button>
            </div>

            <div class="recentIssues">
              <div class="sectionHeader">
                <h3>
                  <i class="fa-solid fa-clock-rotate-left"></i> Recent Issues
                </h3>
                <a href="#" class="viewAll">View All</a>
              </div>
              <ul class="issuesList">
                <?php include("php/recent_issue.php") ?>
                <!-- <li>
                  <span class="title">Printer not working</span>
                  <span class="meta">
                    <span class="badge warning">Pending</span>
                    <span class="time">2h ago</span>
                  </span>
                </li>
                <li>
                  <span class="title">Email login issue</span>
                  <span class="meta">
                    <span class="badge success">Resolved</span>
                    <span class="time">5h ago</span>
                  </span>
                </li>
                <li>
                  <span class="title">Network slow</span>
                  <span class="meta">
                    <span class="badge info">In Progress</span>
                    <span class="time">1d ago</span>
                  </span>
                </li> -->
              </ul>
            </div>
          </div>

          <!-- All Issues -->
          <div class="Issues page d-none" id="allIssues">
            <div class="row">
              <?php include("php/all_issue.php") ?>
              <!-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card">
                  <img
                    src="Images/9318694.jpg"
                    class="card-img-top"
                    alt="..."
                  />
                  <div class="department">IT</div>
                  <div class="card-body">
                    <h5 class="card-title">Printer not working</h5>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit.
                      Quisquam, quos.
                    </p>
                    <form action="" class="solutionForm">
                      <textarea class="form-control" placeholder="Enter the solution to the issue"></textarea>
                    </form>
                    <div class="card-buttons">
                      <a
                        href="#"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#allissueDetailsModal"
                      >
                        Details
                      </a>
                      <button type="button" class="btn solveBtn">
                        <i class="fa-solid fa-check"></i>
                        Solve
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card">
                  <img
                    src="Images/worker-using-digital-application.jpg"
                    class="card-img-top"
                    alt="..."
                  />
                  <div class="department">Finance</div>
                  <div class="card-body">
                    <h5 class="card-title">Email login issue</h5>
                    <p class="card-text">
                      Some quick example text to build on the card title and
                      make up the bulk of the card's content.
                    </p>
                    <form action="" class="solutionForm">
                      <textarea class="form-control" placeholder="Enter the solution to the issue"></textarea>
                    </form>
                    <div class="card-buttons">
                      <a href="#" class="btn btn-primary" 
                      data-bs-toggle="modal"
                      data-bs-target="#allissueDetailsModal"
                      >Details</a>
                      <button type="button" class="btn solveBtn">
                        <i class="fa-solid fa-check"></i>
                        Solve
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card">
                  <img
                    src="Images/teamwork_544543.png"
                    class="card-img-top"
                    alt="..."
                  />
                  <div class="department">HR</div>
                  <div class="card-body">
                    <h5 class="card-title">Network slow</h5>
                    <p class="card-text">
                      Some quick example text to build on the card title and
                      make up the bulk of the card's content.
                    </p>
                    <form action="" class="solutionForm">
                      <textarea class="form-control" placeholder="Enter the solution to the issue"></textarea>
                    </form>
                    <div class="card-buttons">
                      <a href="#" class="btn btn-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#allissueDetailsModal"
                      >Details</a>
                      <button type="button" class="btn solveBtn">
                        <i class="fa-solid fa-check"></i>
                        Solve
                      </button>
                    </div>
                  </div>
                </div>
              </div> -->
            </div>
          </div>

          <!-- My Issues -->
          <div class="Issues page d-none" id="myIssues">
            <div class="row">
              <?php 
              include("php/my_issue.php");
              ?>
              <!-- <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card">
                  <img
                    src="Images/9318694.jpg"
                    class="card-img-top"
                    alt="..."
                  />
                  <div class="cancelBtn">
                    <i class="fa-solid fa-xmark"></i>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Printer not working</h5>
                    <span class="badge statusBadge warning">Open</span>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit.
                      Quisquam, quos.
                    </p>
                    <div class="card-buttons">
                      <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myIssueDetailsModal" data-issue-id="issue-1">Details</a>
                      <a href="#" class="btn btn-primary respondBtn" data-bs-toggle="modal" data-bs-target="#respondToIssueModal" data-issue-id="issue-1">Respond</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card">
                  <img
                    src="Images/9318694.jpg"
                    class="card-img-top"
                    alt="..."
                  />
                  <div class="cancelBtn">
                    <i class="fa-solid fa-xmark"></i>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Email login issue</h5>
                    <span class="badge statusBadge warning">Open</span>
                    <p class="card-text">
                      Some quick example text to build on the card title and
                      make up the bulk of the card's content.
                    </p>
                    <div class="card-buttons">
                      <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myIssueDetailsModal" data-issue-id="issue-2">Details</a>
                      <a href="#" class="btn btn-primary respondBtn" data-bs-toggle="modal" data-bs-target="#respondToIssueModal" data-issue-id="issue-2">Respond</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card">
                  <img
                    src="Images/9318694.jpg"
                    class="card-img-top"
                    alt="..."
                  />
                  <div class="cancelBtn">
                    <i class="fa-solid fa-xmark"></i>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Network slow</h5>
                    <span class="badge statusBadge warning">Open</span>
                    <p class="card-text">
                      Some quick example text to build on the card title and
                      make up the bulk of the card's content.
                    </p>
                    <div class="card-buttons">
                      <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myIssueDetailsModal" data-issue-id="issue-3">Details</a>
                      <a href="#" class="btn btn-primary respondBtn" data-bs-toggle="modal" data-bs-target="#respondToIssueModal" data-issue-id="issue-3">Respond</a>
                    </div>
                  </div>
                </div>
              </div> -->
            </div>
          </div>

          <!-- My Replies -->
          <div class="Replies page d-none" id="myReplies">
            <div class="repliesHeader">
              <div>
                <h3><i class="fa-solid fa-envelope-open-text"></i> Replies to My Solutions</h3>
                <p>Track the latest responses to the issues you have helped resolve.</p>
              </div>
            </div>
            <?php include("php/replies.php") ?>
            <!-- <div class="repliesList">
              <div class="replyCard" data-issue-id="issue-1">
                <div class="replyCardHeader">
                  <div>
                    <h5>Printer not working</h5>
                    <span class="replyMeta">
                      <i class="fa-solid fa-building"></i> IT Department
                    </span>
                  </div>
                  <span class="badge info replyStatus">New Reply</span>
                </div>
                <p class="replySummary">
                  <strong>Ahmed Mohamed:</strong> Thanks for the steps! The printer is working now, but the dashboard still shows a warning. Can you check that?
                </p>
                <div class="userReplyPreview d-none">
                  <strong>Your reply:</strong>
                  <span class="userReplyPreviewText"></span>
                </div>
                <div class="replyFooter">
                  <span class="replyTime">
                    <i class="fa-regular fa-clock"></i> 15 minutes ago
                  </span>
                  <div class="replyActions">
                    <button type="button" class="btn btn-primary btn-sm replyInlineToggle">
                      <i class="fa-solid fa-comments"></i> Reply
                    </button>
                  </div>
                </div>
                <form class="replyInlineForm d-none">
                  <textarea class="form-control" placeholder="Type your reply here"></textarea>
                  <div class="replyInlineActions">
                    <button type="button" class="btn btn-secondary btn-sm cancelReplyInlineBtn">
                      Cancel
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm submitReplyInlineBtn">
                      Send Reply
                    </button>
                  </div>
                </form>
              </div>

              <div class="replyCard reply-read" data-issue-id="issue-2">
                <div class="replyCardHeader">
                  <div>
                    <h5>Email login issue</h5>
                    <span class="replyMeta">
                      <i class="fa-solid fa-building"></i> Finance Department
                    </span>
                  </div>
                  <span class="badge success replyStatus">Read</span>
                </div>
                <p class="replySummary">
                  <strong>Sara Youssef:</strong> The password reset worked perfectly. Appreciate the quick response!
                </p>
                <div class="userReplyPreview d-none">
                  <strong>Your reply:</strong>
                  <span class="userReplyPreviewText"></span>
                </div>
                <div class="replyFooter">
                  <span class="replyTime">
                    <i class="fa-regular fa-clock"></i> Yesterday
                  </span>
                  <div class="replyActions">
                    <button type="button" class="btn btn-primary btn-sm replyInlineToggle">
                      <i class="fa-solid fa-comments"></i> Reply
                    </button>
                  </div>
                </div>
                <form class="replyInlineForm d-none">
                  <textarea class="form-control" placeholder="Type your reply here"></textarea>
                  <div class="replyInlineActions">
                    <button type="button" class="btn btn-secondary btn-sm cancelReplyInlineBtn">
                      Cancel
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm submitReplyInlineBtn">
                      Send Reply
                    </button>
                  </div>
                </form>
              </div>

              <div class="replyCard" data-issue-id="issue-3">
                <div class="replyCardHeader">
                  <div>
                    <h5>Network slow</h5>
                    <span class="replyMeta">
                      <i class="fa-solid fa-building"></i> HR Department
                    </span>
                  </div>
                  <span class="badge info replyStatus">New Reply</span>
                </div>
                <p class="replySummary">
                  <strong>Omar Khaled:</strong> We still have latency after 4 PM. Could there be a scheduled task running?
                </p>
                <div class="userReplyPreview d-none">
                  <strong>Your reply:</strong>
                  <span class="userReplyPreviewText"></span>
                </div>
                <div class="replyFooter">
                  <span class="replyTime">
                    <i class="fa-regular fa-clock"></i> 2 hours ago
                  </span>
                  <div class="replyActions">
                    <button type="button" class="btn btn-primary btn-sm replyInlineToggle">
                      <i class="fa-solid fa-comments"></i> Reply
                    </button>
                  </div>
                </div>
                <form class="replyInlineForm d-none">
                  <textarea class="form-control" placeholder="Type your reply here"></textarea>
                  <div class="replyInlineActions">
                    <button type="button" class="btn btn-secondary btn-sm cancelReplyInlineBtn">
                      Cancel
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm submitReplyInlineBtn">
                      Send Reply
                    </button>
                  </div>
                </form>
              </div>
            </div> -->
          </div>
          <div class="Replies page d-none" id="resolvedIssues">
              <div class="sectionHeader">
                <h3>
                  Resolved Issues
                </h3>
              </div>
              <ul class="issuesList">
                <?php include("php/resolved.php") ?>
              </ul>
            </div>
          </div>

          <!-- Modal to create issue -->
          <div
            class="modal fade"
            id="createIssueModal"
            tabindex="-1"
            aria-labelledby="createIssueModalLabel"
            aria-hidden="true"
          >
            <div
              class="modal-dialog modal-dialog-scrollable modal-dialog-centered"
              role="document"
            >
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                    Create Issue
                  </h5>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                  ></button>
                </div>
                <div class="modal-body">
                  <form action="php/create_ticket.php" method="post" enctype="multipart/form-data">
                    <div>
                      <label for="title">Title</label>
                      <input
                        type="text"
                        id="title"
                        class="form-control"
                        name="Title"
                        placeholder="Enter the title of the issue"
                      />
                    </div>
                    <div>
                      <label for="description">Description</label>
                      <textarea
                        id="description"
                        class="form-control"
                        name="Description"
                        placeholder="Enter the description of the issue"
                      ></textarea>
                    </div>
                    <div>
                      <label for="department">Department</label>
                      <select id="department" name="department" class="form-control">
                        <option value="IT Department">IT</option>
                        <option value="HR Department">HR</option>
                        <option value="Finance Department">Finance</option>
                        <option value="Marketing Department">Marketing</option>
                        <option value="Sales Department">Sales</option>
                        <option value="Software Engineering Department">Engineering</option>
                        <option value="Design Department">Design</option>
                      </select>
                    </div>
                    <div>
                      <label for="priority">Priority</label>
                      <select id="priority" class="form-control" name="Priority">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                      </select>
                    </div>
                    <div>
                      <label for="attachment">Attachment</label>
                      <input type="file" id="attachment" name="file" class="form-control" />
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                      >
                        Close
                      </button>
                      <button type="input" class="btn btn-primary">
                        Save changes
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- modal For All issue details -->
          <!-- <div class="modal" id="allissueDetailsModal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Issue Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Issue Title: Printer not working</p>
                  <p>Issue Description: Printer is not working properly</p>
                  <p>Issue Department: IT</p>
                  <p>Issue Priority: High</p>
                  <p>Issue Attachment: <a href="#">Attachment.pdf</a></p>
                  <form action="" class="solutionForm">
                    <textarea class="form-control" placeholder="Enter the solution to the issue"></textarea>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn solveBtn">
                    <i class="fa-solid fa-check"></i>
                    Solve
                  </button>
                </div>
              </div>
            </div>
          </div> -->

          <!-- modal For My issue details -->
          <!-- <div class="modal" id="myIssueDetailsModal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">My Issue Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Issue Title: Printer not working</p>
                  <p>Issue Description: Printer is not working properly</p>
                  <p>Issue Department: IT</p>
                  <p>Issue Priority: High</p>
                  <p>Issue Attachment: <a href="#">Attachment.pdf</a></p>
                </div>
              </div>
            </div>
          </div> -->

          <!-- modal For Respond to issue -->
          <!-- <div class="modal" id="respondToIssueModal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Respond to Issue</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                 <div class="modelRespondBody" data-response-id="1">
                   <div class="d-flex align-items-center gap-4">
                     <img src="Images/worker-using-digital-application.jpg" alt="user" width="50" height="50" class="rounded-circle">
                     <div class="flex-grow-1">
                      <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-1"><?= $user_name ?></h5>
                        <span class="badge bg-secondary responseTag">Solution</span>
                      </div>
                      <p class="mb-2">
                        Solution: Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.
                      </p>
                     </div>
                   </div>
                   <div class="responseActions">
                     <button type="button" class="btn btn-light btn-sm replyBtn">
                       <i class="fa-solid fa-reply"></i> Reply
                     </button>
                     <button type="button" class="btn btn-outline-success btn-sm acceptSolutionBtn">
                       <i class="fa-solid fa-check"></i> Accept Solution
                     </button>
                   </div>
                   <form class="replyForm d-none">
                     <textarea class="form-control" placeholder="Write your reply here"></textarea>
                     <div class="d-flex gap-2 justify-content-end mt-2">
                       <button type="button" class="btn btn-secondary btn-sm cancelReplyBtn">Cancel</button>
                       <button type="submit" class="btn btn-primary btn-sm submitReplyBtn">Send Reply</button>
                     </div>
                   </form>
                 </div>
                </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                   <button type="button" class="btn btn-success closeIssueBtn">
                     <i class="fa-solid fa-circle-check"></i>
                     Mark Issue Resolved
                   </button>
                 </div>
              </div>
            </div>
          </div> -->
        </div>
      </main>
    </div>
   
    <!-- Logout Modal -->
    <div class="modal" id="logoutModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Logout</h5>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to logout?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary logoutBtnInsure">
              <a href="php/logout.php">Logout</a>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Toast for solution saved successfully -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div
        id="solutionToast"
        class="toast align-items-center text-white bg-success border-0"
        role="status"
        aria-live="assertive"
        aria-atomic="true"
      >
        <div class="d-flex">
          <div class="toast-body">Solution saved successfully.</div>
          <button
            type="button"
            class="btn-close btn-close-white me-2 m-auto"
            data-bs-dismiss="toast"
            aria-label="Close"
          >
        </button>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <script src="js/index.js"></script>
  </body>
</html>
