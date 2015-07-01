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
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and password = '".$_POST['password2']."' and usertype = '002' and userstatus = 'Yes' and active_status = 'Yes'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "Invalid password!";
  $db->disconnect();
  exit();
}

// Check main activity
$strSQL = "SELECT * FROM tfc_main_activity WHERE mac_id = '".$_POST['mac_id']."'";
$resultMac = $db->select($strSQL,false,true);

if(!$resultMac){
  print "Main activity not available! - Error code x2";
  $db->disconnect();
  exit();
}

$strSQL = "UPDATE tfc_main_activity SET mac_title = '".$_POST['act_title']."',
          mac_date = '".$_POST['coldate']."',
          mac_start = '".$_POST['startTime']."',
          mac_end = '".$_POST['endTime']."',
          mac_interval = '".$_POST['interval_val']."',
          mac_activity_type = '".$_POST['acType']."',
          mac_place = '".$_POST['pname']."',
          mac_place_desc = '".$_POST['descs']."'
          WHERE mac_id = '".$_POST['mac_id']."'";
$resultUpdate =$db->update($strSQL);


if($resultUpdate){
  print "Y";
}else{
  print "Can not update main-activity! - Error code x1";
  $db->disconnect();
  exit();
}



?>
