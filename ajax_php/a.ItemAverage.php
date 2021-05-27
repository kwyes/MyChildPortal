<?php
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
	@extract($_POST);
	if(isset($courseIdArr)) {
		include_once '../config/dbconnect.php';
		require_once '../config/studentPortalClass.php';
		$c = new studentPortalClass();
		$mob = $c->GetItemAverage($courseIdArr);
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
