<?php
session_start();
require("../libs/connect.class.php");
$db = new database();
$db->connect();

// Check admin privilege
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and usertype = '002' and userstatus = 'Yes' and active_status = 'Yes'";
$result = $db->select($strSQL,false,true);
if(!$result){
  ?>
  <script>
    alert('System denine!');
    window.history.back();
  </script>
  <?php
}

if(isset($_GET['mac_id']) && isset($_GET['act_id']) && isset($_GET['username'])){

  $strSQL = "DELETE FROM tfc_activity_vehicle WHERE avh_username = '".$_GET['username']."' and  avh_act_id = '".$_GET['act_id']."' and avh_vg_id = '".$_GET['vg_id']."'";
  $resultDel = $db->delete($strSQL);

  // print $strSQL;
  // exit();
  ?>
  <script>
    window.history.back();
  </script>
  <?php
}else{
  ?>
  <script>
    alert('System error! - Error code X2');
    window.history.back();
  </script>
  <?php
}




?>
