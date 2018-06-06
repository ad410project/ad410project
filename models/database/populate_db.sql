-- -----------------------------------------------------
-- Inserting Dummy data
-- -----------------------------------------------------
 -- User Types Table
INSERT INTO UserType VALUES
	(DEFAULT, 'new'),
    (DEFAULT, 'registered'),
    (DEFAULT, 'organization'),
    (DEFAULT, 'admin');

 -- Filling Users Table
 INSERT INTO Users VALUES
	(DEFAULT, 'notornados@yahoo.com', 'Ka-El', 'Jonathan', 'Kent', NULL, 0, 2), 
    (DEFAULT, 'morethanbutler@wayne.com', 'ihatebats', 'Alfred', 'Pennyworth', 4255551212, 0, 2), 
    (DEFAULT, 'howard@starkindustries.com', 'jarvis', 'Howard', 'Stark', 4254444444, 0, 1),
    (DEFAULT, 'jackkirby@prodigy.com', 'theCreator', 'Jack', 'Kirby', NULL, 0, 2),			
    (DEFAULT, 'jack@reddevilgym.com', 'Battlin', 'Jack', 'Murdock', 6066665555, 0, 3),			
    (DEFAULT, 'margret_carter@aol.com', 'knownValue', 'Margert', 'Carter', NULL, 0, 4),		
    (DEFAULT, 'lynda1@aol.com', 'Hippolyta', 'Lynda', 'Carter', 3609871234, 0, 2), 			
    (DEFAULT, 'ms_marvel@yahoo.com', 'Avengers', 'Carol',  'Danvers', NULL, 0, 2), 			
    (DEFAULT, 'lucas_carl@gmail.com', 'Always-Forward', 'Carl', 'Lucas', 4255558888, 0, 1),		
    (DEFAULT, 'may_be_not@gmail.com', 'responsiblity>power', 'May', 'Parker', 2065557980, 0, 2); 
    
-- Adderess Table
INSERT INTO Addresses VALUES
	(DEFAULT, '321 Dirt Road', NULL, 'SmallVille', 'Kansas', 98111 ),
    (DEFAULT, '1 Wayne Island Drive', NULL, 'Gotham', 'Washington', 11111), 
    (DEFAULT, '505 Lexington Ave', 'Penthouse', 'New York', 'Washington', 10101), 
    (DEFAULT, '5678 George Washington Blvd', 'Apt 404', 'Brooklyn', 'Washington', 10101), 
    (DEFAULT, '666 Hells Kitchen', NULL, 'Seattle', 'Washington', 98103)		,
    (DEFAULT, '5555 Picadily Circle', NULL, 'Seattle', 'Washington', 98107)		,
	(DEFAULT, '888 Paridaise Island Way', 'Themyscria', 'Lopez', 'Washington', 978342) ,
    (DEFAULT, '222 Midtown Blvd', '#404', 'Seattle', 'Washington', 98105)	,
    (DEFAULT, '7777 Harlem Heights Ave', NULL, 'Renton', 'Washington', 98040) ,
    (DEFAULT, '98 Queens Blvd', 'apt 192', 'Shoreline', 'Washington', 98133),
    (DEFAULT, '1911 SW Campus Dr', '#616', 'Federal Way', 'WA' , 98023)		, -- CampQuest 11
    (DEFAULT, '2414 SW Andover Street', 'Suite D-105', 'Seattle', 'WA' , 98106), -- CampFire 12
    (DEFAULT, 'Camp Kirby', NULL,  'Samish Island', 'Washington',  NULL ), -- Camp Kirby 13
    (DEFAULT, '950 NW Carkeek Park Rd', NULL, 'Seattle' , 'WA' , 98177), -- Carkeek 14
    (DEFAULT, '1000 N 50th St', NULL, 'Seattle', 'WA' ,  98103 ),	-- Lower Woodland 15
    (DEFAULT, '14500 SW Camp Sealth Rd', NULL,  'Vashon', 'WA',  98070); -- Sealth 16
	
    
