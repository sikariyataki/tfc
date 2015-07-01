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

// Inser sub activity
$strSQL = "INSERT INTO tfc_activity (act_title, act_position, act_desc, act_direction, mac_id) VALUES ('".$_POST['subtitle']."', '".$_POST['position']."', '".$_POST['other_desc']."', '".$_POST['direction']."', '".$_POST['mac_id']."')";
$resultInsert = $db->insert($strSQL,false,true);

if($resultInsert){
  $strSQL = "SELECT * FROM tfc_activity WHERE act_title = '".$_POST['subtitle']."' and mac_id = '".$_POST['mac_id']."'";
  $resultCheck = $db->select($strSQL,false,true);

  if($resultCheck){

    $strSQL = "DELETE FROM tfc_activity_detail WHERE act_id = '".$resultCheck[0]['act_id']."'";
    $resultDel = $db->delete($strSQL);

    $strSQL = "INSERT INTO tfc_activity_detail VALUE ('', '".$resultCheck[0]['act_id']."', '".$_POST['auditor']."')";
    $resultInsert = $db->insert($strSQL,false,true);

    $strSQL = "INSERT INTO tfc_activity_detail VALUE ('', '".$resultCheck[0]['act_id']."', '".$_POST['counter']."')";
    $resultInsert = $db->insert($strSQL,false,true);
    
    foreach($_POST['vehiclegroup'] as $v){

      $strSQL = "DELETE FROM tfc_activity_vehicle WHERE act_id = '".$resultCheck[0]['act_id']."' and avh_username = '".$v."'";
      $resultDel = $db->delete($strSQL);

      // $strSQL = "INSERT INTO tfc_activity_detail VALUE ('', '".$resultCheck[0]['act_id']."', '".$v."')";
      $strSQL = "INSERT INTO tfc_activity_vehicle VALUE ('','".$resultCheck[0]['act_id']."','".$_POST['counter']."','".$v."')";
      $resultInsert = $db->insert($strSQL,false,true);
    }

    print "Y";
    exit();
  }

  print "Can not create sub-activity! - Error code x2";
  exit();
}else{
  print "Can not create sub-activity! - Error code x1";
  $db->disconnect();
  exit();
}



?>
