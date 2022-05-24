function init() {
    $(document).ready(function () {
        $("#t a").on('mouseover', function (e) {
            $(this).css({opacity: 0.4});
        });

        $("#t a").on('mouseout', function (e) {
            $(this).css({opacity: 1});
        });

        $("#t a").on('click', function (e) {
            if (new Date(this.title).getTime() >=new Date(moment(new Date().getTime()).format('YYYY-MM-DD'))) {
                var form = document.createElement("form");
                form.action = "";
                form.method = "post";
                var temp = document.createElement("input");
                temp.hidden = true;
                temp.name = "Submit";
                form.appendChild(temp);
                temp = document.createElement("input");
                temp.hidden = true;
                temp.name = "departing";
                temp.value = this.title;
                form.appendChild(temp);
                temp = document.createElement("input");
                temp.hidden = true;
                temp.name = "arrival";
                temp.value = document.getElementById("ap").innerText;
                form.appendChild(temp);
                temp = document.createElement("input");
                temp.hidden = true;
                temp.name = "departure";
                temp.value = document.getElementById("dp").innerText;
                form.appendChild(temp);
                if(document.getElementById("twoway").innerText === "twoway"){
                    temp = document.createElement("input");
                    temp.hidden = true;
                    temp.name = "returning";
                    temp.value = this.title;
                    form.appendChild(temp);
                }
                document.body.appendChild(form);
                form.submit();
            }
        });

        $(":button").on('click', function (e) {
            if ($(this).attr("name") === "Booking") {
                var xmlhttp;
                var x = false;
                if ($(this).attr("alt") === "Booking") x = confirm("You will book this trip from " + document.getElementById("dp").innerText + " to " + document.getElementById("ap").innerText + ". Are you sure ?");
                else x = confirm("You will book this trip from " + document.getElementById("ap").innerText + " to " + document.getElementById("dp").innerText + ". Are you sure ?");
                if (x) {
                    if (window.XMLHttpRequest) {
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.open("POST", "../php/process.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    var dd = "";
                    if ($(this).attr("alt") === "Booking") dd = document.getElementById("dd").innerText;
                    else dd = document.getElementById("dd2").innerText;
                    xmlhttp.send("RouteID=" + $(this).attr("id") + "&DepartDate=" + dd + "&ArrivalDate=" + dd + "&TotalFee=" + this.getAttribute("about"), false);

                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            var y = xmlhttp.responseText;
                            alert("Congratulation! Operation complete! The trip book successfully! This page will redirect to the Invoice page.");
                            post(y, true, "");
                        }
                    };
                }
                ;
            } else if ($(this).attr("name") === "Details") {
                post($(this).attr("id"), false, $(this).attr("alt"));
            }
        });
    });
}

k = 0;
function week(date, date2, date3){
    date = moment(new Date(date).getTime()).format('YYYY-MM-DD');
    var x = moment(date).format('dddd');
    var data = {'Sunday':0, 'Monday':1, 'Tuesday':-5, 'Wednesday':-4, 'Thursday':-3, 'Friday':-2, 'Saturday':-1};
    var num = data[x];
    if(num == 0) var number1 = moment((new Date(date).getTime())-(num-1*24*60*60*1000)).format('YYYY-MM-DD');
    else if(num == 1) var number1 = moment((new Date(date).getTime())-(num-6*24*60*60*1000)).format('YYYY-MM-DD');
    else var number1 = moment((new Date(date).getTime())-(num*24*60*60*1000)).format('YYYY-MM-DD');
    var day = new Array();
    for(var i = 7; i > 0; i--){
        day[7-i] = moment(number1).subtract('days',i).format('YYYY-MM-DD');
    }

    var m = document.getElementById("t");
    m = m.getElementsByTagName("td");
    for(var i = 0; i < 7; i++){
        var temp = moment(new Date(day[i]).getTime()).format('DD');
        if(day[i] === moment(new Date().getTime()).format('YYYY-MM-DD')){
            m.item(i).innerHTML = "<a href='#' id='" + day[i] + "' style='border:10px solid red;border-radius:50px;color:white;font-size:20px;background-color:red;text-decoration: none;' title='" + day[i] + "'>" + temp + "</a>"
        }
        else if(day[i] < moment(new Date().getTime()).format('YYYY-MM-DD')){
            m.item(i).innerHTML = "<a href='#' id='' style='border:10px solid #ECE7E7;background-color:#ECE7E7;border-radius:50px;color:#AAA5A5;font-size:20px;text-decoration: none;' title='" + day[i] + "'>" + temp + "</a>"
        }
        else if(date2 === day[i] || date3 === day[i]){
            m.item(i).innerHTML = "<a href='#' id='" + day[i] + "' style='border:10px solid #2ecc71;border-radius:50px;color:white;font-size:20px;background-color:#2ecc71;text-decoration: none;' title='" + day[i] + "'>" + temp + "</a>"
        }
        else{
            m.item(i).innerHTML = "<a href='#' id='" + day[i] + "' style='border:10px solid #52A4E8;background-color:#52A4E8;border-radius:50px;color:white;font-size:20px;text-decoration: none;' title='" + day[i] + "'>" + temp + "</a>"
        }
    }
    temp = moment(new Date(day[3]).getTime());
    month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    temp = "" + temp.format('YYYY') + " " + month[temp.format('MM')-1];
    if(document.getElementById("year").innerText !== temp) document.getElementById("year").innerText = temp;
    init();
}

function last(){
    k--;
    var x = ["", ""];
    var g = document.getElementsByName("gg");
    for(var i = 0; i < g.length; i++) {x[i] = g[i].getAttribute("title");}
    week(moment((new Date(x[0]).getTime())+(k*7*24*60*60*1000)).format('YYYY-MM-DD'), x[0], x[1]);
}
function next(){
    k++;
    var x = ["", ""];
    var g = document.getElementsByName("gg");
    for(var i = 0; i < g.length; i++) {x[i] = g[i].getAttribute("title");}
    week(moment((new Date(x[0]).getTime())+(k*7*24*60*60*1000)).format('YYYY-MM-DD'), x[0], x[1]);
}

function post(w, b, g){
    var form = document.createElement("form");
    form.action = "../php/view.php";
    form.method = "post";
    var temp = document.createElement("input");
    temp.hidden = true;
    temp.value = w;
    if(!b){
        temp.name = "RouteID";
        form.appendChild(temp);
        temp = document.createElement("input");
        temp.hidden = true;
        temp.name = "DepartDate";
        temp.value = g;
    }
    else{
        temp.name = "BookingID";
    }
    form.appendChild(temp);
    document.body.appendChild(form);
    form.submit();
}