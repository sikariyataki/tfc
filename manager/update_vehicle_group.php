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
  if($curNem=='config_activity.php'){
    header('Location: config_activity.php?id=3');
    exit();
  }
}

if(isset($_GET['mac_id'])){
  $strSQL = "SELECT * FROM tfc_main_activity a inner join tfc_activity_type b on a.mac_activity_type = b.at_id WHERE a.mac_id = '".$_GET['mac_id']."'";
  $resultMA = $db->select($strSQL,false,true);
  if(!$resultMA){
    ?>
    <script>
    alert('Activity id not available! - Code x1');
    window.location = 'activity.php?id=3';
    </script>
    <?php
  }
}else{
  ?>
  <script>
  alert('Activity id not available! - Code x2');
  window.location = 'activity.php?id=3';
  </script>
  <?php
}

if(isset($_GET['vg_id'])){
  $strSQL = "SELECT * FROM tfc_vehicle_grouping WHERE vg_id = '".$_GET['vg_id']."'";
  $resultVg = $db->select($strSQL,false,true);
  if(!$resultVg){
    ?>
    <script>
    alert("Vehicle's group id not available! - Code x1");
    window.history.back();
    </script>
    <?php
  }
}else{
  ?>
  <script>
  alert("Vehicle's id not available! - Code x3");
  window.history.back();
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
    <script src="../js/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> -->
    <script type="text/javascript" src="../js/jquery.ddslick.min.js"></script>
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
                <h3><a href="activity.php?id=3">Activity/Work management</a> / <a href="config_activity.php?id=3&mac_id=<?php print $_GET['mac_id'];?>">Activity configuration</a> / Edit sub-activity</h3>
            </div> <!-- /widget-header -->
          <div class="widget-content">
            <div class="tabbable">
            <ul class="nav nav-tabs">
              <li>
                <a href="#formcontrols1" data-toggle="tab">Main activity info.</a>
              </li>
              <li class="active"><a href="#jscontrols" data-toggle="tab">Edit sub-activity/work</a></li>
            </ul>
            <br>
              <div class="tab-content">
                <div class="tab-pane" id="formcontrols1" style="padding-left:20px;"">
                  <!-- tab content -->
                  <table width="100%">
                    <tr>
                      <td valign="top" width="250" height="40" style="font-weight:bold;">Activity/Work title</td>
                      <td valign="top"><?php print $resultMA[0]['mac_title'];?></td>
                    </tr>
                    <tr>
                      <td valign="top" width="150" height="40" style="font-weight:bold;">Date - Time of data collection</td>
                      <td valign="top"><?php print engDate($resultMA[0]['mac_date'])." <strong>From:</strong> ".$resultMA[0]['mac_start']." <strong>To:</strong> ".$resultMA[0]['mac_end'];?></td>
                    </tr>
                    <tr>
                      <td valign="top" width="150" height="40" style="font-weight:bold;">Base interval calculation</td>
                      <td valign="top"><?php print $resultMA[0]['mac_interval']." minute";?></td>
                    </tr>
                    <tr>
                      <td valign="top" width="150" height="40" style="font-weight:bold;">Activity type</td>
                      <td valign="top">
                        <?php print $resultMA[0]['at_detail'];?>
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" width="150" height="40" style="font-weight:bold;">Place name</td>
                      <td valign="top">
                        <?php print $resultMA[0]['mac_place'];?>
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" width="150" height="40" style="font-weight:bold;">Other discription</td>
                      <td valign="top">
                        <?php print $resultMA[0]['mac_place_desc'];?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" valign="top" width="150" height="40" style="font-weight:bold;">
                        <button type="button" class="btn btn-reverse" title="Edit information of main activity/work" onclick="update_account('<?php print $resultMA[0]['mac_id'];?>')" ><i class="icon-wrench"></i></button>
                        <button type="button" class="btn btn-reverse" title="Config this activity/work" onclick="config_main_activity('<?php print $resultMA[0]['mac_id'];?>')" ><i class="icon-cogs"></i></button>
                        <button type="button" class="btn btn-danger" title="Delete this activity/work" onclick="delete_account('<?php print $resultMA[0]['mac_id'];?>','user.php?id=2')"  ><i class="icon-trash"></i></button>
                      </td>
                    </tr>
                  </table>
                </div>

                <!-- row -->
                <div class="tab-pane active" id="jscontrols">
                  <form name id="group-vehicle-update" class="form-horizontal" >
                    <fieldset>
                      <h3>Create group</h3>
                      <hr>
                      <div class="control-group">
                        <label class="control-label" for="mac_id">Activity ID</label>
                        <div class="controls">
                          <input type="text" class="span2 disabled" name id="mac_id" value="<?php print $_GET['mac_id'];  ?>" required readonly>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->

                      <div class="control-group">
                        <label class="control-label" for="vg_id">Vehicle group ID</label>
                        <div class="controls">
                          <input type="text" class="span2 disabled" name id="vg_id" value="<?php print $_GET['vg_id'];  ?>" required readonly>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->


                      <div class="control-group" style="display:none;">
                        <label class="control-label" for="act_id2">Activity ID</label>
                        <div class="controls">
                          <input type="text" class="span2 disabled" name id="act_id2" value="<?php print $_GET['mac_id'];  ?>" required readonly>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->

                      <div class="control-group">
                        <label class="control-label" for="grouptitle">Group title</label>
                        <div class="controls">
                          <input type="text" class="span6 disabled" name id="grouptitle" value="<?php print $resultVg[0]['vg_title'];?>" required>
                          <p class="help-block"><font color="red">** Required!</font> Sub-activity's name.</p>
                          <p class="help-block" style="font-size:1.5em;"><font color="red">** Warning!</font> You can create vehicle's group up to <font color="red">10 groups</font> for each activity.<br>Check created group in <font color="red">"Config group of vehicle"</font> tab.</p>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->



                      <h3>Choose group's icon</h3>
                      <hr>

                      <div style="width:100%; height:300px; overflow: scroll;">
                        <table width="100%" class="table table-striped table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th style="font-size:1.0em;" width="30">#</th>
                                  <th style="font-size:1.0em;">Vehicle icon</th>
                                  <th style="font-size:1.0em;">Description</th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php
                          $strSQL = "SELECT * FROM tfc_icon WHERE ic_picname not in (SELECT vg_iconname FROM tfc_vehicle_grouping WHERE vg_mac_id = '".$_GET['mac_id']."') or ic_picname = '".$resultVg[0]['vg_iconname']."' ";
                          //print $strSQL;
                          $resultVhc = $db->select($strSQL,false,true);
                          if($resultVhc){
                            $c = 1;
                            foreach($resultVhc as $v){
                              ?>
                              <tr>
                                <td><?php print $c;?></td>
                                <td>
                                  <label class="radio inline">
                                    <input type="radio"  name="rdio_icon" value="<?php print $v['ic_picname'];?>" <?php if($resultVg[0]['vg_iconname']==$v['ic_picname']){ print "checked"; }?>>
                                  </label>
                                  <img src="../img/<?php print $v['ic_picname'];?>" width="80"></td>
                                <td><?php print $v['ic_desc'];?></td>
                              </tr>
                              <?php
                              $c++;
                            }
                          }
                          ?>
                          </tbody>
                        </table>
                      </div>
                      <br>
                      <!-- <hr> -->
                      <h3>Manager confirmation</h3>
                      <hr>

                      <div class="control-group">
                        <label class="control-label" for="password2">Manager password</label>
                        <div class="controls">
                          <input type="password" class="span4" name id="password3" placeholder="Enter admin password to confirm progress!" required>
                          <p class="help-block"><font color="red">** Required!</font></p>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->

                      <div class="form-actions">
                        <button type="submit" name id="btnSubmit" class="btn btn-primary">Create</button>
                        <button type="reset" class="btn">Reset</button>
                      </div> <!-- /form-actions -->
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




<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
<script src="js/activity.js"></script>
<script src="../js/jquery.multi-select.js" type="text/javascript"></script>

  </body>

</html>
