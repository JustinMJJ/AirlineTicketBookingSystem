<?php

class Connection {
    private $dbcon;

    public function Connection() {
        $username = "root";
        $password = "123456";

        $hostname = "localhost";
        $database = "AirlineSystem";
        $port  = 3306;
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->dbcon = new mysqli($hostname, $username, $password, $database, $port);
    }

    public function doquery($sqlstr) {
        $result = $this->dbcon->query($sqlstr);
        $table = Array();
        $n = 0;
        while ($row = $result->fetch_assoc()) {
            $table[$n] = $row;
            ++$n;
        }
        return $table;
    }

    public function query($sqlstr) {
        return $this->dbcon->query($sqlstr);
    }
};

class LocationQuery {

    private $numRows;
    private $table;

    # Constructor takes an established DB connection and the Location name
    public function LocationQuery($dbcon) {

        # Run the query
        $sql = "select * from airport order by Region";
        $this->table = $dbcon->doquery($sql);
        $this->numRows = count($this->table);
    }

    # Accessor function to get the number of rows in the table
    public function getNumRows() {return $this->numRows;}

    # Accessor function to look up individual cells
    public function getAirportID($rowNo)    {return $this->table[$rowNo]['AirportID'];}
    public function getAirportName($rowNo)    {return $this->table[$rowNo]['AirportName'];}
    public function getRegion($rowNo) {return $this->table[$rowNo]['Region'];}
}

class RouteQuery {

    private $numRows;
    private $table;

    public function RouteLocation($dbcon, $condition, $require) {

        # Run the query
        $sql = "";
        // use to
        if($require) $sql = "select r.RouteID, r.CraftID, r.DepartID, a.AirportName as 'DepartAirportName', a.Region as 'DepartAirportRegion', r.ArrivalID, b.AirportName as 'ArrivalAirportName', b.Region as 'ArrivalAirportRegion', r.DepartDays, r.ArrivalDays, r.Price from routes r join airport a on r.DepartID=a.AirportID join airport b on r.ArrivalID=b.AirportID where b.Region ='$condition' order by a.Region asc";
        //use from
        else $sql = "select r.RouteID, r.CraftID, r.DepartID, a.AirportName as 'DepartAirportName', a.Region as 'DepartAirportRegion', r.ArrivalID, b.AirportName as 'ArrivalAirportName', b.Region as 'ArrivalAirportRegion', r.DepartDays, r.ArrivalDays, r.Price from routes r join airport a on r.DepartID=a.AirportID join airport b on r.ArrivalID=b.AirportID where a.Region ='$condition' order by b.Region asc";

        $this->table = $dbcon->doquery($sql);
        $this->numRows = count($this->table);
    }

    public function RouteSelect($dbcon, $x, $y, $z) {

        # Run the query
        $sql = "select r.*, ac.*, d.AirportName as DepartAirportName, d.Region as DepartAirportRegion, a.AirportName as ArrivalAirportName, a.Region as ArrivalAirportRegion from routes r join airport d on r.DepartID = d.AirportID join airport a on r.ArrivalID = a.AirportID join aircraft ac on ac.CraftID = r.CraftID where d.Region = '$x' and a.Region = '$y' and r.DepartDays like '%$z%'";

        $this->table = $dbcon->doquery($sql);
        $this->numRows = count($this->table);
    }

    public function RouteSelectById($dbcon, $x) {

        # Run the query
        $sql = "select r.*, ac.*, d.AirportName as DepartAirportName, d.Region as DepartAirportRegion, a.AirportName as ArrivalAirportName, a.Region as ArrivalAirportRegion from routes r join airport d on r.DepartID = d.AirportID join airport a on r.ArrivalID = a.AirportID join aircraft ac on ac.CraftID = r.CraftID where r.RouteID='$x'";
        $this->table = $dbcon->doquery($sql);
        $this->numRows = count($this->table);
    }

    # Accessor function to get the number of rows in the table
    public function getNumRows() {return $this->numRows;}

    # Accessor function to look up individual cells
    public function getRouteID($rowNo)    {return $this->table[$rowNo]['RouteID'];}
    public function getCraftID($rowNo)    {return $this->table[$rowNo]['CraftID'];}
    public function getModelSeries($rowNo)    {return $this->table[$rowNo]['ModelSeries'];}
    public function getModelName($rowNo)    {return $this->table[$rowNo]['ModelName'];}
    public function getCapacity($rowNo)    {return $this->table[$rowNo]['Capacity'];}
    public function getDepartID($rowNo) {return $this->table[$rowNo]['DepartID'];}
    public function getDepartAirportName($rowNo)    {return $this->table[$rowNo]['DepartAirportName'];}
    public function getDepartAirportRegion($rowNo)    {return $this->table[$rowNo]['DepartAirportRegion'];}
    public function getArrivalID($rowNo)    {return $this->table[$rowNo]['ArrivalID'];}
    public function getArrivalAirportName($rowNo) {return $this->table[$rowNo]['ArrivalAirportName'];}
    public function getArrivalAirportRegion($rowNo) {return $this->table[$rowNo]['ArrivalAirportRegion'];}
    public function getDepartDays($rowNo)    {return $this->table[$rowNo]['DepartDays'];}
    public function getArrivalDays($rowNo) {return $this->table[$rowNo]['ArrivalDays'];}
    public function getDepartTime($rowNo)    {return $this->table[$rowNo]['DepartTime'];}
    public function getArrivalTime($rowNo)    {return $this->table[$rowNo]['ArrivalTime'];}
    public function getPrice($rowNo) {return $this->table[$rowNo]['Price'];}
}

