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

// Check available useraccount
$strSQL = "SELECT * FROM tfc_license_config WHERE lc_ls_id = '".$_POST['lsid']."'";
$resultLsconfig = $db->select($strSQL,false,true);

if($resultLsconfig){  //If available
  $strSQL = "UPDATE tfc_license_config SET lc_regkey = '".$_POST['regkey']."', lc_creater = '".$_SESSION['userTFC']."' WHERE lc_ls_id = '".$_POST['lsid']."'";
  $resultUpdate = $db->update($strSQL);

  $strSQL = "SELECT * FROM tfc_license_config WHERE lc_ls_id = '".$_POST['lsid']."' and lc_regkey = '".$_POST['regkey']."' and lc_creater = '".$_SESSION['userTFC']."'";
  $resultLsconfig = $db->select($strSQL,false,true);

  if($resultLsconfig){
    print "Y";
    $db->disconnect();
    exit();
  }else{
    print "Can not create register key! - Error code x1";
    $db->disconnect();
    exit();
  }

}else{                //If not available
  $strSQL = "INSERT INTO tfc_license_config VALUE ('','".$_POST['regkey']."','".$_SESSION['userTFC']."','".$_POST['lsid']."')";
  $resultInsert = $db->insert($strSQL,false,true);

  $strSQL = "SELECT * FROM tfc_license_config WHERE lc_ls_id = '".$_POST['lsid']."'";
  $resultLsconfig = $db->select($strSQL,false,true);

  if($resultLsconfig){
    print "Y";
    $db->disconnect();
    exit();
  }else{
    print "Can not create register key! - Error code x1";
    $db->disconnect();
    exit();
  }
}

// $strSQL = "UPDATE tfc_useraccount SET usertype = '".$_POST['accountType']."' WHERE username = '".$_POST['username']."'";
// $resuktUpdate1 = $db->update($strSQL);
//
// $strSQL = "UPDATE tfc_userinformation SET firstname = '".$_POST['firstname']."', surname = '".$_POST['surname']."', phonenumber = '".$_POST['phone']."', address = '".$_POST['address']."', email = '".$_POST['email']."' WHERE username = '".$_POST['username']."'";
// $resultUpdate2 = $db->update($strSQL);
//
// if($resultUpdate2){
//   print "Y";
// }else{
//   print "Can not update user information! - Error code x1";
//   $db->disconnect();
//   exit();
// }

?>
