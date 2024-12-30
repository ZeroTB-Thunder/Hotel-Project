<!DOCTYPE html>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Khách sạn chúng tôi luôn chào đón những con nghiện và đớ thủ">
    <link rel="stylesheet" href="css/roomstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <title>GACHA HOTEL</title>
</head>
<body style="background-color: #E8E8E2">
<header>
    <div id="menu-bar" class="fas fa-bars"></div>
    <a href="index.php" class="logo"><span>G</span>ACHA HOTEL</a>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="booking.php">Booking</a>
        <a href="room.php">Rooms</a>
        <a href="mainservice.php">Services</a>
        <a href="login.php">Admin Login</a>
    </nav>
    </header>
<section class="rooms" id="rooms">
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
        <div class="price">$20.0 - $25.00</div>
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
        <div class="price">$40.00 - $55.00</div>
        <a href="DoubleRoom.php" class="btn">Click For Details</a>
      </div>
    </div>
    <div class="box">
      <img src="css/vr1.jpg" alt="">
      <div class="content">
        <h3>VIP Room</h3>
        <p>The high luxury room can hold 3-4 people </p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <div class="price">$100.00 - $125.00</div>
        <a href="VipRoom.php" class="btn">Click For Detail</a>
      </div>
    </div>
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