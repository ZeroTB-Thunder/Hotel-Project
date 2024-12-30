<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doubel Room Details</title>
    <link rel="stylesheet" href="css/detailstyle.css">
    <script src="https://kit.fontawesome.com/2f354ed672.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>
<body style="background-color:#C4C396">
<header>
    <div id="menu-bar" class="fas fa-bars"></div>
    <a href="index.php" class="logo"><span>G</span>ACHA HOTEL</a>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="booking.php">Booking</a>
        <a href="room.php">Rooms</a>
        <a href="mainservice.php">Services</a>
        <a href="login.php">Logout</a>
    </nav>
    </header>
    <section class="gallery" id="gallery">
        <div class="swiper gallery-slider">
            <div class="swiper-wrapper">
                <img src="css/droom1.jpg" class="swiper-slide" alt="">
                <img src="css/droom2.jpg" class="swiper-slide" alt="">
                <img src="css/droom3.jpg" class="swiper-slide" alt="">
                <img src="css/droom4.jpg" class="swiper-slide" alt="">
                <img src="css/droom5.jpg" class="swiper-slide" alt="">
                <img src="css/droom6.jpg" class="swiper-slide" alt="">
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>
    <script>
  var swiper = new Swiper(".gallery-slider",{
    loop:true,
    effect: "coverflow",
    centeredSlides: true,
    grabCursor:true,
    coverflowEffect:{
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        sliderShadows: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
});
   </script>
 
    <div class="main">
        <section class="room-detail">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="room-content">
                            <div class="room-name">
                                <div class="inner">
                                    <h3 class="room-title">Double room</h3>
                                    <div class="room-caption">
                                        <span style="color:rgb(101, 101, 101)">Room features</span>
                                    </div>
                                    <div class="room-price">
                                        <div class="price-head">
                                            <span class="price-head">From</span>
                                            <span class="price-value" style="text-decoration: line-through;">$55 / Night</span>
                                            <span class="price-value" style="color:red">$42.35/ Night</span>
                                        </div>
                                    </div>
                                    <div class="book-button">
                                    <a href="booking.php"><input type="submit" class="btn" value="Book now"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="room-service">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="inner">
                                            <div class="icon">
                                                <i class="fa-solid fa-bed" style="color: #e45428;"></i>
                                            </div>
                                            <div class="content">
                                                <h3>Bed</h3>
                                                <span><i class="fa-solid fa-gem"></i> 1 Double bed</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="inner">
                                            <div class="icon">
                                                <i class="fa-solid fa-users-line" style="color: #e45428;"></i>
                                            </div>
                                            <div class="content">
                                                <h3>Max guest</h3>
                                                <span><i class="fa-solid fa-gem"></i> 2 Guests</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="inner">
                                            <div class="icon">
                                                <i class="fa-solid fa-maximize" style="color: #e45428;"></i>
                                            </div>
                                            <div class="content">
                                                <h3>Room space</h3>
                                                <span><i class="fa-solid fa-gem"></i> 16m<sup>2</sup></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="inner">
                                            <div class="icon">                                              
                                                <i class="fa-solid fa-city" style="color: #e45428;"></i>
                                            </div>
                                            <div class="content">
                                                <h3>Room view</h3>
                                                <span><i class="fa-solid fa-gem"></i> City view</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                         
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>  
    <div class="desc">
        <p></p>
        <p style="text-align: justify;">
            Warmth, luxury and peace meet you in our charming comfort double room. In addition to the plush beds, the room (16 m²) is equipped with all amenities the Amsterdam Forest Hotel has to offer.

            From docking station to Nespresso machine with free coffee and tea and from rain shower to room service. In short, everything for a lovely stay on the edge of the Amsterdam Forest.
        </p>
        <p></p>
    </div>
    <div class="room-stuff">
        <div class="room-amenities">
            <h3 class="title">
                room amenities
            </h3>
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <div class="inner1">
                        <div class="icon1">
                            <i class="fa-solid fa-wifi"></i>
                        </div>
                        <div class="icon-wrap">
                            <h4 data-text="&nbsp;Wifi&nbsp;">&nbsp;Wifi&nbsp;</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="inner1">
                        <div class="icon1">
                            <i class="fa-solid fa-wind"></i>
                        </div>
                        <div class="icon-wrap">
                            <h4 data-text="&nbsp;Air Conditioner&nbsp;">&nbsp;Air Conditioner&nbsp;</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="inner1">
                        <div class="icon1">
                            <i class="fa-solid fa-shower"></i>
                        </div>
                        <div class="icon-wrap">
                            <h4 data-text="&nbsp;Shower&nbsp;">&nbsp;Shower&nbsp;</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="inner1">
                        <div class="icon1">
                            <i class="fa-solid fa-vault"></i>
                        </div>
                        <div class="icon-wrap">
                            <h4 data-text="&nbsp;Safe&nbsp;">&nbsp;Safe&nbsp;</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="inner1">
                        <div class="icon1">
                            <i class="fa-solid fa-bell-concierge"></i>
                        </div>
                        <div class="icon-wrap">
                            <h4 data-text="&nbsp;24/7 Service&nbsp;">&nbsp;24/7 Service&nbsp;</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="inner1">
                        <div class="icon1">
                            <i class="fa-solid fa-tv"></i>
                        </div>
                        <div class="icon-wrap">
                            <h4 data-text="&nbsp;Smart TV&nbsp;">&nbsp;Smart TV&nbsp;</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="inner1">
                        <div class="icon1">
                            <i class="fa-solid fa-mug-hot"></i>
                        </div>
                        <div class="icon-wrap">
                            <h4 data-text="&nbsp;Free Coffee/Tea&nbsp;">&nbsp;Free Coffee/Tea&nbsp;</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="inner1">
                        <div class="icon1">
                            <i class="fa-solid fa-gamepad"></i>
                        </div>
                        <div class="icon-wrap">
                            <h4 data-text="&nbsp;PC/Console&nbsp;">&nbsp;PC/Console&nbsp;</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="room-rule">
        <div class="rule"></div>
        <h3 class="title">
            Hotel Rules
        </h3>
               <ul class="list-rules">
                    <li>
                         Smoking not allowed
                    </li>
                    <li>
                         Pets not allowed
                    </li>
                    <li>
                         Swimming pool closed from 8.00pm - 6.00am
                    </li>
                    <li>
                         Spa closed from 12.00pm - 6.00am
                   </li>
                    <li>
                         Gaming center open 24/7
                    </li>
               </ul>
</div>
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
      <a href="room.php" >Rooms</a>
      <a href="service.php">Services</a>
    </div>
  </div>
</div>
   </body>
</html>