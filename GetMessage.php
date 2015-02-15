<?php
	
	// Vars
	
	$preSecs = 5;
	$response = array();
	
	// Enter the details for your server
	$host="";
	$user="";
	$pass="";
	$conn=mysql_connect($host, $user, $pass);
	if(!$conn)
	{
		die("Could not connect " . mysql_error());
	}
	mysql_select_db("");
	
?>

<?php
	
	// Functions
	
	function execQuery($sql) {
		global $conn;
		$res = mysql_query($sql, $conn);
		return $res;
	}
	
?>


<?php
	
	$preTime = time() - ($preSecs);
	$predatetime = date("Y-m-d H:i:s", $preTime);

	$sql = "select * from messages where datetime >= TIMESTAMP(\"{$predatetime}\") order by datetime, position asc;";
	$res = execQuery($sql);
	
	while($row=mysql_fetch_assoc($res)) {
		array_push($response, $row);
	}
	
	echo json_encode($response);
	
	mysql_close($conn);
	
?>
