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
 </form>
<br/>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Phone: <input type="text" name="phone" id="phone">
 </form>
<br/>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Address: <input type="text" name="addr" id="addr">
 </form>
<br/>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Car Model: <input type="text" name="carmod" id="carmod">
 </form>
<br/>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Car License No: <input type="text" name="carno" id="carno">
 </form>
<br/>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Please select from the list of problems: <select one>
  <option name="prob" value="Battery">Battery</option>
  <option name="prob" value="Engine">Engine</option>
  <option name="prob" value="Tires">Tires</option>
  <option name="prob" value="Windows">Windows</option>
  <option name="prob" value="Mirrors">Mirrors</option>
	</select> 
 </form>
<br/>
 <form>
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
}
function PostToDB($name, $phone, $addr, $carno, $carmod, $problem){
	//connect to your database
	$conn=oci_connect('myeon','<password>', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> Connection to database failed. Please try again.";
        exit;
	}


	//SQL INSERT FOR CUSTOMERS TABLE
	$insert = oci_parse($conn, "INSERT INTO Customers VALUES (:p1,:p2,:p3)");

	oci_bind_by_name($insert,':p1',$phone);
	oci_bind_by_name($insert,':p2',$name);
	oci_bind_by_name($insert,':p3',$addr);
	// Execute the insert statement
	oci_execute($insert);
	oci_free_statement($insert);



	//SQL INSERT FOR CAR TABLE
	$insert2 = oci_parse($conn, "INSERT INTO Car VALUES (:p4,:p5,:p6)");

	oci_bind_by_name($insert2,':p4',$carno);
	oci_bind_by_name($insert2,':p5',$carmod);
	oci_bind_by_name($insert2,':p6',$phone);
	// Execute the insert statement
	oci_execute($insert2);
	oci_free_statement($insert2);
	

	//SQL INSERT FOR PROBLEMS
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

	//SQL INSERT FOR PROBLEM TABLE
	$insert = oci_parse($conn, "INSERT INTO Customers  (:p1,:p2,:p3)");

	oci_bind_by_name($insert,':p1',$phone);
	oci_bind_by_name($insert,':p2',$name);
	oci_bind_by_name($insert,':p3',$addr);
	// Execute the insert statement
	oci_execute($insert);
	oci_free_statement($insert);

	//close SQL connection
	oci_close($conn);
}
?>
<!-- end PHP script -->
   </body>
</html>
