$(document).ready(function () {
    $("input[name='UserName']").on('input',function(e){
        if (!/(\d|[a-zA-Z])+$/.test($("input[name='UserName']").val())) {
            $("#spanUserName").text("User Name can only include digits 0 - 9 and letters.");
        }else{
            $("#spanUserName").text("");
        }
    });

    $("input[name='MobileNumber']").on('input',function(e){
        if (!/(\d)+$/.test($("input[name='MobileNumber']").val())) {
            $("#spanMobileNumber").text("Mobile Number can only include digits 0 - 9.");
        }else{
            $("#spanMobileNumber").text("");
        }
    });

    $("input[name='Email']").on('blur',function(e){
        var r = /^\w+([-.]\w+)*@[A-Za-z0-9]+([-.][A-Za-z0-9]+)*(\.[A-Za-z0-9]+)$/;
        if (!r.test($("input[name='Email']").val())) {
            $("#spanEmail").text("Email format incorrect.");
        }
        else{
            $("#spanEmail").text("");
        }
    });

    $("input[name='DOB']").datepicker({ maxDate: new Date() });
    $("input[name='DOB']").change(function() {
        startDate = $(this).datepicker('getDate');
        $("input[name='DOB']").text(startDate);
    });

    $("input[name='Email']").on('blur',function(e){
        var r = /^\w+([-.]\w+)*@[A-Za-z0-9]+([-.][A-Za-z0-9]+)*(\.[A-Za-z0-9]+)$/;
        if (!r.test($("input[name='Email']").val())) {
            $("#spanEmail").text("Email format incorrect.");
        }
        else{
            $("#spanEmail").text("");
        }
    });

    $("input[name='Password']").on('blur',function(e){
        var m = $("input[name='ConfirmPassword']").val();
        var n = $("input[name='Password']").val();
        if (m !== "" && n !== "" && m !== n) {
            $("#spanPassword").text("Two input password is not same. Please check.");
            $("#spanConfirmPassword").text("Two input password is not same. Please check.");
        }
        else{
            $("#spanPassword").text("");
            $("#spanConfirmPassword").text("");
        }
    });

    $("input[name='ConfirmPassword']").on('blur',function(e){
        var m = $("input[name='ConfirmPassword']").val();
        var n = $("input[name='Password']").val();
        if (m !== "" && n !== "" && m !== n) {
            $("#spanPassword").text("Two input password is not same. Please check.");
            $("#spanConfirmPassword").text("Two input password is not same. Please check.");
        }
        else{
            $("#spanPassword").text("");
            $("#spanConfirmPassword").text("");
        }
    });
});

function x(){
    if(document.getElementsByName("UserName")[0].value === ""){
        document.getElementById("spanUserName").innerText = "Please fill in User Name.";
    }
    else if(!/(\d|[a-zA-Z])+$/.test(document.getElementsByName("UserName")[0].value)) {
        document.getElementById("spanUserName").innerText = "User Name can only include digits 0 - 9 and letters.";
    }
    else if(document.getElementsByName("Password")[0].value === ""){
        document.getElementById("spanPassword").innerText = "Please fill in Password.";
    }
    else if(document.getElementsByName("ConfirmPassword")[0].value === ""){
        document.getElementById("spanConfirmPassword").innerText = "Please fill in Confirm Password.";
    }
    else if(document.getElementsByName("ConfirmPassword")[0].value !== document.getElementsByName("Password")[0].value){
        document.getElementById("spanConfirmPassword").innerText = "Two input password is not same. Please check.";
    }
    else if(document.getElementsByName("DriverID")[0].value === ""){
        document.getElementById("spanDriverID").innerText = "Please fill in Driver ID.";
    }
    else if(document.getElementsByName("Email")[0].value === ""){
        document.getElementById("spanEmail").innerText = "Please fill in Email.";
    }
    else if(!/^\w+([-.]\w+)*@[A-Za-z0-9]+([-.][A-Za-z0-9]+)*(\.[A-Za-z0-9]+)$/.test(document.getElementsByName("Email")[0].value)){
        document.getElementById("spanEmail").innerText = "Email format incorrect.";
    }
    else if(document.getElementsByName("MobileNumber")[0].value === ""){
        document.getElementById("spanMobileNumber").innerText = "Please fill in Mobile Number.";
    }
    else if(!/(\d)+$/.test(document.getElementsByName("MobileNumber")[0].value)){
        document.getElementById("spanMobileNumber").innerText = "Mobile Number can only include digits 0 - 9.";
    }
    else if(document.getElementsByName("Address")[0].value === ""){
        document.getElementById("spanAddress").innerText = "Please fill in Address.";
    }
    else if(document.getElementsByName("DOB")[0].value === ""){
        document.getElementById("spanDOB").innerText = "Please select Date Of Birth.";
    }
    else{

        return true;
    }
    return false;
}