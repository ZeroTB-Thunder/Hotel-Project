<?php
include 'Database/compoment/connect.php';

error_reporting(0);
/*session_start();
if (!isset($_SESSION["Username"])) {
    $_SESSION["Username"] = $username;
    header("location:login.php");
}
session_destroy();

error_reporting(0);
session_start();
session_destroy();*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GACHA HOTEL</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="css/dashstyle.css">
</head>

<body>
    <aside class="sidebar">
        <header class="sidebar-header">
            <a href="#" class="header-logo">
                <img src="logo.png">
            </a>
            <button class="toggler sidebar-toggler">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
        </header>

        <nav class="sidebar-nav">
        <ul class="nav-list primary-nav">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="nav-icon material-symbols-outlined">dashboard</span>
                    <span class="nav-label">Dashboard</span>
                </a>
                <span class="nav-tooltip">Dashboard</span>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="nav-icon material-symbols-outlined">group</span>
                    <span class="nav-label">Accounts</span>
                </a>
                <span class="nav-tooltip">Accounts</span>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="nav-icon material-symbols-outlined">room</span>
                    <span class="nav-label">Room</span>
                </a>
                <span class="nav-tooltip">Room</span>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="nav-icon material-symbols-outlined">book</span>
                    <span class="nav-label">Book</span>
                </a>
                <span class="nav-tooltip">Book</span>
            </li>
        </ul>

        <ul class="nav-list secondary-nav">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="nav-icon material-symbols-outlined">logout</span>
                    <span class="nav-label">Logout</span>
                </a>
                <span class="nav-tooltip">Logout</span>
            </li>
        </ul>
    </nav>
    </aside>
    
   <!-- Main Content -->
   <main class="main-content">
        <!-- Nút chọn tầng -->
        <div class="floor-buttons">
            <button class="floor-button" data-floor="1">Tầng 1</button>
            <button class="floor-button" data-floor="2">Tầng 2</button>
            <button class="floor-button" data-floor="3">Tầng 3</button>
            <button class="floor-button" data-floor="4">Tầng 4</button>
        </div>

        <!-- Container chứa các phòng -->
        <div class="room-container" id="room-container">
            <!-- Các thẻ phòng sẽ được thêm vào đây bằng JavaScript -->
        </div>
    </main>

    <script><?php require("java/sidebar.js");?></script>
    <script><?php require("java/listroom.js");?></script>
</body>

</html>