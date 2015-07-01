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
	      				<h3><a href="license.php?id=1">License configuration</a></h3>
	  				</div> <!-- /widget-header -->
					<div class="widget-content">
						<div class="tabbable">
						<br>
							<div class="tab-content">
                <?php
                $strSQL = "SELECT * FROM tfc_license WHERE ls_id = '".$resultUserInfo[0]['license']."'";
                $resultLicense = $db->select($strSQL,false,true);
                ?>
                <h3>License information</h2>
                  <hr>
                <table width="100%">
                  <tr>
                    <td width="150" height="40" style="font-weight:bold;">Serial number</td>
                    <td><?php print $resultLicense[0]['ls_license'];?></td>
                  </tr>
                  <tr>
                    <td width="150" height="40" style="font-weight:bold;">Create date</td>
                    <td><?php print $resultLicense[0]['ls_createdate'];?></td>
                  </tr>
                </table>
                <hr>
                <h3>License configuration</h3>
                <hr>
                <?php
                $strSQL = "SELECT * FROM tfc_license_config WHERE lc_ls_id = '".$resultLicense[0]['ls_id']."'";
                $resultRegkey = $db->select($strSQL,false,true);
                ?>
                <form name id="license-config" class="form-horizontal">
                  <fieldset>
                    <div class="control-group">
                      <label class="control-label" for="lsid">license ID</label>
                      <div class="controls">
                        <input type="text" class="span2 disabled" name id="lsid" value="<?php print $resultLicense[0]['ls_id']; ?>" readonly >
                        </div> <!-- /controls -->
                    </div>

                    <div class="control-group">
                      <label class="control-label" for="regkey">Register key</label>
                      <div class="controls">
                        <input type="text" class="span4 disabled" name id="regkey" value="<?php if($resultRegkey){ print $resultRegkey[0]['lc_regkey'];} ?>" required >
                        <p class="help-block"><font color="red">** Required!</font> <br>Please create register key for register on mobile application. <font color="#06c">[ recommend 4-6 charaters ]</font></p>
                      </div> <!-- /controls -->
                    </div>

                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary"><?php if($resultRegkey){ print "Update";}else{ print "Save";} ?></button>
                      <button type="reset" class="btn">Reset</button>
                    </div> <!-- /form-actions -->
                  </fieldset>
                </form>
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
<script src="js/license.js"></script>

  </body>

</html>
