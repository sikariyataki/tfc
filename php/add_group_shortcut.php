<?php
session_start();

require("../libs/connect.class.php");
$db = new database();
$db->connect();

// Check admin privilege
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and usertype = '002' and userstatus = 'YES' and active_status = 'Yes'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "System privilege denine!";
  $db->disconnect();
  exit();
}

$strSQL = "SELECT * FROM tfc_group_shortcut WHERE gs_name = '".$_POST['group_sc']."'";
$resultCheck = $db->select($strSQL,false,true);

if($resultCheck){
  print "Duplicate pattern name! - Error code x2";
  $db->disconnect();
  exit();
}

$strSQL = "DELETE FROM tfc_group_shortcut WHERE gs_mac_id = '".$_POST['mac_id']."'";
$resultDel = $db->delete($strSQL);

// Inser sub activity
$strSQL = "INSERT INTO tfc_group_shortcut VALUES ('','".$_POST['group_sc']."', '".$_POST['mac_id']."')";
$resultInsert = $db->insert($strSQL,false,true);

if($resultInsert){
  print "Y";
}else{
  print "Can not create pattern! - Error code x1";
  $db->disconnect();
  exit();
}



?>
