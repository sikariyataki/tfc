<?php
session_start();

require("../libs/connect.class.php");

require("../php/function.inc.php");
$db = new database();
$db->connect();

$id=0;
if(isset($_GET['id'])){
  $id = $_GET['id'];
}else{
  $curNem = basename($_SERVER['PHP_SELF']);
  if($curNem=='user.php'){
    header('Location: user.php?id=1');
    exit();
  }
}

$strSQL = "SELECT * FROM tfc_main_activity WHERE mac_id = '".$_GET['mac_id']."'";
$resultMain = $db->select($strSQL,false,true);

if(!$resultMain){

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <?php
    include "includes/title.php";
    ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">

    <link href="../fonts/css.css" rel="stylesheet" type='text/css'>
    <link href="css/font-awesome.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" />
  </head>
<body>
<div class="navbar navbar-fixed-top">

  <div class="navbar-inner">

    <div class="container">

      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <a class="brand" href="index.php">Traffic Count Application	</a>

      <div class="nav-collapse">
        <?php include "includes/userpanel.php"; ?>
      </div><!--/.nav-collapse -->
    </div> <!-- /container -->
  </div> <!-- /navbar-inner -->
</div> <!-- /navbar -->

<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <?php include "includes/menus.php"; ?>
    </div> <!-- /container -->
  </div> <!-- /subnavbar-inner -->
</div> <!-- /subnavbar -->

<div class="main">
  <div class="main-inner">
      <div class="container">
        <div class="row">
          <div class="span12">
            <div class="widget ">
              <div class="widget-header">
                <i class="icon-wrench"></i>
                <h3><a href="activity.php?id=3">Activity counting information</a></h3>
            </div> <!-- /widget-header -->
          <div class="widget-content">
            <div class="tabbable">
              <div class="tab-content">
                <table width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="3" height="40" valign="top">
                      <h3>Traffic count information</h3>
                    </td>
                  </tr>
                  <tr>
                    <td width="200" height="30" valign="top">
                      <strong>Explore date :</strong>
                    </td>
                    <td width="200" valign="top" >
                      <?php print $resultMain[0]['mac_date']; ?>
                    </td>
                    <td  rowspan="5">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" valign="top">
                      <strong>Investigator :</strong>
                    </td>
                    <td valign="top">
                      <?php
                      $strSQL = "SELECT * FROM tfc_activity_detail a inner join tfc_activity b on a.act_id = b.act_id inner join tfc_main_activity c on b.mac_id = c.mac_id inner join tfc_userinformation d on a.username = d.username  WHERE  c.mac_id = '".$_GET['mac_id']."' and a.username in (SELECT username FROM tfc_useraccount WHERE usertype = '004')";

                      if(isset($_GET['invest'])){
                        $strSQL = "SELECT * FROM tfc_activity_detail a inner join tfc_activity b on a.act_id = b.act_id inner join tfc_main_activity c on b.mac_id = c.mac_id inner join tfc_userinformation d on a.username = d.username  WHERE  c.mac_id = '".$_GET['mac_id']."' and a.username in (SELECT username FROM tfc_useraccount WHERE usertype = '004' and username = '".$_GET['invest']."')";
                      }

                      $resultCounter = $db->select($strSQL,false,true);
                      if($resultCounter){
                        foreach($resultCounter as $v){
                          print $v['firstname']." ".$v['surname']."<br>";
                        }

                      }else{
                        print "N/A";
                      }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td height="30" valign="top">
                      <strong>Auditor :</strong>
                    </td>
                    <td valign="top">
                      <?php
                      $strSQL = "SELECT * FROM tfc_activity_detail a inner join tfc_activity b on a.act_id = b.act_id inner join tfc_main_activity c on b.mac_id = c.mac_id inner join tfc_userinformation d on a.username = d.username  WHERE  c.mac_id = '".$_GET['mac_id']."' and a.username in (SELECT username FROM tfc_useraccount WHERE usertype = '003')";
                      $resultAuditor = $db->select($strSQL,false,true);
                      if($resultAuditor){
                        print $resultAuditor[0]['firstname']." ".$resultAuditor[0]['surname'];
                      }else{
                        print "N/A";
                      }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td height="30" valign="top">
                      <strong>Explore position / place :</strong>
                    </td>
                    <td valign="top">
                      <?php
                      if($resultCounter){
                        print $resultCounter[0]['act_position'];
                      }else{
                        print "N/A";
                      }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td height="30" valign="top">
                      <strong>Direction :</strong>
                    </td>
                    <td valign="top">
                      <?php
                      if($resultCounter){
                        foreach($resultCounter as $v){
                          $strSQL = "SELECT * FROM tfc_direction WHERE dr_id = '".$v['act_direction']."'";
                          $resultDr = $db->select($strSQL,false,true);
                          if($resultDr){
                            print $resultDr[0]['dr_detail']."<br>";
                          }else{
                            print "N/A<br>";
                          }
                        }

                      }else{
                        print "N/A";
                      }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td height="30">&nbsp;</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td height="30"><h3>Fillters</h3></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td height="30" valign="bottom">
                      <strong><div class="control-group">
                      <label class="control-label" for="interval_val">Time interval</label>
                      <div class="controls">
                                <select class="form-control" name id="interval_val">
                                    <option value="15" <?php if(isset($_GET['interval'])){ if($_GET['interval']==15){ print "selected"; } }else{ if($resultMain[0]['mac_interval']==15){ print "selected"; } } ?>>15 min.</option>
                                    <option value="20" <?php if(isset($_GET['interval'])){ if($_GET['interval']==20){ print "selected"; } }else{ if($resultMain[0]['mac_interval']==20){ print "selected"; } } ?>>20 min.</option>
                                    <option value="30"  <?php if(isset($_GET['interval'])){ if($_GET['interval']==30){ print "selected"; } }else{ if($resultMain[0]['mac_interval']==30){ print "selected"; } } ?>>30 min.</option>
                                    <option value="60"  <?php if(isset($_GET['interval'])){ if($_GET['interval']==60){ print "selected"; } }else{ if($resultMain[0]['mac_interval']==60){ print "selected"; } } ?>>60 min.</option>
                                </select>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group --></strong></td>
                    <td style="padding-left:10px;" valign="bottom">
                      <div class="control-group">
                        <label class="control-label" for="investigator_val">Investigator</label>
                        <div class="controls">
                                  <select class="form-control" name id="investigator_val" >
                                    <option value="" selected>-- All --</option>
                                    <?php
                                    if($resultCounter){
                                      //print $resultAuditor[0]['firstname']." ".$resultAuditor[0]['surname'];
                                      foreach($resultCounter as $f){
                                        ?><option value="<?php print $f['username'];?>" <?php if(isset($_GET['invest'])){ if($_GET['invest']==$f['username']){ print "selected";}} ?>><?php print $f['firstname']." ".$f['surname'];?></option><?php
                                      }
                                    }else{
                                      print "N/A";
                                    }
                                    ?>
                                  </select>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group --></strong>
                    </td>
                    <td style="padding-left:10px; padding-top:5px;" valign="middle">
                      <button type="button" class="btn btn-reverse" title="Edit information of main activity/work" onclick="filter_view('<?php print $_GET['mac_id'];?>')" ><i class="fa fa-undo"></i></button></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="3">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <tr>
                          <th width="150" align="center">Time Period</th>
                          <?php
                          $strSQL = "SELECT * FROM tfc_vehicle_grouping WHERE vg_mac_id = '".$_GET['mac_id']."'";
                          $resultVg = $db->select($strSQL,false,true);
                          if($resultVg){
                            foreach($resultVg as $v){
                              ?>
                              <th align="center"><div align="center"><img src="../img/<?php print $v['vg_iconname'];?>" width="80%">
                                <br>
                                <?php
                                  //print $v['vg_title'];
                                  $strSQL = "SELECT * FROM tfc_grouping_description a inner join tfc_vehicletype b on a.vehicle_id=b.vehicle_id WHERE a.vg_id = '".$v['vg_id']."'";
                                  $resultV = $db->select($strSQL,false,true);
                                  if($resultV){
                                    foreach($resultV as $vh){
                                      print $vh['vehicle_detail']."<br>";
                                    }
                                  }
                                ?></div></th>
                              <?php
                            }
                          }
                          ?>
                        </tr>
                        <?php
                        $startTime = strtotime($resultMain[0]['mac_start']);
                        $endTime = strtotime($resultMain[0]['mac_end']);
                        if(isset($_GET['interval'])){
                          $durration = $_GET['interval'];
                        }else{
                          $durration = $resultMain[0]['mac_interval'];
                        }


                        for( $i=$startTime; $i<$endTime; $i+=($durration*60)) {
                            ?>
                            <tr>
                              <td align="center"><?php print date("H:i",$i)." - ".date("H:i",$i+($durration*60)); ?></td>
                            <?php
                            if($resultVg){
                              foreach($resultVg as $v){
                                ?>
                                <td align="center">
                                  <div align="center">
                                    <?php
                                      $strSQL = "SELECT count(*) FROM tfc_count_value WHERE mac_id = '".$_GET['mac_id']."' and timePress between '".date("H:i",$i).":00' and '".date("H:i",$i+($durration*60)).":00' and vg_id = '".$v['vg_id']."'";

                                      if(isset($_GET['invest'])){
                                        $strSQL = "SELECT count(*) FROM tfc_count_value WHERE mac_id = '".$_GET['mac_id']."' and timePress between '".date("H:i",$i).":00' and '".date("H:i",$i+($durration*60)).":00' and vg_id = '".$v['vg_id']."' and username = '".$_GET['invest']."'";
                                      }

                                      $resultSumcount = $db->select($strSQL,false,true);
                                      if($resultSumcount){
                                        if($resultSumcount[0]['count(*)']==0){
                                          print "<font color='#ccc'>0</font>";
                                        }else{
                                          print "<strong>".$resultSumcount[0]['count(*)']."</strong>";
                                        }

                                      }else{
                                        print "<font color='#ccc'>0</font>";
                                      }
                                    ?>
                                  </div>
                                </td>
                                <?php
                              }
                            }
                            ?>
                            </tr>
                            <?php
                        }
                        ?>

                      </table>
                    </td>
                  </tr>
                </table>


              </div>
            </div>





          </div> <!-- /widget-content -->

        </div> <!-- /widget -->

        </div> <!-- /span8 -->




        </div> <!-- /row -->
      </div> <!-- /container -->
  </div> <!-- /main-inner -->
</div> <!-- /main -->

<div class="footer">

  <div class="footer-inner">

    <div class="container">

      <div class="row">

          <div class="span12">
            &copy; 2013 <a href="http://www.egrappler.com/">Bootstrap Responsive Admin Template</a>.
          </div> <!-- /span12 -->

        </div> <!-- /row -->

    </div> <!-- /container -->

  </div> <!-- /footer-inner -->

</div> <!-- /footer -->



<script src="js/jquery-1.7.2.min.js"></script>

<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
<script src="js/activity.js"></script>

  </body>

</html>
