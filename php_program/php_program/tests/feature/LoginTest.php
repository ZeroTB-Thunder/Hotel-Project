<?php

use PHPUnit\Framework\TestCase;

beforeEach(function () {
    $_SESSION = []; // Reset session trước mỗi test
    $_SERVER["REQUEST_METHOD"] = "POST"; // Giả lập POST request
});

test('Đăng nhập với tên đăng nhập và mật khẩu trống', function () {
    $_POST['Username'] = '';  // Chưa nhập tên đăng nhập
    $_POST['Password'] = '';  // Chưa nhập mật khẩu

    // Chạy file login.php
    ob_start();
    include __DIR__ . '/../../login.php';
    $output = ob_get_clean();

    // Kiểm tra xem có thông báo lỗi nào hay không
    expect($output)->toContain('Vui lòng nhập đầy đủ thông tin!');
});

test('Đăng nhập với tên đăng nhập trống', function () {
    $_POST['Username'] = '';  // Chưa nhập tên đăng nhập
    $_POST['Password'] = '123456';  // Chưa nhập mật khẩu

    // Chạy file login.php
    ob_start();
    include __DIR__ . '/../../login.php';
    $output = ob_get_clean();

    // Kiểm tra xem có thông báo lỗi nào hay không
    expect($output)->toContain('Tên đăng nhập bỏ trống');
});

test('Đăng nhập với mật khẩu trống', function () {
    $_POST['Username'] = 'abc';  // Chưa nhập tên đăng nhập
    $_POST['Password'] = '';  // Chưa nhập mật khẩu

    // Chạy file login.php
    ob_start();
    include __DIR__ . '/../../login.php';
    $output = ob_get_clean();

    // Kiểm tra xem có thông báo lỗi nào hay không
    expect($output)->toContain('Mật khẩu bỏ trống');
});



test('Đăng nhập tài khoản không tồn tại', function () {
    $_POST['Username'] = 'abc'; // Tên đăng nhập không đúng
    $_POST['Password'] = '123456'; // Mật khẩu không đúng

    // Chạy file login.php
    ob_start();
    include __DIR__ . '/../../login.php';
    $output = ob_get_clean();

    // Kiểm tra xem có thông báo lỗi "Sai tên đăng nhập hoặc mật khẩu!" hay không
    expect($output)->toContain('Sai tên đăng nhập hoặc mật khẩu!');
});

test('đăng nhập với quyền admin', function () {
    define('RUNNING_TEST', true);  // Xác định môi trường test

    $_POST['Username'] = 'admin1';  // Giả sử tài khoản admin1 là hợp lệ
    $_POST['Password'] = '123456';  // Mật khẩu hợp lệ

    // Chạy file login.php
    ob_start();
    include __DIR__ . '/../../login.php';
    $output = ob_get_clean();

    // Kiểm tra xem thông báo thành công có xuất hiện không
    expect($output)->toContain('Đăng nhập thành công');

    // Kiểm tra xem header có bị gửi hay không (chắc chắn là không)
    expect(headers_sent())->toBeFalse();
});

test('đăng nhập với quyền khách hàng', function () {
    if (!defined('RUNNING_TEST')) {
        define('RUNNING_TEST', true);  // Xác định môi trường test nếu chưa được định nghĩa
    }  // Xác định môi trường test

    $_POST['Username'] = 'khachhang1';  // Giả sử tài khoản admin1 là hợp lệ
    $_POST['Password'] = '123456';  // Mật khẩu hợp lệ

    // Chạy file login.php
    ob_start();
    include __DIR__ . '/../../login.php';
    $output = ob_get_clean();

    // Kiểm tra xem thông báo thành công có xuất hiện không
    expect($output)->toContain('Đăng nhập thành công');

    // Kiểm tra xem header có bị gửi hay không (chắc chắn là không)
    expect(headers_sent())->toBeFalse();
});

test('đăng nhập với quyền khách hàng và tên đăng nhập có ký tự đặc biệt', function () {
    if (!defined('RUNNING_TEST')) {
        define('RUNNING_TEST', true);  // Xác định môi trường test nếu chưa được định nghĩa
    }  // Xác định môi trường test

    $_POST['Username'] = 'Nguyen@';  // Giả sử tài khoản admin1 là hợp lệ
    $_POST['Password'] = '123456';  // Mật khẩu hợp lệ

    // Chạy file login.php
    ob_start();
    include __DIR__ . '/../../login.php';
    $output = ob_get_clean();

    // Kiểm tra xem thông báo thành công có xuất hiện không
    expect($output)->toContain('Đăng nhập thành công');

    // Kiểm tra xem header có bị gửi hay không (chắc chắn là không)
    expect(headers_sent())->toBeFalse();
});

test('đăng nhập với quyền khách hàng và tên đăng nhập có ký tự đặc biệt tài khoản không tồn tại', function () {
    if (!defined('RUNNING_TEST')) {
        define('RUNNING_TEST', true);  // Xác định môi trường test nếu chưa được định nghĩa
    }  // Xác định môi trường test

    $_POST['Username'] = 'Nguyen@';  // Giả sử tài khoản admin1 là hợp lệ
    $_POST['Password'] = '123456';  // Mật khẩu hợp lệ

    // Chạy file login.php
    ob_start();
    include __DIR__ . '/../../login.php';
    $output = ob_get_clean();

    // Kiểm tra xem thông báo thành công có xuất hiện không
    expect($output)->toContain('Đăng nhập thành công');

    // Kiểm tra xem header có bị gửi hay không (chắc chắn là không)
    expect(headers_sent())->toBeFalse();
});
?>
