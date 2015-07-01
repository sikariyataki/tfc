<?php
session_start();


require("../libs/connect.class.php");
$db = new database();
$db->connect();

// Check admin privilege
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and usertype = '001' and userstatus = 'YES' and active_status = 'Yes'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "System privilege denine!";
  $db->disconnect();
  exit();
}

// Check duplicate license
$strSQL = "SELECT * FROM tfc_license WHERE ls_id = '".$_POST['ls_id']."'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "License not available!";
  $db->disconnect();
  exit();
}

$strSQL = "SELECT * FROM tfc_license WHERE ls_id = '".$_POST['ls_id']."'";
$resultLs = $db->select($strSQL,false,true);

if($resultLs){
  $strSQL = "DELETE FROM tfc_userinformation WHERE username in (SELECT username FROM tfc_useraccount WHERE license = '".$_POST['ls_id']."')";
  $resultDel = $db->delete($strSQL);

  // DELETE license
  $strSQL = "DELETE FROM tfc_license WHERE ls_id = '".$_POST['ls_id']."'";
  $result = $db->delete($strSQL);

  $strSQL = "SELECT * FROM tfc_license WHERE ls_id = '".$_POST['ls_id']."'";
  $resultDelete = $db->select($strSQL,false,true);

  // Check updated license

  if(!$resultDelete){
    $strSQL = "DELETE FROM tfc_useraccount WHERE license = '".$_POST['ls_id']."'";
    $resultDel = $db->delete($strSQL);
    print "Y";
  }else{
    print "Can not delete this license! - Error x1";
    $db->disconnect();
    exit();
  }
}else{
  print "Can not delete this license! - Error x2";
  $db->disconnect();
  exit();
}

?>
