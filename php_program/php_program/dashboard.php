<?php
include 'Database/compoment/connect.php';

error_reporting(0);
session_start();	
if(!isset($_SESSION["Username"]))
{
  $_SESSION["Username"]=$username;
  header("location:login.php");
}
session_destroy();

error_reporting(0);
session_start();
session_destroy();
?>
<!DOCTYPE html>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GACHA HOTEL</title>
    <link rel="stylesheet" href="css/dashstyle.css">
</head>
<body>
<header>
    <div id="menu-bar" class="fas fa-bars"></div>
    <a class="logo"><span>G</span>ACHA HOTEL</a>
    <nav class="navbar">
        <a href="dashboard.php">Home</a>
        <a href="adminbook.php">Bookings</a>
        <a href="adminmes.php">Messages</a>
        <a href="logout.php" onclick="return confirm('Do yo want to logout from this website?');">Logout</a>
    </nav>
    </header>
</body>
</html>