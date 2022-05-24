<?php
include_once ("Model.php");
session_start();
if (!isset($_SESSION["UserID"]) && !isset($_COOKIE["UserID"])){
    header("Location: login.php");
}
?>
<?php
if (isset($_POST["demo"]) || isset($_POST["alter"]) || isset($_POST["edit"])) {
    $db = new Connection();
    $search = new UserQuery();
    $id = filter_input(INPUT_POST, 'demo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(!isset($_COOKIE["UserID"])) header("Location: login.php");
    else{
        if(isset($_POST["demo"]) || isset($_POST["alter"])) {
            if(isset($_POST["alter"])) $id = filter_input(INPUT_POST, 'alter', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $search->UserSelect($db, $id);
            if (!$search->getNumRows() > 0) {
                redirect("Unfortunately, Read failed !<br/><br/>The System occurs some errors. Please try again later !", "javascript:history.back();", "previous");
            } else {
                $UserName = $search->getUserName(0);
                $CreateDate = $search->getCreateDate(0);
                $DriverID = $search->getDriverID(0);
                $PhoneNum = $search->getPhoneNum(0);
                $Email = $search->getEmail(0);
                $Address = $search->getAddress(0);
                $DOB = $search->getDOB(0);
            }
        }
        if(isset($_POST["edit"]))
        {
            $id = $_COOKIE["UserID"];
            $UserName = filter_input(INPUT_POST, 'UserName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $Password = filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $DriverID = filter_input(INPUT_POST, 'DriverID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $PhoneNum = filter_input(INPUT_POST, 'MobileNumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $Email = filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL);
            $Address = filter_input(INPUT_POST, 'Address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $DOB = filter_input(INPUT_POST, 'DOB', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $Password = md5($Password);
            $DOB = new DateTime($DOB);
            $DOB = $DOB->format('Y-m-d H:i:s');
            $result = $search->UserUpdate($db, $id, $UserName, $Password, $DriverID, $PhoneNum, $Email, $Address, $DOB);
            if ($result !== false) {
                redirect("Congratulation ! Update successful !<br/><br/>Please remember your new Password. ", "../index.php", "Home");
            }
            else {
                redirect("Unfortunately, Update failed !<br/><br/>The System occurs some errors. Please try again later !", "../index.php", "Home");
            }
            return;
        }
    }
}
else{
    redirect("Warning !<br/><br/>Access from illegal path. !", "../index.php", "Home");
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php if(isset($_POST["alter"])) echo "Edit " ?>User Detail</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet"></link>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="../js/register.js"></script>
    <link rel="stylesheet" href="../css/register.css">
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

<h1><?php if(isset($_POST["alter"])) echo "Edit " ?>User Detail</h1><hr/>
<div id="form">
    <form method="post" action="">
        <div class="form-horizontal">
            <div class="form-group">
                <label class = "control-label col-md-2">User Name</label>
                <div class="col-md-10">
                    <input type="text" name="UserName" class = "form-control" <?php if(isset($_POST["demo"])) echo "readonly='readonly'"; ?> value="<?php echo $UserName ?>">
                    <span id="spanUserName"></span>
                </div>
            </div>
            <?php if(isset($_POST["alter"])) echo '
                <div class="form-group" >
                <label class = "control-label col-md-2" > Password</label >
                <div class="col-md-10" >
                    <input type = "password" name = "Password" class = "form-control">
                    <span id = "spanPassword" ></span >
                </div >
            </div >

            <div class="form-group" >
                <label class = "control-label col-md-2" > Confirm Password </label >
                <div class="col-md-10" >
                    <input type = "password" name = "ConfirmPassword" class = "form-control">
                    <span id = "spanConfirmPassword" ></span >
                </div >
            </div >
            ' ?>

            <div class="form-group">
                <label class = "control-label col-md-2">Driver ID</label>
                <div class="col-md-10">
                    <input type="text" name="DriverID" class = "form-control" <?php if(isset($_POST["demo"])) echo "readonly='readonly'"; ?> value="<?php echo $DriverID ?>">
                    <span id="spanDriverID"></span>
                </div>
            </div>

            <div class="form-group">
                <label class = "control-label col-md-2">Email</label>
                <div class="col-md-10">
                    <input type="text" name="Email" class = "form-control" <?php if(isset($_POST["demo"])) echo "readonly='readonly'"; ?> value="<?php echo $Email ?>">
                    <span id="spanEmail"></span>
                </div>
            </div>

            <div class="form-group">
                <label class = "control-label col-md-2">Mobile Number</label>
                <div class="col-md-10">
                    <input type="text" name="MobileNumber" class = "form-control" <?php if(isset($_POST["demo"])) echo "readonly='readonly'"; ?> value="<?php echo $PhoneNum ?>">
                    <span id="spanMobileNumber"></span>
                </div>
            </div>

            <div class="form-group">
                <label class = "control-label col-md-2">Address</label>
                <div class="col-md-10">
                    <input type="text" name="Address" class = "form-control" <?php if(isset($_POST["demo"])) echo "readonly='readonly'"; ?> value="<?php echo $Address ?>">
                    <span id="spanAddress"></span>
                </div>
            </div>

            <div class="form-group">
                <label class = "control-label col-md-2">Date Of Birth</label>
                <div class="col-md-10">
                    <input type="text" name="DOB" class = "form-control" <?php if(isset($_POST["demo"])) echo "disabled='true'"; ?> value="<?php echo $DOB ?>">
                    <span id="spanDOB"></span>
                </div>
            </div>

            <div class="form-group">
                <label class = "control-label col-md-2">Register Date</label>
                <div class="col-md-10">
                    <input type="text" name="RegisterDate" class = "form-control" readonly="readonly" value="<?php echo $CreateDate ?>">
                    <span id="spanRegisterDate"></span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
            <?php if(isset($_POST["alter"])) echo '
                    <input type="submit" style="margin-right: 50px;" name="edit" value="Edit" class="btn btn-default" onclick="return x();"/>
            ' ?>
                    <input type="submit" name="Submit" value="Back" class="btn btn-default" onclick="javascript:history.back();"/>
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