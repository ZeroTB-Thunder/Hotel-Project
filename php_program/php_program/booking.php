<?php
include 'Database/compoment/connect.php';

// Ensure that `user_id` exists in the cookies or create it.
if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
} else {
    setcookie('user_id', create_unique_id(), time() + 60*60*24*30, '/');
    header('location:booking.php');
    exit();
}

// Initialize $check_in and $check_out to avoid undefined variable warnings
$check_in = isset($_POST['check_in']) ? $_POST['check_in'] : null;
$check_out = isset($_POST['check_out']) ? $_POST['check_out'] : null;

// Initialize $selected_floor and room variables to avoid undefined variable warnings
$selected_floor = isset($_POST['selected_floor']) ? $_POST['selected_floor'] : 1; // Default to floor 1
$singleroom = isset($_POST['singleroom']) ? $_POST['singleroom'] : 0;
$doubleroom = isset($_POST['doubleroom']) ? $_POST['doubleroom'] : 0;
$viproom = isset($_POST['viproom']) ? $_POST['viproom'] : 0;

// Season price query
$season_query = "SELECT * FROM seasonal_prices WHERE start_date <= ? AND end_date >= ?";
$stmt = $conn->prepare($season_query);
$stmt->execute([$check_in, $check_out]);
$season_data = $stmt->fetch(PDO::FETCH_ASSOC);

$season_multiplier_single = 1;
$season_multiplier_double = 1;
$season_multiplier_vip = 1;

if ($season_data) {
    $season_multiplier_single = $season_data['single_room_multiplier'];
    $season_multiplier_double = $season_data['double_room_multiplier'];
    $season_multiplier_vip = $season_data['vip_room_multiplier'];
}

// Floor price query
$floor_query = "SELECT * FROM floor_prices WHERE floor = ?";
$stmt = $conn->prepare($floor_query);
$stmt->execute([$selected_floor]);
$floor_data = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if floor data is fetched
if ($floor_data) {
    echo "Floor Data: ";
    var_dump($floor_data);  // Display fetched floor data

    $floor_extra_single = $floor_data['single_room_extra'];
    $floor_extra_double = $floor_data['double_room_extra'];
    $floor_extra_vip = $floor_data['vip_room_extra'];
} else {
    // If no data, use default values
    $floor_extra_single = 0;
    $floor_extra_double = 0;
    $floor_extra_vip = 0;

    echo "No floor data found for floor " . $selected_floor;
}

// Room base prices
$base_single_price = 25;
$base_double_price = 55;
$base_vip_price = 125;

// Calculate final prices
$final_single_price = $base_single_price * $season_multiplier_single + $floor_extra_single;
$final_double_price = $base_double_price * $season_multiplier_double + $floor_extra_double;
$final_vip_price = $base_vip_price * $season_multiplier_vip + $floor_extra_vip;

$total_price = 0;

// Calculate total price for the rooms
$total_price += $singleroom * $final_single_price;
$total_price += $doubleroom * $final_double_price;
$total_price += $viproom * $final_vip_price;

