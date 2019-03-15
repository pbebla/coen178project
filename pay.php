<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
      <title>Show Mechanic's Pay</title>
   </head>
   <body>
<header>
	<h1>We will find the pay of the mechanic working on your car.</h1>
</header>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Please give us your car license number: <input type="text" name="num" id="num">
  <input type="submit" value="Submit">
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # collect input data
     $num = $_POST['num'];

     if (!empty($num)){
		$num = prepareInput($num);
		$data = getFromDB($num);
		echo "Total pay for hours worked on for your car are:$ $data[0]<br>\n Maximum Labor Hours: $data[1] $data[2]\n Minimum Labor Hours: $data[3] $data[4]\n";
		echo "<br> Averages:<br>";
		$x=0;
		while($x<sizeof($data[5])){
			echo $data[5][$x]." ".$data[6][$x];
			echo "<br>";
			$x=$x+1;
		}
	
	 }
}
function getFromDB($num){
	//connect to your database
	$conn=oci_connect('','', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
        exit;
	}
	//Parse the SQL query for bill
	$query = oci_parse($conn, "SELECT sum(laborhrs) FROM RepairJob where car_license_no= :bv");

	oci_bind_by_name($query,':bv',$num);
	// Execute the query
	oci_execute($query);

	if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
		// We can use either numeric indexed starting at 0
		// or the column name as an associative array index to access the colum value
		// Use the uppercase column names for the associative array indices
		$total = $row[0];
	}
	else {
		exit("I'm sorry but that license number is incorrect\n");
	}
	
	$q2 = oci_parse($conn,"select s.emp_id, mname, Hours from (select emp_id, sum(laborhrs) Hours from RepairJob group by emp_id) s, Mechanic where Mechanic.emp_id = s.emp_id and Hours = (select min(Hours) from (select emp_id, sum(laborhrs) Hours from RepairJob group by emp_id))");
	oci_execute($q2);
	if (($row = oci_fetch_array($q2, OCI_BOTH)) != false) {
		// We can use either numeric indexed starting at 0
		// or the column name as an associative array index to access the colum value
		// Use the uppercase column names for the associative array indices
		$minname = $row[1];
		$minnum = $row[2];
	}
	
	$q2 = oci_parse($conn,"select s.emp_id, mname, Hours from (select emp_id, sum(laborhrs) Hours from RepairJob group by emp_id) s, Mechanic where Mechanic.emp_id = s.emp_id and Hours = (select max(Hours) from (select emp_id, sum(laborhrs) Hours from RepairJob group by emp_id))");
	oci_execute($q2);
	if (($row = oci_fetch_array($q2, OCI_BOTH)) != false) {
		// We can use either numeric indexed starting at 0
		// or the column name as an associative array index to access the colum value
		// Use the uppercase column names for the associative array indices
		$maxname = $row[1];
		$maxnum = $row[2];
	}

	$q2 = oci_parse($conn,"select s.emp_id, mname, AvgHours from (select emp_id, avg(laborhrs) AvgHours from RepairJob group by emp_id) s, Mechanic where Mechanic.emp_id = s.emp_id");
	oci_execute($q2);
	$i=0;
	while(($row = oci_fetch_array($q2, OCI_BOTH)) != false) {
		// We can use either numeric indexed starting at 0
		// or the column name as an associative array index to access the colum value
		// Use the uppercase column names for the associative array indices
		$avgname[$i] = $row[1];
		$avghrs[$i] = $row[2];
		$i=$i+1;
	}
	oci_free_statement($query);
	oci_close($conn);

	return array($total*20,$maxname,$maxnum, $minname, $minnum, $avgname, $avghrs);
}

function prepareInput($inputData){
	// Removes any leading or trailing white space
	$inputData = trim($inputData);
	// Removes any special characters that are not allowed in the input

  	$inputData  = htmlspecialchars($inputData);

  	return $inputData;
}

?>
<!-- end PHP script -->
   </body>
</html>
