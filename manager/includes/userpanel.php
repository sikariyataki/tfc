<?php
$strSQL = "SELECT * FROM tfc_useraccount a inner join tfc_userinformation b on a.username = b.username WHERE a.username = '".$_SESSION['userTFC']."'";
$resultUserInfo = $db->select($strSQL,false,true);

if(!$resultUserInfo){
  ?>
  <script>
    alert('Session denine!');
    window.location = '../signout.php';
  </script>
  <?php
}

// if($resultUserInfo){
//   print "A";
// }else{
//   print "N";
// }
?>
<ul class="nav pull-right">
  <li class="dropdown" >
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="icon-user"></i> <?php print $resultUserInfo[0]['firstname']." ".$resultUserInfo[0]['surname']; ?> <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="javascript:;">Profile</a></li>
      <li><a href="javascript:;">Change password</a></li>
      <li><a href="../signout.php">Logout</a></li>
    </ul>
  </li>
</ul>
