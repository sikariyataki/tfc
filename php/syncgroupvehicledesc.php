<?php
header('Access-Control-Allow-Origin: *');
?>
<?php
date_default_timezone_set('Asia/Bangkok');
require("../libs/connect.class.php");
	$db = new database();
	$db->connect();

	$sql = "SELECT * FROM tfc_grouping_description WHERE vg_id in ( SELECT vg_id FROM tfc_vehicle_grouping WHERE vg_mac_id in (SELECT mac_id FROM tfc_main_activity WHERE mac_date = '".date('Y-m-d')."'))" ;
	$result = $db->select($sql,false,true);

	$return = '';
	for($i=0;$i<count($result);$i++){
		$return[$i]['dg_id'] = $result[$i]['dg_id'];
		$return[$i]['vg_id'] = $result[$i]['vg_id'];
		$return[$i]['vehicle_id'] = $result[$i]['vehicle_id'];
	}

	echo json_encode($return);
	$db->disconnect();
?>
