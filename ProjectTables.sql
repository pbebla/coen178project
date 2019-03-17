create table Problem(problem_id int primary key, type varchar(20));
create table Customers(cphone char(10) primary key, cname varchar(20), address varchar(50));
create table Mechanic(emp_id int primary key, mname varchar(20), mphone char(10), payrate decimal(*,2));
create table Car(car_license_no varchar(5) primary key, model varchar(5), cphone char(10), foreign key(cphone) references Customers(cphone));
create table RepairJob(repairjobId int primary key, car_license_no varchar(5), time_in timestamp(0), time_out timestamp(0), emp_id int, laborhrs decimal(*,2), foreign key(car_license_no) references Car(car_license_no), foreign key(emp_id) references Mechanic(emp_id));
create table Parts(pname varchar(20) primary key, cost decimal(*,2));
create table PartsUsed(repairjobId int, pname varchar(20), foreign key(repairJobId) references RepairJob(repairjobId) ON DELETE CASCADE, foreign key(pname) references Parts(pname), primary key(repairjobId, pname));
create table ProblemsFixed(repairjobId int, problem_id int, foreign key(repairjobId) references RepairJob(repairjobId) ON DELETE CASCADE, foreign key(problem_id) references Problem(problem_id), primary key(repairjobId, problem_id));
create table RepairLog(repairjobId int primary key, car_license_no varchar(5), time_in timestamp(0), time_out timestamp(0) not null, emp_id int, laborhrs decimal(*,2), bill decimal(*,2), foreign key(car_license_no) references Car(car_license_no), foreign key(emp_id) references Mechanic(emp_id));
