<?php
header('Access-Control-Allow-Origin: *');
?>
<?php
date_default_timezone_set('Asia/Bangkok');
require("../libs/connect.class.php");
	$db = new database();
	$db->connect();

	$sql = "SELECT * FROM tfc_activity_detail WHERE act_id in (SELECT act_id FROM tfc_activity WHERE mac_id in ( SELECT mac_id FROM tfc_main_activity WHERE mac_date = '".date('Y-m-d')."'))" ;
	// $sql = "SELECT * FROM tfc_activity_detail WHERE act_id in (SELECT act_id FROM tfc_activity WHERE mac_id in ( SELECT mac_id FROM tfc_main_activity WHERE 1))" ;
	$result = $db->select($sql,false,true);

	$return = '';
	for($i=0;$i<count($result);$i++){
		$return[$i]['ad_id'] = $result[$i]['ad_id'];
		$return[$i]['act_id'] = $result[$i]['act_id'];
		$return[$i]['username'] = $result[$i]['username'];
	}

	echo json_encode($return);
	$db->disconnect();
?>
