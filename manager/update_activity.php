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
  $strSQL = "SELECT * FROM tfc_main_activity WHERE mac_id = '".$_GET['mac_id']."'";
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
                <h3><a href="activity.php?id=3">Activity/Work management</a> / Update main activity</h3>
            </div> <!-- /widget-header -->
          <div class="widget-content">
            <div class="tabbable">
            <ul class="nav nav-tabs">
              <li  class="active"><a href="#jscontrols" data-toggle="tab">Activity/Work information </a></li>
            </ul>
            <br>
              <div class="tab-content">

                <!-- row -->
                <div class="tab-pane active" id="jscontrols">
                  <form name id="main_activity_update" class="form-horizontal" action="user.php?id=2">
                    <h3>Main activity information</h3>
                    <hr>
                    <fieldset>

                      <div class="control-group">
                        <label class="control-label" for="mac_id">Activity ID</label>
                        <div class="controls">
                          <input type="text" class="span6 disabled" name id="mac_id" value="<?php print $resultMA[0]['mac_id'];?>" required readonly>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->

                      <div class="control-group">
                        <label class="control-label" for="act_title">Activity title</label>
                        <div class="controls">
                          <input type="text" class="span6 disabled" name id="act_title" value="<?php print $resultMA[0]['mac_title'];?>" required>
                          <p class="help-block"><font color="red">** Required!</font> Enter activity name.</p>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->

                      <div class="control-group">
                        <label class="control-label" for="coldate">Date collected data</label>
                        <div class="controls">
                          <input type="date" class="span4" name id="coldate" value="<?php print $resultMA[0]['mac_date'];?>" required>
                          <p class="help-block"><font color="red">** Required!</font> Choose the date of this activity will happend.</p>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->
                      <?php
                      $buff = explode(':',$resultMA[0]['mac_start']);
                      ?>
                      <div class="control-group">
                        <label class="control-label" for="start">Start time</label>
                        <div class="controls">
                          <select class="form-control span1" name id="s_h" required>
                              <?php
                              for($h=0; $h<24; $h++){
                                if($h<10){
                                  ?><option value="<?php print "0".$h;?>" <?php if($buff[0]==("0".$h)){ print "selected";}?>><?php print "0".$h;?></option><?php
                                }else{
                                  ?><option value="<?php print $h;?>" <?php if($buff[0]==($h)){ print "selected";}?>><?php print $h;?></option><?php
                                }
                              }
                              ?>
                          </select>
                          :
                          <select class="form-control span1" name id="s_m" required>
                              <?php
                              for($m=0; $m<60; $m++){
                                if($m<10){
                                  ?><option value="<?php print "0".$m;?>" <?php if($buff[1]==("0".$m)){ print "selected";}?>><?php print "0".$m;?></option><?php
                                }else{
                                  ?><option value="<?php print $m;?>"  <?php if($buff[1]==($m)){ print "selected";}?>><?php print $m;?></option><?php
                                }
                              }
                              ?>
                          </select>
                          :
                          <input type="text" class="span1" name id="s_s" value="00" readonly>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->

                      <?php
                      $buff2 = explode(':',$resultMA[0]['mac_end']);
                      ?>

                      <div class="control-group">
                        <label class="control-label" for="end">End time</label>
                        <div class="controls">
                          <select class="form-control span1" name id="e_h" required>
                              <?php
                              for($h=0; $h<24; $h++){
                                if($h<10){
                                  ?><option value="<?php print "0".$h;?>" <?php if($buff2[0]==("0".$h)){ print "selected";}?>><?php print "0".$h;?></option><?php
                                }else{
                                  ?><option value="<?php print $h;?>"  <?php if($buff2[0]==($h)){ print "selected";}?>><?php print $h;?></option><?php
                                }
                              }
                              ?>
                          </select>
                          :
                          <select class="form-control span1" name id="e_m" required>
                              <?php
                              for($m=0; $m<60; $m++){
                                if($m<10){
                                  ?><option value="<?php print "0".$m;?>" <?php if($buff2[1]==("0".$m)){ print "selected";}?>><?php print "0".$m;?></option><?php
                                }else{
                                  ?><option value="<?php print $m;?>" <?php if($buff2[1]==($m)){ print "selected";}?>><?php print $m;?></option><?php
                                }
                              }
                              ?>
                          </select>
                          :
                          <input type="text" class="span1" name id="e_s" value="00" readonly>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->

                      <div class="control-group">
                        <label class="control-label" for="interval_val">Based interval</label>
                        <div class="controls">
                                  <select class="form-control" name id="interval_val" required>
                                      <option value="15" <?php if($resultMA[0]['mac_interval']=='15'){ print "selected";}?>>15 min.</option>
                                      <option value="20" <?php if($resultMA[0]['mac_interval']=='20'){ print "selected";}?>>20 min.</option>
                                      <option value="30" <?php if($resultMA[0]['mac_interval']=='30'){ print "selected";}?>>30 min.</option>
                                      <option value="60" <?php if($resultMA[0]['mac_interval']=='60'){ print "selected";}?>>60 min.</option>
                                  </select>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->

                      <div class="control-group">
                        <label class="control-label" for="acType">Activity type</label>
                        <div class="controls">
                                  <select class="form-control" name id="acType" required>
                                      <option value="" selected>-- Please select activity type --</option>
                                      <option value="001"  <?php if($resultMA[0]['mac_activity_type']=='001'){ print "selected";}?>>MB</option>
                                      <option value="002" <?php if($resultMA[0]['mac_activity_type']=='002'){ print "selected";}?>>TMC</option>
                                  </select>
                                  <p class="help-block"><font color="red">** Required!</font> Please select activity type.</p>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->

                      <div class="control-group">
                        <label class="control-label" for="pname">Place name</label>
                        <div class="controls">
                          <input type="text" class="span6 disabled" name id="pname" value="<?php print $resultMA[0]['mac_place'];?>">
                          <p class="help-block">Enter name of place.</p>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->

                      <div class="control-group">
                        <label class="control-label" for="desc">Description</label>
                        <div class="controls">
                          <input type="text" class="span6 disabled" name id="desc" value="<?php print $resultMA[0]['mac_place_desc'];?>">
                          <p class="help-block">Enter place or activity description.</p>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->
                      <br>
                      <h3>Manager confirmation</h3>
                      <hr>
                      <div class="control-group">
                        <label class="control-label" for="password2">Manager password</label>
                        <div class="controls">
                          <input type="password" class="span4" name id="password2" placeholder="Enter admin password to confirm progress!" required>
                          <p class="help-block"><font color="red">** Required!</font></p>
                        </div> <!-- /controls -->
                      </div> <!-- /control-group -->

                      <div class="form-actions">
                        <button type="submit" name id="btnSubmit" class="btn btn-primary">Update</button>
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



<script src="js/jquery-1.7.2.min.js"></script>

<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
<script src="js/activity.js"></script>

  </body>

</html>
