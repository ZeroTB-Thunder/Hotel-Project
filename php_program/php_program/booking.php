<?php
include 'Database/compoment/connect.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["book"])) {
    require_once "Database/compoment/connect.php"; // Kết nối database

    session_start();
    if (!isset($_SESSION["AccID"])) {
        echo "<script>alert('Please log in to make a booking.');</script>";
        exit();
    }

    $accID = $_SESSION["AccID"];

    $stmt = $conn->prepare("SELECT a.CustomerID, CONCAT(c.Ho, ' ', c.Ten) AS Name, c.Email, c.SDT 
                        FROM accounts a 
                        JOIN customers c ON a.CustomerID = c.CustomerID 
                        WHERE a.AccID = ?");
    $stmt->execute([$accID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $customerID = $user['CustomerID'];
        $customerName = $user['Name']; // Sẽ là sự kết hợp giữa Ho và Ten
        $customerEmail = $user['Email'];
        $customerPhone = $user['SDT'];
    } else {
        echo "<script>alert('User not found.');</script>";
        exit();
    }


  $rooms = []; // Khai báo biến từ đầu để tránh lỗi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $peoples = $_POST["peoples"];
    $checkIn = $_POST["check_in"];
    $checkOut = $_POST["check_out"];

    // Thực hiện truy vấn SQL
    $sql = "SELECT r.RoomID, r.RoomTypeID, r.RoomLocationID, r.RoomNumber, r.FloorID, r.RoomStatus, rp.FinalPrice 
            FROM room r
            JOIN RoomPrice rp ON r.RoomID = rp.RoomID
            LEFT JOIN booking b ON r.RoomID = b.RoomID 
                AND b.StartDate < ? 
                AND b.EndDate > ?
            WHERE r.RoomStatus = 'Available' 
            AND b.RoomID IS NULL";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$checkOut, $checkIn]);
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    $selectedRooms = isset($_POST["selected_rooms"]) ? $_POST["selected_rooms"] : [];
    $totalPrice = isset($_POST["total_price"]) ? $_POST["total_price"] : 0;


    if (empty($selectedRooms)) {
        echo "<script>alert('Please select at least one room!');</script>";
    } else {
        $roomIDs = implode(", ", $selectedRooms); // Biến này lưu các RoomID đã chọn
        echo "<script>alert('CustomerID: $customerID\nSelected RoomIDs: $roomIDs');</script>";
        try {
            $conn->beginTransaction();

            // Thêm từng phòng vào bảng Booking
            try {
                // Tạo mã booking duy nhất
                $bookingCode = 'BOOK' . strtoupper(bin2hex(random_bytes(4))); // Tạo mã booking ngẫu nhiên

                // Thêm từng phòng vào bảng Booking
                $stmt = $conn->prepare("INSERT INTO Booking (BookingCode, CustomerID, RoomID, StartDate, EndDate, Peoples, BookingStatus, PaymentStatus, TotalPrice, CreateAt) 
                               VALUES (?, ?, ?, ?, ?, ?, 'Pending', 'Unpaid', ?, NOW())");

                foreach ($selectedRooms as $roomID) {
                    $stmt->execute([$bookingCode, $customerID, $roomID, $checkIn, $checkOut, $peoples, $totalPrice]);
                    echo "<script>alert('Inserted Booking: BookingCode=$bookingCode, CustomerID=$customerID, RoomID=$roomID, Check-in=$checkIn, Check-out=$checkOut, Peoples=$peoples, TotalPrice=$totalPrice');</script>";
                }
            } catch (PDOException $e) {
                echo "<script>alert('Lỗi khi insert Booking: ');</script>" . $e->getMessage();
            }

            $conn->commit();
            echo "<script>alert('Booking successful!');</script>";
        } catch (Exception $e) {
            $conn->rollBack();
            echo "<script>alert('Booking failed: " . $e->getMessage() . "');</script>";
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

    <div class="background">
        <section class="reservation" id="reservation">
            <form action="" method="post">
                <h3>make a reservation</h3>
                <div class='flex'>
                    <div class="box">
                        <input type="text" id="book-name" name="name" maxlength="50" required class="input" onkeyup="validateName()">
                        <label for="name"><i class="fa-solid fa-user" style="color: #e45428;"></i> Your Name</label>
                        <span id="name-error"></span>
                    </div>
                    <div class="box">
                        <input type="email" id="book-email" name="email" maxlength="50" required class="input" onkeyup="validateEmail()">
                        <label for="email"><i class="fa-solid fa-envelope" style="color: #e45428;"></i> Your Email</label>
                        <span id="email-error"></span>
                    </div>
                    <div class="box">
                        <input type="numbere" id="book-number" name="number" required class="input" onkeyup="validateNumber()">
                        <label for="number"><i class="fa-solid fa-phone" style="color: #e45428;"></i> Your Number</label>
                        <span id="number-error"></span>
                    </div>
                    <div class="box">
                        <input type="string" id="book-peoples" name="peoples" maxlength="3" required class="input" onkeyup="validatePeoples()">
                        <label for="people"><i class="fa-solid fa-people-group" style="color: #e45428;"></i> Amount of People</label>
                        <span id="peoples-error"></span>
                    </div>
                    <div class="box">
                        <input type="date" id="book-checkin" name="check_in" class="input" required onkeyup="validateCheckin()" >
                        
                        <script>
                            var date = new Date();
                            sessionStorage.setItem("check_in", date);
                            var tdate = date.getDate();
                            if (tdate < 10) {
                                tdate = "0" + month;
                            }
                            var month = date.getMonth() + 1;
                            if (month < 10) {
                                month = "0" + month;
                            }
                            var year = date.getFullYear();
                            var minDate = year + "-" + month + "-" + tdate;
                            document.getElementById('book-checkin').setAttribute('min', minDate);
                        </script>
                        <label for="check_in" class="date1"><i class="fa-solid fa-calendar-days" style="color: #e45428;"></i> Check In</label>
                    </div>
                    <div class="box">
                        <input type="date" id="book-checkout" name="check_out" class="input"  required >
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                let checkInInput = document.getElementById("book-checkin");
                                let checkOutInput = document.getElementById("book-checkout");

                                // Đặt min cho check-in là ngày hôm nay
                                let today = new Date();
                                let todayStr = today.toISOString().split('T')[0];
                                checkInInput.setAttribute("min", todayStr);

                                checkInInput.addEventListener("change", function() {
                                    let checkInDate = new Date(this.value);
                                    if (!isNaN(checkInDate.getTime())) {
                                        let nextDay = new Date(checkInDate);
                                        nextDay.setDate(nextDay.getDate() + 1);
                                        checkOutInput.setAttribute("min", nextDay.toISOString().split('T')[0]);
                                        if (checkOutInput.value && new Date(checkOutInput.value) < nextDay) {
                                            checkOutInput.value = "";
                                        }
                                    }
                                });
                            });
                        </script>
                        <label for="check_out" class="date1"><i class="fa-solid fa-calendar-days" style="color: #e45428;"></i> Check Out</label>
                    </div>

                    <h2>Room Table with Prices</h2>

                        <div class="table-container">
                            <table id="roomTable">
                                <tr>
                                    <th>Room Type ID</th>
                                    <th>Room Location ID</th>
                                    <th>Room Number</th>
                                    <th>Floor ID</th>
                                    <th>Room Status</th>
                                    <th>Price</th>
                                    <th>Select</th>
                                </tr>
                                <?php
                                // Kết nối và truy vấn dữ liệu từ cơ sở dữ liệu
                                $sql = "SELECT r.RoomID, r.RoomTypeID, r.RoomLocationID, r.RoomNumber, r.FloorID, r.RoomStatus, rp.FinalPrice 
                    FROM room r
                    JOIN RoomPrice rp ON r.RoomID = rp.RoomID
                    where RoomStatus = 'Available'";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($rooms) {
                                    foreach ($rooms as $room) {
                                        echo "<tr>
                            <td>" . $room["RoomTypeID"] . "</td>
                            <td>" . $room["RoomLocationID"] . "</td>
                            <td>" . $room["RoomNumber"] . "</td>
                            <td>" . $room["FloorID"] . "</td>
                            <td>" . $room["RoomStatus"] . "</td>
                            <td>$" . $room["FinalPrice"] . "</td>
                        <td><input type='checkbox' name='selected_rooms[]' value='" . $room["RoomID"] . "' onchange='updateSelectedRooms()' class='room-checkbox' data-room-number='" . $room["RoomNumber"] . "'></td>
                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No data found</td></tr>";
                                }
                                ?>
                            </table>
                        </div>

                    <!-- Selected Rooms Section -->
                    <div class="selected-rooms">
                        <label class="select">Selected Rooms: </label>
                        <span id="selectedRoomsList">None</span>
                    </div>
                    <div class="total-price">
                        <label class="select">Total Price: </label>
                        <span id="totalPrice">$0.00</span>
                    </div>
                    <input type="hidden" name="total_price" id="total_price" value="0">
                </div>
                <span id="submit-error"></span>
                <input type="submit" value="book now" name="book" class="btn" onclick="someFunc()">
            </form>
        </section>
        <div id="booking-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Xác nhận đặt phòng</h2>
        <div id="booking-info"></div>
        <button id="confirm-btn">Xác nhận</button>
        <button id="cancel-btn">Hủy</button>
    </div>
</div>

        <script src="java/script.js"></script>
        <script>
            <?php require("java/booking.js"); ?>
        </script>
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
                <a href="room.php">Rooms</a>
                <a href="service.php">Services</a>
            </div>
        </div>
    </div>
</body>

</html>