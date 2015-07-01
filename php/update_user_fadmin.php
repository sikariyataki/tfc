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

// Check confirm admin password
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and password = '".$_POST['password2']."' and usertype = '001' and userstatus = 'YES' and active_status = 'Yes'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "Invalid password!";
  $db->disconnect();
  exit();
}

// Check available useraccount
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_POST['username']."'";
$resultLs = $db->select($strSQL,false,true);
if(!$resultLs){
  print "Useraccount not available!";
  $db->disconnect();
  exit();
}

$strSQL = "UPDATE tfc_useraccount SET usertype = '".$_POST['accountType']."' WHERE username = '".$_POST['username']."'";
$resuktUpdate1 = $db->update($strSQL);

$strSQL = "UPDATE tfc_userinformation SET firstname = '".$_POST['firstname']."', surname = '".$_POST['surname']."', phonenumber = '".$_POST['phone']."', address = '".$_POST['address']."', email = '".$_POST['email']."' WHERE username = '".$_POST['username']."'";
$resultUpdate2 = $db->update($strSQL);

if($resultUpdate2){
  print "Y";
}else{
  print "Can not update user information! - Error code x1";
  $db->disconnect();
  exit();
}

?>
