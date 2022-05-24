$(document).ready(function () {
    $(":button").on('click',function(e){
        if($(this).attr("name") === "Cancel") {
            var xmlhttp;
            if (confirm("You will cancell your Booking reference number " + $(this).attr("id") + ". Are you sure ?")) {
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.open("POST", "../php/process.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("BookingID=" + $(this).attr("id"));

                xmlhttp.onreadystatechange = function (v){
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var y = xmlhttp.responseText;
                        if (y === "true") {
                            alert("Congratulation ! Operation complete ! The Booking reference number cancell successful ! This page will redirect to the Invoice page.");
                            post(v);
                        }
                    }
                }.bind(null, $(this).attr("id"));
            };
        }
        else if($(this).attr("name") === "View"){
            post($(this).attr("id"));
        }
    });
});

function post(x){
    var form = document.createElement("form");
    form.action = "../php/view.php";
    form.method = "post";
    var temp = document.createElement("input");
    temp.name = "BookingID";
    temp.value = x;
    temp.hidden = true;
    form.appendChild(temp);
    document.body.appendChild(form);
    form.submit();
}
