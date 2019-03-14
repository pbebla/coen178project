create or replace procedure listRepairJobs(time_begin in timestamp, time_end in timestamp)
IS
	c_id RepairLog.repairjobId%type;
	c_model Car.model%type;
	c_mname Mechanic.mname%type;
	c_time_in RepairLog.time_in%type;
	c_time_out RepairLog.time_out%type;
	cursor c_q1 IS (select distinct RepairLog.repairjobId, model, mname, time_in, time_out from RepairLog, Car, ProblemsFixed, Mechanic where
RepairLog.car_license_no=Car.car_license_no and
RepairLog.emp_id = Mechanic.emp_id);
BEGIN
	open c_q1;
	loop
	fetch c_q1 into c_id, c_model, c_mname, c_time_in, c_time_out;
		exit when c_q1%notfound;
		if c_time_out>=time_begin and c_time_out<=time_end then
			dbms_output.put_line(c_id||' '||c_model||' '||' '||c_mname||' '||c_time_in||' '||c_time_out);
			for loop_emp in (select distinct type from Problem, RepairJob, ProblemsFixed where ProblemsFixed.repairjobId = c_id and Problem.problem_id=ProblemsFixed.problem_id)
			loop
				dbms_output.put_line(loop_emp.type);
			end loop loop_emp;
		end if;
	end loop;
	close c_q1;
end;
/
show errors;