-- Orgs Table
INSERT INTO Organizations VALUES
	(DEFAULT, 11, 'CampQuest NorthWest', 'Camp Quest is a residential summer camp focused on fun, friends, and freethought for kids ages 8-17' ,
		NULL, 'https://campquestnorthwest.org/', 1),
	(DEFAULT, 12, 'Camp Fire Central Puget Sound', 'Camp Fire Central Puget Sound ignites a passion for nature, a commitment to service and a drive to succeed in 6,000 children and teens every year. Since 1915',
		2064618550 , 'https://campfireseattle.org/contact-us/', 2);
 
 -- Events Table
 INSERT INTO `Events` VALUES
	(DEFAULT, 2, 'Woodland Park Day Camp', 'Our day camp is located at Lower Woodland, the entrance at N 50th St and Woodland Park Ave N',NULL, NULL,NULL,NULL,NULL,NULL, NULL,145,186),
    (DEFAULT, 2, ' Carkeek Park Day Camp', 'Carkeek enjoys 220 acres of forest, wetlands, meadow, and beach. Our day camp uses the upper meadow as a base for all operations throughout the week, giving the campers a chance to explore Carkeek’s various ecosystems',
		240.00, 5, 13, 20170717, NULL, NULL, NULL,38,2888),
	(DEFAULT, 1, 'Flying Spaghetti Western: June Session', 'Programming and activities will be the same at both camp sessions', 
		700.00, 8, 17, 20180717, 20180428, 20180629, NULL,264,904),
	(DEFAULT, 1, 'Flying Spaghetti Western: August Session', 'Programming and activities will be the same at both camp sessions', 
		700.00, 8, 17, 20180717, 20180428, 20180629, NULL,11,1221),
	(DEFAULT, 2, 'Camp Sealth: Session 1', 'Short week', 340.00, 6, 14, NULL, NULL, NULL, NULL,66,1604);
 
 -- UserAdresses Table 
INSERT INTO UserAddresses VALUES
	(1,1),
    (2,2),
    (3,3),
    (4,4),
    (5,5),
    (6,6),
    (7,7),
    (8,8),
    (9,9),
    (10,10);
    
-- EventAdress Tables
INSERT INTO EventAddresses VALUES
		(1, 15),
        (2,14),
        (3, 13),
        (4, 13);
     
-- Children Table
INSERT INTO Children VALUES
	(DEFAULT, 1, 'Clark', 'Kent', 20060628, 'Kyptonite', NULL),
    (DEFAULT, 2, 'Bruce', 'Wayne', 20050615, 'Clowns', 425551212),
    (DEFAULT, 3, 'Tony', 'Stark', 20080502, 'Weak Heart', 4254444444),
    (DEFAULT, 4, 'Steve', 'Rogers', 20110622, 'Ice', NULL),
    (DEFAULT, 5,'Matt', 'Murdock', 20030214, 'Asthma', 6066665555),
    (DEFAULT,6, 'Peggy', 'Carter', 20110623, NULL, 3609871234),
    (DEFAULT,7, 'Diana', 'Prince', 20140602, NULL, NULL),
    (DEFAULT,8, 'Jessica', 'Jones', 20070804, NULL, NULL),
    (DEFAULT,9, 'Luke', 'Cage', 20090909, NULL, 4255558888),
    (DEFAULT,10, 'Peter', 'Parker', 20020503, NULL, 2065557980);
    
-- Child Event Linking Table
INSERT INTO ChildEvents VALUES
(NULL,3,3),
(NULL,2,1),
(NULL,3,1),
(NULL,1,2),
(NULL,3,2),
(NULL,1,1),
(NULL,4,1),
(NULL,5,1),
(NULL,3,6),
(NULL,2,7),
(NULL,3,8),
(NULL,1,10),
(NULL,3,9),
(NULL,1,8),
(NULL,4,6),
(NULL,5,2),
(6,4,3),
(7,2,4),
(8,3,5),
(9,1,6),
(10,2,10),
(10,3,10);