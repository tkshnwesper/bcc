<?php
	
	session_start();
	
	$preSecs = 10;
	$deleteSecs = 60;
	$response = array();
	
	// Enter SQL details
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
	
	$preTime = time() - ($preSecs);
	$predatetime = date("Y-m-d H:i:s", $preTime);
	$datetime = date("Y-m-d H:i:s");
	$deleteTime = time() - $deleteSecs;
	$deleteDateTime = date("Y-m-d H:i:s", $deleteTime);
	
	if(!isset($_SESSION["nickname"])) {
		while(true) {
			$sql = "select nickname from onlineusers where session_id = \"". session_id() . "\";";
			$res2 = execQuery($sql);
			if(!mysql_num_rows($res2)) {
				$_SESSION["nickname"] = uniqid();
				$sql = "insert into onlineusers values(\"". session_id() . "\", \"". $_SESSION["nickname"] . "\", \"{$datetime} \");";
				execQueryNoReturn($sql);
			}
			else {
				$_SESSION["nickname"] = mysql_fetch_assoc($res2)["nickname"];
				break;
			}
		}
	}
	
	$sql = "select nickname from onlineusers where datetime >= TIMESTAMP(\"{$predatetime}\");";
	$res = execQuery($sql);
	
	while($row = mysql_fetch_assoc($res)) {
		if(isset($_SESSION["nickname"])) {
			if($row["nickname"] != $_SESSION["nickname"]) {
				array_push($response, $row["nickname"]);
			}
		}
	}
	
	echo json_encode($response);
	
	$sql = "update onlineusers set datetime = \"{$datetime}\" where session_id = \"". session_id() . "\";";
	execQueryNoReturn($sql);
	
	$sql = "delete from onlineusers where datetime < \"{$deleteDateTime}\";";
	execQueryNoReturn($sql);
		
	mysql_close($conn);	
		
?>
