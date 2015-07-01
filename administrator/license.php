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
	      				<h3><a href="license.php?id=1">License management</a></h3>
	  				</div> <!-- /widget-header -->
					<div class="widget-content">
						<div class="tabbable">
						<ul class="nav nav-tabs">
						  <li>
						    <a href="#formcontrols" data-toggle="tab">Create new license</a>
						  </li>
						  <li  class="active"><a href="#jscontrols" data-toggle="tab">License lists</a></li>
						</ul>
						<br>
							<div class="tab-content">
								<div class="tab-pane" id="formcontrols">
								<form name id="license-profile" class="form-horizontal">
									<fieldset>

										<div class="control-group">
											<label class="control-label" for="firstname">Serial number</label>
											<div class="controls">
												<input type="text" class="span1" name id="key1" placeholder="xxxx" value="<?php print genkey(1);?>" readonly> -
                        <input type="text" class="span1" name id="key2" placeholder="xxxx" value="<?php print genkey(2);?>" readonly> -
                        <input type="text" class="span1" name id="key3" placeholder="xxxx" value="<?php print genkey(3);?>" readonly> -
                        <input type="text" class="span1" name id="key4" placeholder="xxxx" value="<?php print genkey(4);?>" readonly>
											</div> <!-- /controls -->
										</div> <!-- /control-group -->

                    <div class="control-group">
                      <label class="control-label" for="username">Username</label>
                      <div class="controls">
                        <input type="text" class="span6 disabled" name id="username" value="<?php print genusername();?>" required>
                        <p class="help-block"><font color="red">** Required!</font> Username used to managent this license.</p>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

										<div class="control-group">
											<label class="control-label" for="password1">Password</label>
											<div class="controls">
												<input type="text" class="span4" name id="password1" value="<?php print genpassword();?>" required>
                        <p class="help-block"><font color="red">** Required!</font> Password used to managent this license.</p>
											</div> <!-- /controls -->
										</div> <!-- /control-group -->

                    <div class="control-group">
                      <label class="control-label" for="email">Email Address</label>
                      <div class="controls">
                        <input type="email" class="span4" name id="email" placeholder="Example: john.donga@egrappler.com" required>
                        <p class="help-block"><font color="red">** Required!</font></p>
                      </div> <!-- /controls -->
                    </div> <!-- /control-group -->

										<div class="control-group">
											<label class="control-label" for="password2">Admin password</label>
											<div class="controls">
												<input type="password" class="span4" name id="password2" placeholder="Enter admin password to confirm progress!" required>
                        <p class="help-block"><font color="red">** Required!</font></p>
											</div> <!-- /controls -->
										</div> <!-- /control-group -->

										<div class="form-actions">
											<button type="submit" class="btn btn-primary">Save</button>
											<button type="reset" class="btn">Reset</button>
										</div> <!-- /form-actions -->
									</fieldset>
								</form>
								</div>
                <!-- row -->
								<div class="tab-pane active" id="jscontrols">
                  <form id="edit-profile" class="form-horizontal">
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
                                                  <button class="btn" id="searchBtn" type="button">Go!</button>
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
                  	$key = " and ls_license like '".$_GET['key']."%' ";
                  	$key2 = " and ls_license like '".$_GET['key']."%' ";
                  }

                  $row_per_page = 30;
                  $start_row = ($current_page - 1) * $row_per_page;

                  $strSQL = "SELECT * FROM tfc_license WHERE 1 $key";
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

                      $URL = $_SERVER['PHP_SELF'];
                      $result = "";

                      if($current_page > 1){
                        $pg = $current_page - 1;
                        $result .= "&nbsp;";
                        $result .= "<a href=\"$URL?page=$pg\"><button type=\"button\" class=\"btn btn-sm btn-primary\">Back</button></a>";
                      }

                      if($page_start > 1){
                        $pg = $page_start - 1;
                        $result .= "&nbsp;";
                        $result .= "<a href=\"$URL?page=$pg\"><button type=\"button\" class=\"btn btn-sm btn-primary\">...</button></a>";
                      }

                      for($i = $page_start; $i <= $page_end; $i++){
                                $result .= "&nbsp;";
                                  if($i == $current_page){
                                    $result .= "<button type=\"button\" class=\"btn btn-sm btn-warning\">$i</button>";
                                    //$result .= $i;
                                  }else{
                                    $result .= "<a href=\"$URL?page=$i\"><button type=\"button\" class=\"btn btn-sm btn-primary\">$i</button></a>";
                                    // $result .= "<a href=\"$URL?page=$i\">$i</a>";
                                  }
                                  $result .= "&nbsp;";
                                }

                                if($page_end < $total_pages){
                                  $pg = $page_end + 1;
                                  $result .= "&nbsp;";$result .= "<a href=\"$URL?page=$pg\"><button type=\"button\" class=\"btn btn-sm btn-primary\">...</button></a>";
                                  //$result .= "<a href=\"$URL?page=$pg\">...</a>";
                                }

                                if($current_page< $total_pages){
                                  $pg = $current_page + 1;
                                  $result .= "&nbsp;";
                                  $result .= "<a href=\"$URL?page=$pg\"><button type=\"button\" class=\"btn btn-sm btn-primary\">Next</button></a>";
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
                                            <th style="font-size:1.0em;">Serial number</th>
                                            <th style="font-size:1.0em;">By</th>
                                            <th style="font-size:1.0em;" width="130">Create date</th>
                                            <th style="font-size:1.0em;" width="80">Status</th>
                                            <th style="font-size:1.0em;" width="20"></th>
                                        </tr>
                                    </thead>

                                    <?php

                                    $strSQL = "SELECT * FROM tfc_license WHERE 1 $key2 limit $start_row, $row_per_page";
                                    $resultLicense = $db->select($strSQL,false,true);

                                    print "<tbody>";
                                    if($resultLicense){
                                      $c = 1;
                                      foreach($resultLicense as $v){
                                        $class = 'class="even gradeA"';
                                        if(($c%2)==0){
                                          $class = 'class="odd gradeA"';
                                        }
                                        ?>
                                        <tr <?php print $class; ?>>
                                            <td><?php print $c + ($row_per_page * ($current_page-1));?></td>
                                            <td><a href="license_detail.php?id=1&ls_id=<?php print $v['ls_id'];?>"><?php print $v['ls_license'];?></a></td>
                                            <td><?php print $v['ls_username'];?></td>
                                            <td class="center">
                                            <?php
                                              print engDate($v['ls_createdate']);
                                            ?>
                                            </td>
                                            <td class="center">
                                            <?php
                                              if($v['ls_status']=='Yes'){
                                                ?>
                                                <button type="button" onclick="change_license_status('<?php print $v['ls_id'];?>','No','license')" class="btn btn-success" style="width:80px; font-size:0.9em;">Actived</button>
                                                <?php
                                              }else{
                                                ?>
                                                <button type="button" onclick="change_license_status('<?php print $v['ls_id'];?>','Yes','license')" id="enable1" class="btn btn-warning" style="width:80px; font-size:0.9em;">Disabled</button>
                                                <?php
                                              }
                                            ?>
                                            </td>
                                            <td class="center">
                                              <button type="button" class="btn btn-danger" onclick="delete_license('<?php print $v['ls_id'];?>','Yes','license.php?id=1')" ><i class="fa fa-trash"></i></button>
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
									<form id="edit-profile2" class="form-vertical">
										<fieldset>

											<br />

											<!-- <div class="form-actions">
												<button type="submit" class="btn btn-primary">Save</button> <button class="btn">Cancel</button>
                                                <button class="btn btn-info">Info</button>
                                                <button class="btn btn-danger">Danger</button>
                                                <button class="btn btn-warning">Warning</button>
                                                <button class="btn btn-invert">Invert</button>
                                                <button class="btn btn-success">Success</button>
											</div> -->
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
