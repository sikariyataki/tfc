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

$resultMA = false;
if(isset($_GET['mac_id'])){
  $strSQL = "SELECT * FROM tfc_main_activity a inner join tfc_activity_type b on a.mac_activity_type = b.at_id WHERE a.mac_id = '".$_GET['mac_id']."'";
  $resultMA = $db->select($strSQL,false,true);
  if(!$resultMA){
    ?>
    <script>
      alert('Main activity ID not available');
      window.location = 'activity.php?id=3';
    </script>
    <?php
  }
}else{
  ?>
  <script>
    alert('Can not get activity ID!');
    window.location = 'activity.php?id=3';
  </script>
  <?php
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
                <h3><a href="activity.php?id=3">Activity/Work management</a> / <a href="config_activity.php?id=3&mac_id=<?php print $_GET['mac_id'];?>">Activity configuration</a> / <a href="config_sub_activity.php?id=3&mac_id=<?php print $_GET['mac_id'];?>&act_id=<?php print $_GET['act_id'];?>">Sub-activity configuration</a> / Assing vehicle's group</h3>
            </div> <!-- /widget-header -->
          <div class="widget-content">
            <div class="tabbable">
            <ul class="nav nav-tabs">
              <!-- <li>
                <a href="#formcontrols1" data-toggle="tab">Main&Sub-activity info.</a>
              </li> -->
              <li class="active"><a href="#jscontrols" data-toggle="tab">Vehicle group list</a></li>
              <li><a href="#formcontrols2" data-toggle="tab">Assigned vehicle group list</a></li>
            </ul>
            <br>
              <div class="tab-content">

                <!-- row -->
                <div class="tab-pane active" id="jscontrols">
                  <form name id="assignVehicle-form" class="form-horizontal">
                    <h3>Vehicle group list</h3>
                    <p style="color:#06c;">Check in checkbox for assign vehicle's group for this counter staff</p>
                    <hr>
                    <table width="100%" class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                              <th style="font-size:1.0em;" width="30">#</th>
                              <th style="font-size:1.0em;" width="25">&nbsp;</th>
                              <th style="font-size:1.0em;">Group title</th>
                              <th style="font-size:1.0em;">Group icon</th>
                              <th style="font-size:1.0em;">Description</th>

                          </tr>
                      </thead>
                      <tbody>
                      <?php
                      $strSQL = "SELECT * FROM tfc_vehicle_grouping WHERE vg_mac_id = '".$_GET['mac_id']."' and vg_id not in (SELECT avh_vg_id FROM tfc_activity_vehicle WHERE avh_username = '".$_GET['username']."' and avh_act_id = '".$_GET['act_id']."')";
                      $resultVhc = $db->select($strSQL,false,true);
                      if($resultVhc){
                        $c = 1;
                        foreach($resultVhc as $v){
                          ?>
                          <tr>
                            <td><?php print $c;?></td>
                            <td>  <input type="checkbox" name="vhc_checkbox[]" value="<?php print $v['vg_id'];?>"></td>
                            <td><?php print $v['vg_title'];?></td>
                            <td>
                              <img src="../img/<?php print $v['vg_iconname'];?>" width="80"></td>
                            <td>
                              <?php
                              $strSQL = "SELECT * FROM tfc_grouping_description a inner join tfc_vehicletype b on a.vehicle_id=b.vehicle_id WHERE a.vg_id = '".$v['vg_id']."'";
                              $resultVg = $db->select($strSQL,false,true);

                              if($resultVg){
                                foreach($resultVg as $vg){
                                  print $vg['vehicle_detail']."<br>";
                                }
                              }
                              ?>
                            </td>
                          </tr>
                          <?php
                          $c++;
                        }
                      }else{
                        ?>
                        <tr>
                          <td colspan="5"><?php print "No available data";?></td>
                        </tr>
                        <?php
                      }
                      ?>
                      </tbody>
                    </table>
                    <br>
                    <!-- <hr> -->
                    <h3>Manager confirmation</h3>
                    <hr>
                    <div class="control-group" style="display:none;">
                      <label class="control-label" for="mac_id">Main activity ID</label>
                      <div class="controls">
                        <input type="text" class="span4" name id="mac_id" value="<?php print $_GET['mac_id'];?>" readonly>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

                    <div class="control-group" style="display:;">
                      <label class="control-label" for="act_id">Sub activity ID</label>
                      <div class="controls">
                        <input type="text" class="span4" name id="act_id" value="<?php print $_GET['act_id'];?>" readonly>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

                    <div class="control-group" style="display:;">
                      <label class="control-label" for="username">Counter's username</label>
                      <div class="controls">
                        <input type="text" class="span4" name id="username" value="<?php print $_GET['username'];?>" readonly>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

                    <div class="control-group">
                      <label class="control-label" for="password4">Manager password</label>
                      <div class="controls">
                        <input type="password" class="span4" name id="password4" placeholder="Enter password to confirm progress!" required>
                        <p class="help-block"><font color="red">** Required!</font></p>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

                    <div class="form-actions">
                      <button type="submit" name id="btnSubmit" class="btn btn-primary">Submit</button>
                      <button type="reset" class="btn">Reset</button>
                    </div> <!-- /form-actions -->
                  </fieldset>
                  </form>
                </div>

                <div class="tab-pane" id="formcontrols2" style="padding-left:20px;">

                  <form name id="assignStaff-form" class="form-horizontal">
                    <h3>Assigned vehicle's group list</h3>
                    <hr>
                    <table width="100%" class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                              <th style="font-size:1.0em;" width="30">#</th>

                              <th style="font-size:1.0em;">Group title</th>
                              <th style="font-size:1.0em;">Group icon</th>
                              <th style="font-size:1.0em;">Description</th>
                              <th style="font-size:1.0em;" width="23">&nbsp;</th>

                          </tr>
                      </thead>
                      <tbody>
                      <?php
                      $strSQL = "SELECT * FROM tfc_vehicle_grouping WHERE vg_mac_id = '".$_GET['mac_id']."' and vg_id in (SELECT avh_vg_id FROM tfc_activity_vehicle WHERE avh_username = '".$_GET['username']."' and avh_act_id = '".$_GET['act_id']."')";
                      $resultVhc = $db->select($strSQL,false,true);
                      //print $strSQL;
                      if($resultVhc){
                        $c = 1;
                        foreach($resultVhc as $v){
                          ?>
                          <tr>
                            <td><?php print $c;?></td>
                            <td><?php print $v['vg_title'];?></td>
                            <td>
                              <img src="../img/<?php print $v['vg_iconname'];?>" width="80"></td>
                            <td>
                              <?php
                              $strSQL = "SELECT * FROM tfc_grouping_description a inner join tfc_vehicletype b on a.vehicle_id=b.vehicle_id WHERE a.vg_id = '".$v['vg_id']."'";
                              $resultVg = $db->select($strSQL,false,true);

                              if($resultVg){
                                foreach($resultVg as $vg){
                                  print $vg['vehicle_detail']."<br>";
                                }
                              }
                              ?>
                            </td><td align="center">

                              <button type="button" class="btn btn-danger" title="Delete staff from this sub-activity" onclick="delete_assign_vehicle('<?php print $_GET['username'];?>','<?php print $v['vg_id'];?>','<?php print $_GET['mac_id'];?>','<?php print $_GET['act_id'];?>')"  ><i class="icon-trash"></i></button>

                            </td>
                          </tr>
                          <?php
                          $c++;
                        }
                      }else{
                        ?>
                        <tr>
                          <td colspan="5"><?php print "No available data";?></td>
                        </tr>
                        <?php
                      }
                      ?>
                      </tbody>
                    </table>
                    <br>

                  </fieldset>
                  </form>
                </div>

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
