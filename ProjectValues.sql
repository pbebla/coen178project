--Customer Table
INSERT INTO Customers VALUES ('4081234567','Bebla','124 Willow St. Santa Clara, CA 95053');
INSERT INTO Customers VALUES ('6712834567','Chan','349 Dimple St. Sunnyvale, CA 94043');
INSERT INTO Customers VALUES ('8889876543','Jacobs','444 Nowhere Lane Cupertino, CA 94024');
INSERT INTO Customers VALUES ('1009627236','Stevens','666 Devil St. San Francisco, CA 94666');
INSERT INTO Customers VALUES ('3339238293','Jones','180 Lala Ave. San Jose, CA 95555');

--Car Table
INSERT INTO Car VALUES ('A1111','H1234','4081234567');
INSERT INTO Car VALUES ('A2222','V2346','6712834567');


--Problem Table
INSERT INTO Problem VALUES (1,'Battery');
INSERT INTO Problem VALUES (2,'Engine');
INSERT INTO Problem VALUES (3,'Tires');
INSERT INTO Problem VALUES (4,'Windows');
INSERT INTO Problem VALUES (5,'Mirrors');


--Mechanic Table
INSERT INTO Mechanic VALUES (43,'Adams','4089999999',20.00);
INSERT INTO Mechanic VALUES (24,'Smith','8887124003',20.00);
INSERT INTO Mechanic VALUES (61,'Enriquez','8117774444',20.00);


--RepairJob Table
INSERT INTO RepairJob VALUES (11,'A1111',CURRENT_TIMESTAMP,NULL,24,2.00,NULL);
INSERT INTO RepairJob VALUES (27,'A2222',CURRENT_TIMESTAMP,NULL,43,4.50,NULL);
INSERT INTO RepairJob VALUES (44,'A2222',CURRENT_TIMESTAMP,NULL,61,6.00,NULL);

--Parts Table
INSERT INTO Parts VALUES ('Nut',100.00);
INSERT INTO Parts VALUES ('Bolt',500.00);
INSERT INTO Parts VALUES ('Tin',75.00);
INSERT INTO Parts VALUES ('Jack',799.99);


--PartsUsed Table
INSERT INTO PartsUsed VALUES (11,'Nut');
INSERT INTO PartsUsed VALUES (27,'Bolt');
INSERT INTO PartsUsed VALUES (27,'Tin');
INSERT INTO PartsUsed VALUES (44,'Jack');

--ProblemsFixed Table
INSERT INTO ProblemsFixed VALUES (11,1);
INSERT INTO ProblemsFixed VALUES (27,1);
INSERT INTO ProblemsFixed VALUES (27,2);
INSERT INTO ProblemsFixed VALUES (44,5);