class UserQuery {

    private $numRows;
    private $table;

    # Constructor takes an established DB connection and the User
    public function UserSelect($dbcon, $condition) {

        # Run the query
        $sql = "select * from user where UserID='$condition'";
        $this->table = $dbcon->doquery($sql);
        $this->numRows = count($this->table);
    }

    public function UserUpdate($dbcon, $condition, $UserName, $Password, $DriverID, $PhoneNum, $Email, $Address, $DOB) {

        # Run the query
        $sql = "UPDATE User SET UserName = '$UserName', Password = '$Password', DriverID = '$DriverID', PhoneNum = '$PhoneNum', Email = '$Email', Address = '$Address', DOB = '$DOB' where UserID='$condition'";
        return $dbcon->query($sql);
    }

    public function UserCreate($dbcon, $UserName, $Password, $CreateDate, $DriverID, $PhoneNum, $Email, $Address, $DOB) {

        # Run the query
        $sql = "insert into User(UserName, Password, CreateDate, DriverID, PhoneNum, Email, Address, DOB) values('$UserName', '$Password', '$CreateDate', '$DriverID', '$PhoneNum', '$Email', '$Address', '$DOB')";
        return $dbcon->query($sql);
    }

    # Accessor function to get the number of rows in the table
    public function getNumRows() {return $this->numRows;}

    # Accessor function to look up individual cells
    public function getUserID($rowNo)    {return $this->table[$rowNo]['UserID'];}
    public function getUserName($rowNo)    {return $this->table[$rowNo]['UserName'];}
    public function getPassword($rowNo) {return $this->table[$rowNo]['Password'];}
    public function getCreateDate($rowNo)    {return $this->table[$rowNo]['CreateDate'];}
    public function getDriverID($rowNo)    {return $this->table[$rowNo]['DriverID'];}
    public function getPhoneNum($rowNo) {return $this->table[$rowNo]['PhoneNum'];}
    public function getEmail($rowNo)    {return $this->table[$rowNo]['Email'];}
    public function getAddress($rowNo)    {return $this->table[$rowNo]['Address'];}
    public function getDOB($rowNo) {return $this->table[$rowNo]['DOB'];}
}

class BookingQuery {

    private $numRows;
    private $table;

    public function BookingMaxID($dbcon){
        $sql = "select max(BookingID) as MaxID from booking";
        $this->table = $dbcon->doquery($sql);
        $this->numRows = count($this->table);
    }

    public function BookingSelectByUser($dbcon, $condition) {

        # Run the query
        $sql = "select b.BookingID, b.UserID, u.UserName,u.Email, b.RouteID, b.DepartDate, b.ArrivalDate, d.AirportName as 'DepartAirportName', a.AirportName as 'ArrivalAirportName', d.Region as 'DepartRegion', a.Region as 'ArrivalRegion', r.DepartTime, r.ArrivalTime, ac.ModelName, ac.ModelSeries,b.BookingDate, b.TotalFee, b.Cancell from booking b join user u on u.UserID = b.UserID join routes r on r.RouteID = b.RouteID join airport d on d.AirportID = r.DepartID join airport a on a.AirportID = r.ArrivalID join aircraft ac on ac.CraftID = r.CraftID where b.UserID = '$condition' order by b.BookingID desc";
        $this->table = $dbcon->doquery($sql);
        $this->numRows = count($this->table);
    }

    # Constructor takes an established DB connection and the Booking
    public function BookingSelectById($dbcon, $condition) {

        # Run the query
        $sql = "select b.BookingID, b.UserID, u.UserName,u.Email,u.Address, u.DriverID, b.RouteID, b.DepartDate, b.ArrivalDate, d.AirportName as 'DepartAirportName', a.AirportName as 'ArrivalAirportName', d.Region as 'DepartRegion', a.Region as 'ArrivalRegion', r.DepartTime, r.ArrivalTime, ac.ModelName, ac.ModelSeries, ac.Capacity, b.BookingDate, b.TotalFee, b.Cancell from booking b join user u on u.UserID = b.UserID join routes r on r.RouteID = b.RouteID join airport d on d.AirportID = r.DepartID join airport a on a.AirportID = r.ArrivalID join aircraft ac on ac.CraftID = r.CraftID where b.BookingID = '$condition'";
        $this->table = $dbcon->doquery($sql);
        $this->numRows = count($this->table);
    }

