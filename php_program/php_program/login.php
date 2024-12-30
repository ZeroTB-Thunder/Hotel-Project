<?php

$host="localhost";
$user="root";
$password="";
$db="hotel_db";
error_reporting(0);
session_start();
$data=mysqli_connect($host,$user,$password,$db);
if($data==false){
    die("Có lỗi xảy ra");
}
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $name = $_POST["Username"];
    $pass=$_POST["Password"];

    $sql="SELECT * from admins where Username='".$name."' AND Password='".$pass."'";
    $result=mysqli_query($data,$sql);
    $row=mysqli_fetch_array($result);

    if($row["Role"]=="Khách hàng"){  
        $_SESSION["Username"]=$name;
        $_SESSION["Role"]="Khách hàng";
        $_SESSION["id"] = $row["id"]; // Assuming "user_id" is the column name for user ID
        header("location:index.php");
    }
    elseif($row["Role"]=="Admin"){
        $_SESSION["Username"]=$name;
        $_SESSION["Role"]="Admin";
        $_SESSION["id"] = $row["id"]; // Assuming "user_id" is the column name for user ID
        header("location:dashboard.php");
    }
    else{
        $warning_msg[] = 'Incorrect username or password!';
    }
}
 ?>
     

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GACHA HOTEL</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php 
    include 'Database/compoment/message.php'
    ?>
    <div class="form-container">
        <form action="" method="POST">   
         <h3>Login</h3>
            <input type="text" name="Username" placeholder="Name" required oninput="this.value = this.value.replace(/\s/g, '')" >
            <input type="password" name="Password" placeholder="Password" required oninput="this.value = this.value.replace(/\s/g, '')" >
            <input type="submit" name="submit" value="Login" class="btn">
            <p>Don't have account? <a href="register.php">Register now</a></p>
        </form>
    </div>
</body>
</html>