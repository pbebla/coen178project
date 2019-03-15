CREATE OR Replace TRIGGER createbill 
AFTER UPDATE of time_out ON RepairJob 
FOR EACH ROW

DECLARE
pcost decimal;
r_bill decimal;
last_service_date TIMESTAMP;


BEGIN
Select sum(cost) into pcost from Parts where pname in (select pname from PartsUsed where repairjobId=:old.repairjobid);

Select MAX(time_out) into last_service_date from RepairLog where car_license_no in (Select car_license_no from Car);

IF (last_service_date > (:new.time_out - 365)) then
	r_bill := 0.9*(30 + pcost + (25*:old.laborhrs));
ELSE
	r_bill := 30 + pcost + (25*:old.laborhrs);
END IF;  

insert into repairlog values (:old.repairjobid,:old.car_license_no,:old.time_in,:new.time_out,:old.emp_id,:old.laborhrs,r_bill);

dbms_output.put_line('The Bill is: '||r_bill);

END;
/ 
Show errors;
