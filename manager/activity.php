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
                <h3><a href="activity.php?id=3">Activity/Work management</a></h3>
            </div> <!-- /widget-header -->
          <div class="widget-content">
            <div class="tabbable">
            <ul class="nav nav-tabs">
              <li>
                <a href="#formcontrols" data-toggle="tab">Create new activity/work</a>
              </li>
              <li  class="active"><a href="#jscontrols" data-toggle="tab">Activity/Work list </a></li>
            </ul>
            <br>
              <div class="tab-content">
                <div class="tab-pane" id="formcontrols">
                <form name id="main_activity_add" class="form-horizontal" action="user.php?id=2">
                  <h3>Main activity information</h3>
                  <hr>
                  <fieldset>

                    <div class="control-group">
                      <label class="control-label" for="act_title">Activity title</label>
                      <div class="controls">
                        <input type="text" class="span6 disabled" name id="act_title" value="" required>
                        <p class="help-block"><font color="red">** Required!</font> Enter activity name.</p>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

                    <div class="control-group">
                      <label class="control-label" for="coldate">Date collected data</label>
                      <div class="controls">
                        <input type="date" class="span4" name id="coldate" value="<?php print date('Y-m-d');?>" required>
                        <p class="help-block"><font color="red">** Required!</font> Choose the date of this activity will happend.</p>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

                    <div class="control-group">
                      <label class="control-label" for="start">Start time</label>
                      <div class="controls">
                        <select class="form-control span1" name id="s_h" required>
                            <?php
                            for($h=0; $h<24; $h++){
                              if($h<10){
                                ?><option value="<?php print "0".$h;?>"><?php print "0".$h;?></option><?php
                              }else{
                                ?><option value="<?php print $h;?>"><?php print $h;?></option><?php
                              }
                            }
                            ?>
                        </select>
                        :
                        <select class="form-control span1" name id="s_m" required>
                            <?php
                            for($m=0; $m<60; $m++){
                              if($m<10){
                                ?><option value="<?php print "0".$m;?>"><?php print "0".$m;?></option><?php
                              }else{
                                ?><option value="<?php print $m;?>"><?php print $m;?></option><?php
                              }
                            }
                            ?>
                        </select>
                        :
                        <input type="text" class="span1" name id="s_s" value="00" readonly>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

                    <div class="control-group">
                      <label class="control-label" for="end">End time</label>
                      <div class="controls">
                        <select class="form-control span1" name id="e_h" required>
                            <?php
                            for($h=0; $h<24; $h++){
                              if($h<10){
                                ?><option value="<?php print "0".$h;?>"><?php print "0".$h;?></option><?php
                              }else{
                                ?><option value="<?php print $h;?>"><?php print $h;?></option><?php
                              }
                            }
                            ?>
                        </select>
                        :
                        <select class="form-control span1" name id="e_m" required>
                            <?php
                            for($m=0; $m<60; $m++){
                              if($m<10){
                                ?><option value="<?php print "0".$m;?>"><?php print "0".$m;?></option><?php
                              }else{
                                ?><option value="<?php print $m;?>"><?php print $m;?></option><?php
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
                                    <option value="15">15 min.</option>
                                    <option value="20">20 min.</option>
                                    <option value="30">30 min.</option>
                                    <option value="60">60 min.</option>
                                </select>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

                    <div class="control-group">
                      <label class="control-label" for="acType">Activity type</label>
                      <div class="controls">
                                <select class="form-control" name id="acType" required>
                                    <option value="" selected>-- Please select activity type --</option>
                                    <option value="001">MB</option>
                                    <option value="002">TMC</option>
                                </select>
                                <p class="help-block"><font color="red">** Required!</font> Please select activity type.</p>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

                    <div class="control-group">
                      <label class="control-label" for="pname">Place name</label>
                      <div class="controls">
                        <input type="text" class="span6 disabled" name id="pname" value="">
                        <p class="help-block">Enter name of place.</p>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

                    <div class="control-group">
                      <label class="control-label" for="desc">Description</label>
                      <div class="controls">
                        <input type="text" class="span6 disabled" name id="desc" value="">
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
                      <button type="submit" name id="btnSubmit" class="btn btn-primary">Save</button>
                      <button type="reset" class="btn">Reset</button>
                    </div> <!-- /form-actions -->
                  </fieldset>
                </form>
                </div>
                <!-- row -->
                <div class="tab-pane active" id="jscontrols">
                  <form id="search-profile" class="form-horizontal" action="user.php?id=2">
                                               <div class="input-append">
                                                  <input class="span2 m-wrap" autofocus name id="appendedInputButton" type="text" placeholder="Enter search key"
                                                  value="<?php
                                                    if(isset($_GET['key'])){
                                                      if($_GET['key']!=''){
                                                        print $_GET['key'];
                                                      }
                                                    }
                                                    ?>"
                                                    >
                                                  <button class="btn"  id="searchBtnAct" type="submit">Search!</button>
                                                </div>
                </form>
                  <!-- PHP script for paging result -->
                  <?php
                  $current_page = 1;
                  if(isset($_GET['page'])){
                    $current_page = $_GET['page'];
                  }

                  $key = '';
                  $key2 = '';

                  // Searching by keyword
                  if(isset($_GET['key'])){
                    $key = " and (mac_title like '%".$_GET['key']."%') ";
                    $key2 = " and (a.mac_title like '%".$_GET['key']."%') ";
                  }

                  $row_per_page = 30;
                  $start_row = ($current_page - 1) * $row_per_page;

                  $strSQL = "SELECT * FROM tfc_main_activity WHERE username in (SELECT username FROM tfc_useraccount WHERE license = '".$resultUserInfo[0]['license']."') $key";
                  $resultLicenseAll = $db->select($strSQL,false,true);

                  $total_rows = 0;
                  if($resultLicenseAll){
                    $total_rows = sizeof($resultLicenseAll);
                  }

                  $total_pages = ceil($total_rows / $row_per_page);
                  ?>

                    <?php
                      $page_range = 5;
                      $page_start = $current_page - $page_range;
                      $page_end = $current_page + $page_range;

                      if($page_start < 1){
                        $page_end += 1 - $page_start;
                        $page_start = 1;
                      }

                      if($page_end > $total_pages){
                        $diff = $page_end - $total_pages;
                        $page_start -= $diff;

                        if($page_start < 1){
                            $page_start = 1;
                        }

                        $page_end = $total_pages;
                      }

                      $URL = $_SERVER['PHP_SELF']."?id=2";
                      $result = "";

                      $vkey='';
                      if(isset($_GET['key'])){
                        $vkey = '&key='.$_GET['key'];
                      }

                      if($current_page > 1){
                        $pg = $current_page - 1;
                        $result .= "&nbsp;";

                        $result .= "<a href=\"$URL&page=$pg$vkey\"><button type=\"button\" class=\"btn btn-sm btn-primary\">Back</button></a>";
                      }

                      if($page_start > 1){
                        $pg = $page_start - 1;
                        $result .= "&nbsp;";
                        $result .= "<a href=\"$URL&page=$pg$vkey\"><button type=\"button\" class=\"btn btn-sm btn-primary\">...</button></a>";
                      }

                      for($i = $page_start; $i <= $page_end; $i++){
                                $result .= "&nbsp;";
                                  if($i == $current_page){
                                    $result .= "<button type=\"button\" class=\"btn btn-sm btn-warning\">$i</button>";
                                    //$result .= $i;
                                  }else{
                                    $result .= "<a href=\"$URL&page=$i$vkey\"><button type=\"button\" class=\"btn btn-sm btn-primary\">$i</button></a>";
                                    // $result .= "<a href=\"$URL?page=$i\">$i</a>";
                                  }
                                  $result .= "&nbsp;";
                                }

                                if($page_end < $total_pages){
                                  $pg = $page_end + 1;
                                  $result .= "&nbsp;";$result .= "<a href=\"$URL&page=$pg$vkey\"><button type=\"button\" class=\"btn btn-sm btn-primary\">...</button></a>";
                                  //$result .= "<a href=\"$URL?page=$pg\">...</a>";
                                }

                                if($current_page< $total_pages){
                                  $pg = $current_page + 1;
                                  $result .= "&nbsp;";
                                  $result .= "<a href=\"$URL&page=$pg$vkey\"><button type=\"button\" class=\"btn btn-sm btn-primary\">Next</button></a>";
                                  //$result .= "<a href=\"$URL?page=$pg\">Next</a>";
                                }

                                if($result!=''){
                                  //$result .= "<button type=\"button\" class=\"btn btn-sm btn-primary\">Back</button>";
                                  print $result;
                                }
                  ?>
                  <br><br>
                  <div class="dataTable_wrapper">

                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th style="font-size:1.0em;" width="30">#</th>
                                            <th style="font-size:1.0em;">Activity title</th>
                                            <th style="font-size:1.0em;">Date-time collection</th>
                                            <th style="font-size:1.0em;" width="110">Activity type</th>
                                            <th style="font-size:1.0em;" width="80">Create by</th>
                                            <th style="font-size:1.0em;" width="170">&nbsp;</th>
                                        </tr>
                                    </thead>

                                    <?php

                                    $strSQL = "SELECT * FROM tfc_main_activity a inner join tfc_activity_type b on a.mac_activity_type = b.at_id WHERE a.username in (SELECT username FROM tfc_useraccount WHERE license = '".$resultUserInfo[0]['license']."') $key2 order by mac_date desc limit $start_row, $row_per_page";
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
                                            <td><?php print $c + ($row_per_page * ($current_page-1));?></td>
                                            <td><a href="config_activity.php?id=3&mac_id=<?php print $v['mac_id'];?>"><?php print $v['mac_title'];?></a></td>
                                            <td><?php print "<font color=\"#06c\">".engDate($v['mac_date'])."</font><br><strong>From:</strong> ".$v['mac_start']." <strong>To:</strong>".$v['mac_end'];?></td>
                                            <td class="center">
                                            <?php

                                              print $v['at_detail'];

                                            ?>
                                            </td>
                                            <td class="center">
                                            <?php

                                            print  $v['username'];

                                            ?>
                                            </td>
                                            <td class="center">
                                              <button type="button" class="btn btn-reverse" title="Edit information of main activity/work" onclick="update_main_activity('<?php print $v['mac_id'];?>')" ><i class="icon-wrench"></i></button>
                                              <button type="button" class="btn btn-reverse" title="Config this activity/work" onclick="config_main_activity('<?php print $v['mac_id'];?>')" ><i class="icon-cogs"></i></button>
                                              <button type="button" class="btn btn-reverse" title="View data" onclick="view_main_activity('<?php print $v['mac_id'];?>')" ><i class="fa fa-file-text-o"></i></button>
                                              <button type="button" class="btn btn-danger" title="Delete this activity/work" onclick="delete_main_activity('<?php print $v['mac_id'];?>')"  ><i class="icon-trash"></i></button>
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



<!-- <script src="js/jquery-1.7.2.min.js"></script> -->

<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
<script src="js/activity.js"></script>
<script src="../js/jquery.multi-select.js" type="text/javascript"></script>

  </body>

</html>
