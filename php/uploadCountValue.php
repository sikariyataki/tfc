<?php
header('Access-Control-Allow-Origin: *');
?>
<?php
date_default_timezone_set('Asia/Bangkok');
require("../libs/connect.class.php");
	$db = new database();
	$db->connect();

	$vg_id = $_POST["position"];
	$datePress = mysql_real_escape_string($_POST["datePress"]);
	$timePress = mysql_real_escape_string($_POST["timePress"]);
	$mac_id = mysql_real_escape_string($_POST["mac_id"]);
	$username = mysql_real_escape_string($_POST["username"]);

	$strSQL = "SELECT * FROM tfc_activity a inner join tfc_activity_detail b on a.act_id=b.act_id WHERE a.mac_id = '".$mac_id."' and b.username = '".$username."'";
	$resultSelect = $db->select($strSQL,false,true);

	//echo $strSQL;

	$sql = "INSERT INTO tfc_count_value (vg_id, datePress, timePress, mac_id, act_id, date_sync, time_sync, username) " ;
	$sql .= "VALUES ('".$vg_id."', '".$datePress."', '".$timePress."', '".$mac_id."', '".$resultSelect[0]['act_id']."', '".date('Y-m-d')."', '".date('H:i:s')."', '".$username."')";
	$result = $db->insert($sql, false, true);



	if($result){
		//echo "Comment added";
		//echo $sql;
	}else{
		//echo "No";
	}

	$db->disconnect();
?>
