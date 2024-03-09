<?php

use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "{$_SERVER["DOCUMENT_ROOT"]}/vendor/phpmailer/phpmailer/src/PHPMailer.php";
require_once "{$_SERVER["DOCUMENT_ROOT"]}/vendor/phpmailer/phpmailer/src/Exception.php";
require_once "{$_SERVER["DOCUMENT_ROOT"]}/vendor/phpmailer/phpmailer/src/SMTP.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/env.php";

function sendMail (string $to, string $subject, string $message,  $attachments = []): bool {

    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = MAIL_DEBUG;                    // Enable verbose debug output
        $mail->isSMTP();                                  // Send using SMTP
        $mail->Host       = MAIL_HOST;                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                         // Enable SMTP authentication
        $mail->Username   = MAIL_USERNAME;                // SMTP username
        $mail->Password   = MAIL_PASSWORD;                // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Enable implicit TLS encryption
        $mail->Port       = MAIL_PORT;                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->CharSet    = MAIL_CHARSET;

        // Recipients
        $mail->setFrom(MAIL_USERNAME, "Website");
        $mail->addAddress($to);                           //Add a recipient

        // Attachments
        if ($attachments){
            foreach ($attachments as $attachment){
                $mail->addAttachment($attachment);
            }
        }

        // Content
        $mail->isHTML(true);                       //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;

        return $mail->send();

    } catch (Exception $e) {
        echo "PHPMailer Error: $e";
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

