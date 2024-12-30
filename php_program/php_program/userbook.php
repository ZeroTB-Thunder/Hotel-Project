<?php

include 'Database/compoment/connect.php';
session_start();  // Start the session

// Ensure the user is logged in by checking if their email or user ID exists in the session
if (!isset($_SESSION['id'])) {
    // If the user is not logged in, redirect to the login page or show an error
    header("Location: login.php");
    exit;
}

$username = $_SESSION['id']; // Or $_S

if(isset($_POST['delete'])){

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `bookings` WHERE booking_id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $delete_messages = $conn->prepare("DELETE FROM `bookings` WHERE booking_id = ?");
      $delete_messages->execute([$delete_id]);
      $success_msg[] = 'Message deleted!';
   }else{
      $warning_msg[] = 'MEssage deleted already!';
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
    <link rel="stylesheet" href="css/dashstyle.css">
</head>
<body>
<header>
    <div id="menu-bar" class="fas fa-bars"></div>
    <a class="logo"><span>G</span>ACHA HOTEL</a>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="userbook.php">Bookings</a>
        <a href="logout.php" onclick="return confirm('Do you want to logout from this website?');">Logout</a>
    </nav>
    </header>
    <section class="grid">
        <h1 class="heading">Bookings</h1>
        <div class="box-container">
            <?php
          $select_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ?");
          $select_bookings->execute([$username]); // Pass the logged-in user's email
           if($select_bookings->rowCount() > 0){
              while($fetch_bookings = $select_bookings->fetch(PDO::FETCH_ASSOC)){
        ?>
            <div class="box">
                    <p>Booking id : <span><?= $fetch_bookings['booking_id']; ?></span></p>
                    <p>Name : <span><?= $fetch_bookings['name']; ?></span></p>
                    <p>Email : <span><?= $fetch_bookings['email']; ?></span></p>
                    <p>Number : <span><?= $fetch_bookings['number']; ?></span></p>
                    <p>People: <span><?= $fetch_bookings['peoples']; ?></span></p>
                    <p>Check in : <span><?= $fetch_bookings['check_in']; ?></span></p>
                    <p>Check out : <span><?= $fetch_bookings['check_out']; ?></span></p>
                    <p>Single room : <span><?= $fetch_bookings['singleroom']; ?></span></p>
                    <p>Double room : <span><?= $fetch_bookings['doubleroom']; ?></span></p>
                    <p>VIP room : <span><?= $fetch_bookings['viproom']; ?></span></p>
                    <p>Total price: <span><?= $fetch_bookings['total_price']; ?></span></p>
                <form action="" method="POST">
                    <input type="hidden" name="delete_id" value="<?= $fetch_bookings['booking_id']; ?>">
                    <input type="submit" value="delete booking" onclick="return confirm('Delete this booking?');" name="delete" class="btn">
               </form>
              </div>
            <?php
                   }
                }else{           
            ?>
        <div class="box" style="text-align:center;">
        <p>No bookings avaible!</p>
        <p><?php echo $username?></p>
    </div>
            <?php
                }
            ?>
</div>
            </section>
</body>
</html>