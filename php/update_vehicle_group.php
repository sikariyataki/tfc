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

$strSQL = "SELECT * FROM tfc_vehicle_grouping WHERE vg_mac_id = '".$_POST['mac_id']."' and vg_id = '".$_POST['vg_id']."'";
$resultCheck = $db->select($strSQL,false,true);
if(!$resultCheck){
  print "Vehicle group not available! - Error code x2";
  //print $strSQL;
  $db->disconnect();
  exit();
}

// UPDATE vehicle group
$strSQL = "UPDATE tfc_vehicle_grouping SET
          vg_title = '".$_POST['grouptitle']."',
          vg_add_date = '".date('Y-m-d')."',
          vg_iconname = '".$_POST['icon']."'
          WHERE vg_mac_id = '".$_POST['mac_id']."' and vg_id = '".$_POST['vg_id']."'";

$resultUpdate = $db->update($strSQL);
if($resultUpdate){
  print "Y";
}else{
  print "Can not create vehicle group! - Error code x1";
  $db->disconnect();
  exit();
}



?>
