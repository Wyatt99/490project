
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

CREATE TABLE ageGroup (
	ageGroup CHAR NOT NULL,
	PRIMARY KEY (ageGroup)
);

CREATE TABLE Season (
	seasonId VARCHAR(20) NOT NULL,
	seasonStatus TINYINT(1) NOT NULL,
	PRIMARY KEY (seasonId)
);

CREATE TABLE Team (
    teamId int NOT NULL AUTO_INCREMENT,
    teamName VARCHAR(60) NOT NULL,
    coachId int NOT NULL,
	ageGroup VARCHAR(3) NOT NULL,
	teamLocation VARCHAR(30) NOT NULL,
	seasonId VARCHAR(20) NOT NULL,
    PRIMARY KEY (teamId),
	FOREIGN KEY (seasonId) REFERENCES Season(seasonId),
    FOREIGN KEY (coachId) REFERENCES Coach(coachId),
	FOREIGN KEY (ageGroup) REFERENCES ageGroup(ageGroup)
); 

CREATE TABLE Park (
    parkId int NOT NULL AUTO_INCREMENT,
	parkName VARCHAR(60) NOT NULL,
    PRIMARY KEY (parkId)
); 

CREATE TABLE Field (
   	fieldId int NOT NULL AUTO_INCREMENT,
    fieldName VARCHAR(4) NOT NULL,
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
	day CHAR(9) NOT NULL,
	adminId int NOT NULL,
    PRIMARY KEY (practiceId),
	FOREIGN KEY (fieldId) REFERENCES Field(fieldId),
	FOREIGN KEY (teamId) REFERENCES Team(teamId),
	FOREIGN KEY (adminId) REFERENCES Admins(adminId)
); 
