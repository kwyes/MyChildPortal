<?php
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
	@extract($_POST);
	if(isset($EnrollmentDate)) {
		include_once '../config/dbconnect.php';
		require_once '../config/mychildPortalClass.php';
		$c = new mychildPortalClass();
		$mob = $c->EnrollTerm($EnrollmentDate);
		if ($mob != false) {
			echo json_encode($mob);
		} else {
			echo json_encode(array('result' => '0'));
		}
	}else {
		echo json_encode(array('result' => '-2'));
	}
} else {
	echo 0;
	exit;
}


?>
