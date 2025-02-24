<?php

use function Pest\Laravel\postJson;

beforeEach(function () {
    // Tạo database test
    $this->conn = new PDO("mysql:host=localhost;dbname=hotel_db", "root", "");
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tạo dữ liệu phòng có sẵn
    $this->conn->exec("INSERT INTO room (room_id, is_free, room_type) VALUES 
        (1, 'Available', 1),
        (2, 'Available', 2),
        (3, 'Available', 3)");
});

test('Đặt phòng thành công', function () {
    setcookie('user_id', 'test_user_123', time() + 60*60*24*30, '/');

    $response = postJson('/booking.php', [
        'name' => 'Nguyen Van A',
        'email' => 'nguyenvana@example.com',
        'number' => '0123456789',
        'peoples' => 2,
        'check_in' => '2025-02-15',
        'check_out' => '2025-02-20',
        'selected_floor' => 1,
        'singleroom' => 1,
        'doubleroom' => 1,
        'viproom' => 0,
        'book' => true
    ]);

    $response->assertStatus(200)
             ->assertJson(['status' => 'Room booked already!']);
});

test('Báo lỗi khi phòng không đủ', function () {
    setcookie('user_id', 'test_user_456', time() + 60*60*24*30, '/');

    // Yêu cầu quá số phòng hiện có
    $response = postJson('/booking.php', [
        'name' => 'Tran Thi B',
        'email' => 'tranthib@example.com',
        'number' => '0987654321',
        'peoples' => 4,
        'check_in' => '2025-02-15',
        'check_out' => '2025-02-20',
        'selected_floor' => 1,
        'singleroom' => 5, // Quá số lượng phòng có sẵn
        'doubleroom' => 5,
        'viproom' => 2,
        'book' => true
    ]);

    $response->assertStatus(400)
             ->assertJson(['status' => 'error', 'message' => 'Rooms are not available']);
});

test('Báo lỗi khi trùng đặt phòng', function () {
    setcookie('user_id', 'test_user_789', time() + 60*60*24*30, '/');

    // Đặt phòng lần đầu
    postJson('/booking.php', [
        'name' => 'Le Van C',
        'email' => 'levanc@example.com',
        'number' => '0345678901',
        'peoples' => 2,
        'check_in' => '2025-02-15',
        'check_out' => '2025-02-20',
        'selected_floor' => 1,
        'singleroom' => 1,
        'doubleroom' => 1,
        'viproom' => 0,
        'book' => true
    ]);

    // Thử đặt phòng lần thứ hai với cùng thông tin
    $response = postJson('/booking.php', [
        'name' => 'Le Van C',
        'email' => 'levanc@example.com',
        'number' => '0345678901',
        'peoples' => 2,
        'check_in' => '2025-02-15',
        'check_out' => '2025-02-20',
        'selected_floor' => 1,
        'singleroom' => 1,
        'doubleroom' => 1,
        'viproom' => 0,
        'book' => true
    ]);

    $response->assertStatus(400)
             ->assertJson(['status' => 'error', 'message' => 'Room booked already!']);
});
