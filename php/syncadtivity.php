<?php
header('Access-Control-Allow-Origin: *');
?>
<?php
date_default_timezone_set('Asia/Bangkok');
require("../libs/connect.class.php");
	$db = new database();
	$db->connect();

	$sql = "SELECT * FROM tfc_main_activity WHERE mac_date = '".date('Y-m-d')."'" ;
	// $sql = "SELECT * FROM tfc_main_activity WHERE mac_date = '2015-03-22'" ;
	$result = $db->select($sql,false,true);

	$return = '';
	for($i=0;$i<count($result);$i++){
		$return[$i]['mac_id'] = $result[$i]['mac_id'];
		$return[$i]['mac_title'] = $result[$i]['mac_title'];
		$return[$i]['mac_date'] = $result[$i]['mac_date'];
		$return[$i]['mac_start'] = $result[$i]['mac_start'];
		$return[$i]['mac_end'] = $result[$i]['mac_end'];
		$return[$i]['mac_activity_type'] = $result[$i]['mac_activity_type'];
		$return[$i]['mac_place'] = $result[$i]['mac_place'];
		$return[$i]['mac_place_desc'] = $result[$i]['mac_place_desc'];
	}

	echo json_encode($return);
	$db->disconnect();
?>
