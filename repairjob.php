<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
      <title>Create Repair Job</title>
   </head>
   <body>
<header>
	<h1>Please fill out the form below</h1>
</header>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Last Name: <input type="text" name="lastname" id="lastname">
<br/>
  Phone: <input type="text" name="phone" id="phone">
<br/>
  Address: <input type="text" name="addr" id="addr">
<br/>
  Car Model: <input type="text" name="carmod" id="carmod">
<br/>
  Car License No: <input type="text" name="carno" id="carno">
<br/>
  Please select from the list of problems: <select name="prob">
  <option value="Battery">Battery</option>
  <option value="Engine">Engine</option>
  <option value="Tires">Tires</option>
  <option value="Windows">Windows</option>
  <option value="Mirrors">Mirrors</option>
	</select> 
<br/>
	<input type="submit" value="Submit">
 </form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # collect input data
     $name = $_POST['lastname'];
     $phone = $_POST['phone'];
     $addr = $_POST['addr'];
     $carmod = $_POST['carmod'];
     $carno = $_POST['carno'];
	 $problem = $_POST['prob'];
	PostToDB($name, $phone, $addr, $carno, $carmod, $problem);
	echo "Your data has been added successfully";
}
function PostToDB($name, $phone, $addr, $carno, $carmod, $problem){
	//connect to your database
	$conn=oci_connect('','', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> Connection to database failed. Please try again.";
        exit;
	}
	//SQL INSERT FOR CUSTOMERS TABLE
	$sql1 = "INSERT INTO Customers VALUES('$phone','$name','$addr')";
	$insert = oci_parse($conn, $sql1);
	
	// Execute the insert statement
	oci_execute($insert);
	//SQL INSERT FOR CAR TABLE
	$sql2 = "INSERT INTO Car (car_license_no,model,cphone)"."VALUES (:p4,:p5,:p6)";
	$insert = oci_parse($conn, $sql2);
	oci_bind_by_name($insert,':p4',$carno);
	oci_bind_by_name($insert,':p5',$carmod);
	oci_bind_by_name($insert,':p6',$phone);
	// Execute the insert statement
	oci_execute($insert);
	
	//SQL SWITCH FOR INSERT FOR PROBLEMSFIXED
	switch ($problem) {
    case "Battery":
        $id=1;
        break;
    case "Engine":
        $id=2;
        break;
    case "Tires":
        $id=3;
        break;
	case "Windows":
		$id=4;
		break;
	case "Mirrors":
		$id=5;
		break;
	}
	//GET THE MAX NUMBER FROM THE DATABASE FOR THE NEXT PROBLEM ID
	$query = oci_parse($conn, "SELECT max(repairJobId) FROM RepairJob,RepairLog");
	// Execute the query
	oci_execute($query);
	if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
		$max = $row[0]+1;
	}
	else
	{
		$max=1;
	}
	$query2 = oci_parse($conn, "SELECT emp_id FROM Mechanic");
	oci_execute($query2);
	$isFound = false;
	$empid = 43;
	while (($row = oci_fetch_array($query2, OCI_BOTH)) != false and $isFound == false) {
		if(rand(0,1)==1){
			$empid = $row[0];
			$isFound = true;
		}
	}
	//CREATE THE REPAIR JOB
	$sql4 = "INSERT INTO RepairJob(repairjobId,car_license_no,time_in,time_out,emp_id,laborhrs)". "VALUES ('$max','$carno',CURRENT_TIMESTAMP,NULL,'$empid',NULL)";
	$insert = oci_parse($conn, $sql4);
	// Execute the insert statement
	oci_execute($insert);
	
	
	//SQL INSERT FOR PROBLEMFIXED TABLE
	$sql3 = "INSERT INTO ProblemsFixed(repairjobId,problem_id)"."VALUES (:p7,:p8)";
	$insert = oci_parse($conn, $sql3);
	oci_bind_by_name($insert,':p7',$max);
	oci_bind_by_name($insert,':p8',$id);
	// Execute the insert statement
	oci_execute($insert);
	
	//free all resources
	oci_free_statement($insert);
	
	oci_commit($conn);
	//close SQL connection
	oci_close($conn);
}
?>
<!-- end PHP script -->
   </body>
</html>
