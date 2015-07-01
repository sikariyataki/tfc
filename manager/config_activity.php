<?php
session_start();

require("../libs/connect.class.php");

require("../php/function.inc.php");
$db = new database();
$db->connect();

$menu_id = 1;
if(isset($_GET['menu_id'])){
    $menu_id = $_GET['menu_id'];
}

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
    <link href="../css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" />

    <style>
    .dd-options {
        max-height: 250px;
    }
    </style>
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
                <h3><a href="activity.php?id=3">Activity/Work management</a> / Activity configuration</h3>
              </div> <!-- /widget-header -->
              <div class="widget-content">
                <div class="tabbable">
                  <table width="100%">
                    <tr>
                      <td width="200" style="padding:5px;" valign="top">
                        <table width="100%">
                          <tr>
                            <td style="padding-top:5px; padding-bottom:5px;">
                              <button type="button" class="btn btn-reverse"  style="width:100%; height:50px; text-align:left;" onclick="Javascript:window.location='config_activity.php?id=3&mac_id=<?php print $_GET['mac_id'];?>'">1. Activity info.</button>
                            </td>
                          </tr>
                          <tr>
                            <td style="padding-top:5px; padding-bottom:5px;">
                              <button type="button" class="btn btn-reverse" style="width:100%; height:50px; text-align:left;" onclick="Javascript:window.location='config_activity.php?id=3&mac_id=<?php print $_GET['mac_id'];?>&menu_id=2'">2. Vehicle's group</button>
                            </td>
                          </tr>
                          <tr>
                            <td style="padding-top:5px; padding-bottom:5px;">
                              <button type="button" class="btn btn-reverse"  style="width:100%; height:50px; text-align:left;" onclick="Javascript:window.location='config_activity.php?id=3&mac_id=<?php print $_GET['mac_id'];?>&menu_id=3'">3. Sub-activity</button>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td height="500" style="padding:10px; padding-left:30px;" valign="top">
                        <?php
                        if($menu_id==1){
                          ?>
                          <h3>Activity information</h3>
                          <hr>
                          <table width="100%">
                            <tr>
                              <td valign="top" width="250" height="40" style="font-weight:bold;">Activity/Work title</td>
                              <td valign="top"><?php print $resultMA[0]['mac_title'];?></td>
                            </tr>
                            <tr>
                              <td valign="top" width="150" height="40" style="font-weight:bold;">Date - Time of data collection</td>
                              <td valign="top"><?php print engDate($resultMA[0]['mac_date'])." <br><strong>From:</strong> ".$resultMA[0]['mac_start']." <strong>To:</strong> ".$resultMA[0]['mac_end'];?><br></td>
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
                            <tr>
                              <td colspan="2" valign="top" width="150" height="40" style="font-weight:bold;">
                                <button type="button" class="btn btn-reverse" title="Edit information of main activity/work" onclick="update_main_activity('<?php print $resultMA[0]['mac_id'];?>')" ><i class="icon-wrench"></i></button>
                                <button type="button" class="btn btn-reverse" title="Config this activity/work" onclick="config_main_activity('<?php print $resultMA[0]['mac_id'];?>')" ><i class="icon-cogs"></i></button>
                                <button type="button" class="btn btn-danger" title="Delete this activity/work" onclick="delete_main_activity('<?php print $resultMA[0]['mac_id'];?>')"  ><i class="icon-trash"></i></button>
                              </td>
                            </tr>
                          </table>
                          <?php
                        }else if($menu_id==2){
                          ?>
                          <h3>Vehicle's group</h3>
                          <hr>
                          <?php
                          $strSQL = "SELECT * FROM tfc_activity a inner join tfc_direction b on a.act_direction=b.dr_id WHERE a.mac_id = '".$_GET['mac_id']."' order by a.act_id desc";
                          $resultUser = $db->select($strSQL,false,true);

                          $strSQL = "SELECT * FROM tfc_vehicle_grouping WHERE vg_mac_id = '".$_GET['mac_id']."'";
                          $resultVhc = $db->select($strSQL,false,true);

                          if(!$resultVhc){
                            ?>
                            <div style="padding-bottom:10px; padding-left:160px;">
                              <button type="button" class="btn btn-reverse" title="Choose all group from created pattern" onclick="choosePattern_value('<?php print $_GET['mac_id'];?>')" ><i class="icon-search"></i>&nbsp;&nbsp;Choose from pattern</button>
                            </div>
                            <p>
                            <?php
                          }
                          ?>

                          <form name id="group-vehicle" class="form-horizontal" >
                            <fieldset>
                              <div class="control-group" style="display:;">
                                <label class="control-label" for="act_id2">Activity ID</label>
                                <div class="controls">
                                  <input type="text" class="span2 disabled" name id="act_id2" value="<?php print $_GET['mac_id'];  ?>" required readonly>
                                </div> <!-- /controls -->
                              </div> <!-- /control-group -->

                              <div class="control-group">
                                <label class="control-label" for="grouptitle">Enter group's title</label>
                                <div class="controls">
                                  <input type="text" min="1" max="10" class="span6 disabled" name id="grouptitle" value="" required>
                                  <p class="help-block"><font color="red">** Required!</font> Enter name or title of group.</p>

                                </div> <!-- /controls -->

                              </div>
                              <table width="100%">
                                <tr>
                                  <td width="140" align="right">Choose icon
                                  </td>
                                  <td style="padding-left:20px;">

                                    <div name id="myDropdown"></div></td>
                                </tr>
                                <tr>
                                  <td width="140" align="right"></td>
                                  <td style="padding-left:20px;">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="140" align="right" valign="top">Choose vehicle
                                  </td>
                                  <td style="padding-left:20px;" valign="top">
                                    <select multiple="multiple" id="my-select" name="my-select[]">
                                      <?php
                                      $strSQL = "SELECT * FROM tfc_vehicletype WHERE vehicle_id not in (SELECT vehicle_id FROM tfc_grouping_description WHERE vg_id in (SELECT vg_id FROM tfc_vehicle_grouping WHERE vg_mac_id = '".$_GET['mac_id']."')) or vehicle_id in (select vehicle_id FROM tfc_grouping_description WHERE vg_id = '".$_GET['vg_id']."') ";
                                      $resultVhc = $db->select($strSQL,false,true);

                                      if($resultVhc){
                                        foreach($resultVhc as $v){
                                          ?>
                                          <option value='<?php print $v['vehicle_id']; ?>'><?php print $v['vehicle_detail'];?></option>
                                          <?php
                                        }
                                      }
                                      ?>
                                      </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="140" align="right">&nbsp;</td>
                                  <td style="padding-left:20px; padding-top:20px;">
                                    <button type="submit" class="btn btn-reverse" title="Create vehicle group"  ><i class="icon-plus"></i>&nbsp;&nbsp;Create new group</button>

                                  </td>
                                </tr>
                              </table>


                                <div align="center" style="padding-top:15px;"> </div>
                              <!-- </div> <!-- /control-group -->
                            </fieldset>

                          </form>

                          <?php
                          $strSQL = "SELECT * FROM tfc_group_shortcut WHERE gs_mac_id = '".$_GET['mac_id']."'";
                          $resultSc = $db->select($strSQL,false,true);
                          ?>

                          <form name id="group-vehicle-shortcut" class="form-horizontal" >
                            <h3>Group list</h3>
                            <hr>

                            <table width="100%">
                              <tr>
                                <td width="50" align="left">
                                  <!-- <div class="controls"> -->
                                    <input type="text" class="span2 disabled" style="width:30px; text-align:center;" name id="mac_idc" value="<?php print $_GET['mac_id'];  ?>" required readonly>
                                  <!-- </div> -->
                                </td>
                                <td width="270" align="left">
                                  <!-- <div class="controls"> -->
                                    <input type="text" style="width:250px;" max="10" class="span6 disabled" name id="group_sc" placeholder="Enter pattern name" value="<?php if($resultSc){print $resultSc[0]['gs_name'];}?>" required>
                                  <!-- </div> -->
                                </td>
                                <td align="left">
                                  <button type="submit" name id="btnSubmit" class="btn btn-primary"><?php if($resultSc){print "Update";}else{ print "Create";}?></button>
                                </td>
                              </tr>
                            </table>


                              <!-- <button type="button" class="btn btn-reverse" title="Config vehicle in this group" onclick="config_vehicle_group('<?php print $_GET['mac_id'];?>','<?php print $v['vg_id'];?>')" ><i class="icon-cogs"></i>&nbsp;&nbsp;Assign vehicle to each group</button> -->
                            <p>
                            <!-- <div style="width:100%; height:300px; overflow: scroll;"> -->
                              <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="font-size:1.0em;" width="30">#</th>
                                        <th style="font-size:1.0em;">Group title</th>
                                        <th style="font-size:1.0em;">Group icon</th>
                                        <th style="font-size:1.0em;">Description</th>
                                        <th style="font-size:1.0em;" width="127">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                
                                $strSQL = "SELECT * FROM tfc_vehicle_grouping WHERE vg_mac_id = '".$_GET['mac_id']."'";
                                $resultVhc = $db->select($strSQL,false,true);

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
                                      </td>
                                      <td>
                                        <button type="button" class="btn btn-reverse" title="Edit information of vehicle's group" onclick="update_vehicle_group('<?php print $_GET['mac_id'];?>','<?php print $v['vg_id'];?>')" ><i class="icon-wrench"></i></button>
                                        <button type="button" class="btn btn-reverse" title="Config vehicle in this group" onclick="config_vehicle_group('<?php print $_GET['mac_id'];?>','<?php print $v['vg_id'];?>')" ><i class="icon-cogs"></i></button>
                                        <button type="button" class="btn btn-danger" title="Delete this vehicle's group" onclick="delete_vehicle_group('<?php print $_GET['mac_id'];?>','<?php print $v['vg_id'];?>')"  ><i class="icon-trash"></i></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $c++;
                                  }
                                }
                                ?>
                                </tbody>
                              </table>
                            <!-- </div> -->
                          </form>
                          <?php
                        }else{
                          ?><h3>Sub-activity</h3>
                          <hr>

                          <!-- -------------------------------------------------------- -->

                          <div class="tab-pane" id="formcontrols2">
                          <form name id="usub-activity" class="form-horizontal" >
                            <fieldset>

                              <div class="control-group">
                                <label class="control-label" for="username">Activity ID</label>
                                <div class="controls">
                                  <input type="text" class="span2 disabled" name id="act_id" value="<?php print $_GET['mac_id'];  ?>" required readonly>
                                </div> <!-- /controls -->
                              </div> <!-- /control-group -->

                              <div class="control-group">
                                <label class="control-label" for="username">Sub-activity title</label>
                                <div class="controls">
                                  <input type="text" class="span6 disabled" name id="subtitle" value="" required>
                                  <p class="help-block"><font color="red">** Required!</font> Sub-activity's name.</p>
                                </div> <!-- /controls -->
                              </div> <!-- /control-group -->

                              <div class="control-group">
                                <label class="control-label" for="position">Position</label>
                                <div class="controls">
                                  <input type="text" class="span4" name id="position" value="" placeholder="ex. บนสะพานลอยหน้าวัด">
                                </div> <!-- /controls -->
                              </div> <!-- /control-group -->

                              <div class="control-group">
                                <label class="control-label" for="other_desc">Other discription</label>
                                <div class="controls">
                                  <textarea name id="other_desc" class="span4" ></textarea>
                                </div> <!-- /controls -->
                              </div> <!-- /control-group -->

                              <div class="control-group">
                                <label class="control-label" for="direction">Direction</label>
                                <div class="controls">
                                          <select class="form-control span4" name id="direction" required>
                                              <option value="" selected>-- Please select direction --</option>
                                              <option value="001">No direction&nbsp;&nbsp;</option>
                                              <option value="002">The opposite direction [left to right]&nbsp;&nbsp;</option>
                                              <option value="003">The turn direction [turn left or turn right]&nbsp;&nbsp;</option>
                                          </select>
                                          <p class="help-block"><font color="red">** Required!</font></p>
                                </div> <!-- /controls -->
                              </div> <!-- /control-group -->

                              <div class="control-group">
                                <label class="control-label" for="direction">Auditor</label>
                                <div class="controls">
                                          <select class="form-control span4" name id="auditor" required>
                                              <option value="" selected>-- Please select auditor's name --</option>
                                              <?php
                                                $strSQL = " SELECT
                                                            b.firstname,
                                                            a.username,
                                                            b.surname
                                                            FROM
                                                            tfc_useraccount AS a
                                                            INNER JOIN tfc_userinformation AS b ON a.username = b.username
                                                            INNER JOIN tfc_usertype AS c ON a.usertype = c.usertype_id
                                                            WHERE
                                                            c.usertype_detail = 'Auditor' AND a.userstatus = 'Yes' AND a.active_status = 'Yes' AND
                                                            a.license in (SELECT license FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."')";
                                                $resultAuditor = $db->select($strSQL,false,true);
                                                if($resultAuditor){
                                                  foreach($resultAuditor as $v){
                                                    ?>
                                                      <option value="<?php print $v['username'];?>"><?php print $v['firstname']." ".$v['surname'];?></option>
                                                    <?php
                                                  }
                                                }
                                              ?>
                                          </select>
                                          <p class="help-block"><font color="red">** Required!</font></p>
                                </div> <!-- /controls -->
                              </div> <!-- /control-group -->

                              <table width="100%">
                                <tr>
                                  <td width="140" align="right" valign="top">Assign staff's<br>for this activity
                                  </td>
                                  <td style="padding-left:20px;" valign="top">
                                    <!-- <select multiple="multiple" id="my-select2" name="my-select2[]"> -->
                                      <select class="form-control span4" name id="my-select2" required>
                                      <?php
                                       $strSQL = " SELECT
                                                            b.firstname,
                                                            a.username,
                                                            b.surname
                                                            FROM
                                                            tfc_useraccount AS a
                                                            INNER JOIN tfc_userinformation AS b ON a.username = b.username
                                                            INNER JOIN tfc_usertype AS c ON a.usertype = c.usertype_id
                                                            WHERE
                                                            c.usertype_detail = 'Counter' AND a.userstatus = 'Yes' AND a.active_status = 'Yes' AND
                                                            a.license in (SELECT license FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."')";
                                      $resultVhc = $db->select($strSQL,false,true);

                                      if($resultVhc){
                                        foreach($resultVhc as $v){
                                          ?>
                                          <option value='<?php print $v['username']; ?>'><?php print $v['firstname']." ".$v['surname'];?></option>
                                          <?php
                                        }
                                      }
                                      ?>
                                      </select>
                                  </td>
                                </tr>

                                <tr>
                                  <td width="140" align="right" style="padding-top:20px;" valign="top">Assign vehicle's group
                                  </td>
                                  <td style="padding-left:20px; padding-top:20px;" valign="top">
                                    <select multiple="multiple" id="my-select3" name="my-select3[]">
                                      <?php
                                      $strSQL = "SELECT * FROM tfc_vehicle_grouping WHERE vg_mac_id = '".$_GET['mac_id']."'";
                                      $resultVhc = $db->select($strSQL,false,true);

                                      if($resultVhc){
                                        foreach($resultVhc as $v){
                                          ?>
                                          <option value='<?php print $v['vg_id']; ?>'><?php print $v['vg_title'];?></option>
                                          <?php
                                        }
                                      }
                                      ?>
                                      </select>
                                  </td>
                                </tr>
                              </table>

                              <div class="form-actions">
                                <button type="submit" name id="btnSubmit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn">Reset</button>
                              </div> <!-- /form-actions -->
                            </fieldset>
                          </form>
                          </div>

                          <!-- ------------------------------------------------------------ -->





                            <h3>Sub-activity list</h3>
                            <hr>
                            <div class="dataTable_wrapper">

                                          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                              <thead>
                                                  <tr>
                                                      <th style="font-size:1.0em;" width="30">#</th>
                                                      <th style="font-size:1.0em;">Sub-Activity title</th>
                                                      <th style="font-size:1.0em;">Position / Direction</th>
                                                      <th style="font-size:1.0em;" width="110">Auditor / Counter</th>
                                                      <th style="font-size:1.0em;" width="150">Assigned vehicle's group</th>
                                                      <th style="font-size:1.0em;" width="80">&nbsp;</th>
                                                  </tr>
                                              </thead>

                                              <?php

                                              $strSQL = "SELECT * FROM tfc_activity a inner join tfc_direction b on a.act_direction=b.dr_id WHERE a.mac_id = '".$_GET['mac_id']."' order by a.act_id desc ";
                                              $resultUser = $db->select($strSQL,false,true);

                                              print "<tbody>";
                                              if($resultUser){
                                                $c = 1;
                                                foreach($resultUser as $v){
                                                  $class = 'class="even gradeA"';
                                                  if(($c%2)==0){
                                                    $class = 'class="odd gradeA"';
                                                  }
                                                  ?>
                                                  <tr <?php print $class; ?>>
                                                      <td valign="top" style="vertical-align: top;"><?php print $c ;?></td>
                                                      <td valign="top" style="vertical-align: top;"><a href="activity_detail.php?id=3&mac_id=<?php print $v['mac_id'];?>"><?php print $v['act_title'];?></a></td>
                                                      <td valign="top" style="vertical-align: top;">Position : <?php print $v['act_position'];?><p>Direction : <?php print $v['dr_detail'];?></td>
                                                      <td class="center"  style="vertical-align: top;">
                                                        <?php
                                                         $strSQL = "SELECT 
                                                                    a.act_title,
                                                                    a.act_position,
                                                                    a.act_direction,
                                                                    a.mac_id,
                                                                    d.firstname,
                                                                    d.surname,
                                                                    c.usertype
                                                                    FROM
                                                                    tfc_activity AS a
                                                                    INNER JOIN tfc_activity_detail AS b ON a.act_id = b.act_id
                                                                    INNER JOIN tfc_useraccount AS c ON c.username = b.username
                                                                    INNER JOIN tfc_userinformation AS d ON c.username = d.username
                                                                    WHERE
                                                                    a.mac_id = 9 and a.act_id = '".$v['act_id']."'";
                                                          $resultUsers = $db->select($strSQL,false,true);

                                                          if($resultUsers){
                                                            foreach($resultUsers as $u){
                                                              print $u['firstname']." ".$u['surname']."<br>";
                                                            }
                                                            
                                                          }
                                                        ?>
                                                      </td>
                                                      <td class="center"  style="vertical-align: top;"> 
                                                        <?php
                                                         $strSQL = "SELECT vg_title 
                                                                    FROM tfc_activity_vehicle AS a 
                                                                    INNER JOIN tfc_userinformation AS b ON a.avh_username = b.username 
                                                                    INNER JOIN tfc_vehicle_grouping AS c ON a.avh_vg_id = c.vg_id 
                                                                    WHERE a.avh_username in (SELECT username FROM tfc_activity_vehicle WHERE avh_act_id = '".$v['act_id']."') 
                                                                    and a.avh_act_id = '".$v['act_id']."' group by c.vg_title";

                                    
                                                          $results3 = $db->select($strSQL,false,true);

                                                          if($results3){
                                                            foreach($results3 as $vg){
                                                              print $vg['vg_title']."<br>";
                                                            }
                                                            
                                                          }
                                                        ?>
                                                      </td>
                                                      <td class="center" style="vertical-align: top;">
                                                        <button type="button" class="btn btn-reverse" title="Edit sub-activity/work" onclick="update_subactivity('<?php print $_GET['mac_id'];?>','<?php print $v['act_id'];?>')" ><i class="icon-wrench"></i></button>
                                                        <!-- <button type="button" class="btn btn-reverse" title="Config this activity/work" onclick="config_sub_activity('<?php print $_GET['mac_id'];?>','<?php print $v['act_id'];?>')" ><i class="icon-cogs"></i></button> -->
                                                        <button type="button" class="btn btn-danger" title="Delete this activity/work" onclick="delete_sub_activity('<?php print $v['mac_id'];?>','<?php print $v['act_id'];?>')"  ><i class="icon-trash"></i></button>
                                                      </td>
                                                  </tr>
                                                  <?php
                                                  $c++;
                                                }
                                              }else{
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td colspan="5">No data</td>
                                                </tr>
                                                <?php
                                              }
                                              print "</tbody>";
                                              ?>
                                          </table>
                                      </div>
                            <!-- </div> -->
                          <?php
                        }
                        ?>

                      </td>
                    </tr>
                  </table>
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



<!-- <script src="js/jquery-1.7.2.min.js"></script> -->

<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
<script src="js/activity.js"></script>
<script src="../js/jquery.multi-select.js" type="text/javascript"></script>
  </body>

</html>
