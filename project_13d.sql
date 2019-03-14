--Min Labor Hours
select s.emp_id, mname, Hours from (select emp_id, sum(laborhrs) Hours from RepairJob group by emp_id) s, Mechanic where Mechanic.emp_id = s.emp_id and Hours = (select min(Hours) from (select emp_id, sum(laborhrs) Hours from RepairJob group by emp_id));

--Max Labor Hours
select s.emp_id, mname, Hours from (select emp_id, sum(laborhrs) Hours from RepairJob group by emp_id) s, Mechanic where Mechanic.emp_id = s.emp_id and Hours = (select max(Hours) from (select emp_id, sum(laborhrs) Hours from RepairJob group by emp_id));

--Avg Hours
select s.emp_id, mname, AvgHours from (select emp_id, avg(laborhrs) AvgHours from RepairJob group by emp_id) s, Mechanic where Mechanic.emp_id = s.emp_id;
