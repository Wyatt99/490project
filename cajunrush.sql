
CREATE TABLE Admins (
    adminId int NOT NULL AUTO_INCREMENT,
    username VARCHAR(60) NOT NULL,
    password CHAR(60) NOT NULL,
   	PRIMARY KEY (adminId)
); 

CREATE TABLE ageGroup (
	ageGroup INT(3) NOT NULL,
	PRIMARY KEY (ageGroup)
);

CREATE TABLE Season (
	seasonId VARCHAR(20) NOT NULL,
	seasonStatus TINYINT(1) NOT NULL,
	PRIMARY KEY (seasonId)
);

CREATE TABLE teamLocation (
	teamLocation VARCHAR(30) NOT NULL,
	PRIMARY KEY (teamLocation)
);

CREATE TABLE Team (
    teamId int NOT NULL,
	  teamIdentifier VARCHAR(60),
    teamName VARCHAR(60) NOT NULL,
    coachFirstName VARCHAR(60) NOT NULL,
    coachLastName VARCHAR(60) NOT NULL,
    coachEmail VARCHAR(60),
    ageGroup INT(3) NOT NULL,
    teamLocation VARCHAR(30) NOT NULL,
    seasonId VARCHAR(20) NOT NULL,
    PRIMARY KEY (teamId),
    FOREIGN KEY (seasonId) REFERENCES Season(seasonId),
    FOREIGN KEY (ageGroup) REFERENCES ageGroup(ageGroup),
    FOREIGN KEY (teamLocation) REFERENCES teamLocation(teamLocation),
    unique (ageGroup, teamLocation, teamName, seasonId)
); 

CREATE TABLE Park (
    parkId int NOT NULL AUTO_INCREMENT,
	parkName VARCHAR(60) NOT NULL,
    PRIMARY KEY (parkId)
); 

CREATE TABLE Field (
   	fieldId int NOT NULL AUTO_INCREMENT,
    fieldName VARCHAR(40) NOT NULL,
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
    parkname 
    PRIMARY KEY (practiceId),
	FOREIGN KEY (fieldId) REFERENCES Field(fieldId),
	FOREIGN KEY (teamId) REFERENCES Team(teamId),
	FOREIGN KEY (adminId) REFERENCES Admins(adminId)
); 

INSERT INTO ageGroup (ageGroup)
VALUES ('5');
INSERT INTO ageGroup (ageGroup)
VALUES ('6');
INSERT INTO ageGroup (ageGroup)
VALUES ('7');
INSERT INTO ageGroup (ageGroup)
VALUES ('8');
INSERT INTO ageGroup (ageGroup)
VALUES ('9');
INSERT INTO ageGroup (ageGroup)
VALUES ('10');

INSERT INTO teamLocation (teamLocation)
VALUES ('NS');
INSERT INTO teamLocation (teamLocation)
VALUES ('PB');
INSERT INTO teamLocation (teamLocation)
VALUES ('RS');
INSERT INTO teamLocation (teamLocation)
VALUES ('PR');


INSERT INTO park (parkId, parkName)
VALUES ('1', 'Moore Park'), ('2', 'Youngsville Sports Complex');

INSERT INTO field (fieldName,parkId,lights)
VALUES  ('field 1', 1, 1),
        ('field 2', 1, 0),
        ('field 3', 1, 1),
        ('field 4', 1, 0),
        ('field 1', 2, 1),
        ('field 2', 2, 0),
        ('field 3', 2, 1),
        ('field 4', 2, 0);


insert into Admins (username, password)
values ('lane', '$2y$10$FXMGOs9k2HLSRgCqH4FFGuxYMS1qXYGURLW5n4x.T01c9DlmRSfa6');

INSERT INTO Season (seasonId, seasonStatus)
VALUES ('FALL 2022', '1');

INSERT INTO park (parkId, parkName) 
VALUES (1, 'Moore Park'), (2,'Youngsville Sports Complex');