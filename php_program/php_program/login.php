<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "ghotel_db";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'Database/compoment/connect.php';
$error_message = ''; // Khởi tạo biến thông báo lỗi rỗng

// Giả lập nếu đang chạy trong môi trường test
$testingMode = defined('RUNNING_TEST') && RUNNING_TEST;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["Username"]);
    $pass = trim($_POST["Password"]);
    
    // Kiểm tra xem tên đăng nhập và mật khẩu có bị thiếu không
    if (empty($name) || empty($pass)) {
        $error_message = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        // Kiểm tra kết nối database
        if (!$conn) {
            $error_message = "Lỗi kết nối cơ sở dữ liệu";
        } else {
            // Sử dụng prepared statement để chống SQL Injection
            $sql = "SELECT * FROM accounts WHERE UserName = :username AND Password = :password";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $name);
            $stmt->bindParam(':password', $pass);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $_SESSION["Username"] = $row["UserName"];
                $_SESSION["Role"] = $row["Role"];
                $_SESSION["AccID"] = $row["AccID"];

                // Chỉ thực hiện header nếu không phải trong môi trường test
                if (!$testingMode) {
                    // Nếu người dùng là Customer hoặc Admin, thực hiện chuyển hướng
                    if ($row["Role"] == "Customer") {
                        header("Location: index.php");
                        exit();
                    } elseif ($row["Role"] == "Admin") {
                        header("Location: dashboard.php");
                        exit();
                    }
                }

                // Thông báo đăng nhập thành công nếu không có chuyển hướng
                $error_message = "Đăng nhập thành công";
            } else {
                // Nếu không tìm thấy tài khoản, thông báo sai tên đăng nhập hoặc mật khẩu
                $error_message = "Sai tên đăng nhập hoặc mật khẩu!";
            }
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
        <?php if ($error_message): ?>
            <div class="error-msg" ><?php echo $error_message; ?></div>
        <?php endif; ?>
            <h3>Login</h3>

            <input type="text" name="Username" placeholder="Name" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="Password" placeholder="Password" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" name="submit" value="Login" class="btn">
            <p>Don't have account? <a href="register.php">Register now</a></p>
        </form>

    </div>
</body>

</html>