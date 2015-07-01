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
// Check sub activity
$strSQL = "SELECT * FROM tfc_activity WHERE act_id = '".$_POST['act_id']."' and mac_id = '".$_POST['mac_id']."'";
$resultCheck = $db->select($strSQL,false,true);

if(!$resultCheck){
  print "Sub activity id not available - Error code x2!";
  $db->disconnect();
  exit();
}

// Update sub activity
$strSQL = "UPDATE tfc_activity SET
          act_title = '".$_POST['subtitle']."',
          act_position = '".$_POST['position']."',
          act_desc = '".$_POST['other_desc']."',
          act_direction = '".$_POST['direction']."'
          WHERE act_id = '".$_POST['act_id']."' and mac_id = '".$_POST['mac_id']."'";
$resultUpdate = $db->update($strSQL);

// Check sub activity
$strSQL = "SELECT * FROM tfc_activity WHERE act_id = '".$_POST['act_id']."' and mac_id = '".$_POST['mac_id']."'";
$resultCheck = $db->select($strSQL,false,true);

if($resultCheck){
  print "Y";
}else{
  print "Can not create sub-activity! - Error code x1";
  $db->disconnect();
  exit();
}



?>
