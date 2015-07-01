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

if(isset($_GET['username'])){
  $strSQL = "SELECT * FROM tfc_useraccount a inner join tfc_userinformation b on a.username=b.username WHERE a.username = '".$_GET['username']."'";
  $resultAccount = $db->select($strSQL,false,true);

  if(!$resultAccount){
    header('Location: user.php?id=2');
    exit();
  }
}else{
  header('Location: user.php?id=2');
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
	      				<h3><a href="user.php?id=2">User account management</a> / Update user account information</h3>
	  				</div> <!-- /widget-header -->
					<div class="widget-content">
						<div class="tabbable">
              <br>
              <form name id="update-user-profile" class="form-horizontal" action="user.php?id=2">
                <fieldset>
                  <h3>Account information</h3><hr>
                  <div class="control-group">
                    <label class="control-label" for="username">Username</label>
                    <div class="controls">
                      <input type="text" class="span6 disabled" name id="username" value="<?php print $resultAccount[0]['username'];?>" required readonly>
                    </div> <!-- /controls -->
                  </div> <!-- /control-group -->

                  <div class="control-group">
                    <label class="control-label" for="email">Email Address</label>
                    <div class="controls">
                      <input type="email" class="span4" name id="email" placeholder="Example: john.donga@egrappler.com" required value="<?php print $resultAccount[0]['email'];?>">
                      <p class="help-block"><font color="red">** Required!</font></p>
                    </div> <!-- /controls -->
                  </div> <!-- /control-group -->

                  <div class="control-group">
                    <label class="control-label" for="email">Accout type</label>
                    <div class="controls">
                              <select class="form-control" name id="acctype" required>
                                  <option value="" selected>-- Please select account type --</option>
                                  <option value="001" <?php if($resultAccount[0]['usertype']=='001') print "selected";?>>Administrator</option>
                                  <option value="002" <?php if($resultAccount[0]['usertype']=='002') print "selected";?>>Manager</option>
                                  <option value="003" <?php if($resultAccount[0]['usertype']=='003') print "selected";?>>Auditor</option>
                                  <option value="004" <?php if($resultAccount[0]['usertype']=='004') print "selected";?>>Counter</option>
                                  <option value="005" <?php if($resultAccount[0]['usertype']=='005') print "selected";?>>Monitor</option>
                              </select>
                              <p class="help-block"><font color="red">** Required!</font></p>
                    </div> <!-- /controls -->
                  </div> <!-- /control-group -->
                  <hr>
                    <h3>User information</h3>
                  <hr>
                  <div class="control-group">
                    <label class="control-label" for="firstname">Firstname</label>
                    <div class="controls">
                      <input type="text" class="span6 disabled" name id="firstname" value="<?php print $resultAccount[0]['firstname'];?>" required>
                      <p class="help-block"><font color="red">** Required!</font></p>
                    </div> <!-- /controls -->
                  </div> <!-- /control-group -->

                  <div class="control-group">
                    <label class="control-label" for="surname">Surname</label>
                    <div class="controls">
                      <input type="text" class="span6 disabled" name id="surname" value="<?php print $resultAccount[0]['surname'];?>" >
                    </div> <!-- /controls -->
                  </div> <!-- /control-group -->

                  <div class="control-group">
                    <label class="control-label" for="phone">Phone number</label>
                    <div class="controls">
                      <input type="tel" class="span6 disabled" name id="phone" value="<?php print $resultAccount[0]['phonenumber'];?>" >
                    </div> <!-- /controls -->
                  </div> <!-- /control-group -->

                  <div class="control-group">
                    <label class="control-label" for="address">Address</label>
                    <div class="controls">
                      <textarea rows="5" class="span6 disabled" name id="address" ><?php print $resultAccount[0]['address']; ?></textarea>
                    </div> <!-- /controls -->
                  </div> <!-- /control-group -->

                  <hr>
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
<script src="js/account.js"></script>

  </body>

</html>
