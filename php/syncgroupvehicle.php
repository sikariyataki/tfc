<?php
header('Access-Control-Allow-Origin: *');
?>
<?php
date_default_timezone_set('Asia/Bangkok');
require("../libs/connect.class.php");
	$db = new database();
	$db->connect();

	$sql = "SELECT * FROM tfc_vehicle_grouping WHERE vg_mac_id in ( SELECT mac_id FROM tfc_main_activity WHERE mac_date = '".date('Y-m-d')."')" ;

	$result = $db->select($sql,false,true);

	$return = '';
	for($i=0;$i<count($result);$i++){
		$return[$i]['vg_id'] = $result[$i]['vg_id'];
		$return[$i]['vg_title'] = $result[$i]['vg_title'];
		$return[$i]['vg_iconname'] = $result[$i]['vg_iconname'];
		$return[$i]['vg_mac_id'] = $result[$i]['vg_mac_id'];
	}

	echo json_encode($return);
	$db->disconnect();
?>
