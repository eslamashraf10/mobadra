<?php
include("php/get_user_info.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .profile-container {
            padding: 100px 20px 50px;
            max-width: 800px;
            margin: 0 auto;
        }
        .profile-card {
            background-color: var(--card-color);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        }
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #fff;
            font-size: 48px;
            font-weight: bold;
        }
        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background-color: var(--background-color);
            border-radius: 8px;
        }
        .info-item i {
            font-size: 24px;
            color: var(--primary-color);
        }
        .info-item .info-label {
            font-weight: 600;
            color: var(--primary-color);
            min-width: 120px;
        }
        .info-item .info-value {
            color: var(--primary-color);
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <img src="Images/teamwork_544543.png" alt="logo" width="30" height="30">
                <span>Mobadra</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse navLinks" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h1 class="h2 mb-2" style="color: var(--primary-color);">User Information</h1>
            </div>
            <div class="profile-info">
                <div class="info-item">
                    <i class="bi bi-person"></i>
                    <span class="info-label">Name:</span>
                    <span class="info-value" id="userName"><?= $user_name ?></span>
                </div>
                <div class="info-item">
                    <i class="bi bi-envelope"></i>
                    <span class="info-label">Email:</span>
                    <span class="info-value" id="userEmail"><?= $user_email ?></span>
                </div>
                <div class="info-item">
                    <i class="bi bi-building"></i>
                    <span class="info-label">Department:</span>
                    <span class="info-value" id="userDept"><?= $department ?></span>
                </div>
                <div class="info-item">
                    <i class="bi bi-shield-check"></i>
                    <span class="info-label">Role:</span>
                    <span class="info-value" id="userRole"><?= $user_role ?></span>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">All rights reserved &copy; 2025 Initiative Portal</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script>
        // Load user data from localStorage or API
        document.addEventListener('DOMContentLoaded', function() {
            const userData = JSON.parse(localStorage.getItem('userData')) || {
                name: 'John Doe',
                email: 'user@example.com',
                department: 'IT',
                role: 'User'
            };
            
            document.getElementById('userName').textContent = userData.name;
            document.getElementById('userEmail').textContent = userData.email;
            document.getElementById('userDept').textContent = userData.department;
            document.getElementById('userRole').textContent = userData.role;
        });
    </script> -->
</body>
</html>
