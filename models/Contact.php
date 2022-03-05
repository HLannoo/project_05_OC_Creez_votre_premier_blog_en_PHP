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
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.orange.fr';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'h.lannoo@orange.fr';                     //SMTP username
            $mail->Password = '6D5be11f!';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('h.lannoo@orange.fr', 'Formulaire de contact');
            $mail->addAddress("h.lannoo@orange.fr", "$email");

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "New message : $headers";
            $mail->AltBody = "$message";
            $mail->Body = "$message";

            $mail->send();
            echo 'Message envoyé';
        } catch (Exception $e) {
            echo "Votre message n'a pas pu être envoyé. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}