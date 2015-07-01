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
                <h3><a href="activity.php?id=3">Activity/Work management</a> / <a href="config_activity.php?id=3&mac_id=<?php print $_GET['mac_id'];?>">Activity configuration</a> / Sub-activity configuration</h3>
            </div> <!-- /widget-header -->
          <div class="widget-content">
            <div class="tabbable">
            <ul class="nav nav-tabs">
              <li>
                <a href="#formcontrols1" data-toggle="tab">Main&Sub-activity info.</a>
              </li>
              <li class="active"><a href="#jscontrols" data-toggle="tab">Assign staff</a></li>
              <li><a href="#formcontrols2" data-toggle="tab">Assigned staff</a></li>
            </ul>
            <br>
              <div class="tab-content">
                <div class="tab-pane" id="formcontrols1" style="padding-left:20px;"">
                  <!-- tab content -->
                  <h3>Main activity information</h3>
                  <hr>
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
                      <td valign="top" width="150" height="40" style="font-weight:bold;">Other description</td>
                      <td valign="top">
                        <?php print $resultMA[0]['mac_place_desc'];?>
                      </td>
                    </tr>
                  </table>
                  <p></p><br>
                  <h3>Sub-activity information</h3>
                  <hr>
                  <?php
                  $strSQL = "SELECT * FROM tfc_activity a inner join tfc_direction b on a.act_direction=b.dr_id WHERE a.act_id = '".$_GET['act_id']."'";
                  $resultSub = $db->select($strSQL,false,true);

                  if($resultSub){
                    ?>
                    <table width="100%">
                      <tr>
                        <td valign="top" width="250" height="40" style="font-weight:bold;">Sub-Activity/Work title</td>
                        <td valign="top"><?php print $resultSub[0]['act_title'];?></td>
                      </tr>
                      <tr>
                        <td valign="top" width="150" height="40" style="font-weight:bold;">Position</td>
                        <td valign="top"><?php print $resultSub[0]['act_position'];?></td>
                      </tr>
                      <tr>
                        <td valign="top" width="150" height="40" style="font-weight:bold;">Description</td>
                        <td valign="top"><?php print $resultSub[0]['act_desc'];?></td>
                      </tr>
                      <tr>
                        <td valign="top" width="150" height="40" style="font-weight:bold;">Direction</td>
                        <td valign="top">
                          <?php print $resultSub[0]['dr_detail'];?>
                        </td>
                      </tr>
                    </table>
                    <?php
                  }else{
                    print "No data";
                  }
                  ?>

                </div>
                <!-- row -->
                <div class="tab-pane active" id="jscontrols">
                  <form name id="assignStaff-form" class="form-horizontal">
                    <h3>Staff list</h3>
                    <p style="color:#06c;">Check in checkbox for assign staff forthis sub-activity</p>
                    <hr>
                    <table width="100%" class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                              <th style="font-size:1.0em;" width="30">#</th>
                              <th style="font-size:1.0em; width:50px;">&nbsp;</th>
                              <th style="font-size:1.0em;">Name - Surname</th>
                              <th style="font-size:1.0em;">Type</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                      $strSQL = "SELECT * FROM tfc_useraccount a inner join tfc_userinformation b on a.username = b.username inner join tfc_usertype c on a.usertype=c.usertype_id WHERE a.license in (SELECT license FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."') and a.usertype not in ('001','002') and a.username not in (SELECT username FROM tfc_activity_detail WHERE act_id = '".$_GET['act_id']."')";
                      $resultVhc = $db->select($strSQL,false,true);
                      //print $strSQL;
                      if($resultVhc){
                        $c = 1;
                        foreach($resultVhc as $v){
                          ?>
                          <tr>
                            <td><?php print $c;?></td>
                            <td align="center">

                              <!-- <div class="controls"> -->
                                        <!-- <label class="checkbox inline"> -->
                                          <input type="checkbox" name="vhc_checkbox[]" value="<?php print $v['username'];?>">
                                        <!-- </label> -->
                                      <!-- </div> -->

                              </td>
                            <td><?php print $v['firstname']." ".$v['surname'];?></td>
                            <td><?php print $v['usertype_detail'];?></td>
                          </tr>
                          <?php
                          $c++;
                        }
                      }else{
                        ?>
                        <tr>
                          <td align="center" colspan="4">No data of un-assign staff</td>
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

                    <div class="control-group" style="display:none;">
                      <label class="control-label" for="act_id">Sub activity ID</label>
                      <div class="controls">
                        <input type="text" class="span4" name id="act_id" value="<?php print $_GET['act_id'];?>" readonly>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

                    <div class="control-group">
                      <label class="control-label" for="password2">Manager password</label>
                      <div class="controls">
                        <input type="password" class="span4" name id="password3" placeholder="Enter admin password to confirm progress!" required>
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
                    <h3>Assigned staff list</h3>
                    <hr>
                    <table width="100%" class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                              <th style="font-size:1.0em;" width="30">#</th>

                              <th style="font-size:1.0em;">Name - Surname</th>
                              <th style="font-size:1.0em;">Type</th>
                              <th style="font-size:1.0em; width:83px;">&nbsp;</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                      $strSQL = "SELECT * FROM tfc_useraccount a inner join tfc_userinformation b on a.username = b.username inner join tfc_usertype c on a.usertype=c.usertype_id inner join tfc_activity_detail d on b.username=d.username WHERE a.license in (SELECT license FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."') and a.usertype not in ('001','002') and a.username  in (SELECT username FROM tfc_activity_detail WHERE act_id = '".$_GET['act_id']."')";
                      $resultVhc = $db->select($strSQL,false,true);
                      //print $strSQL;
                      if($resultVhc){
                        $c = 1;
                        foreach($resultVhc as $v){
                          if($v['act_id']==$_GET['act_id']){
                            
                            $username = $v['username'];
                            ?>
                            <tr>
                              <td><?php print $c;?></td>

                              <td><?php print $v['firstname']." ".$v['surname'];?></td>
                              <td><?php print $v['usertype_detail'];?></td>
                              <td align="center">
                                <button type="button" class="btn btn-reverse" title="Assign vahicle group" onclick="config_vahicle_activity('<?php print $resultMA[0]['mac_id'];?>','<?php print $v['act_id'];?>','<?php print $v['username'];?>')" ><i class="fa fa-truck"></i></button>
                                <button type="button" class="btn btn-danger" title="Delete staff from this sub-activity" onclick="delete_assign_staffs('<?php print $username;?>','<?php print $_GET['mac_id'];?>','<?php print $_GET['act_id'];?>')"  ><i class="icon-trash"></i></button>

                              </td>
                            </tr>
                            <?php
                          }
                          ?>
                          <?php
                          $c++;
                        }
                      }else{
                        ?>
                        <tr>
                          <td align="center" colspan="4">No data of un-assign staff</td>
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
