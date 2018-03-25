-- Table Creation Queries

-- Drop table queries to faciliate testing

DROP TABLE IF EXISTS `shelter_account`;
DROP TABLE IF EXISTS `pet_account`;
DROP TABLE IF EXISTS `user_account`;
DROP TABLE IF EXISTS `calender`;
DROP TABLE IF EXISTS `schedule_appointment`;
DROP TABLE IF EXISTS `view_schedule`;
DROP TABLE IF EXISTS `play_with`;


-- Create a table called shelter_account with the following properties:
-- id - an auto incrementing integer which is the primary key
-- shelterName - a varchar with a maximum length of 255 characters, cannot be null
-- firstName - a varchar with a maximum length of 255 characters, cannot be null
-- lastName - a varchar with a maximum length of 255 characters, cannot be null
-- email - a varchar with a maximum length of 255 characters, cannot be null and must be unique
-- password - a varchar with a maximum length of 255 characters, cannot be null
-- acctCreationDate - a date type
-- accessLevel - an integer, cannot be null


CREATE TABLE shelter_account (
    id int NOT NULL AUTO_INCREMENT,
    shelterName varchar(255) NOT NULL,
    firstName varchar(255) NOT NULL,
    lastName varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    acctCreationDate date,
    accessLevel int NOT NULL,
    permissionCode varchar(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (email)
)ENGINE = InnoDB;


-- Pet name is required upon creation of account
-- Other attributes can be edited in settings


-- Create a table called pet_account with the following properties:
-- id - an auto incrementing integer which is the primary key
-- user - a varchar with a maximum length of 255 characters, cannot be null
-- sid - an integer which is a foreign key reference to the shelter_account table
-- gender - a varchar with a maximum length of 255 characters, default null
-- breed - a varchar with a maximum length of 255 characters, cannot be null
-- species - a varchar with a maximum length of 255 characters, cannot be null
-- description - a text field to describe the pet, like what its fears are and more
-- acctCreationDate - a date type
-- accessLevel - an integer, cannot be null


CREATE TABLE pet_account (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    age int DEFAULT NULL,
    sid int NOT NULL,
    gender varchar(255) DEFAULT NULL,
    breed varchar(255) DEFAULT NULL,
    species varchar(255) DEFAULT NULL,
    description text,
    acctCreationDate date,
    accessLevel int NOT NULL, 
    PRIMARY KEY (id),
    FOREIGN KEY (sid) REFERENCES shelter_account(id) ON DELETE CASCADE
)ENGINE = InnoDB;



-- User fist and last name can be null upon creation of account
-- and can be add/edit in profile settings

-- Create a table called user_account with the following properties:
-- id - an auto incrementing integer which is the primary key
-- sid - an integer which is a foreign key reference to the shelter_account table
-- userName - a varchar with a maximum length of 255 characters, cannot be null and must be unique
-- firstName - a varchar with a maximum length of 255 characters, default null
-- lastName - a varchar with a maximum length of 255 characters, default null
-- email - a varchar with a maximum length of 255 characters, cannot be null and must be unique
-- password - a varchar with a maximum length of 255 characters, cannot be null
-- acctCreationDate - a date type
-- accessLevel - an integer, cannot be null

CREATE TABLE user_account (
    id int NOT NULL AUTO_INCREMENT,
    sid int NOT NULL,
    userName varchar(255) NOT NULL,
    firstName varchar(255) DEFAULT NULL,
    lastName varchar(255) DEFAULT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    acctCreationDate date,
    accessLevel int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (sid) REFERENCES shelter_account(id) ON DELETE CASCADE,
    UNIQUE KEY (userName, email)
)ENGINE = InnoDB;



-- Create a table called calender with the following properties:
-- id - an auto incrementing integer which is the primary key
-- sid - an integer which is a foreign key reference to the shelter_account table
-- pid - an integer which is a foreign key reference to the pet_account table
-- uid - an integer which is a foreign key reference to the user_account table
-- scheduleDate - a datetime type

CREATE TABLE calender (
    id int NOT NULL AUTO_INCREMENT,
    sid int NOT NULL,
    pid int NOT NULL,
    uid int NOT NULL,
    scheduleDate datetime,
    PRIMARY KEY (id),
    FOREIGN KEY (sid) REFERENCES shelter_account(id) ON DELETE CASCADE,
    FOREIGN KEY (pid) REFERENCES pet_account(id) ON DELETE CASCADE,
    FOREIGN KEY (uid) REFERENCES user_account(id) ON DELETE CASCADE
)ENGINE = InnoDB;


-- Create a table called schedule_appointment (many to many relationship with calender and shelter_account) with the following properties:
-- sid - an integer which is a foreign key reference to the shelter_account table
-- cid - an integer which is a foreign key reference to the calender_account table


CREATE TABLE schedule_appointment (
    sid int NOT NULL,
    cid int NOT NULL,
    PRIMARY KEY (sid, cid),
    FOREIGN KEY (sid) REFERENCES shelter_account(id) ON DELETE CASCADE,
    FOREIGN KEY (cid) REFERENCES calender(id) ON DELETE CASCADE
)ENGINE = InnoDB;


-- Create a table called view_schedule (many to many relationship with calender and user_account) with the following properties:
-- uid - an integer which is a foreign key reference to the user_account table
-- cid - an integer which is a foreign key reference to the calender table


CREATE TABLE view_schedule (
    uid int NOT NULL,
    cid int NOT NULL,
    PRIMARY KEY (uid, cid),
    FOREIGN KEY (uid) REFERENCES user_account(id) ON DELETE CASCADE,
    FOREIGN KEY (cid) REFERENCES calender(id) ON DELETE CASCADE
)ENGINE = InnoDB;

-- Create a table called play_with (many to many relationship with pet_account and user_account) with the following properties: 
-- id - an auto incrementing integer which is the primary key
-- uid - an integer which is a foreign key reference to the user_account table
-- pid - an integer which is a foreign key reference to the pet_account table
-- notes - a text field for leaving a note indicating that user and pet are playing with each other

CREATE TABLE play_with (
    id int NOT NULL AUTO_INCREMENT,
    uid int NOT NULL,
    pid int NOT NULL,
    notes text,
    PRIMARY KEY (id),
    FOREIGN KEY (uid) REFERENCES user_account(id) ON DELETE CASCADE,
    FOREIGN KEY (pid) REFERENCES pet_account(id) ON DELETE CASCADE
)ENGINE = InnoDB;


-- Create Shelter's account 
INSERT INTO shelter_account(shelterName, firstName, lastName, email, password, acctCreationDate, permissionCode, accessLevel) VALUES 
("Animal Society", "Jane", "Doe", "lovedog@gmail.com", "dog6", "2017-06-04", "SuperSecret999", 5);


-- Create pet's accounts
INSERT INTO pet_account(name, age, sid, gender,  species, breed, description, acctCreationDate, accessLevel) VALUES 
('dog1', 1, 1, 'M', 'dog', 'pug', 'none', '2017-06-06', 0),
('dog2', 2, 1, 'F', 'dog', 'Labrador', 'none', '2017-06-06', 0),
('dog3', 3, 1, 'M', 'dog', 'Husky', 'none', '2017-06-06', 0),
('dog4', 4, 1, 'F', 'dog', 'Mixed Breed', 'none', '2017-06-06', 0),
('cat1', 1, 1, 'F', 'cat', 'domestic shorthair', 'likes to snuggle','2017-06-06', 0),
('cat2', 2, 1, 'F', 'cat', 'domestic shorthair', 'none','2017-06-06', 0),
('cat3', 3, 1, 'F', 'cat', 'domestic shorthair', 'doesnt sleep at night','2017-06-06', 0),
('cat4', 4, 1, 'M', 'cat', 'siamese', 'likes to snuggle','2017-06-06', 0);


-- Create user's accounts
INSERT INTO user_account(userName, firstName, lastName, email, password, acctCreationDate, accessLevel, sid) VALUES
('user1', 'John', 'Doe', 'jdoe1@gmail.com', 'dog123', '2017-06-10', 1, 1),
('user2', 'Jane', 'Doe', 'jdoe2@gmail.com', 'dog123', '2017-06-10', 1, 1),
('user3', 'Jody', 'Doe', 'jdoe3@gmail.com', 'dog123', '2017-06-10', 1, 1),
('user4', 'Jonas', 'Doe', 'jdoe4@gmail.com', 'dog123', '2017-06-10', 1, 1),
('user5', 'Joe', 'Doe', 'jdoe5@gmail.com', 'dog123', '2017-06-10', 1, 1),
('user6', 'Jake', 'Doe', 'jdoe6@gmail.com', 'dog123', '2017-06-10', 1, 1),
('user7', 'Jorge', 'Doe', 'jdoe7@gmail.com', 'dog123', '2017-06-10', 1, 1),
('user8', 'Juan', 'Doe', 'jdoe8@gmail.com', 'dog123', '2017-06-10', 1, 1);


-- Schedule appointments
INSERT INTO calender(sid, pid, uid, scheduleDate) VALUES 
((SELECT id FROM shelter_account WHERE shelterName = 'Animal Society'), (SELECT id FROM pet_account WHERE name = 'dog1'), (SELECT id FROM user_account WHERE userName = 'user1'), "2017-06-11 12:30:00"),
((SELECT id FROM shelter_account WHERE shelterName = 'Animal Society'), (SELECT id FROM pet_account WHERE name = 'dog2'), (SELECT id FROM user_account WHERE userName = 'user2'), "2017-06-12 12:30:00"),
((SELECT id FROM shelter_account WHERE shelterName = 'Animal Society'), (SELECT id FROM pet_account WHERE name = 'dog3'), (SELECT id FROM user_account WHERE userName = 'user3'), "2017-06-13 12:30:00"),
((SELECT id FROM shelter_account WHERE shelterName = 'Animal Society'), (SELECT id FROM pet_account WHERE name = 'dog4'), (SELECT id FROM user_account WHERE userName = 'user4'), "2017-06-14 12:30:00"),
((SELECT id FROM shelter_account WHERE shelterName = 'Animal Society'), (SELECT id FROM pet_account WHERE name = 'cat1'), (SELECT id FROM user_account WHERE userName = 'user5'), "2017-06-15 12:30:00"),
((SELECT id FROM shelter_account WHERE shelterName = 'Animal Society'), (SELECT id FROM pet_account WHERE name = 'cat2'), (SELECT id FROM user_account WHERE userName = 'user6'), "2017-06-16 12:30:00"),
((SELECT id FROM shelter_account WHERE shelterName = 'Animal Society'), (SELECT id FROM pet_account WHERE name = 'cat3'), (SELECT id FROM user_account WHERE userName = 'user7'), "2017-06-17 12:30:00"),
((SELECT id FROM shelter_account WHERE shelterName = 'Animal Society'), (SELECT id FROM pet_account WHERE name = 'cat4'), (SELECT id FROM user_account WHERE userName = 'user8'), "2017-06-18 12:30:00");









    