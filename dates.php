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
  Enter a start date Format(: <input type="text" name="start" id="start">
  <input type="submit" value="Submit">
 </form>
 <br/>
 <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Enter an end date: <input type="text" name="end" id="end">
  <input type="submit" value="Submit">
 </form>
 <br/>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # collect input data
     $num = $_POST['num'];

     if (!empty($num)){
		$num = prepareInput($num);
		$data = getFromDB($start,$end);
		echo "Bills are: $data<br>\n";
	 }
}
function getFromDB($start,$end){
	//connect to your database
	$conn=oci_connect('myeon','mamaluigi1', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";
        exit;
	}
	//Parse the SQL query for RepairJobs
	$query = oci_parse($conn, "SELECT calcTotalBill ($start,$end)");

	// Execute the query
	oci_execute($query);

	if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
		// We can use either numeric indexed starting at 0
		// or the column name as an associative array index to access the colum value
		// Use the uppercase column names for the associative array indices
		$total = $row[0];
	}
	else {
		exit("I'm sorry but your bill is not generated yet\n");
	}
	oci_free_statement($query);
	oci_close($conn);

	return $total*20;
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
