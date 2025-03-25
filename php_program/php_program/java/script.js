var nameError = document.getElementById('name-error');
var emailError = document.getElementById('email-error');
var numberError = document.getElementById('number-error');
var peoplesError = document.getElementById('peoples-error');
var submitError = document.getElementById('submit-error');
var roomError = document.getElementById('room-error');

function validateName(){
    var name = document.getElementById('book-name').value;

    if(name.length == 0){
        nameError.innerHTML = 'Name is required!';
        return false;
    }
    
    nameError.innerHTML = '<i class="fa-solid fa-square-check" style="color: #58f514;"></i>';
    return true;
}

function validateEmail(){
    var email = document.getElementById('book-email').value;

    if (email.length == 0){
        emailError.innerHTML = 'Email is required!';
        return false;
    }
    if (!email.match(/^[A-Za-z\._\-[0-9]*[@][A-Za-z]*[\.][a-z]{2,4}$/)){
        emailError.innerHTML = 'Email Invalid!';
        return false;
    }

    emailError.innerHTML = '<i class="fa-solid fa-square-check" style="color: #58f514;"></i>';
    return true;
}

function validateNumber(){
    var number = document.getElementById('book-number').value;

    if (number.length == 0){
        numberError.innerHTML = 'Number is required!';
        return false;
    }
    if (number.length != 10){
        numberError.innerHTML = 'Number must be 10 digits!';
        return false;
    }
    if (!number.match(/^[0-9]{10}$/)){
        numberError.innerHTML = 'Number digit must be 0-9!';
        return false;
    }
    
    numberError.innerHTML = '<i class="fa-solid fa-square-check" style="color: #58f514;"></i>';
    return true;
}

function validatePeoples(){
    var peoples = document.getElementById('book-peoples').value;

    if (peoples.length == 0){
        peoplesError.innerHTML = 'Peoples is required!';
        return false;
    }
    if (!peoples.match(/^[0-9]{1,3}$/)){
        peoplesError.innerHTML = 'Peoples must be number!';
        return false;
    }  
    peoplesError.innerHTML = '<i class="fa-solid fa-square-check" style="color: #58f514;"></i>';
    return true;
}



function validateForm(){
    if(!validateName() || !validateNumber() || !validateEmail() ){
        submitError.style.display = 'block';
          submitError.innerHTML = "Please fix error before submit!!!";
          setTimeout(function(){submitError.style.display = 'none';}, 3000);
          return false;
    }
}

function someFunc(){
    validateName();
    validateEmail();
    validateNumber();
    validatePeoples();
    return validateForm();
}


document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").onsubmit = function (event) {
        // Lấy giá trị từ các input
        let name = document.getElementById("book-name").value;
        let email = document.getElementById("book-email").value;
        let phone = document.getElementById("book-number").value;
        let peoples = document.getElementById("book-peoples").value;
        let checkIn = document.getElementById("book-checkin").value;
        let checkOut = document.getElementById("book-checkout").value;

        // Lấy danh sách phòng đã chọn
        let selectedRooms = [];
        document.querySelectorAll(".room-checkbox:checked").forEach((room) => {
            selectedRooms.push(room.dataset.roomNumber);
        });

        // Hiển thị thông tin nhập vào
        let message = `Bạn đã nhập:\n
        - Họ và tên: ${name}\n
        - Email: ${email}\n
        - Số điện thoại: ${phone}\n
        - Số người: ${peoples}\n
        - Ngày nhận phòng: ${checkIn}\n
        - Ngày trả phòng: ${checkOut}\n
        - Phòng đã chọn: ${selectedRooms.length > 0 ? selectedRooms.join(", ") : "Chưa chọn"}\n\n
        Bạn có muốn tiếp tục đặt phòng?`;

        // Nếu người dùng không đồng ý, chặn form submit
        if (!confirm(message)) {
            event.preventDefault();
        }
    };
});

