                <!-- database-->
                <?php

include 'Database/compoment/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    setcookie('user_id', create_unique_id(), time() + 60*60*24*30, '/');
    header('location:booking.php');
 }

 if(isset($_POST['cancel'])){

    $booking_id = $_POST['booking_id'];
    $booking_id = filter_var($booking_id, FILTER_SANITIZE_STRING);
 
    $verify_booking = $conn->prepare("SELECT * FROM `bookings` WHERE booking_id = ?");
    $verify_booking->execute([$booking_id]);
 
    if($verify_booking->rowCount() > 0){
       $delete_booking = $conn->prepare("DELETE FROM `bookings` WHERE booking_id = ?");
       $delete_booking->execute([$booking_id]);
       $success_msg[] = 'Booking cancelled successfully!';
    }else{
       $warning_msg[] = 'Booking cancelled already!';
    }
    
 }
 
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GACHA HOTEL</title>
    <link rel="stylesheet" href="css/bookstyle.css">   
    <script src="https://kit.fontawesome.com/2f354ed672.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&family=Oswald:wght@500&display=swap" rel="stylesheet">
</head>
<body>

     <!-- database-->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweeta0lert.min.js"></script>
     <?php 
    include 'Database/compoment/message.php'
    ?>
     <!-- database-->
        <section class="mybookings">
            <h1 class="heading">My bookings</h1>
            <div class="box-container">
            <?php
      $select_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ?");
      $select_bookings->execute([$user_id]);
      if($select_bookings->rowCount() > 0){
         while($fetch_booking = $select_bookings->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Name : <span><?= $fetch_booking['name']; ?></span></p>
      <p>Email : <span><?= $fetch_booking['email']; ?></span></p>
      <p>Number : <span><?= $fetch_booking['number']; ?></span></p>
      <p>Check in : <span><?= $fetch_booking['check_in']; ?></span></p>
      <p>Check out : <span><?= $fetch_booking['check_out']; ?></span></p>
      <p>Peoples : <span><?= $fetch_booking['peoples']; ?></span></p>
      <p>Single room : <span><?= $fetch_booking['singleroom']; ?></span></p>
      <p>Double room : <span><?= $fetch_booking['doubleroom']; ?></span></p>
      <p>VIP room : <span><?= $fetch_booking['viproom']; ?></span></p>
      <p>booking id : <span><?= $fetch_booking['booking_id']; ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="booking_id" value="<?= $fetch_booking['booking_id']; ?>">
         <input type="submit" value="cancel booking" name="cancel" class="btn" onclick="return confirm('Cancel this booking?');">
      </form>
   </div>
   <?php
    }
   }else{
   ?>   
   <div class="box" style="text-align: center;">
      <p style="padding-bottom: .5rem; text-transform:capitalize;">no bookings found!</p>
      <a href="booking.php" class="btn" >book new</a>
   </div>
   <?php
   }
   ?>
   </div>
        </section>







   

</body>
</html>
