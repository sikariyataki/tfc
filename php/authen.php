<?php
session_start();
if(isset($_SESSION['userTFC'])){
	if($_SESSION['userTFC']==''){
		header('Location: ../');
		exit();
	}
}else{
	header('Location: ../');
	exit();
}


require("../libs/connect.class.php");
$db = new database();
$db->connect();

$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and userstatus = 'Yes'";
$resultUser = $db->select($strSQL,false,true);

//print $strSQL;
//exit();
if($resultUser){
	switch($resultUser[0]['usertype']){
		case '001': header('Location: ../administrator/index.php'); break;
		case '002': header('Location: ../manager/index.php'); break;
		default: header('Location: ../signout.php');
	}
}else{
	header('Location: ../signout.php');
	exit();
}
?>
