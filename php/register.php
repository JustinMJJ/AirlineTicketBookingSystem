<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign up</title>
    <link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet"></link>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="../js/register.js"></script>
    <link rel="stylesheet" href="../css/register.css">
    <link href="../css/nav.css" rel="stylesheet"/>
    <script>

    </script>
</head>
<body style="margin-left: -1px;">
<div id="show" style="font-size: 16px;padding-left:18px;font-family: Arial, Helvetica, sans-serif;">
    <ul>
        <li><a class="active" href="../index.php"><i class="fa fa-fw fa-home"></i> Home</a></li>
        <li><a href="book.php"><i class="fa fa-fw fa-search"></i> Booking</a></li>
        <li><a href="reference.php"><i class="fa fa-address-book"></i> Invoice</a></li>
        <li><a href="contact.php"><i class="fa fa-fw fa-envelope"></i> Contact</a></li>
        <li><a href="about.php"><i class="fa fa-fw fa-info"></i> About</a></li>
        <li id="dropdown" style="float: right">
            <a href="javascript:void(0)" class="id"><i class="fa fa-fw fa-user"></i> Account</a>
            <div id="dropdown-content">
                <a href="register.php"><i class="fa fa-fw fa-user-plus"></i> Register</a>
            </div>
        </li>
        <li style="float:right"><a href='http://www.twitter.com'><i class="fa fa-fw fa-twitter"></i> Twitter</a></li>
        <li style="float:right"><a href="http://www.facebook.com"><i class="fa fa-fw fa-facebook"></i> Facebook</a></li>
    </ul>
</div>
<h1>Sign up</h1><hr/>
<div id="form">
<form action="process.php" method="post">
    <div class="form-horizontal">
        <div class="form-group">
            <label class = "control-label col-md-2">User Name</label>
            <div class="col-md-10">
                <input type="text" name="UserName" class = "form-control" >
                <span id="spanUserName"></span>
            </div>
        </div>

        <div class="form-group">
            <label class = "control-label col-md-2">Password</label>
            <div class="col-md-10">
                <input type="password" name="Password" class = "form-control">
                <span id="spanPassword"></span>
            </div>
        </div>

        <div class="form-group">
            <label class = "control-label col-md-2">Confirm Password</label>
            <div class="col-md-10">
                <input type="password" name="ConfirmPassword" class = "form-control">
                <span id="spanConfirmPassword"></span>
            </div>
        </div>

        <div class="form-group">
            <label class = "control-label col-md-2">Driver ID</label>
            <div class="col-md-10">
                <input type="text" name="DriverID" class = "form-control">
                <span id="spanDriverID"></span>
            </div>
        </div>

        <div class="form-group">
            <label class = "control-label col-md-2">Email</label>
            <div class="col-md-10">
                <input type="text" name="Email" class = "form-control">
                <span id="spanEmail"></span>
            </div>
        </div>

        <div class="form-group">
            <label class = "control-label col-md-2">Mobile Number</label>
            <div class="col-md-10">
                <input type="text" name="MobileNumber" class = "form-control">
                <span id="spanMobileNumber"></span>
            </div>
        </div>

        <div class="form-group">
            <label class = "control-label col-md-2">Address</label>
            <div class="col-md-10">
                <input type="text" name="Address" class = "form-control">
                <span id="spanAddress"></span>
            </div>
        </div>

        <div class="form-group">
            <label class = "control-label col-md-2">Date Of Birth</label>
            <div class="col-md-10">
                <input type="text" name="DOB" class = "form-control" readonly="readonly">
                <span id="spanDOB"></span>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" name="Create" value="Create" class="btn btn-default" onclick="return x();"/>
            </div>
        </div>
        <div><a href="javascript:history.back();">Back to previous page</a></div><br/>
        <footer>
            <hr style="margin-left: 0px;padding-bottom: 20px;">
            &copy; Copyright - 2020 Junjie Mai Airline Site Application. All Rights Reserved.
        </footer>
    </div>
</form>

</div>
</body>
</html>