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

// Delete all vehicle in group
$strSQL = "DELETE FROM tfc_grouping_description WHERE vg_id = '".$_POST['vg_id']."'";
$resultDel = $db->delete($strSQL);

foreach($_POST['vehicle'] as $d){
  $strSQL = "INSERT INTO tfc_grouping_description VALUE ('', '".$_POST['vg_id']."', '".$d."')";
  $resultInsert = $db->insert($strSQL,false,true);
}

print "Y";



?>
