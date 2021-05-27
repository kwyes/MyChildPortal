<?php
// require_once '../settings.php';
require_once '../lib/PHPMailer-5.2.22/PHPMailerAutoload.php';

function sendEmail($from, $to, $cc, $subject, $body, $altBody = '') {
    global $settings;
    $mail = new PHPMailer();
    $mail->isSMTP();

    $mail->CharSet = "UTF-8";
    $mail->SMTPDebug = false;
    $mail->Host = 'smtp.sendgrid.net';
    $mail->Port = 587;
    $mail->SMTPSecure = 'TLS';
    $mail->SMTPAuth = true;



    $mail->setFrom($from['email'], $from['name']);
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    foreach($to as $row) {
        $email = $row['email'];
        $name = $row['name'];
        $mail->addAddress($email, $name);
    }
    //$mail->addCC($from['email'], $from['name']);
    if($cc) {
        foreach($cc as $row) {
            $email = $row['email'];
            $name = $row['name'];
            $mail->addCC($email, $name);
        }
    }
    $mail->Subject = $subject;
    $mail->msgHTML($body);
    $mail->AltBody = $altBody;
    if(!$mail->send()) {
        return $mail->ErrorInfo;
    } else {
        return true;
    }
}
