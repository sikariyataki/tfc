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
                <h3><a href="activity.php?id=3">Activity/Work management</a> / Choose pattern</h3>
            </div> <!-- /widget-header -->
          <div class="widget-content">
            <div class="tabbable">
            <ul class="nav nav-tabs">
              <li  class="active"><a href="#jscontrols" data-toggle="tab">Pattern</a></li>
            </ul>
            <br>
              <div class="tab-content">

                <!-- row -->
                <div class="tab-pane active" id="jscontrols">
                  <form name id="" class="form-horizontal">
                    <h3>Pattern list information</h3>
                    <hr>
                    <table width="100%" class="table table-striped table-bordered table-hover">
                      <thead>
                          <tr>
                              <th style="font-size:1.0em;" width="30">#</th>
                              <th style="font-size:1.0em;">Pattern name</th>
                              <th style="font-size:1.0em;">Create by</th>
                              <th style="font-size:1.0em;" width="83">&nbsp;</th>
                          </tr>
                      </thead>

                      <tbody>
                        <?php
                        $strSQL = "SELECT * FROM tfc_group_shortcut a inner join tfc_main_activity b on a.gs_mac_id=b.mac_id WHERE b.username in (SELECT username FROM tfc_useraccount WHERE license in (SELECT license FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."'))";
                        $resultPattern = $db->select($strSQL,false,true);

                        if($resultPattern){
                          $c = 1;
                          foreach($resultPattern as $v){
                            ?>
                            <tr>
                              <td><?php print $c;?></td>
                              <td><?php print $v['gs_name'];?></td>
                              <td><?php print $v['username'];?></td>
                              <td>
                                <button type="button" class="btn btn-reverse" title="View pattern" onclick="view_pattern('<?php print $_GET['mac_id'];?>','<?php print $v['gs_mac_id'];?>')" ><i class="icon-eye-open"></i></button>
                                <button type="button" class="btn btn-primary" title="Copy pattern" onclick="config_vehicle_group('<?php print $_GET['mac_id'];?>','<?php print $v['vg_id'];?>')" ><i class="icon-share"></i></button>
                              </td>
                            </tr>
                            <?php
                            $c++;
                          }
                        }
                        ?>
                      </tbody>
                    </table>
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