    public function BookingCancel($dbcon, $UserID, $BookingID) {

        # Run the query
        $sql = "update booking set Cancell = true where UserID = '$UserID' and BookingID = '$BookingID'";
        return $dbcon->query($sql);
    }

    public function BookingCreate($dbcon, $UserID, $RouteID, $DepartDate, $ArrivalDate, $BookingDate, $TotalFee) {

        # Run the query
        $sql = "insert into Booking(UserID, RouteID, DepartDate, ArrivalDate, BookingDate, TotalFee, Cancell) values('$UserID', '$RouteID', '$DepartDate', '$ArrivalDate', '$BookingDate', '$TotalFee', false)";
        return $dbcon->query($sql);
    }

    public function BookingCheck($dbcon, $RouteID, $DepartDate) {

        # Run the query
        $sql = "select count(RouteID + ' ' + DepartDate) as 'CurrentCapacity' from booking where DepartDate = '$DepartDate' and RouteID = '$RouteID'";
        $this->table = $dbcon->doquery($sql);
        $this->numRows = count($this->table);
    }

    # Accessor function to get the number of rows in the table
    public function getNumRows() {return $this->numRows;}

    # Accessor function to look up individual cells
    public function getMaxID($rowNo)    {return $this->table[$rowNo]['MaxID'];}
    public function getBookingID($rowNo)    {return $this->table[$rowNo]['BookingID'];}
    public function getUserID($rowNo)    {return $this->table[$rowNo]['UserID'];}
    public function getUserName($rowNo)    {return $this->table[$rowNo]['UserName'];}
    public function getUserAddress($rowNo)    {return $this->table[$rowNo]['Address'];}
    public function getUserDriverID($rowNo)    {return $this->table[$rowNo]['DriverID'];}
    public function getEmail($rowNo)    {return $this->table[$rowNo]['Email'];}
    public function getRouteID($rowNo) {return $this->table[$rowNo]['RouteID'];}
    public function getModelSeries($rowNo)    {return $this->table[$rowNo]['ModelSeries'];}
    public function getModelName($rowNo)    {return $this->table[$rowNo]['ModelName'];}
    public function getDepartDate($rowNo)    {return $this->table[$rowNo]['DepartDate'];}
    public function getArrivalDate($rowNo)    {return $this->table[$rowNo]['ArrivalDate'];}
    public function getDepartTime($rowNo)    {return $this->table[$rowNo]['DepartTime'];}
    public function getArrivalTime($rowNo)    {return $this->table[$rowNo]['ArrivalTime'];}
    public function getDepartAirportName($rowNo)    {return $this->table[$rowNo]['DepartAirportName'];}
    public function getArrivalAirportName($rowNo)    {return $this->table[$rowNo]['ArrivalAirportName'];}
    public function getDepartRegion($rowNo)    {return $this->table[$rowNo]['DepartRegion'];}
    public function getArrivalRegion($rowNo)    {return $this->table[$rowNo]['ArrivalRegion'];}
    public function getBookingDate($rowNo) {return $this->table[$rowNo]['BookingDate'];}
    public function getTotalFee($rowNo)    {return $this->table[$rowNo]['TotalFee'];}
    public function getCancell($rowNo)    {return $this->table[$rowNo]['Cancell'];}
    public function getCurrentCapacity($rowNo)    {return $this->table[$rowNo]['CurrentCapacity'];}
    public function getCapacity($rowNo)    {return $this->table[$rowNo]['Capacity'];}
}

function redirect($temp, $data, $x){
    echo "<div id='s1' style='margin: 0 auto;text-align: center;padding:130px'></div>
          <script>       
          k=5;
          m = document.getElementById('s1');
          m.style.width='1100px';
          function y(){
            document.getElementById('s1').innerHTML = '<div style=\"padding: 100px; ' +
             'border-top-left-radius: 16px; border-bottom-left-radius: 16px; border-top-right-radius: 16px;' +
             'border-bottom-right-radius: 16px; background-color:skyblue; \">' +
             '<div style=\"text-align: center;font-size:22px;\">' +
             '<b>". $temp . "</b></br></br></br></br><b><img src=\'../img/refresh.gif\'; width=\'3%\'; height=\'3%\';> ' +
             'After ' + k +' seconds, this page will redirect to the " . $x . " page.</b><br/><br/>' +
             '<a href=\"". $data ."\">Click to jump immediately!</a></div><br/>';
            k--;
            if(k < 0) window.location.href='" . $data . "';
            window.setTimeout(y,1000);
          }
          y();
          </script>";
}