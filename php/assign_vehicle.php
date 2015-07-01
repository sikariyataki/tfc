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
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and password = '".$_POST['password4']."' and usertype = '002' and userstatus = 'Yes' and active_status = 'Yes'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "Invalid password!";
  $db->disconnect();
  exit();
}

// Delete all vehicle in group
$strSQL = "DELETE FROM tfc_activity_vehicle WHERE act_id = '".$_POST['act_id']."' and avh_username = '".$_POST['username']."'";
$resultDel = $db->delete($strSQL);

foreach($_POST['vg_id'] as $d){
  $strSQL = "INSERT INTO tfc_activity_vehicle VALUE ('', '".$_POST['act_id']."', '".$_POST['username']."','".$d."')";
  $resultInsert = $db->insert($strSQL,false,true);
}

// print $strSQL;
print "Y";



?>
