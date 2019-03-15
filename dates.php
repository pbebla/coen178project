<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
      <title>Show Total Bills Between Dates</title>
   </head>
   <body>
<header>
	<h1>We will find total amount from bills between dates.</h1>
</header>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Enter a start date: <input type="text" name="start" id="start">
 <br/>
  Enter an end date: <input type="text" name="end" id="end">
 <br/>
	<input type="submit" value="Submit">
 </form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # collect input data
     $start = $_POST['start'];
	 $end = $_POST['end'];
	 $data = getFromDB($start,$end);
	 echo "Total amount from bills between those dates is: $data<br>\n";

}

function getFromDB($start,$end){
	//connect to your database
	$conn=oci_connect('','', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
        exit;
	}
	//Parse the SQL query for RepairJobs
	//$sql = "SELECT calcTotalBill(':s',':e') from dual";
	$query = oci_parse($conn, "SELECT calcTotalBill(:s,:e) from dual");
	oci_bind_by_name($query,':s',$start);
	oci_bind_by_name($query,':e',$end);
	// Execute the query
	oci_execute($query);

	if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
		// We can use either numeric indexed starting at 0
		// or the column name as an associative array index to access the colum value
		// Use the uppercase column names for the associative array indices
		$total = $row[0];
	}
	else {
		exit("I'm sorry but no bill exists in the database\n");
	}
	oci_free_statement($query);
	oci_close($conn);

	return $total;
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
