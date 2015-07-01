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
                <i class="icon-user"></i>
                <h3><a href="user.php?id=2">Vehicle management</a></h3>
            </div> <!-- /widget-header -->
          <div class="widget-content">
            <div class="tabbable">
            <ul class="nav nav-tabs">
              <!-- <li>
                <a href="#formcontrols" data-toggle="tab">Create new vehicle type</a>
              </li> -->
              <li  class="active"><a href="#jscontrols" data-toggle="tab">Vehicle type list </a></li>
            </ul>
            <br>
              <div class="tab-content">

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
                                                  <button class="btn"  id="searchBtn" type="submit">Search!</button>
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
                    $key = " and (vehicle_detail like '%".$_GET['key']."%' ) ";
                    $key2 = " and (vehicle_detail like '%".$_GET['key']."%' ) ";
                  }

                  $row_per_page = 30;
                  $start_row = ($current_page - 1) * $row_per_page;

                  $strSQL = "SELECT * FROM tfc_vehicletype WHERE 1 $key";
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
                                            <th style="font-size:1.0em;">Vehicle name</th>
                                            <th style="font-size:1.0em;">Icon</th>
                                            <!-- <th style="font-size:1.0em;" width="80">&nbsp;</th> -->
                                        </tr>
                                    </thead>

                                    <?php

                                    $strSQL = "SELECT * FROM tfc_vehicletype WHERE 1 $key2 limit $start_row, $row_per_page";
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
                                            <td><a href="#"><?php print $v['vehicle_detail'];?></a></td>
                                            <td><?php print $v['icon'];?></td>

                                            <!-- <td class="center">
                                              <button type="button" class="btn btn-reverse" onclick="update_account('<?php //print $v['vehicle_id'];?>')"  ><i class="icon-wrench"></i></button>
                                              <button type="button" class="btn btn-danger" onclick="delete_account('<?php //print $v['vehicle_id'];?>','user.php?id=2')" ><i class="icon-trash"></i></button>
                                            </td> -->
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



<script src="js/jquery-1.7.2.min.js"></script>

<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
<script src="js/vehicle.js"></script>

  </body>

</html>
