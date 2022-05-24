<?php
include_once ("Model.php");
session_start();
if (!isset($_SESSION["UserID"]) && !isset($_COOKIE["UserID"])){
    header("Location: login.php");
}

if(isset($_POST["BookingID"])){
    $db = new Connection();
    $query = new BookingQuery();
    $query->BookingSelectById($db, filter_input(INPUT_POST, 'BookingID', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    if($query->getNumRows() > 0){
        $UserName = $query->getUserName(0);
        $UserAddress = $query->getUserAddress(0);
        $UserID = $query->getUserID(0);
        $DriverID = $query->getUserDriverID(0);
        $UserEmail = $query->getEmail(0);
        $DepartDate = $query->getDepartDate(0);
        $DepartTime = $query->getDepartTime(0);
        $ArrivalTime = $query->getArrivalTime(0);
        $ArrivalRegion = $query->getArrivalRegion(0);
        $ArrivalAirportName = $query->getArrivalAirportName(0);
        $ArrivalDate = $query->getArrivalDate(0);
        $DepartRegion = $query->getDepartRegion(0);
        $DepartAirportName = $query->getDepartAirportName(0);
        $BookingDate = $query->getBookingDate(0);
        $ModelSeries = $query->getModelSeries(0);
        $ModelName = $query->getModelName(0);
        $TotalFee = $query->getTotalFee(0);
        $Cancell = $query->getCancell(0);
        $Capacity = $query->getCapacity(0);
    }
}
else if(isset($_POST["RouteID"])){
    $db = new Connection();
    $query = new RouteQuery();
    $query->RouteSelectById($db, filter_input(INPUT_POST, 'RouteID', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    if($query->getNumRows() > 0) {
        $DepartDate = filter_input(INPUT_POST, 'DepartDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $DepartTime = $query->getDepartTime(0);
        $ArrivalTime = $query->getArrivalTime(0);
        $ArrivalRegion = $query->getArrivalAirportRegion(0);
        $ArrivalAirportName = $query->getArrivalAirportName(0);
        $ArrivalDate = filter_input(INPUT_POST, 'DepartDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $DepartRegion = $query->getDepartAirportRegion(0);
        $DepartAirportName = $query->getDepartAirportName(0);
        $ModelSeries = $query->getModelSeries(0);
        $ModelName = $query->getModelName(0);
        $Capacity = $query->getCapacity(0);
        $TotalFee = $query->getPrice(0);
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
    <title>Invoice Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../css/search.css" rel="stylesheet"/>
    <link href="../css/nav.css" rel="stylesheet"/>
    <link href="../css/view.css" rel="stylesheet"/>
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
<body>
<div id="show" style="font-size: 18px;font-family: Arial, Helvetica, sans-serif;margin-left: 17px;">
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

        <div class="toolbar hidden-print">
            <h1 style="padding-top: 50px;padding-left: 10px;">Invoice Details</h1>
            <div class="text-right">
                <button class="btn btn-info" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                <button class="btn btn-danger" onclick="window.location = 'mailto:Junjie_Mai@Massey.com';"><i class="fa fa-envelope-o" ></i> Mail</button>
            </div>
        </div>
        <hr style="margin-bottom: -15px;">
    <div id="page">
        <div class="card">
            <div class="card-header">
                <strong>Issuing Date: </strong><?php echo (new DateTime())->format('F d Y');?>
                <span class="float-right"> <strong>Status:</strong>
                    <?php
                    if(isset($_POST["BookingID"]) && !$Cancell) echo "Booked";
                    else if(isset($_POST["BookingID"]) && $Cancell) echo "Cancelled";
                    else echo "Pending";
                    ?>
                </span>
            </div>
        </div>
        <div id="invoice">
                <h3><strong>Invoice</strong></h3>
                <div class="row" style="margin-top:40px;">
                    <div class="col-sm-6"><strong>Issuing Date: </strong><?php if(isset($BookingDate)) echo $BookingDate; else echo (new DateTime())->format('F d Y'); ?></div>
                    <div class="col-sm-6 text-sm-right"> <strong>Booking Reference No : #</strong> <?php if(isset($_POST["BookingID"])) echo "0000".$_POST["BookingID"]; else echo "Pending";?></div>
                </div>
                <hr style="margin-bottom: -0px;">

                <h4 class="text-2" style="margin-bottom:30px;">Journey Details</h4>
                <div class="row">
                    <div class="col-sm-3 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">From:</span><br>
                        <span class="font-weight-500 text-3"><?php echo $DepartRegion;?></span> </div>
                    <div class="col-sm-3 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">To:</span><br>
                        <span class="font-weight-500 text-3"><?php echo $ArrivalRegion;?></span> </div>
                    <div class="col-sm-3 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">Departure Airport:</span><br>
                        <span class="font-weight-500 text-3"><?php echo $DepartAirportName;?></span> </div>
                    <div class="col-sm-3 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">Arrival Airport:</span><br>
                        <span class="font-weight-500 text-3"><?php echo $ArrivalAirportName;?></span> </div>
                </div>
                <hr class="my-4">
                <div class="row">
                    <div class="col-sm-3 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">Departure Date:</span><br>
                        <span class="font-weight-500 text-3"><?php echo $DepartDate;?></span> </div>
                    <div class="col-sm-3 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">Arrival Date:</span><br>
                        <span class="font-weight-500 text-3"><?php echo $ArrivalDate;?></span> </div>
                    <div class="col-sm-3 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">Departure Time:</span><br>
                        <span class="font-weight-500 text-3"><?php echo $DepartTime;?></span> </div>
                    <div class="col-sm-3 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">Arrival Time:</span><br>
                        <span class="font-weight-500 text-3"><?php echo $ArrivalTime;?></span> </div>
                </div>
                <hr class="my-4">
                <div class="row">
                    <div class="col-sm-3 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">Airplane Model:</span><br>
                        <span class="font-weight-500 text-3"><?php echo $ModelSeries;?></span> </div>
                    <div class="col-sm-3 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">Airplane Name:</span><br>
                        <span class="font-weight-500 text-3"><?php echo $ModelName;?></span> </div>
                    <div class="col-sm-3 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">Journey Time:</span><br>
                        <span class="font-weight-500 text-3"><?php echo (new DateTime($ArrivalTime))->diff((new DateTime($DepartTime)))->h;?> Hour(s)</span> </div>
                    <div class="col-sm-3 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">Maximum Capacity:</span><br>
                        <span class="font-weight-500 text-3"><?php echo $Capacity;?></span> </div>
                </div>
                <hr class="my-4">
                <div class="row">
                    <div class="col-sm-6 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">Booking Status:</span><br>
                        <span class="font-weight-500 text-3"><?php if(!isset($Cancell)) echo "Pending"; else if(($Cancell) == true) echo "Cancelled"; else echo "Booked";?></span> </div>
                    <div class="col-sm-6 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">Booking Date:</span><br>
                        <span class="font-weight-500 text-3"><?php if(isset($BookingDate)) echo $BookingDate;else echo "Pending";?></span> </div>
                </div>
                <hr class="my-4">
                <?php if(isset($_POST["BookingID"])) echo
                "<h4 class='text-2 mt-2' style='margin-bottom:30px;'>Passenger Details</h4>
                <div class='row'>
                    <div class='col-sm-3 mb-3 mb-sm-0'> <span class='text-black-50 text-uppercase'>Passenger Name:</span><br>
                        <span class='font-weight-500 text-3'>$UserName</span> </div>
                    <div class='col-sm-3 mb-3 mb-sm-0'> <span class='text-black-50 text-uppercase'>Account ID:</span><br>
                        <span class='font-weight-500 text-3'>$UserID</span> </div>
                    <div class='col-sm-3 mb-3 mb-sm-0'> <span class='text-black-50 text-uppercase'>Contact Address:</span><br>
                        <span class='font-weight-500 text-3'>$UserAddress</span> </div>
                    <div class='col-sm-3 mb-3 mb-sm-0'> <span class='text-black-50 text-uppercase'>Contact Email:</span><br>
                        <span class='font-weight-500 text-3'>$UserEmail</span> </div>
                </div>
                <hr class='my-4'>";?>

                <h4 class="text-2 mt-2" style="margin-bottom:30px;">Charge Details</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr">
                            <td colspan='2' class="bg-light-4 p-3 text-right font-weight-500 text-2"><strong>Total Charge:  $<?php echo $TotalFee;?></strong></span></td>
                        </tr>
                        <tr>
                            <td class="col-9 font-weight-500 text-right"><strong>Basic Charge :</strong></td>
                            <td class="col-3 text-right">$<?php echo $TotalFee*0.85;?></td>
                        </tr>
                        <tr>
                            <td class="col-9 font-weight-500 text-right"><strong>GST :</strong></td>
                            <td class="col-3 text-right">$<?php echo $TotalFee*0.15;?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <h4 class="text-2 mt-2">Important Instruction</h4>
                <ul class="text-1">
                    <li>One of the passengers in an e-ticket should carry proof of identification during the train journey.</li>
                    <li>The input for the proof of identity in case of cancellation/partial cancellation is also not required now.</li>
                    <li>The passenger should also carry the Electronic Reservation Slip (ERS) during the train journey failing which a penalty of $10 will be charged by the TTE/Conductor Guard.</li>
                </ul>
            </main>
        </div>
        <br/>
        <div id="end">
            <button class="btn btn-info" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
            <button class="btn btn-danger" onclick="window.location = 'mailto:Junjie_Mai@Massey.com'"><i class="fa fa-envelope-o"></i> Mail</button>
        </div>
    </div>
    <div class="card">
        <div class="card-header" style="height: 50px;">
        </div>
    </div>
    <hr style="margin-top: 10px;"/>
    <div><a href="javascript:history.back();">Back to previous page</a></div>

    <footer>
        <hr>
        &copy; Copyright - 2020 Junjie Mai Airline Site Application. All Rights Reserved.
    </footer>

</div>
</body>
</html>
