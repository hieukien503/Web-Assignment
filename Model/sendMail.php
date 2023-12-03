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

function sendMail($patient_email, $patient_name, $doctor_email, $doctor_name, $appoint_timeslot, $appoint_date)
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

        $mail->addAddress($patient_email, $patient_name);

        $mail->isHTML(true);
        $mail->Subject = "Confirm your appointment on " . $appoint_date . " at " . $appoint_timeslot . ".";
        // $mail->AltBody = 'Your appointment with ' . $doctor_name . 'has been scheduled';
        $mail->Body    = "Dear " . $patient_name . ",<br> <br>";

        // Provide more details about the appointment
        $mail->Body   .= "Your appointment with " . $doctor_name . " has been scheduled. Here are the details:<br>";
        $mail->Body   .= "Date: " . $appoint_date . "<br>";
        $mail->Body   .= "Time: " . $appoint_timeslot . "<br>";
        $mail->Body   .= "Doctor: " . $doctor_name . "<br>";
        $mail->Body   .= "Location: 268 Ly Thuong Kiet, District 10, HCM city" . "<br>";
        $mail->Body   .= "<br>";
        $mail->Body   .= "Please arrive 15 minutes before your appointment time. If you have any questions, ";
        $mail->Body   .= "feel free to contact us at 113 ." . "<br> <br>";
        $mail->Body   .= "Thank you for choosing our clinic. We look forward to providing you with excellent healthcare services." . "<br> <br>";
        $mail->Body   .= "Best regards," . "<br>";
        $mail->Body   .= "SOS Clinic";
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function sendMailforDoctor($patient_email, $patient_name, $doctor_email, $doctor_name, $appoint_timeslot, $appoint_date)
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

        $mail->isHTML(true);
        $mail->Subject = 'Confirm your appointment on ' . $appoint_date . ' at ' . $appoint_timeslot . '.';
        // $mail->AltBody = 'Your appointment with ' . $doctor_name . 'has been scheduled';
        $mail->Body    = 'Dear ' . $doctor_name . ',' . "<br> <br>";

        // Provide more details about the appointment
        $mail->Body   .= 'Your appointment with ' . $patient_name . ' has been scheduled. Here are the details:' . "<br>";
        $mail->Body   .= 'Date: ' . $appoint_date . "<br>";
        $mail->Body   .= 'Time: ' . $appoint_timeslot . "<br>";
        $mail->Body   .= 'Patient: ' . $patient_name . "<br>";
        $mail->Body   .= 'Please arrive 5 minutes before your appointment time'. "<br> <br>";
        $mail->Body   .= 'Best regards,' . "<br>";
        $mail->Body   .= 'SOS Clinic';
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function sendMailCancelforPatient($patient_email, $patient_name, $doctor_email, $doctor_name, $appoint_timeslot, $appoint_date)
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

        $mail->addAddress($patient_email, $patient_name);

        $mail->isHTML(true);
        $mail->Subject = 'Cancel your appointment on ' . $appoint_date . ' at ' . $appoint_timeslot . '!';
        // $mail->AltBody = 'Your appointment with ' . $doctor_name . 'has been scheduled';
        $mail->Body    = 'Dear ' . $patient_name . ',' . '<br> <br>';

        // Provide more details about the appointment
        $mail->Body   .= 'Your appointment with ' . $doctor_name . ' has been cancelled due to ' . $doctor_name . ' has some busy work. Here are the details:' . "<br>";
        $mail->Body   .= 'Date: ' . $appoint_date . '<br>';
        $mail->Body   .= 'Time: ' . $appoint_timeslot . "<br>";
        $mail->Body   .= 'Doctor: ' . $doctor_name . "<br>";
        $mail->Body   .= 'Location: 268 Ly Thuong Kiet, District 10, HCM city' . "<br>";
        $mail->Body   .= "<br>";
        $mail->Body   .= 'We are very sorry to inform you that ! We hope that you can book another appointment on the website'. "<br> <br>";
        $mail->Body   .= 'Thank you for reading our email. We look forward to providing you with another appointment on the website.' . "<br> <br>";
        $mail->Body   .= 'Best regards,' . "<br>";
        $mail->Body   .= 'SOS Clinic';

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function sendMailCancelforDoctor($patient_email, $patient_name, $doctor_email, $doctor_name, $appoint_timeslot, $appoint_date)
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
        
        $mail->isHTML(true);
        $mail->Subject = 'Cancel your appointment on ' . $appoint_date . ' at ' . $appoint_timeslot . '!';
        // $mail->AltBody = 'Your appointment with ' . $doctor_name . 'has been scheduled';
        $mail->Body    = 'Dear ' . $doctor_name . ',' . "<br> <br>";

        // Provide more details about the appointment
        $mail->Body   .= 'Your appointment with ' . $patient_name . ' has been cancelled due to his/her some busy work. Here are the details:' . "<br>";
        $mail->Body   .= 'Date: ' . $appoint_date . "<br>";
        $mail->Body   .= 'Time: ' . $appoint_timeslot . "<br>";
        $mail->Body   .= 'Patient: ' . $patient_name . "<br>";
        $mail->Body   .= 'Location: 268 Ly Thuong Kiet, District 10, HCM city' . "<br>";
        $mail->Body   .= "<br>";
        $mail->Body   .= 'We are very sorry to inform you that ! We hope that you will have a good day'. "<br> <br>";
        $mail->Body   .= 'Thank you for reading our email!' . "<br><br>";
        $mail->Body   .= 'Best regards,' . "<br>";
        $mail->Body   .= 'SOS Clinic';

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
