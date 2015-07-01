<?php
session_start();
require("../libs/connect.class.php");
$db = new database();
$db->connect();

$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_POST['username']."' and password = '".$_POST['password']."' and userstatus = 'Yes' and active_status = 'Yes'";
$resultUser = $db->select($strSQL,false,true);
if($resultUser){
	$_SESSION['userSessionTFC'] = session_id();
	$_SESSION['userTFC'] = $_POST['username'];
	session_write_close();

	print "Y";
}else{
	print "User account not available!";
}
?>
