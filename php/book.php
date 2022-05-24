<?php
include_once ("Model.php");
session_start();
if (!isset($_SESSION["UserID"]) && !isset($_COOKIE["UserID"])){
    header("Location: login.php");
}

if(isset($_POST["Submit"])){
    $book = filter_input(INPUT_POST, 'findid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $db = new Connection();
    $search = new BookingQuery();
    $search->BookingSelectById($db, $book);
    if($search->getNumRows() > 0) {
        $n = $search->getNumRows();
        for ($m = 0; $m < $n; $m++) {
            $Booking[$m] = $search->getBookingID($m);
            $UserID[$m] = $search->getUserID($m);
            $UserName[$m] = $search->getUserName($m);
            $Email[$m] = $search->getEmail($m);
            $RouteID[$m] = $search->getRouteID($m);
            $AirName[$m] = $search->getModelSeries(0) . " " . $search->getModelName($m);
            $DepartureAirportName[$m] = $search->getDepartAirportName($m);
            $ArrivalAirportName[$m] = $search->getArrivalAirportName($m);
            $DepartRegion[$m] = $search->getDepartRegion($m);
            $ArrivalRegion[$m] = $search->getArrivalRegion($m);
            $DepartDate[$m] = $search->getDepartDate($m);
            $ArrivalDate[$m] = $search->getArrivalDate($m);
            $DepartTime[$m] = $search->getDepartTime($m);
            $ArrivalTime[$m] = $search->getArrivalTime($m);
            $BookingDate[$m] = $search->getBookingDate($m);
            $Fee[$m] = $search->getTotalFee($m);
            $Cancell[$m] = $search->getCancell($m);
        }
    }
}
else if(isset($_COOKIE["UserID"])){
    $id = $_COOKIE["UserID"];
    $db = new Connection();
    $search = new BookingQuery();
    $search->BookingSelectByUser($db, $id);
    if($search->getNumRows() > 0){
        $n = $search->getNumRows();
        for($m = 0; $m < $n; $m++) {
            $Booking[$m] = $search->getBookingID($m);
            $UserID[$m] = $search->getUserID($m);
            $UserName[$m] = $search->getUserName($m);
            $Email[$m] = $search->getEmail($m);
            $RouteID[$m] = $search->getRouteID($m);
            $AirName[$m] = $search->getModelSeries(0) . " " . $search->getModelName($m);
            $DepartureAirportName[$m] = $search->getDepartAirportName($m);
            $ArrivalAirportName[$m] = $search->getArrivalAirportName($m);
            $DepartRegion[$m] = $search->getDepartRegion($m);
            $ArrivalRegion[$m] = $search->getArrivalRegion($m);
            $DepartDate[$m] = $search->getDepartDate($m);
            $ArrivalDate[$m] = $search->getArrivalDate($m);
            $DepartTime[$m] = $search->getDepartTime($m);
            $ArrivalTime[$m] = $search->getArrivalTime($m);
            $BookingDate[$m] = $search->getBookingDate($m);
            $Fee[$m] = $search->getTotalFee($m);
            $Cancell[$m] = $search->getCancell($m);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mange Your Booking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../css/book.css" rel="stylesheet"/>
    <link href="../css/nav.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../js/book.js"></script>
    <script>
        $(document).ready(function () {
            $("#demo").click(function () {
                link("demo", this.name)
            })

            $("#alter").click(function () {
                link("alter", this.name)
            })
        });
        function link(e, f){
            var form = document.createElement("form");
            form.action = "userdetail.php";
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
<body style="margin-left: 17px;">
<div id="show" style="font-size: 18px;font-family: Arial, Helvetica, sans-serif;">
    <ul>
        <li><a class="active" href="../index.php"><i class="fa fa-fw fa-home"></i> Home</a></li>
        <li><a href="book.php"><i class="fa fa-fw fa-search"></i> Booking</a></li>
        <li><a href="reference.php"><i class="fa fa-address-book"></i> Invoice</a></li>
        <li><a href="contact.php"><i class="fa fa-fw fa-envelope"></i> Contact</a></li>
        <li><a href="about.php"><i class="fa fa-fw fa-info"></i> About</a></li>
        <li id="dropdown" style="float: right">
            <a href="javascript:void(0)" class="id"><i class="fa fa-fw fa-user"></i> Account</a>
            <div id="dropdown-content">
                <a href="javascript:void(0)" id="demo" name="<?php echo $_COOKIE["UserID"];?>"><i class="fa fa-fw fa-user-circle"></i> Account Details</a>
                <a href="javascript:void(0)" id="alter" name="<?php echo $_COOKIE["UserID"];?>"><i class="fa fa-fw fa-user-circle-o"></i> Edit Account</a>
                <a href="logout.php"><i class="fa fa-fw fa-sign-out"></i> Logout</a>
                <a href="register.php"><i class="fa fa-fw fa-user-plus"></i> Register</a>
            </div>
        </li>
        <li style="float:right"><a href='http://www.twitter.com'><i class="fa fa-fw fa-twitter"></i> Twitter</a></li>
        <li style="float:right"><a href="http://www.facebook.com"><i class="fa fa-fw fa-facebook"></i> Facebook</a></li>
    </ul>
</div>

<div class='container body-content'>
<h1>Mange Your Booking</h1><hr/>
    <?php if($search->getNumRows() > 0){
      for($m = 0; $m < $search->getNumRows(); $m++){
      echo "<span class='title'>
            <strong>Booking Reference :</strong><strong style='padding-left: 20px;'>#0000$Booking[$m]</strong>
            <strong name='gg' title='$BookingDate[$m]' style='float: right'>Booking Create Date : $BookingDate[$m]</strong>
        </span>

        <table id='table'>
            <tr>
                <th style='width:150px'>
                    Air Name
                </th>
                <th style='width:500px'>
                    Departure Location - Arrival Location
                </th>
                <th style='width:320px'>
                    Departure Time - Arrival Time
                </th>
                <th style='width:150px'>
                    Price
                </th>
                <th style='width:130px'>
                    Action
                </th>
                <th></th>
            </tr>

            <tr>
                <td style='width:150px'>
                    <font style='font-weight: bolder;' size=''>$AirName[$m]</font>
                </td>

                <td style='width:500px'>
                    <div class='dd'>
                    <font style='font-weight: bolder;' size='5.5px;'>$DepartRegion[$m] <i class='fa fa-plane'></i> $ArrivalRegion[$m]</font><br/>
                    <font size='2px;'>($DepartureAirportName[$m] ----- $ArrivalAirportName[$m])<br/></font>
                    </div>
                </td>             

                <td style='width:320px'>
                    <div class='dd' style='font-size: 18px;'>
                    <font style='font-weight: bolder;' size='5.5px;'>$DepartTime[$m] <i class='fa fa-long-arrow-right'></i> $ArrivalTime[$m]</font><br/>
                    <font size='2px;'>($DepartDate[$m] ----- $ArrivalDate[$m])</font>
                    </div>
                </td>

                <td style='width:150px'>
                    <font style='font-weight: bolder;' size='5.5px;'>$$Fee[$m]</font>
                </td>

                <td style='width:130px'>
                    <div class='kk'>";
                    if(!$Cancell[$m])  echo "<input type='button' id='$Booking[$m]' name='Cancel' value='Cancel' class='btn btn-danger'/><br/>";
                    echo "<input type='button' id='$Booking[$m]' name='View' value='View' class='btn btn-info'/>
                    </div>
                </td>
            </tr>
        </table><br>
        ";
      }
    }else{
        echo "<span class='title'>
            <strong>Booking Reference :</strong><strong style='padding-left: 50px;'></strong>
            <strong name='gg' title='' style='float: right'>Booking Create Date : </strong>
              </span>

        <table id='table'>
            <tr>
                <th style='width:130px'>
                    Air Name
                </th>
                <th style='width:720px'>
                    Departure Location - Arrival Location
                </th>
                <th style='width:720px'>
                    Departure Time - Arrival Time
                </th>
                <th style='width:130px'>
                    Price
                </th>
                <th style='width:130px'>
                    Action
                </th>
                <th></th>
            </tr>
                <tr><td colspan='7' style='background-color:lightgrey;font-size: 20px;height:150px;'>No result on your booking details from database !</td></tr>
        </table>";
    }
?>
    <br/>
    <footer>
        <hr>
        &copy; Copyright - 2020 Junjie Mai Airline Site Application. All Rights Reserved.
    </footer>
</div>

</body>
</html>
