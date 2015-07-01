<?php
function genKey($key) {
    $alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 3; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }

	$fp = '';
	if($key==1){
		$fp = date('d');
	}else if($key==2){
		$fp = date('m');
	}else if($key==3){
		$fp = substr(date('Y'),0,2);
	}else if($key==4){
		$fp = substr(date('Y'),2,2);
	}

  if(($key==1) || ($key==3)){
    return $fp.implode($pass); //turn the array into a string
  }else{
    return implode($pass).$fp; //turn the array into a string
  }


}

function genusername(){
  $alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYabcdefghijklmnopqrstuvwxyzZ0123456789";
  $pass = array(); //remember to declare $pass as an array
  $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
  for ($i = 0; $i < 5; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
  }

  $fp1 = date('d');
  $fp2 = substr(date('Y'),2,2);

  return "ls".$fp1.$fp2.implode($pass);
}

function genpassword(){
  $alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYabcdefghijklmnopqrstuvwxyzZ0123456789";
  $pass = array(); //remember to declare $pass as an array
  $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
  for ($i = 0; $i < 8; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
  }

  return implode($pass);
}

function engDate($date){
	$month=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
	$buff = explode('-',$date);
	$mon = intval($buff[1]);
	$year = $buff[0]+543;

	return $buff[2]." ".$month[$mon]." ".$year;
}


?>
