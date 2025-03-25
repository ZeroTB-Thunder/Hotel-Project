<?php

session_start();
include 'Database/compoment/connect.php';

if (isset($_POST["submit"])) {
    $id = create_unique_id();
    $name = $_POST["name"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];

    // Lọc dữ liệu đầu vào
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $repassword = filter_var($repassword, FILTER_SANITIZE_STRING);

    // Kiểm tra xem username đã tồn tại chưa
    $check_user = $conn->prepare("SELECT * FROM `Accounts` WHERE UserName = ?");
    $check_user->execute([$name]);

    if ($check_user->rowCount() > 0) {
        $_SESSION['error'] = "Username already taken!";
    } else {
        if ($password !== $repassword) {
            $_SESSION['error'] = "Passwords do not match!";
        } else {
            // Mã hóa mật khẩu an toàn
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Mặc định CustomerID là NULL, Role là "Customer", Status là "Active"
            $insert_user = $conn->prepare("INSERT INTO `Accounts` (AccID, CustomerID, UserName, Password, Role, Status, CreateAt) 
                                           VALUES (?, NULL, ?, ?, 'Customer', 'Active', NOW())");
            $insert_user->execute([$id, $name, $hashed_password]);

            $_SESSION['success'] = "Your account has been registered successfully!";
            header("Location: login.php");
            exit;
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
    // Hiển thị thông báo lỗi/thành công
    if (isset($_SESSION['error'])) {
        echo "<script>swal('Error', '" . $_SESSION['error'] . "', 'error');</script>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "<script>swal('Success', '" . $_SESSION['success'] . "', 'success');</script>";
        unset($_SESSION['success']);
    }
    ?>
    <?php
    include 'Database/compoment/message.php'
    ?>
    <div class="form-container">
        <form action="" method="post">
            <h3>Register</h3>
            <input type="text" name="name" placeholder="Name" required oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="password" placeholder="Password" required oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="repassword" placeholder="Repassword" required oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" name="submit" value="Confirm" class="btn">
            <p>Have an account already? <a href="login.php">Login now</a></p>
        </form>
    </div>
</body>

</html>