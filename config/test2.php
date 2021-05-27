<?php
require_once 'sendEmailClass.php';

$from = array('email' => 'helpdesk@bodwell.edu', 'name' => 'BHS IT Help Desk');
$cc = '';
$subject = 'devAzure - test';
$body = 'devAzure - test';

$to = array(
    array('email' => 'kwyes2@hotmail.com', 'name' => "Chanho Lee")
);
$res = sendEmail($from, $to, $cc, $subject, $body);
echo $res;
 ?>
