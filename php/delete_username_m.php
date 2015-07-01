<?php
session_start();
require("../libs/connect.class.php");
$db = new database();
$db->connect();

// Check admin privilege
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and usertype = '002' and userstatus = 'Yes' and active_status = 'Yes'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "System privilege denine!";
  $db->disconnect();
  exit();
}

// Check duplicate license
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_POST['username']."'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "Useraccount not available!";
  $db->disconnect();
  exit();
}

if($result[0]['usertype']=='002'){
  // If manager account
  $strSQL = "SELECT * FROM tfc_useraccount WHERE license = '".$result[0]['license']."' and usertype = '002'";
  $resultLsParticipant = $db->select($strSQL,false,true);

  if($resultLsParticipant){
    if(sizeof($resultLsParticipant)>1){

      $strSQL = "DELETE FROM tfc_userinformation WHERE username = '".$_POST['username']."'";
      $resultDel1 = $db->delete($strSQL);

      $strSQL = "DELETE FROM tfc_useraccount WHERE username = '".$_POST['username']."'";
      $resultDel2 = $db->delete($strSQL);

      if($resultDel1 && $resultDel2){
        print "Y";
        $db->disconnect();
        exit();
      }else{
        print "Can not delete this useraccount! - Error x4";
        $db->disconnect();
        exit();
      }
    }else{
      // There is only 1 manager for this license
      print "Can not delete this useraccount! - Error x1";
      $db->disconnect();
      exit();
    }
  }else{
    print "Can not delete this useraccount! - Error x2";
    $db->disconnect();
    exit();
  }
}else{
  // If not manager account
  $strSQL = "DELETE FROM tfc_userinformation WHERE username = '".$_POST['username']."'";
  $resultDel1 = $db->delete($strSQL);

  $strSQL = "DELETE FROM tfc_useraccount WHERE username = '".$_POST['username']."'";
  $resultDel2 = $db->delete($strSQL);

  if($resultDel1 && $resultDel2){
    print "Y";
    $db->disconnect();
    exit();
  }else{
    print "Can not delete this useraccount! - Error x3";
    $db->disconnect();
    exit();
  }
}



?>
