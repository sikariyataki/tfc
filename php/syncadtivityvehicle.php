<?php
header('Access-Control-Allow-Origin: *');
?>
<?php
date_default_timezone_set('Asia/Bangkok');
require("../libs/connect.class.php");
	$db = new database();
	$db->connect();

	$sql = "SELECT * FROM tfc_activity_vehicle WHERE avh_act_id in (SELECT act_id FROM tfc_activity WHERE mac_id in ( SELECT mac_id FROM tfc_main_activity WHERE mac_date = '".date('Y-m-d')."')) " ;

	$result = $db->select($sql,false,true);

	$return = '';
	for($i=0;$i<count($result);$i++){
		//$return[$i]['avh_id'] = $result[$i]['avh_id'];
		$return[$i]['avh_act_id'] = $result[$i]['avh_act_id'];
		$return[$i]['avh_username'] = $result[$i]['avh_username'];
		$return[$i]['avh_vg_id'] = $result[$i]['avh_vg_id'];
	}

	echo json_encode($return);
	$db->disconnect();
?>