if (isset($_POST['book'])) {
    $booking_id = create_unique_id();
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
    $peoples = filter_var($_POST['peoples'], FILTER_SANITIZE_STRING);

    // Check room availability
    $sroom = "SELECT room_id, is_free FROM room WHERE is_free ='Available' AND room_type='1'";
    $droom = "SELECT room_id, is_free FROM room WHERE is_free ='Available' AND room_type='2'";
    $vroom = "SELECT room_id, is_free FROM room WHERE is_free ='Available' AND room_type='3'";

    $result1 = $conn->query($sroom);
    $result2 = $conn->query($droom);
    $result3 = $conn->query($vroom);

    $e1 = $singleroom;
    $e2 = $doubleroom;
    $e3 = $viproom;

    // If there are not enough rooms, show a warning message
    if ($singleroom > $result1->rowCount() || $doubleroom > $result2->rowCount() || $viproom > $result3->rowCount()) {
        $warning_msg[] = 'Rooms are not available';
    } else {
        // Check for duplicate booking
        $verify_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id =? AND name = ? AND email = ? AND number = ? AND peoples = ? AND check_in = ? AND check_out= ? AND singleroom = ? AND doubleroom = ? AND viproom = ?");
        $verify_bookings->execute([$user_id, $name, $email, $number, $peoples, $check_in, $check_out, $singleroom, $doubleroom, $viproom]);
        
        if ($verify_bookings->rowCount() > 0) {
            $warning_msg[] = 'Room booked already!';
        } else {
            // Insert the booking record into the database
            $book_room = $conn->prepare("INSERT INTO `bookings` (booking_id, user_id, name, email, number, peoples, check_in, check_out, singleroom, doubleroom, viproom, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $book_room->execute([$booking_id, $user_id, $name, $email, $number, $peoples, $check_in, $check_out, $singleroom, $doubleroom, $viproom, $total_price]);

            // Update room availability
            while ($e1 != 0) {
                $updates = "UPDATE room SET is_free='Busy' WHERE is_free ='Available' AND room_type='1' order by room_id LIMIT 1";
                $result = $conn->query($updates);
                $stmt1 = $conn->prepare($updates);
                $stmt1->execute();
                $e1--;
            }
            while ($e2 != 0) {
                $updated = "UPDATE room SET is_free='Busy' WHERE is_free ='Available' AND room_type='2' order by room_id LIMIT 1";
                $result = $conn->query($updated);
                $stmt1 = $conn->prepare($updated);
                $stmt1->execute();
                $e2--;
            }
            while ($e3 != 0) {
                $updatev = "UPDATE room SET is_free='Busy' WHERE is_free ='Available' AND room_type='3' order by room_id LIMIT 1";
                $result = $conn->query($updatev);
                $stmt1 = $conn->prepare($updatev);
                $stmt1->execute();
                $e3--;
            }

            $success_msg[] =  'Room booked successfully!';
        }
    }
}
?>


 <!-- database-->

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
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php 
    include 'Database/compoment/message.php'
    ?>
     <!-- database-->
     
     <header>
    <div id="menu-bar" class="fas fa-bars"></div>
    <a href="index.php" class="logo"><span>G</span>ACHA HOTEL</a>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="booking.php">Booking</a>
        <a href="userbook.php">History</a>
        <a href="login.php">Logout</a>
    </nav>
    </header>

        <div class="background" >
    <section class ="reservation" id = "reservation">
        <form action="" method="post" >
            <h3>make a reservation</h3>
            <div class ='flex'>
                <div class="box">
                    <input type="text" id="book-name" name="name" maxlength="50" required  class="input" onkeyup="validateName()">       
                    <label for="name"><i class="fa-solid fa-user" style="color: #e45428;"></i> Your Name</label>
                    <span id="name-error"></span>          
                </div>
                <div class ="box">
                    <input type="email" id="book-email" name="email" maxlength="50" required  class="input" onkeyup="validateEmail()">
                    <label for="email"><i class="fa-solid fa-envelope" style="color: #e45428;"></i> Your Email</label>
                    <span id="email-error"></span>   
                </div>
                <div class="box">
                    <input type="numbere" id="book-number" name="number"   required  class="input" onkeyup="validateNumber()">
                    <label for="number"><i class="fa-solid fa-phone" style="color: #e45428;"></i> Your Number</label>
                    <span id="number-error"></span>  
                </div> 
                <div class="box">
                    <input type="string" id="book-peoples" name="peoples"  maxlength="3"  required  class="input" onkeyup="validatePeoples()">
                    <label for="people"><i class="fa-solid fa-people-group" style="color: #e45428;"></i> Amount of People</label>
                    <span id="peoples-error"></span>  
                </div>             
                <div class="box">
                    <input type="date"  id="book-checkin" name="check_in" class="input" required onkeyup="validateCheckin()">
                    <script>
                         var date = new Date();
                         sessionStorage.setItem("check_in", date);
                         var tdate = date.getDate();
                         if(tdate < 10){
                            tdate = "0" + month;
                                       }
                            var month = date.getMonth() + 1;
                         if(month < 10){
                            month = "0" + month;
                                       }
                        var year = date.getFullYear();
                        var minDate = year + "-" + month + "-" + tdate;
                        document.getElementById('book-checkin').setAttribute('min',minDate);
                    </script>
                    <label for="check_in" class="date1" ><i class="fa-solid fa-calendar-days" style="color: #e45428;"></i> Check In</label>
                </div>
                <div class="box">
                    <input type="date" id="book-checkout" name="check_out" class="input" required>
                    <script>
                         var date = sessionStorage.getItem("check_in");
                         console.log(date);
                         var tdate = date.getDate();
                         if(tdate < 10){
                            tdate = "0" + month;
                                       }
                            var month = date.getMonth() + 1;
                         if(month < 10){
                            month = "0" + month;
                                       }
                        var year = date.getFullYear();
                        var minDate = year + "-" + month + "-" + tdate ;
                        document.getElementById('book-checkout').setAttribute('min',minDate);
                    </script>
                    <label for="check_out" class="date1"><i class="fa-solid fa-calendar-days" style="color: #e45428;"></i> Check Out</label>
                </div>

                <!-- table -->
                 <!-- database-->
                 <div class="error-table"><span class="rooms" id="room-error"></span> </div>
                <div class="boxb">
                   <table class="HotelB">
                    <tbody>
                        <tr>
                            <th class="td-name">
                                <strong>Rooms Type</strong>
                            </th>
                            <th class="td-price">
                                <strong>Price Night</strong>
                            </th>
                            <th class="td-max">
                                <strong>People</strong>
                            </th>
                            <th class="td-pricenet">
                                <strong>Sale Off</strong>
                            </th>
                            <th class="td-select">
                                <strong>Number</strong>
                            </th>
                        </tr>
                        <tr>
                            <td class="td-name">
                                <strong>Single room</strong>
                            </td>
                            <td class="td-price">
                                <strong>25$</strong>
                            </td>
                            <td class="td-max">
                                <strong>1 people</strong>
                            </td>
                            <td class="td-pricenet">
                                <strong>20%</strong>
                            </td>
                            <td class="td-select">
                                <input type="number" id="sroom" name="singleroom" min="0" value="0" class="booking_room" required onchange="validateroom()">
                            </td>
                        </tr>
                        <tr>
                            <td class="td-name">
                                <strong>Double room</strong>
                            </td>
                            <td class="td-price">
                                <strong>55$</strong>
                            </td>
                            <td class="td-max">
                                <strong>1-2 people</strong>
                            </td>
                            <td class="td-pricenet">
                                <strong>23%</strong>
                            </td>
                            <td class="td-select">
                                <input type="number" id="droom" name="doubleroom"  min="0" value="0" class="booking_room" required onchange="validateroom()">
                                <span id="doubleroom-error"></span> 
                            </td>
                        </tr>
                        <tr>
                            <td class="td-name">
                                <strong>Vip room</strong>
                            </td>
                            <td class="td-price">
                                <strong>125$</strong>
                            </td>
                            <td class="td-max">
                                <strong>1-4 people</strong>
                            </td>
                            <td class="td-pricenet">
                                <strong>25%</strong>
                            </td>
                            <td class="td-select">
                                <input type="number" id="vroom" name="viproom" min="0" value="0" class="booking_room"required onchange="validateroom()" >
                                <span id="viproom-error"></span> 
                            </td>
                        </tr>
                         <!-- database-->
                    </tbody>
                   </table>
                </div>
                <!-- Note -->
                <div class="box1">
                    <textarea name="note" class="note" id="note" maxlength="500" cols="30" rows="10"></textarea>
                    <label for="note" ><i class="fa-solid fa-note-sticky" style="color: #e45428;"></i></i> Note</label>
                </div>
            </div>
            <span id="submit-error"></span>
        <input type="submit" value="book now" name="book" class="btn" onclick="someFunc()">
        </form>
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
<script src="java/script.js"></script>
</body>
</html>
