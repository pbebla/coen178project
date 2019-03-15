CREATE OR Replace TRIGGER createbill 
AFTER UPDATE ON RepairJob 
FOR EACH ROW

DECLARE
r_id integer := :new.repairjobId;
names varchar2(20);
pcost decimal;
last_service_date TIMESTAMP;
pbill decimal;
c boolean;							/* used later on to ensure a calculated value is either 0 or 1 */

BEGIN 
IF :new.time_out<>:old.time_out THEN
Select pname into names from PartsUsed where repairjobId=r_id;
Select cost into pcost from Parts where pname=names;

Select MAX(time_out) into last_service_date from RepairLog inner join Car
where RepairLog.car_license_no=Car.car_license_no;

/* If the new version works delete this lol

IF (last_service_date > (:new.time_out - 365)) then
	pbill := 0.9*( 30 + pcost + (25*:new.laborhrs));
ELSE
	pbill := 30 + pcost + (25*:new.laborhrs);
END IF;  
*/

c := 365/(last_service_date - :new.time_out);			/* if last service date within a yr->TRUE (i.e. 1), else FALSE (0) */
pbill :=  c*0.9*( 30 + pcost + (25*:new.laborhrs));

INSERT INTO RepairLog 
(repairjobId, car_license_no, time_in, time_out, emp_id, laborhrs, bill) 
VALUES 
(:new.repairjobId, :new.car_license_no, :new.time_in, :new.time_out, :new.emp_id, 
:new.laborhrs, pbill); 

DELETE FROM RepairJob WHERE repairjobId=:new.repairjobId;

END IF;
END;
/ 
Show errors;
