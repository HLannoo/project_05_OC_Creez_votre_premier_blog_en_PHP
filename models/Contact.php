<?php

/**
 * 
 * 
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Contact
{
    function sendEmail($email,$message,$headers)


    {
        $mail = new PHPMailer(true);

        try {
            $filename = require APP_DIRECTORY . 'config/config_email.php';
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = $filename[0];                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = $filename[1];                     //SMTP username
            $mail->Password = $filename[2];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = $filename[3];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('h.lannoo@orange.fr', 'Formulaire de contact');
            $mail->addAddress("h.lannoo@orange.fr", "$email");

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "New message : $headers";
            $mail->AltBody = "$message";
            $mail->Body = "$message";

            $mail->send();
        } catch (Exception $e) {
            $response = "Votre message n'a pas pu être envoyé. Mailer Error: {$mail->ErrorInfo}";
            echo $response;
        }
    }
}