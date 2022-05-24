<?php
session_start();
    if (!isset($_SESSION["UserID"]) && !isset($_COOKIE["UserID"])){
        header("Location: php/login.php");
    }
?>
<!DOCTYPE>
<html>
<head>
    <title>Airline System</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="js/index.js"></script>
    <script>
        $(document).ready(function () {
            $("#departing").datepicker({ minDate: new Date() });
            $("#returning").datepicker({ minDate: new Date() });

            $("#departing").change(function() {
                startDate = $(this).datepicker('getDate');
                $("#departing").text(startDate);
            });
            $("#returning").change(function() {
                endDate = $(this).datepicker('getDate');
                $("#returning").text(endDate);
            });
            $("input[name='adult']").on('keyup',function(e){
                this.value = "";
            });
            $("input[name='kid']").on('keyup',function(e){
                this.value = "";
            });
            $("input[name='trip']").on('change',function(e){
                if(this.value === "single") {
                    document.getElementsByName("returning")[0].value = "";
                    document.getElementsByName("returning")[0].disabled = true;
                    document.getElementsByName("returning")[0].style.border = '2px solid darkgrey';
                }
                else{
                    document.getElementsByName("returning")[0].value = "";
                    document.getElementsByName("returning")[0].disabled = false;
                    document.getElementsByName("returning")[0].style.border = '2px solid #3498db';
                }
            });
            $("#demo").click(function () {
                link("demo", this.name)
            })

            $("#alter").click(function () {
                link("alter", this.name)
            })
        });

        xmlhttp;
        function getLocation(data){
            //if(data.value === "") return;
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // Define event handler here for a change in the object state
            var url = "";
            if(document.getElementsByName("departure")[0].value === "" && document.getElementsByName("arrival")[0].value === ""){
                url = "php/process.php?Airport=true";
                xmlhttp.onreadystatechange = Location.bind(null, data);
            }
            else if(document.getElementsByName("departure")[0].value !== "" && document.getElementsByName("arrival")[0].value !== "") {return;}
            else{
                if(document.getElementsByName("departure")[0].value === "" && data ==document.getElementsByName("departure")[0]) {
                    url = "php/process.php?ArrivalAirportRegion=" + document.getElementsByName("arrival")[0].value;
                    xmlhttp.onreadystatechange = Location.bind(null, document.getElementsByName("departure")[0]);
                }
                else if(document.getElementsByName("arrival")[0].value === "" && data ==document.getElementsByName("arrival")[0]){
                    url = "php/process.php?DepartAirportRegion=" + document.getElementsByName("departure")[0].value;
                    xmlhttp.onreadystatechange = Location.bind(null, document.getElementsByName("arrival")[0]);
                }
            }
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }
        function link(e, f){
            var form = document.createElement("form");
            form.action = "php/userdetail.php";
            form.method = "post";
            var temp = document.createElement("input");
            temp.name = e;
            temp.value = f;
            temp.hidden = true;
            form.appendChild(temp);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>
<body>
<div id="show" style="font-size: 18px;font-family: Arial, Helvetica, sans-serif;">
    <ul>
        <li><a class="active" href="index.php"><i class="fa fa-fw fa-home"></i> Home</a></li>
        <li><a href="php/book.php"><i class="fa fa-fw fa-search"></i> Booking</a></li>
        <li><a href="php/reference.php"><i class="fa fa-address-book"></i> Invoice</a></li>
        <li><a href="php/contact.php"><i class="fa fa-fw fa-envelope"></i> Contact</a></li>
        <li><a href="php/about.php"><i class="fa fa-fw fa-info"></i> About</a></li>
        <li id="dropdown" style="float: right">
            <a href="javascript:void(0)" class="id"><i class="fa fa-fw fa-user"></i> Account</a>
            <div id="dropdown-content">
                <a href="javascript:void(0)" id="demo" name="<?php echo $_SESSION["UserID"];?>"><i class="fa fa-fw fa-user-circle"></i> Account Details</a>
                <a href="javascript:void(0)" id="alter" name="<?php echo $_SESSION["UserID"];?>"><i class="fa fa-fw fa-user-circle-o"></i> Edit Account</a>
                <a href="php/logout.php"><i class="fa fa-fw fa-sign-out"></i> Logout</a>
                <a href="html/register.html"><i class="fa fa-fw fa-user-plus"></i> Register</a>
            </div>
        </li>
        <li style="float:right"><a href='http://www.twitter.com'><i class="fa fa-fw fa-twitter"></i> Twitter</a></li>
        <li style="float:right"><a href="http://www.facebook.com"><i class="fa fa-fw fa-facebook"></i> Facebook</a></li>
    </ul>
</div>

<form action="php/search.php" method="post" class="container body-content">
    <h1>Airline System</h1><hr/>
    <div class="bookingForm">
        <div class="tripRadio">
            <input type="radio" name="trip" checked="checked" value="return"><span>Return</span>
            <input type="radio" name="trip" value="single"><span>One Way</span>
        </div>

        <div class="info">
            <div class="airOption">
                <label>From</label>
                <input type="text" id="from" class="form-control" autocomplete="off" name="departure" onclick="getLocation(this)" placeholder="Select departure city or airport">
            </div>

            <div class="airOption">
                <label>To</label>
                <input type="text" id="to" class="form-control" autocomplete="off" name="arrival" onclick="getLocation(this)" placeholder="Select arrival city or airport">
            </div>

            <div class="airOption">
                <label>Departing Date</label>
                <input type="text" id="departing" name="departing" class="form-control select-date demoHeaders"readonly="readonly">
            </div>

            <div class="airOption">
                <label>Returning Date</label>
                <input type="text" id="returning" name="returning" class="form-control select-date" readonly="readonly">
            </div>

            <div class="Person">
                <label>Adults</label>
                <input type="number" name="adult" class="form-control" value="1" min="0" max="10">
            </div>

            <div class="Person">
                <label>Children</label>
                <input type="number" name="kid" class="form-control" value="0" min="0" max="10">
            </div>

            <div class="Seat">
                <label>Travel Class</label>
                <select name="seat" class="form-control SeatClass">
                    <option value="1">Economy Class</option>
                    <option value="2">Business Class</option>
                </select>
            </div>

            <div>
                <button type="submit" name="Submit" class="btn btn-primary" onclick="return check();">Search Flights</button>
            </div>
        </div>
    </div>
    <footer>
        <hr>
        &copy; Copyright - 2020 Junjie Mai Airline Site Application. All Rights Reserved.
    </footer>
</form>
</body>
</html>