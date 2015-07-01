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

// Check confirm manager password
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and password = '".$_POST['password3']."' and usertype = '002' and userstatus = 'Yes' and active_status = 'Yes'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "Invalid password!";
  $db->disconnect();
  exit();
}

$strSQL = "SELECT * FROM tfc_vehicle_grouping WHERE vg_mac_id = '".$_POST['mac_id']."' and vg_iconname = '".$_POST['icon']."'";
$resultCheck = $db->select($strSQL,false,true);
if($resultCheck){
  print "Duplicate group [Check by icon]!";
  $db->disconnect();
  exit();
}

// Inser sub activity
$strSQL = "INSERT INTO tfc_vehicle_grouping (vg_title, vg_add_date, vg_iconname, vg_mac_id, vg_username) VALUES ('".$_POST['grouptitle']."', '".date('Y-m-d')."', '".$_POST['icon']."', '".$_POST['mac_id']."', '".$_SESSION['userTFC']."')";
$resultInsert = $db->insert($strSQL,false,true);

if($resultInsert){
  print "Y";
}else{
  print "Can not create vehicle group! - Error code x1";
  $db->disconnect();
  exit();
}



?>
