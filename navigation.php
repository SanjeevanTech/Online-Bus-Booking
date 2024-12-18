<?php
include("adminusername.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Navigation</title>
    <style>
        body {
            margin: 0;
            font-family: Arvo, sans-serif;
            background-color: #f4f4f4;
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #141850;
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .logo-title {
            margin-left: 10px;
            font-size: 24px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 12px;
            transition: 0.3s;
        }

        .nav-links a:hover {
            background-color: #FFD100;
            color: black;
            border-radius: 5px;
            box-shadow: 0px 1px 10px #fff;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .login, .logout {
            font-family: Arvo, sans-serif;
            border-radius: 15px;
            height: 30px;
            width: 80px;
            border: 0;
            background-color: #fff;
            cursor: pointer;
            transition: 0.3s;
        }

        .login:hover, .logout:hover {
            background-color: #FFD100;
            color: black;
            box-shadow: 0px 1px 10px #fff;
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav {
                flex-wrap: wrap;
                text-align: center;
            }

            .logo-title {
                font-size: 18px;
            }

            .nav-links {
                gap: 10px;
            }

            .nav-links a {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .logo img {
                width: 40px;
                height: 40px;
            }

            .logo-title {
                font-size: 16px;
            }

            .login, .logout {
                width: 60px;
                height: 25px;
                font-size: 12px;
            }

            .profile-icon {
                width: 30px;
                height: 30px;
            }
        }
    </style>
</head>
<body>

<div class="nav">
    <!-- Logo Section -->
    <div class="logo">
        <img src="assets/trendbus.jpeg" alt="Logo">
        <span class="logo-title">Trendbus Booking</span>
    </div>

    <!-- Navigation Links -->
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="schedule.php">Book Ticket</a>
        <?php if (isset($_SESSION['Admin']) && $_SESSION['Admin'] == $adminuser): ?>
            <a href="admin_schedule.php">Manage Schedule</a>
            <a href="admin_companylist.php">Manage Company</a>
        <?php endif; ?>
        <a href="history.php">Booking List</a>
    </div>

    <!-- User Actions -->
    <div class="actions">
        <?php if (!isset($_SESSION['Admin'])): ?>
            <button class="login" onclick="window.location.href='login.php'">Login</button>
        <?php else: ?>
            <button class="logout" onclick="window.location.href='logout.php'">Logout</button>
            <a href="setting.php">
                <img src="assets/profile.webp" alt="Profile Icon" class="profile-icon">
            </a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
