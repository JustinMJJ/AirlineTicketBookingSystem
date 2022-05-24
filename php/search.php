<?php
include_once ("Model.php");
session_start();
if (!isset($_SESSION["UserID"]) && !isset($_COOKIE["UserID"])){
    header("Location: login.php");
}

if (isset($_POST["Submit"])) {
    $Departure = filter_input(INPUT_POST, 'departure', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Arrival = filter_input(INPUT_POST, 'arrival', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Departing = filter_input(INPUT_POST, 'departing', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $DepartingDay = new DateTime($Departing);
    $DepartingDay = $DepartingDay->format("w");
    $db = new Connection();
    $search = new RouteQuery();
    $search->RouteSelect($db, $Departure, $Arrival, $DepartingDay);
    if($search->getNumRows() > 0){
        $n = $search->getNumRows();
        for($m = 0; $m < $n; $m++) {
            $RouteID[$m] = $search->getRouteID($m);
            $AirName[$m] = $search->getModelSeries(0) . " " . $search->getModelName($m);
            $DepartureAirportName[$m] = $search->getDepartAirportName($m);
            $ArrivalAirportName[$m] = $search->getArrivalAirportName($m);
            $DepartDays[$m] = $search->getDepartDays($m);
            $ArrivalDays[$m] = $search->getArrivalDays($m);
            $DepartTime[$m] = $search->getDepartTime($m);
            $ArrivalTime[$m] = $search->getArrivalTime($m);
            $Price[$m] = $search->getPrice($m);
            $Capacity[$m] = $search->getCapacity($m);
        }
    }
    else
    {
        ///echo "empty";///////////////////////////////////////////////
    }
}
else{
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Route Searching Result</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../css/search.css" rel="stylesheet"/>
    <link href="../css/nav.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="../js/search.js"></script>
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

    <div class="container body-content">
        <h1>Route Searching Result</h1><hr/>
        <div><table id="time">
                <tr><td colspan="7" style="height:45px;">
                        <input type="button" onclick="last()" class="btn" value="<" style="font-size:22px;float: left;">
                        <?php $now = new DateTime();echo "<strong id='year' style='align-items: center'>".$now->format('Y F')."</strong>"?>
                        <input type="button" onclick="next()" class="btn" value=">" style="font-size:22px;float: right;">
                    </td>
                </tr>
                <tr class="week">
                    <td>
                        Sunday
                    </td>

                    <td>
                        Monday
                    </td>

                    <td>
                        Tuesday
                    </td>

                    <td>
                        Wednesday
                    </td>

                    <td>
                        Thursday
                    </td>

                    <td>
                        Friday
                    </td>

                    <td>
                        Saturday
                    </td>
                </tr>

                <tr id="t">
                    <td id="zero">
                        1
                    </td>

                    <td  id="one">
                        2
                    </td>

                    <td id="two">
                        3
                    </td>

                    <td id="three">
                        4
                    </td>

                    <td id="four">
                        5
                    </td>

                    <td  id="five">
                        6
                    </td>

                    <td id="six">
                        7
                    </td>
                </tr>
            </table>
        </div>


        <span class="title">
            <strong>Departure - Arrival :</strong>
            <?php
            if($Departing === "") $temp = new DateTime();
            else $temp = new DateTime($Departing);
            echo "<span id='dp' hidden='hidden'>$Departure</span><span id='ap' hidden='hidden'>$Arrival</span><strong style='padding-left: 50px;'>" . $Departure ."  --  " . $Arrival . "</strong><span id='dd' hidden='hidden'>" . $temp->format('Y-m-d') . "</span>";
            if(isset($_POST["returning"])) $gg = 'twoway';
            else $gg = '';
            echo "<span id='twoway' hidden='hidden'>$gg</span>";
            echo "<strong name='gg' title='" . $temp->format('Y-m-d') . "' style='float: right'>" . $temp->format("l") . "  " . $temp->format('M d Y') . "</strong>";?>
        </span>
        <script>
            var x = ["", ""];
            var g = document.getElementsByName("gg");
            for(var i = 0; i < g.length; i++) {x[i] = g[i].getAttribute("title");}
            week(moment((new Date(x[0]).getTime())+(k*7*24*60*60*1000)).format('YYYY-MM-DD'), x[0], x[1]);
        </script>
        <table id="table">
            <tr>
                <th style="width:150px">
                    Air Name
                </th>
                <th style="width:500px">
                    Departure Location - Arrival Location
                </th>
                <th style="width:320px">
                    Departure Time - Arrival Time
                </th>
                <th style="width:150px">
                    Price
                </th>
                <th style="width:130px">
                    Action
                </th>
                <th></th>
            </tr>

            <?php
            if($search->getNumRows() > 0){
                for($m = 0; $m < $search->getNumRows(); $m++){
            echo "
            <tr>
                <td style='width:150px'>
                    <font style='font-weight: bolder;' size=''>$AirName[$m]</font>
                </td>

                <td style='width:500px'>
                    <div class='dd'>
                    <font style='font-weight: bolder;' size='5.5px;'>$Departure <i class='fa fa-plane'></i> $Arrival</font><br/>
                    <font size='2px;'>($DepartureAirportName[$m] ----- $ArrivalAirportName[$m])<br/></font>
                    </div>
                </td>

                <td style='width:320px'>
                    <div class='dd' style='font-size: 18px;'>
                    <font style='font-weight: bolder;' size='5.5px;'>$DepartTime[$m] <i class='fa fa-long-arrow-right'></i> $ArrivalTime[$m]</font><br/>
                    <font size='2px;'>($Departing ----- $Departing)</font>
                    </div>
                </td>

                <td style='width:150px'>
                    <font style='font-weight: bolder;' size='5.5px;'>$$Price[$m]</font>
                </td>

                <td style='width:130px'>
                    <div class='kk'>";
                    $con = new Connection();
                    $check= new BookingQuery();
                    $check->BookingCheck($con, $RouteID[$m], (new DateTime($Departing))->format("Y-m-d"));
                    if($check->getNumRows() > 0 ) {
                        $j = $check->getCurrentCapacity(0);
                        if ($Capacity[$m] > $j) echo "<input type='button' id='$RouteID[$m]' name='Booking' alt='Booking' about='$Price[$m]' value='Booking' class='btn btn-success'/><br/>";
                    }
                    echo "<input type='button' id='$RouteID[$m]' alt='$Departing' name='Details' value='Details' class='btn btn-info'/>
                    </div>
                </td>
            </tr>
        
        ";}}else{
                echo '<tr><td colspan="7" style="background-color:lightgrey;font-size: 20px;height:150px;">No result on your searching route from database !</td></tr>';
            }
            ?>
        </table>
<?php
            if(isset($_POST["returning"]) && $_POST["returning"] !== "") {
                $Returning = filter_input(INPUT_POST, 'returning', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $ReturningDay = new DateTime($Returning);
                $ReturningDay = $ReturningDay->format("w");
                $db = new Connection();
                $search = new RouteQuery();
                $search->RouteSelect($db, $Arrival, $Departure, $ReturningDay);
                if($search->getNumRows() > 0){
                    $n = $search->getNumRows();
                    for($m = 0; $m < $n; $m++) {
                        $R_RouteID[$m] = $search->getRouteID($m);
                        $R_AirName[$m] = $search->getModelSeries(0) . " " . $search->getModelName($m);
                        $R_DepartureAirportName[$m] = $search->getDepartAirportName($m);
                        $R_ArrivalAirportName[$m] = $search->getArrivalAirportName($m);
                        $R_DepartDays[$m] = $search->getDepartDays($m);
                        $R_ArrivalDays[$m] = $search->getArrivalDays($m);
                        $R_DepartTime[$m] = $search->getDepartTime($m);
                        $R_ArrivalTime[$m] = $search->getArrivalTime($m);
                        $R_Price[$m] = $search->getPrice($m);
                        $R_Capacity[$m] = $search->getCapacity($m);
                    }
                }
            }
            else{
                echo   "<br/>        
                        <footer>
                            <hr>
                            &copy; Copyright - 2020 Junjie Mai Airline Site Application. All Rights Reserved.
                        </footer>";
                return;
            }
            ?>
        <span class="title" style="margin-top: 30px;">
            <strong>Departure - Arrival :</strong>
            <?php
            $temp = new DateTime($Returning);
            echo "<strong style='padding-left: 50px;'>" . $Arrival ."  --  " . $Departure . "</strong><span id='dd2' hidden='hidden'>" . $temp->format('Y-m-d') . "</span>";
            echo "<strong name='gg' title='" . $temp->format('Y-m-d') . "' style='float: right'>" . $temp->format("l") . "  " . $temp->format('M d Y') . "</strong>";?>
        </span>
        <script>
            var x = ["", ""];
            var g = document.getElementsByName("gg");
            for(var i = 0; i < g.length; i++) {x[i] = g[i].getAttribute("title");}
            week(moment((new Date(x[0]).getTime())+(k*7*24*60*60*1000)).format('YYYY-MM-DD'), x[0], x[1]);
        </script>
        <table id="table">
            <tr>
                <th style="width:150px">
                    Air Name
                </th>
                <th style="width:500px">
                    Departure Location - Arrival Location
                </th>
                <th style="width:320px">
                    Departure Time - Arrival Time
                </th>
                <th style="width:150px">
                    Price
                </th>
                <th style="width:130px">
                    Action
                </th>
                <th></th>
            </tr>

            <?php if($search->getNumRows() > 0){
                for($m = 0; $m < $search->getNumRows(); $m++){
                    echo "
            <tr>
                <td style='width:150px'>
                    <font style='font-weight: bolder;' size=''>$R_AirName[$m]</font>
                </td>

                <td style='width:500px'>
                    <div class='dd'>
                    <font style='font-weight: bolder;' size='5.5px;'>$Arrival <i class='fa fa-plane'></i> $Departure</font><br/>
                    <font size='2px;'>($R_DepartureAirportName[$m] ----- $R_ArrivalAirportName[$m])<br/></font>
                    </div>
                </td>

                <td style='width:320px'>
                    <div class='dd' style='font-size: 18px;'>
                    <font style='font-weight: bolder;' size='5.5px;'>$R_DepartTime[$m] <i class='fa fa-long-arrow-right'></i> $R_ArrivalTime[$m]</font><br/>
                    <font size='2px;'>($Returning ----- $Returning)</font>
                    </div>
                </td>

                <td style='width:150px'>
                    <font style='font-weight: bolder;' size='5.5px;'>$R_Price[$m]</font>
                </td>

                <td style='width:130px'>
                    <div class='kk'>";
                    $con = new Connection();
                    $check = new BookingQuery();
                    $check->BookingCheck($con, $R_RouteID[$m], (new DateTime($Returning))->format("Y-m-d"));
                    if($check->getNumRows() > 0 ) {
                        $jj = $check->getCurrentCapacity(0);
                        if ($R_Capacity[$m] > $jj) echo "<input type='button' id='$R_RouteID[$m]' name='Booking' alt='Booking2' about='$R_Price[$m]'  value='Booking' class='btn btn-success'/><br/>";
                    }
                    echo "<input type='button' id='$R_RouteID[$m]'  alt='$Returning'  name='Details' value='Details' class='btn btn-info'/>
                    </div>
                </td>
            </tr>
        
        ";}}else{
                echo '<tr><td colspan="7" style="background-color:lightgrey;font-size: 20px;height:150px;">No result on your searching route from database !</td></tr>';
            }
            ?>
        </table>
        <br/>
        <footer>
            <hr>
            &copy; Copyright - 2020 Junjie Mai Airline Site Application. All Rights Reserved.
        </footer>
    </div>

</body>
</html>
