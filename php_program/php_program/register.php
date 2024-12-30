<?php

include 'Database/compoment/connect.php';
        if (isset($_POST["submit"])){

            $id = create_unique_id();
            $name=$_POST["name"];
            $name=filter_var($name, FILTER_SANITIZE_STRING);
            $password=sha1($_POST["password"]);
            $password=filter_var($password, FILTER_SANITIZE_STRING);
            $repassword=sha1($_POST["repassword"]);
            $repassword=filter_var($repassword, FILTER_SANITIZE_STRING);


            $select_admins = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
            $select_admins->execute([$name]);

            if($select_admins->rowCount()>0){
                $warning_msg[]='Username already taken!';
            }else{
                if($password != $repassword){
                    $warning_msg[]='Password and repassword are not same!';
                }else{
                    $insert_admin = $conn->prepare("INSERT INTO `admins`(id, name, password) VALUES(?,?,?)");
                    $insert_admin->execute([$id, $name, $repassword]);
                    $success_msg[]="Your account have been registered successfully!";
                }
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
    <link rel="stylesheet" href="css/registerstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php 
    include 'Database/compoment/message.php'
    ?>
    <div class="form-container">
        <form action="" method="post">   
         <h3>Register</h3>
            <input type="text" name="name" placeholder="Name" required oninput="this.value = this.value.replace(/\s/g, '')" >
            <input type="password" name="password" placeholder="Password" required oninput="this.value = this.value.replace(/\s/g, '')" >
            <input type="password" name="repassword" placeholder="Repassword" required oninput="this.value = this.value.replace(/\s/g, '')" >
            <input type="submit" name="submit" value="Confirm" class="btn">
            <p>Have an account already? <a href="login.php">Login now</a></p>
        </form>
    </div>
</body>
</html>