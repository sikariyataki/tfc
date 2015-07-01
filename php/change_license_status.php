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

// Update license
$strSQL = "UPDATE tfc_license SET ls_status = '".$_POST['todo']."' WHERE ls_id = '".$_POST['ls_id']."'";
$result = $db->update($strSQL);

// Check updated license
$strSQL = "SELECT * FROM tfc_license WHERE ls_id = '".$_POST['ls_id']."' and ls_status = '".$_POST['todo']."'";
$resultUpdate = $db->select($strSQL,false,true);
if($resultUpdate){
    print "Y";
}else{
  //print
  print "Can not update this license status!";
  $db->disconnect();
  exit();
}

?>
