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

if(isset($_GET['mac_id']) && isset($_GET['pattern_id'])){

  $mac = $_GET['mac_id'];

  $strSQL = "SELECT * FROM tfc_vehicle_grouping WHERE vg_mac_id = '".$_GET['pattern_id']."'";
  $resultPat = $db->select($strSQL,false,true);

  if($resultPat){
    foreach($resultPat as $v){
      $strSQL = "INSERT INTO tfc_vehicle_grouping VALUE ('','".$v['vg_title']."','".date('Y-m-d')."','".$v['vg_iconname']."','".$mac."','".$_SESSION['userTFC']."')";
      $resultInsert = $db->insert($strSQL,false,true);

      $strSQL = "SELECT * FROM tfc_vehicle_grouping WHERE vg_title = '".$v['vg_title']."' and vg_mac_id = '".$mac."' and vg_username = '".$_SESSION['userTFC']."'";
      //$strSQL = "SELECT * FROM tfc_grouping_description WHERE vg_id = '".$v['vg_id']."'";
      $resultC = $db->select($strSQL,false,true);

      if($resultC){
        $strSQL = "SELECT * FROM tfc_grouping_description WHERE vg_id = '".$v['vg_id']."'";
        $resultVg = $db->select($strSQL,false,true);

        if($resultVg){
          foreach($resultVg as $d){
            $strSQL = "INSERT INTO tfc_grouping_description VALUE ('','".$resultC[0]['vg_id']."','".$d['vehicle_id']."')";
            $resultInsert = $db->insert($strSQL,false,true);
          }
        }


      }

    }
  }

  ?>
  <script>
    alert('Copy pattern success!');
    window.location = '../manager/config_activity.php?id=3&mac_id=<?php print $mac;?>';
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
