<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
      <title>Display Bill</title>
   </head>
   <body>
<header>
	<h1>We will display your bill</h1>
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
		echo "Your Bill is: $data<br>\n";
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
	$query = oci_parse($conn, "SELECT sum(bill) FROM RepairLog where car_license_no= :bv");

	oci_bind_by_name($query,':bv',$num);
	// Execute the query
	oci_execute($query);

	if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
		// We can use either numeric indexed starting at 0
		// or the column name as an associative array index to access the colum value
		// Use the uppercase column names for the associative array indices
		$bill = $row[0];
	}
	else {
		exit("I'm sorry but your bill is not generated yet\n");
	}
	oci_free_statement($query);
	oci_close($conn);

	return $bill;
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
