
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
    PRIMARY KEY (practiceId),
	FOREIGN KEY (fieldId) REFERENCES Field(fieldId),
	FOREIGN KEY (teamId) REFERENCES Team(teamId),
	FOREIGN KEY (adminId) REFERENCES Admins(adminId)
); 

CREATE TABLE announcements (
    announcementId INT(11) AUTO_INCREMENT,
    announcement CHAR(255),
    status TINYINT(1),
    adminID INT (11),
    announcementDate DATE,
    PRIMARY KEY (announcementId),
    FOREIGN KEY (adminId) REFERENCES admins(adminId)
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
VALUES  ('field 11', 1, 0),
        ('field 12', 1, 0),
        ('field 13', 1, 0),
        ('field 14', 1, 0),
        ('field 15', 1, 0),
        ('field 16', 1, 0),
        ('field 17', 1, 0),
        ('field 18', 1, 1),
        ('field 19', 1, 1),
        ('field 20', 1, 1),
        ('field 21', 1, 1),
        ('field 22', 1, 1),
        ('field 23', 1, 0),
        ('field 24', 1, 0),
        ('field 25', 1, 0),
        ('field 26', 1, 0),
        ('field 27', 1, 0),
        ('field 2', 2, 1),
        ('field 6', 2, 1);

insert into Admins (username, password)
values ('lane', '$2y$10$FXMGOs9k2HLSRgCqH4FFGuxYMS1qXYGURLW5n4x.T01c9DlmRSfa6');

INSERT INTO Season (seasonId, seasonStatus)
values ('FALL 2022', '1');
