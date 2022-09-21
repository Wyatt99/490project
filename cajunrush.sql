
CREATE TABLE Admins (
    adminId int NOT NULL AUTO_INCREMENT,
    username VARCHAR(60) NOT NULL,
    password CHAR(60) NOT NULL,
   	PRIMARY KEY (adminId)
); 

CREATE TABLE Coach (
	coachId int NOT NULL AUTO_INCREMENT,
	coachName VARCHAR(60) NOT NULL,
   	PRIMARY KEY (coachId)
); 

CREATE TABLE Team (
    teamId int NOT NULL AUTO_INCREMENT,
    teamName VARCHAR(60) NOT NULL,
    coachId int NOT NULL,
	division VARCHAR(4) NOT NULL,
	location VARCHAR(30 NOT NULL,
    PRIMARY KEY (teamId),
    FOREIGN KEY (coachId) REFERENCES Coach(coachId)
); 

CREATE TABLE Park (
    parkId int NOT NULL AUTO_INCREMENT,
	parkName VARCHAR(60) NOT NULL,
    PRIMARY KEY (parkId)
); 

CREATE TABLE Field (
   	fieldId int NOT NULL AUTO_INCREMENT,
    fieldNum int NOT NULL,
    parkId int NOT NULL,
	lights TINYINT(1) NOT NULL,
    PRIMARY KEY (fieldId),
    FOREIGN KEY (parkId) REFERENCES Park(parkId)
); 

CREATE TABLE Practice (
    practiceId int NOT NULL AUTO_INCREMENT,
	fieldId int NOT NULL,
	fieldSection CHAR(6),
	teamId int NOT NULL,
	startTime TIME NOT NULL,
	endTime TIME NOT NULL,
	day CHAR(9),
	adminId int NOT NULL,
    PRIMARY KEY (practiceId),
	FOREIGN KEY (fieldId) REFERENCES Field(fieldId),
	FOREIGN KEY (teamId) REFERENCES Team(teamId),
	FOREIGN KEY (adminId) REFERENCES Admins(adminId)
); 
