<?php
session_start();

require("../libs/connect.class.php");

require("../php/function.inc.php");
$db = new database();
$db->connect();

$id=0;
if(isset($_GET['id'])){
  $id = $_GET['id'];
}

if(isset($_GET['ls_id'])){
  $strSQL = "SELECT * FROM tfc_license WHERE ls_id = '".$_GET['ls_id']."'";
  $resultLicense = $db->select($strSQL,false,true);

  if(!$resultLicense){
    header('Location: license.php?id=1');
    exit();
  }
}else{
  header('Location: license.php?id=1');
  exit();
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



    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

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
	      				<i class="icon-list-alt"></i>
	      				<h3><a href="license.php?id=1">License management</a> / License information</h3>
	  				</div> <!-- /widget-header -->
					<div class="widget-content">
						<div class="tabbable">

						<br>
							<div class="tab-content">

								<!-- tab content -->
                <table width="100%">
                  <tr>
                    <td width="150" height="40" style="font-weight:bold;">Serial number</td>
                    <td><?php print $resultLicense[0]['ls_license'];?></td>
                  </tr>
                  <tr>
                    <td width="150" height="40" style="font-weight:bold;">Create by</td>
                    <td><?php print $resultLicense[0]['ls_username'];?></td>
                  </tr>
                  <tr>
                    <td width="150" height="40" style="font-weight:bold;">Create date</td>
                    <td><?php print $resultLicense[0]['ls_createdate'];?></td>
                  </tr>
                  <tr>
                    <td width="150" height="40" style="font-weight:bold;">Active status</td>
                    <td>
                    <?php
                      if($resultLicense[0]['ls_status']=='Yes'){
                        ?>
                        <button type="button" class="btn btn-success" onclick="change_license_status_p2('<?php print $resultLicense[0]['ls_id'];?>','No','license_detail')" style="width:80px; font-size:0.9em;">Actived</button>
                        <?php
                      }else{
                        ?>
                        <button type="button" class="btn btn-warning" onclick="change_license_status_p2('<?php print $resultLicense[0]['ls_id'];?>','Yes','license_detail')" style="width:80px; font-size:0.9em;">Disabled</button>
                        <?php
                      }
                    ?>
                    </td>
                  </tr>
                </table>
                <br>
                <h3>Account allowed via this license</h3>
                <br>
                <div class="dataTable_wrapper">

                              <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                  <thead>
                                      <tr>
                                          <th style="font-size:1.0em;" width="30">#</th>
                                          <th style="font-size:1.0em;">Fullname</th>
                                          <th style="font-size:1.0em;">Usertype</th>
                                          <th style="font-size:1.0em;" width="80">Status</th>
                                          <th style="font-size:1.0em;" width="80">Activate</th>
                                          <!-- <th style="font-size:1.0em;" width="20"></th> -->
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $strSQL = "SELECT * FROM tfc_useraccount a inner join tfc_userinformation b on a.username = b.username inner join tfc_usertype c on a.usertype=c.usertype_id WHERE a.license = '".$resultLicense[0]['ls_id']."'";
                                    $resultUser = $db->select($strSQL,false,true);

                                    if($resultUser){
                                      $c = 1;
                                      foreach($resultUser as $v){
                                        $class = 'class="even gradeA"';
                                        if(($c%2)==0){
                                          $class = 'class="odd gradeA"';
                                        }
                                        ?>
                                          <tr <?php print $class; ?>>
                                              <td><?php print $c;?></td>
                                              <td><?php print $v['firstname']." ".$v['surname'];?></td>
                                              <td><?php print $v['usertype_detail']?></td>
                                              <td class="center">
                                              <?php
                                                if($v['userstatus']=='Yes'){
                                                  ?>
                                                  <button type="button" class="btn btn-success" onclick="change_user_status('<?php print $v['username'];?>','No','license_detail.php?id=1&ls_id=<?php print $_GET['ls_id'];?>')" style="width:80px; font-size:0.9em;">Actived</button>
                                                  <?php
                                                }else{
                                                  ?>
                                                  <button type="button" class="btn btn-warning" onclick="change_user_status('<?php print $v['username'];?>','Yes','license_detail.php?id=1&ls_id=<?php print $_GET['ls_id'];?>')" style="width:80px; font-size:0.9em;">Disabled</button>
                                                  <?php
                                                }
                                              ?>
                                              </td>
                                              <td class="center">
                                              <?php
                                                if($v['active_status']=='Yes'){
                                                  ?>
                                                  <button type="button" class="btn btn-success" onclick="change_user_active_status('<?php print $v['username'];?>','No','license_detail.php?id=1&ls_id=<?php print $_GET['ls_id'];?>')" style="width:80px; font-size:0.9em;">Actived</button>
                                                  <?php
                                                }else{
                                                  ?>
                                                  <button type="button" class="btn btn-warning" onclick="change_user_active_status('<?php print $v['username'];?>','Yes','license_detail.php?id=1&ls_id=<?php print $_GET['ls_id'];?>')" style="width:80px; font-size:0.9em;">Disabled</button>
                                                  <?php
                                                }
                                              ?>
                                              </td>
                                              <!-- <td class="center">
                                                <button type="button" class="btn btn-danger" ><i class="fa fa-trash"></i></button>
                                              </td> -->
                                          </tr>
                                        <?php
                                        $c++;
                                      }
                                    }
                                    ?>
                                </tbody>
                            </table>
                </div>
                <!-- End tab content -->

							</div>
						</div>
					</div> <!-- /widget-content -->

				</div> <!-- /widget -->

		    </div> <!-- /span8 -->




	      </div> <!-- /row -->
	    </div> <!-- /container -->
	</div> <!-- /main-inner -->
</div> <!-- /main -->




<div class="extra">

	<div class="extra-inner">

		<div class="container">

			<div class="row">
                    <div class="span3">
                        <h4>
                            Admin menus</h4>
                        <ul>
                            <li><a href="index.php">Dashboard</a></li>
                            <li><a href="license.php?id=1">License</a></li>
                            <li><a href="user.php?id=2">User account</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                </div> <!-- /row -->

		</div> <!-- /container -->

	</div> <!-- /extra-inner -->

</div> <!-- /extra -->




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
<script src="js/license.js"></script>

  </body>

</html>
