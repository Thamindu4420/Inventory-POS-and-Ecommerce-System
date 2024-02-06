<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';


function sendEmail($email, $name) {

$mail = new PHPMailer(true);

try {
    //Server settings

    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'thaminduperera14@gmail.com';                     //SMTP username
    $mail->Password   = 'echroqbbnkxlhpmp';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect 

    //Recipients
    $mail->setFrom('thaminduperera14@gmail.com', 'Kumara Stores');
    $mail->addAddress($email, $name);     //Add a recipient



    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Order Placed Successfully';

    $mail->Body = '
            <div style="text-align: center;">
                <img src="https://i.ibb.co/jrp6hSp/Screenshot-1183.png" alt="Kumara Stores Logo" style="height: 100px; width: 100px; vertical-align: middle; margin-bottom: 50px">
                <p style="margin-bottom: 50px">Your order has been Placed successfully.</p>
                <p style="font-weight: bold; font-size: 15px; margin-bottom: 50px;">Thank you for Shopping with Kumara Stores</p>
                <p style="font-weight: bold; font-size: 10px; font-style: calibri; text-align: left;">Kumara Stores <br> No 25/B, <br> Deniyaya Road, <br> Rakwana.</p>
            </div>';

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}

?>