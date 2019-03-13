--STILL IN THE PROCESS OF DEBUGGING
CREATE OR Replace TRIGGER createbill 
AFTER UPDATE ON RepairJob 
FOR EACH ROW

DECLARE
r_id integer := :new.repairjobId;
names varchar2(20);
pcost decimal;

BEGIN 
IF :new.time_out<>:old.time_out THEN
Select pname into names from PartsUsed where repairjobId=r_id;
Select cost into pcost from Parts where pname=names;

update RepairJob
set bill = 30 + pcost + (25*:new.laborhrs)

END IF; 
END;
/ 
Show errors;
