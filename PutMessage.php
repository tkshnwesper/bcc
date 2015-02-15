<?php
	
	session_start();

	// Vars
	
	$counter = 0;
	
	if(isset($_POST["message"])) {
		$message = $_POST["message"];
	} else { die("Error in fetching message"); }

	// Enter details for your server
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
	
	function execQueryNoReturn($sql) {
		global $conn;
		$res = mysql_query($sql, $conn);
	}
	
?>

<?php
	
	$datetime = date("Y-m-d H:i:s");
	
	$sql = "lock tables timeid;";
	execQueryNoReturn($sql);
	
	$sql = "select * from timeid where datetime = timestamp(\"{$datetime}\");";
	$res = execQuery($sql);
	
	if(mysql_num_rows($res)) {
		$row = mysql_fetch_assoc($res);
		$counter = $row["counter"];
		++$counter;
		$sql = "update timeid set counter = {$counter} where datetime = timestamp(\"{$datetime}\");";
		execQueryNoReturn($sql);
	}
	
	else {
		$sql = "insert into timeid values(\"{$datetime}\", \"{$counter}\");";
		execQueryNoReturn($sql);
	}
	
	$sql = "unlock tables;";
	execQueryNoReturn($sql);
	
	while(true) {
		$sql = "select nickname from onlineusers where session_id = \"". session_id() . "\";";
		$res = execQuery($sql);
		
		if(!mysql_num_rows($res)) {
			$_SESSION["nickname"] = uniqid();
			$sql = "insert into onlineusers values(\"". session_id() . "\", \"". $_SESSION["nickname"] . "\", \"{$datetime} \");";
			execQueryNoReturn($sql);
		}
		else { break; }
	}
	$sql="insert into messages values(\"". mysql_fetch_assoc($res)["nickname"] . "\", \"{$datetime}\", \"{$counter}\", \"{$message}\");";
	execQueryNoReturn($sql);

	mysql_close($conn);
	
?>
