<?php
header('Access-Control-Allow-Origin: *');
?>
<?php
date_default_timezone_set('Asia/Bangkok');
require("../libs/connect.class.php");
	$db = new database();
	$db->connect();

	// $sql = "SELECT * FROM tfc_license_config WHERE 1" ;
	$sql = "SELECT * FROM tfc_license_config WHERE lc_regkey = '".$_GET['lsCode']."'" ;
	$result = $db->select($sql,false,true);

	// if($result){
	// 	return $result[0]['lc_ls_id'];
	// }else{
	// 	return "N";
	// }
	 $return = '';
	for($i=0;$i<count($result);$i++){
		$return[$i]['lc_regkey'] = $result[$i]['lc_regkey'];
		$return[$i]['lc_ls_id'] = $result[$i]['lc_ls_id'];
	}

	echo json_encode($return);
	$db->disconnect();
?>
