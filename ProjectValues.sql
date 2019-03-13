--Car Table
INSERT INTO Car VALUES ('A1111','H1234','4081234567');
INSERT INTO Car VALUES ('A2222','V2346','6712834567');


--Customer Table
INSERT INTO Customers VALUES ('1408123456','Bebla','124 Willow St. Santa Clara, CA 95053');
INSERT INTO Customers VALUES ('6712834567','Chan','349 Dimple St. Sunnyvale, CA 95053');


--Problem Table
INSERT INTO Problem VALUES (1,'Battery');
INSERT INTO Problem VALUES (2,'Engine');
INSERT INTO Problem VALUES (3,'Tires');


--Mechanic Table
INSERT INTO Mechanic VALUES (43,'Adams','4089999999',20.00);
INSERT INTO Mechanic VALUES (24,'Smith','8887124003',20.00);


--RepairJob Table
INSERT INTO RepairJob VALUES (1,'A1111',CURRENT_TIMESTAMP,NULL,24,2.00,NULL);
INSERT INTO RepairJob VALUES (2,'A2222',CURRENT_TIMESTAMP,NULL,43,4.50,NULL);

--Parts Table
INSERT INTO Parts VALUES ('Nut',100.00);
INSERT INTO Parts VALUES ('Bolt',500.00);
INSERT INTO Parts VALUES ('Tin',75.00);
INSERT INTO Parts VALUES ('Jack',799.99);


--PartsUsed Table
INSERT INTO PartsUsed VALUES ('Nut',1);
INSERT INTO PartsUsed VALUES ('Bolt',2);

--ProblemsFixed Table


