<?php
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
    include_once '../config/dbconnect.php';
    require_once '../config/mychildPortalClass.php';
    $c = new mychildPortalClass();
    $mob = $c->getSelfAssessments();
  		if ($mob != false) {
  			echo json_encode($mob);
  		} else {
  			echo json_encode(array('result' => '0'));
  		}
} else {
	echo 0;
	exit;
}
?>
