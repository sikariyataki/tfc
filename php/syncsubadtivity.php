<?php
header('Access-Control-Allow-Origin: *');
?>
<?php
date_default_timezone_set('Asia/Bangkok');
require("../libs/connect.class.php");
	$db = new database();
	$db->connect();

	$sql = "SELECT * FROM tfc_activity WHERE mac_id in ( SELECT mac_id FROM tfc_main_activity WHERE mac_date = '".date('Y-m-d')."')" ;
	// $sql = "SELECT * FROM tfc_activity WHERE mac_id in ( SELECT mac_id FROM tfc_main_activity WHERE 1)" ;
	$result = $db->select($sql,false,true);

	$return = '';
	for($i=0;$i<count($result);$i++){
		$return[$i]['act_id'] = $result[$i]['act_id'];
		$return[$i]['act_title'] = $result[$i]['act_title'];
		$return[$i]['act_position'] = $result[$i]['act_position'];
		$return[$i]['act_desc'] = $result[$i]['act_desc'];
		$return[$i]['act_lat'] = $result[$i]['act_lat'];
		$return[$i]['act_lng'] = $result[$i]['act_lng'];
		$return[$i]['act_location_pic'] = $result[$i]['act_location_pic'];
		$return[$i]['act_direction'] = $result[$i]['act_direction'];
		$return[$i]['mac_id'] = $result[$i]['mac_id'];
	}

	echo json_encode($return);
	$db->disconnect();
?>
