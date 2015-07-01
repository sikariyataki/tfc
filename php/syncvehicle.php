<?php
header('Access-Control-Allow-Origin: *');
?>
<?php
date_default_timezone_set('Asia/Bangkok');
require("../libs/connect.class.php");
	$db = new database();
	$db->connect();

	$sql = "SELECT * FROM tfc_vehicletype WHERE mobile_icon_available = 'Yes'" ;

	$result = $db->select($sql,false,true);

	$return = '';
	for($i=0;$i<count($result);$i++){
		$return[$i]['vehicle_id'] = $result[$i]['vehicle_id'];
		$return[$i]['vehicle_detail'] = $result[$i]['vehicle_detail'];
	}

	echo json_encode($return);
	$db->disconnect();
?>
