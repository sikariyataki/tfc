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

// Check available license
$strSQL = "SELECT * FROM tfc_license WHERE ls_license = '".$_POST['license']."'";
$resultLs = $db->select($strSQL,false,true);
if(!$resultLs){
  print "License not available!";
  $db->disconnect();
  exit();
}

// If license availabel -> Insert userAccount
$strSQL = "INSERT INTO tfc_useraccount VALUE ('".$_POST['username']."','".$_POST['password']."','".$_POST['accountType']."','".randomPassword()."','No','".$resultLs[0]['ls_id']."','No')";
$result = $db->insert($strSQL,false,true);

// Check added license
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_POST['username']."' and password = '".$_POST['password']."' and usertype = '".$_POST['accountType']."'";
$resultAcc = $db->select($strSQL,false,true);
if($resultAcc){

  $strSQL = "INSERT INTO tfc_userinformation VALUE ('','".$_POST['username']."','-','-','".$_POST['email']."','-','".$_POST['username']."')";
  $result = $db->insert($strSQL,false,true);

  $strSQL = "SELECT * FROM tfc_userinformation WHERE username = '".$_POST['username']."'";
  $result = $db->select($strSQL,false,true);

  if($result){
    print "Y";
  }else{
    print "Can not create user account! - Error code x1";

    $strSQL = "DELETE FROM tfc_useraccount WHERE username = '".$_POST['username']."'";
    $resultDel = $db->delete($strSQL);

    $db->disconnect();
    exit();
  }
}else{
  print "Can not create user account! - Error code x2";
  $db->disconnect();
  exit();
}

?>
<?php
function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 16; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
?>
