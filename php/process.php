<?php
    include_once ("Model.php");
    session_start();

    $db = new Connection();
    if(isset($_POST["BookingID"])){
        $exe = new BookingQuery();
        if($exe->BookingCancel($db, $_COOKIE["UserID"], filter_input(INPUT_POST, 'BookingID', FILTER_SANITIZE_FULL_SPECIAL_CHARS))) echo "true";
    }
    else if(isset($_POST["RouteID"])){
        $exe = new BookingQuery();
        if($exe->BookingCreate($db, $_COOKIE["UserID"], filter_input(INPUT_POST, 'RouteID', FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_input(INPUT_POST, 'DepartDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS), filter_input(INPUT_POST, 'ArrivalDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS), (new DateTime())->format("Y-m-d"), filter_input(INPUT_POST, 'TotalFee', FILTER_SANITIZE_FULL_SPECIAL_CHARS))){
            $exe->BookingMaxID($db);
            if($exe->getNumRows() > 0){
                echo $exe->getMaxID(0);
            }
        }
    }
    else if(isset($_GET["Airport"])){
        $query = new LocationQuery($db);
        if($query->getNumRows()>0){
            $result = Array();
            for ($n=0; $n < $query->getNumRows(); ++$n) {
                $result[$n][0] = $query->getAirportID($n);
                $result[$n][1] = $query->getRegion($n);
                $result[$n][2] = $query->getAirportName($n);
            }
            echo json_encode($result);
        }
    }
    else if(isset($_GET["ArrivalAirportRegion"]) || isset($_GET["DepartAirportRegion"])){
        $require = '';
        $condition = '';
        if(isset($_GET["DepartAirportRegion"])){
            $require = false;
            $condition = filter_input(INPUT_GET, 'DepartAirportRegion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        else{
            $require = true;
            $condition = filter_input(INPUT_GET, 'ArrivalAirportRegion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        if(!$condition) return;
        $query = new RouteQuery();
        $query->RouteLocation($db, $condition, $require);
        if($query->getNumRows()>0){
            $result = Array();
            for ($n=0; $n < $query->getNumRows(); ++$n) {
                if(!isset($_GET["DepartAirportRegion"])){
                    $result[$n][0] = $query->getDepartID($n);
                    $result[$n][1] = $query->getDepartAirportRegion($n);
                    $result[$n][2] = $query->getDepartAirportName($n);
                }else{
                    $result[$n][0] = $query->getArrivalID($n);
                    $result[$n][1] = $query->getArrivalAirportRegion($n);
                    $result[$n][2] = $query->getArrivalAirportName($n);
                }
            }
            echo json_encode($result);
        }
    }
    else if (isset($_POST["Login"])) {
        $db = new Connection();
        $search = new UserQuery();
        $user = filter_input(INPUT_POST, 'UserID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass = filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(!$user && !$pass){redirect("Login failed !<br/><br/>The UserID or Password is incorrect. Please try again !", "login.php", "Login");}
        $pass = md5($pass);
        $search->UserSelect($db, $user);
        if ($search->getNumRows() > 0) {
            if ($search->getPassword(0) === $pass) {
                $_SESSION["UserID"] = $user;
                $_SESSION["Password"] = $pass;
                $_SESSION["UserName"] = $search->getUserName(0);
                setcookie("UserID", $user, time() + 7200*48);
                setcookie("Password", $pass, time() + 7200*48);
                setcookie("UserName", $search->getUserName(0), time() + 7200);
                $e = new DateTime();
                $temp = "Login successful !<br/><br/>Welcome back " . $_SESSION["UserName"] . ", Now is " . (string)$e->format('Y-m-d H:i:s');
                redirect($temp, "../index.php", "Home");
            } else {
                $temp = "Login failed !<br/><br/>The Password is incorrect. Please try again !";
                redirect($temp, "login.php", "Login");
            }
        }
        else {
            $temp = "Login failed !<br/><br/>The UserID is incorrect. Please try again !";
            redirect($temp, "login.php", "Login");
        }
    }
    else if (isset($_POST["Create"])) {
        $input=array("UserName","Password","DriverID","MobileNumber","Email","Address","DOB");
        $x = true;
        foreach ($input as $key => $value){
            if(!isset($_POST[$value])){
                $x = false;
                break;
            }
        }
        if($x) {
            $db = new Connection();
            $search = new UserQuery();
            $UserName = filter_input(INPUT_POST, 'UserName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $Password = filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $CreateDate = new DateTime();
            $CreateDate = $CreateDate->format('Y-m-d H:i:s');
            $DriverID = filter_input(INPUT_POST, 'DriverID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $PhoneNum = filter_input(INPUT_POST, 'MobileNumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $Email = filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL);
            $Address = filter_input(INPUT_POST, 'Address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $DOB = filter_input(INPUT_POST, 'DOB', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $Password = md5($Password);
            $DOB = new DateTime($DOB);
            $DOB = $DOB->format('Y-m-d H:i:s');
            $result = $search->UserCreate($db, $UserName, $Password, $CreateDate, $DriverID, $PhoneNum, $Email, $Address, $DOB);
            if ($result !== false) {
                redirect("Congratulation ! Register successful !<br/><br/>Please remember your UserID or Password. ", "login.php", "Login");
            }
            else {
                redirect("Unfortunately, Register failed !<br/><br/>The System occurs some errors. Please try again later !", "register.php", "Sign up");
            }
        }
        else{
            redirect("Unfortunately, Register failed !<br/><br/>Please fill in all required information !", "register.php", "Sign up");
        }
    }else
    {
        header("location: ../index.php");
    }
?>