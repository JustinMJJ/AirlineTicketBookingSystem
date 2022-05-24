CREATE TABLE User (
    UserID    int NOT NULL AUTO_INCREMENT,
    UserName  VARCHAR(55) NOT NULL,
    Password    VARCHAR(55) NOT NULL,
    CreateDate  Date    NOT NULL,
    DriverID     VARCHAR(55) NOT NULL,
    PhoneNum  INT NOT NULL,
    Email    VARCHAR(55) NOT NULL,
    Address VARCHAR(70) NOT NULL,
    DOB  Date    NOT NULL,
    PRIMARY KEY (UserID)
);
insert into User values(001, "First", "001", "2020-01-01", "D001", 022111, "001@gmail.com", "001 Massey Rd", "1990-01-01");
insert into User values(002, "Second", "002", "2020-02-02", "D002", 022222, "002@gmail.com", "002 Massey Rd", "1990-02-02");
insert into User values(003, "Third", "003", "2020-03-03", "D003", 022333, "003@gmail.com", "003 Massey Rd", "1990-03-03");

CREATE TABLE Aircraft (
    CraftID     INT   NOT NULL AUTO_INCREMENT,
    ModelSeries       VARCHAR(55)  NOT NULL,
    ModelName       VARCHAR(55)  NOT NULL,
    Capacity    INT          NOT NULL,   -- max number of passengers\
    PRIMARY KEY (CraftID)
);
insert into Aircraft values(001, "SyberJet", "SJ30i", 6);
insert into Aircraft values(002, "Cirrus", "SF50", 4);
insert into Aircraft values(003, "Cirrus", "SF50", 4);
insert into Aircraft values(004, "HondaJet", "Elite", 5);
insert into Aircraft values(005, "HondaJet", "Elite", 5);

-- List of destinations by airport\
CREATE TABLE Airport (
    AirportID VARCHAR(55) NOT NULL,
    AirportName  VARCHAR(55)  NOT NULL,
    Region    VARCHAR(55)  NOT NULL,
    PRIMARY KEY (AirportID)
);
INSERT INTO Airport VALUES ("NZNS", "Dairy Flat Airport", "North Shore");
INSERT INTO Airport VALUES ("AUSY", "Sydney Kingsford Smith Airport", "Sydney");
INSERT INTO Airport VALUES ("NZRO", "Rotorua Aiport", "Rotorua");
INSERT INTO Airport VALUES ("NZCI", "Tuuta Aiport", "Chatham Islands");
INSERT INTO Airport VALUES ("NZGB", "Claris Aerodrome", "Great Barrier Island");
INSERT INTO Airport VALUES ("NZLT", "Lake Tekapo Airport", "Mackenzie District");

-- List of operating routes. This information applies in either\
-- direction between the points\
CREATE TABLE Routes (
    RouteID VARCHAR(10) NOT NULL,
    CraftID     INT   NOT NULL,
    DepartID    VARCHAR(55) NOT NULL,
    ArrivalID    VARCHAR(55) NOT NULL,
    DepartDays  VARCHAR(10) NOT NULL,
    ArrivalDays  VARCHAR(10) NOT NULL,
    DepartTime  Time NOT NULL,
    ArrivalTime  Time NOT NULL,
    Price   INT NOT NULL,
    PRIMARY KEY (RouteID),
    FOREIGN KEY(CraftID) REFERENCES Aircraft(CraftID),
    FOREIGN KEY(DepartID) REFERENCES Airport(AirportID),
    FOREIGN KEY(ArrivalID) REFERENCES Airport(AirportID)
);
INSERT INTO Routes VALUES ("R01", 001, "NZNS", "AUSY", "5", "5", "15:00", "18:30", 800);
INSERT INTO Routes VALUES ("R02", 001, "AUSY", "NZNS", "0", "0", "15:00", "18:30", 800);
INSERT INTO Routes VALUES ("R03", 002, "NZNS", "NZRO", "12345", "12345", "06:00", "07:00", 155);
INSERT INTO Routes VALUES ("R04", 002, "NZRO", "NZNS", "12345", "12345", "12:00", "13:00", 170);
INSERT INTO Routes VALUES ("R05", 002, "NZNS", "NZRO", "12345", "12345", "18:00", "19:00", 170);
INSERT INTO Routes VALUES ("R06", 002, "NZRO", "NZNS", "12345", "12345", "00:00", "01:00", 155);
INSERT INTO Routes VALUES ("R07", 003, "NZNS", "NZCI", "135", "135", "08:00", "08:45", 170);
INSERT INTO Routes VALUES ("R08", 003, "NZCI", "NZNS", "256", "256", "08:00", "08:45", 170);
INSERT INTO Routes VALUES ("R09", 004, "NZNS", "NZGB", "25", "25", "09:30", "11:30", 600);
INSERT INTO Routes VALUES ("R10", 004, "NZGB", "NZNS", "36", "36", "09:30", "11:30", 600);
INSERT INTO Routes VALUES ("R11", 005, "NZNS", "NZLT", "1", "1", "09:30", "11:00", 200);
INSERT INTO Routes VALUES ("R12", 005, "NZLT", "NZNS", "5", "5", "09:30", "11:00", 200);

CREATE TABLE Booking (
    BookingID INT NOT NULL AUTO_INCREMENT,
    UserID    INT NOT NULL,
    RouteID VARCHAR(10) NOT NULL,
    DepartDate Date NOT NULL,
    ArrivalDate Date NOT NULL,
    BookingDate Date NOT NULL,
    TotalFee Int Not NULL,
    Cancell Bool Default false,
    PRIMARY KEY (BookingID),
    FOREIGN KEY(UserID) REFERENCES User(UserID),
    FOREIGN KEY(RouteID) REFERENCES Routes(RouteID)
);
INSERT INTO Booking VALUES (001, "001", "R01", "2020-02-01", "2020-02-01", "2020-01-31", 800, true);
INSERT INTO Booking VALUES (002, "001", "R01", "2020-02-02", "2020-02-02", "2020-01-31", 800, FALSE);