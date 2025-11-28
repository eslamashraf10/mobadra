<?php
include('php/get_admin_info.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .admin-container {
            padding: 20px;
            margin-left: 250px;
            min-height: 100vh;
            background-color: var(--card-color);
        }
        .admin-section {
            background-color: var(--background-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        }
        .admin-section h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 600;
        }
        .users-table {
            width: 100%;
            border-collapse: collapse;
        }
        .users-table th,
        .users-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(72, 71, 69, 0.1);
        }
        .users-table th {
            background-color: var(--card-color);
            color: var(--primary-color);
            font-weight: 600;
        }
        .users-table td {
            color: var(--primary-color);
        }
        .role-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .role-badge.admin {
            background-color: #bb3e03;
            color: #fff;
        }
        .role-badge.user {
            background-color: #386fa4;
            color: #fff;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        .btn-sm {
            padding: 4px 12px;
            font-size: 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }
        .btn-edit {
            background-color: var(--primary-color);
            color: #fff;
        }
        .btn-delete {
            background-color: #dc3545;
            color: #fff;
        }
        .messages-section {
            max-height: 400px;
            overflow-y: auto;
        }
        .message-card {
            background-color: var(--card-color);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid var(--primary-color);
        }
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .message-name {
            font-weight: 600;
            color: var(--primary-color);
        }
        .message-email {
            font-size: 12px;
            color: var(--primary-color);
            opacity: 0.7;
        }
        .message-dept {
            font-size: 12px;
            background-color: var(--background-color);
            padding: 2px 8px;
            border-radius: 4px;
            color: var(--primary-color);
        }
        .message-text {
            color: var(--primary-color);
            margin-top: 10px;
            line-height: 1.6;
        }
        @media (max-width: 991px) {
            .admin-container {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <aside>
        <div class="asideContent">
            <div class="logo">
                <img src="Images/teamwork_544543.png" alt="logo">
                <span>Mobadra</span>
            </div>
            <div class="asideToggle">
                <i class="bi bi-list"></i>
            </div>
            <div class="menu">
                <ul>
                    <li class="active" data-target="users">
                        <i class="bi bi-people"></i> User Management
                    </li>
                    <li data-target="messages">
                        <i class="bi bi-envelope"></i> Messages
                    </li>
                </ul>
            </div>
        </div>
        <div class="asideFooter">
            <a href="php/logout.php" style="text-decoration: none; color: var(--primary-color);">
                <i class="bi bi-house"></i> Home
            </a>
        </div>
    </aside>

    <div class="admin-container">
        <div class="mainTitle">
            <h1>Admin Dashboard</h1>
        </div>

        <!-- User Management -->
        <div id="users" class="admin-section page">
            <h2><i class="bi bi-people me-2"></i>User & Role Management</h2>
            <div class="table-responsive">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <!-- Will be filled by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Messages -->
        <div id="messages" class="admin-section page d-none">
            <h2><i class="bi bi-envelope me-2"></i>Messages from Home Page</h2>
            <div class="messages-section" id="messagesContainer">
                <?php
                include('php/get_message.php');
                ?>
               <!-- <div class="message-card">
                <div class="message-header">
                    <div>
                      <div class="message-name">John Doe</div>
                      <div class="message-email">john.doe@example.com</div>
                    </div>
                    <span class="message-dept">IT</span>
                  </div>
                  <div class="message-text">I need help updating the company management system. Can you provide technical support?</div>
               </div>
               <div class="message-card">
                <div class="message-header">
                    <div>
                      <div class="message-name">John Doe</div>
                      <div class="message-email">john.doe@example.com</div>
                    </div>
                    <span class="message-dept">IT</span>
                  </div>
                  <div class="message-text">I need help updating the company management system. Can you provide technical support?</div>
               </div>
               <div class="message-card">
                <div class="message-header">
                    <div>
                      <div class="message-name">John Doe</div>
                      <div class="message-email">john.doe@example.com</div>
                    </div>
                    <span class="message-dept">IT</span>
                  </div>
               </div> -->
            </div>
        </div>
    </div>

    <!-- Modal for Editing User -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="editUserId">
                        <div class="mb-3">
                            <label for="editUserName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editUserName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editUserEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserDept" class="form-label" name="department">Department</label>
                            <select class="form-select" id="editUserDept" required>
                                <option value="IT Department">IT Department</option>
                                <option value="HR Department">HR Department</option>
                                <option value="Finance Department">Finance Department</option>
                                <option value="Marketing Department">Marketing Department</option>
                                <option value="Sales Department">Sales Department</option>
                                <option value="Software Engineering Department">Software Engineering Department</option>
                                <option value="Design Department">Design Department</option>
                                <option value="administration department">administration department</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editUserRole" class="form-label">Role</label>
                            <select class="form-select" id="editUserRole" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveUser()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/backend.js"></script>
    <script src="js/admin.js"></script>
</body>
</html>
