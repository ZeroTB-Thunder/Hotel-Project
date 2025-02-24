<?php
include __DIR__ . '/compoment/connect.php';

header('Content-Type: application/json');

// Kiểm tra và lấy FloorID từ URL
$floorID = isset($_GET['FloorID']) ? intval($_GET['FloorID']) : 1;

// Câu truy vấn lấy các phòng thuộc FloorID
$sql = "SELECT RoomID, RoomTypeID, RoomLocationID, FloorID, RoomNumber, RoomStatus, RoomImage 
        FROM room 
        WHERE FloorID = :floorID";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':floorID', $floorID, PDO::PARAM_INT);
$stmt->execute();

$rooms = array();
if ($stmt->rowCount() > 0) {
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode($rooms);

$conn = null;
?>
