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

// Check duplicate license
$strSQL = "SELECT * FROM tfc_license WHERE ls_license = '".$_POST['license']."'";
$result = $db->select($strSQL,false,true);
if($result){
  print "This license already in database!";
  $db->disconnect();
  exit();
}

// Insert license
$strSQL = "INSERT INTO tfc_license VALUE ('','".$_POST['license']."','".date('Y-m-d')."','No','".$_SESSION['userTFC']."')";
$result = $db->insert($strSQL,false,true);

// Check added license
$strSQL = "SELECT * FROM tfc_license WHERE ls_license = '".$_POST['license']."'";
$resultAcc = $db->select($strSQL,false,true);
if($resultAcc){
  $strSQL = "INSERT INTO tfc_useraccount VALUE ('".$_POST['username']."','".$_POST['password']."','002','".randomPassword()."','No','".$resultAcc[0]['ls_id']."','No')";
  $result = $db->insert($strSQL,false,true);

  $strSQL = "INSERT INTO tfc_userinformation VALUE ('','".$_POST['username']."','-','-','".$_POST['email']."','-','".$_POST['username']."')";
  $result = $db->insert($strSQL,false,true);

  $strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_POST['username']."' and password = '".$_POST['password']."' and license = '".$resultAcc[0]['ls_id']."'";
  $result = $db->select($strSQL,false,true);

  if($result){
    print "Y";
  }else{
    print "Can not create this license! - Error code x1";

    $strSQL = "DELETE FROM tfc_license WHERE ls_license = '".$_POST['license']."'";
    $resultDel = $db->delete($strSQL);

    $db->disconnect();
    exit();
  }
}else{
  print "Can not create this license! - Error code x2";
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
