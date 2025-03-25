<?php

include 'Database/compoment/connect.php';

error_reporting(0);
session_start();	
if(!isset($_SESSION["Username"]))
{
  $_SESSION["Username"]=$username;
  header("location:login.php");
}

$username = $_SESSION['id']; // Or $_S
if(isset($_POST['send'])){
  $id = create_unique_id();
  $name= $_POST['name'];
  $name=filter_var($name,FILTER_SANITIZE_STRING);
  $email=$_POST['email'];
  $email=filter_var($email,FILTER_SANITIZE_STRING);
  $number=$_POST['number'];
  $number=filter_var($number,FILTER_SANITIZE_STRING);
  $subject=$_POST['subject'];
  $subject=filter_var($subject,FILTER_SANITIZE_STRING);
  $message=$_POST['message'];
  $message=filter_var($message,FILTER_SANITIZE_STRING);
  
  $verify_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND subject = ? AND message = ?");
  $verify_message->execute([$name, $email, $number, $subject, $message]);

  if($verify_message->rowCount() > 0){
    $warning_msg[]= 'Message sent already!';
  }else{
    $insert_message = $conn->prepare("INSERT INTO `messages`(id, name, email, number, subject, message) VALUES(?,?,?,?,?,?)");
    $insert_message->execute([$id, $name, $email, $number, $subject, $message]);
    $success_msg[]="Message sent successfully!";
  }
}

?>


<!DOCTYPE html>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Khách sạn chúng tôi luôn chào đón những con nghiện và đớ thủ">
    <link rel="stylesheet" href="css/homestyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <title>GACHA HOTEL</title>
</head>
<body>
  <header>
    <div id="menu-bar" class="fas fa-bars"></div>
    <a href="index.php" class="logo"><span>G</span>ACHA HOTEL</a>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="booking.php">Booking</a>
        <a href="#rooms">Rooms</a>
        <a href="#service">Services</a>
        <a href="history.php">History</a>
        <a href="logout.php">Logout</a>
    </nav>
    </header>
    
<section class="home" id="home">
  <div class="content">
    <h3>Welcome to the most luxury experience you ever have</h3>
    <p>There a chance you will get a free vacation if you lucky!!!!</p>
  </div>
  <div class="controls">
    <span class="vid-btn active" data-src="image/view.mp4"></span>
    <span class="vid-btn" data-src="image/hotel.mp4"></span>
    <span class="vid-btn" data-src="image/room.mp4"></span>
    <span class="vid-btn" data-src="image/food.mp4"></span>
  </div>
  <div class="video-container">
    <video src="image/view.mp4" id="video-slider" loop autoplay muted></video>
  </div>
</section>
<section class="rooms" id="rooms">
  <h1 class="heading">
    <span>R</span>
    <span>O</span>
    <span>O</span>
    <span>M</span>
    <span>S</span>
  </h1>
  <div class="box-container">
    <div class="box">
      <img src="css/singleroom1.jpg" alt="">
      <div class="content">
        <h3>Single Room</h3>
        <p>Room for 1 person</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <div class="price">$40.00 - $50.00</div>
        <a href="SingleRoom.php" class="btn">Click For Details</a>
      </div>
    </div>
    <div class="box">
      <img src="css/droom1.jpg" alt="">
      <div class="content">
        <h3>Double Room</h3>
        <p>Room for 2 people</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <div class="price">$60.00 - $80.00</div>
        <a href="DoubleRoom.php" class="btn">Click For Details</a>
      </div>
    </div>
    <div class="box">
      <img src="css/vr1.jpg" alt="">
      <div class="content">
        <h3>VIP Room</h3>
        <p>TThe high luxury room can hold 3-4 people</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <div class="price">$100.00 - $150.00</div>
        <a href="VipRoom.php" class="btn">Click For Detail</a>
      </div>
    </div>
  </div>
</section>
<section class="service" id="service">
  <h1 class="heading">
    <span>S</span>
    <span>e</span>
    <span>r</span>
    <span>v</span>
    <span>i</span>
    <span>c</span>
    <span>e</span>
    <span>s</span>
  </h1>
<div class="box-container">
  <div class="box">
    <img src="image/food.jpg" alt="">
    <div class="content">
      <h3>Restaurant</h3>
      <p>Have variety of food and 100% safe</p>
      <a href="nhahang.php" class="btn">Click For Details</a>
    </div>
  </div>
  <div class="box">
    <img src="image/rock.jpg" alt="">
    <div class="content">
      <h3>Spa </h3>
      <p>Have fresh air and relax with our special rock massage! </p>
      <a href="spa.php" class="btn">Click For Details</a>
    </div>
  </div>
  <div class="box">
    <img src="image/betterrock.jpg" alt="">
    <div class="content">
      <h3>Fitness</h3>
      <p>Have friendly PT and all of thing you need to get muscles!!!</p>
      <a href="fitness.php" class="btn">Click For Details</a>
    </div>
  </div>
</div>
</section>
<?php

include 'Database/compoment/message.php';

?>
<section class="contact" id="contact">
  <h1 class="heading">
    <span>C</span>
    <span>o</span>
    <span>n</span>
    <span>t</span>
    <span>a</span>
    <span>c</span>
    <span>t</span>
  </h1>
  <div class="row">
    <div class="img">
      <img src="image/contact.jpg">
    </div>
    <form action="" method="post">
      <div class="inputBox">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
      </div>
      <div class="inputBox">
        <input type="text" name="number" placeholder="Phone Number" required>
        <input type="text" name="subject" placeholder="Subject" required>
      </div>
      <textarea placeholder="Message" name="message" cols="30" rows="10" required></textarea>
      <input type="submit" class="btn" name="send" value="Send Message">
    </form>
  </div>
</section>
<div class="footer">
  <div class="box-container">
    <div class="box">
      <h3>About Us</h3>
      <P>The customer happiness is our best motive</P>
    </div>
    <div class="box">
      <h3>Contact Information:</h3>
      <p>Phone number: 0123456789</p>
      <p>Address: 282 Sao Hỏa</p>
    </div>
    <div class="box">
      <a href="index.php">Home</a>
      <a href="booking.php">Booking</a>
      <a href="room.php">Rooms</a>
      <a href="service.php">Services</a>
    </div>
  </div>
</div>
</body>
</html>
<script><?php require("java/main.js");?></script>
