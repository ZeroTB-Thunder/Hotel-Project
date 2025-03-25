<?php
use PHPUnit\Framework\TestCase;

class BookingDateTest extends TestCase
{
    protected function setUp(): void
    {
        $_POST = [];
        $_SESSION = [];
    }

    public function testCheckInValidation()
    {
        // Mock current date as 2023-06-15
        $fixedDate = new DateTime('2023-06-15');
        $this->mockGlobalDate($fixedDate);

        // Simulate form submission with valid check-in date
        $_POST['check_in'] = '2023-06-16';
        $_POST['check_out'] = '2023-06-18';
        
        $booking = new Booking();
        $result = $booking->validateDates($_POST['check_in'], $_POST['check_out']);
        
        $this->assertTrue($result['valid']);
    }

    public function testCheckInBeforeToday()
    {
        // Mock current date as 2023-06-15
        $fixedDate = new DateTime('2023-06-15');
        $this->mockGlobalDate($fixedDate);

        // Simulate form submission with check-in in the past
        $_POST['check_in'] = '2023-06-14';
        $_POST['check_out'] = '2023-06-16';
        
        $booking = new Booking();
        $result = $booking->validateDates($_POST['check_in'], $_POST['check_out']);
        
        $this->assertFalse($result['valid']);
        $this->assertEquals('Check-in date cannot be before today', $result['message']);
    }

    public function testCheckOutBeforeCheckIn()
    {
        // Mock current date as 2023-06-15
        $fixedDate = new DateTime('2023-06-15');
        $this->mockGlobalDate($fixedDate);

        // Simulate invalid date range
        $_POST['check_in'] = '2023-06-16';
        $_POST['check_out'] = '2023-06-15';
        
        $booking = new Booking();
        $result = $booking->validateDates($_POST['check_in'], $_POST['check_out']);
        
        $this->assertFalse($result['valid']);
        $this->assertEquals('Check-out date must be after check-in date', $result['message']);
    }

    public function testMinimumStayRequirement()
    {
        // Mock current date as 2023-06-15
        $fixedDate = new DateTime('2023-06-15');
        $this->mockGlobalDate($fixedDate);

        // Simulate stay shorter than minimum requirement
        $_POST['check_in'] = '2023-06-16';
        $_POST['check_out'] = '2023-06-16'; // Same day
        
        $booking = new Booking();
        $result = $booking->validateDates($_POST['check_in'], $_POST['check_out']);
        
        $this->assertFalse($result['valid']);
        $this->assertEquals('Minimum stay is 1 night', $result['message']);
    }

    private function mockGlobalDate(DateTime $date)
    {
        // This function would mock the global date/time for testing
        // Implementation depends on your date handling approach
        // For example, you might use a DateService that can be mocked
    }
}

class Booking
{
    public function validateDates($checkIn, $checkOut)
    {
        $today = new DateTime();
        $checkInDate = DateTime::createFromFormat('Y-m-d', $checkIn);
        $checkOutDate = DateTime::createFromFormat('Y-m-d', $checkOut);

        if (!$checkInDate || !$checkOutDate) {
            return ['valid' => false, 'message' => 'Invalid date format'];
        }

        // Check if check-in is before today
        if ($checkInDate < $today) {
            return ['valid' => false, 'message' => 'Check-in date cannot be before today'];
        }

        // Check if check-out is before or equal to check-in
        if ($checkOutDate <= $checkInDate) {
            return ['valid' => false, 'message' => 'Check-out date must be after check-in date'];
        }

        // Check minimum stay requirement (at least 1 night)
        $interval = $checkInDate->diff($checkOutDate);
        if ($interval->days < 1) {
            return ['valid' => false, 'message' => 'Minimum stay is 1 night'];
        }

        return ['valid' => true, 'message' => ''];
    }
}
?>