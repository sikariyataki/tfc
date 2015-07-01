<?php
header('Access-Control-Allow-Origin: *');
?>
<?php
require("../libs/connect.class.php");
	$db = new database();
	$db->connect();

	$sql = "SELECT * FROM tfc_useraccount a inner join tfc_userinformation b on a.username = b.username WHERE a.usertype in ('003','004') and a.userstatus = 'Yes' and a.active_status = 'Yes' and a.license = '".$_GET['ls']."'";
	$result = $db->select($sql,false,true);

	$return = '';
	for($i=0;$i<count($result);$i++){
		$return[$i]['username'] = $result[$i]['username'];
		$return[$i]['password'] = $result[$i]['password'];
		$return[$i]['usertype'] = $result[$i]['usertype'];
		$return[$i]['userstatus'] = $result[$i]['userstatus'];
		$return[$i]['license'] = $result[$i]['license'];
		$return[$i]['active_status'] = $result[$i]['active_status'];
		$return[$i]['firstname'] = $result[$i]['firstname'];
		$return[$i]['surname'] = $result[$i]['surname'];
	}

	echo json_encode($return);
	$db->disconnect();
?>
