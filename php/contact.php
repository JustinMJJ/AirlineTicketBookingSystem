<?php
session_start();
if (!isset($_SESSION["UserID"]) && !isset($_COOKIE["UserID"])){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../css/nav.css" rel="stylesheet"/>
    <link href="../css/about.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
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
    <section class="content">
        <h1>Contact Us</h1><hr/>
        <div>
            <p>
                If having any questions, suggestions, or copyright and illegal content, PLEASE leave <b>a message</b> and send us <a href="mailto:Junjie_Mai@Massey.com"></a><b>an email</b></a>. We will delete it as soon as possible.
            </p>
            <p>
                <a href="mailto:Junjie_Mai@Massey.com">Email: Junjie Mai@massey.ac.nz</a>
            </p>
            <p>
                Mobile: 0800-555-555
            </p>
        </div>
    </section>

    <br/>
    <footer>
        <hr>
        &copy; Copyright - 2020 Junjie Mai Airline Site Application. All Rights Reserved.
    </footer>

</div>
</body>
</html>
