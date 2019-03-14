CREATE OR Replace TRIGGER createbill 
AFTER UPDATE of time_out ON RepairJob 
FOR EACH ROW

DECLARE
pcost decimal;
r_bill decimal;

BEGIN
Select sum(cost) into pcost from Parts where pname in (select pname from PartsUsed where repairjobId=:old.repairjobid);

r_bill := (30 + pcost + (25*:old.laborhrs));

insert into repairlog values (:old.repairjobid,:old.car_license_no,:old.time_in,:new.time_out,:old.emp_id,:old.laborhrs,r_bill);

dbms_output.put_line('The Bill is: '||r_bill);

END;
/ 
Show errors;
