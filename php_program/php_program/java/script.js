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

function validateroom(){
    var room = 0;
    var sroom = document.getElementById('sroom').value;
    var droom = document.getElementById('droom').value;
    var vroom = document.getElementById('vroom').value;
    room = room + sroom;
    room = room + droom;
    room = room + vroom;

    if(room == 0){
        roomError.innerHTML = 'Room must be booked!';
        return false;
    }
    return true;
}

function validateForm(){
    if(!validateName() || !validateNumber() || !validateEmail() || !validateroom() || validateroom()){
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
    validateroom();
    return validateForm();
}