<?php
include("../PHPMailer/src/PHPMailer.php");
include("../PHPMailer/src/Exception.php");
include("../PHPMailer/src/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$Host     = 'smtp.gmail.com';
$Username = 'sosclinic368@gmail.com';
$Password = 'diqh ryki wodn stpk';
$SMTPPort = 465;
$Server_Email = 'sosclinic368@gmail.com';
$Server_Name  = 'SOSClinic';

function sendMail($patient_email, $patient_name, $doctor_email, $doctor_name)
{
    global $Host, $Username, $Password, $SMTPPort, $Server_Email, $Server_Name;
    $mail = new PHPMailer(true);
    try {
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host         = $Host;
        $mail->SMTPAuth     = true;
        $mail->Username     = $Username;
        $mail->Password     = $Password;
        $mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port         = $SMTPPort;

        $mail->setFrom($Server_Email, $Server_Name);
        $mail->addAddress($doctor_email, $doctor_name);
        $mail->addAddress($patient_email, $patient_name);

        $mail->isHTML(true);
        $mail->Subject = 'Confirm your appointment';
        $mail->Body    = 'Your appointment with ' . $doctor_name . 'has been scheduled';
        $mail->AltBody = 'Your appointment with ' . $doctor_name . 'has been scheduled';

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
