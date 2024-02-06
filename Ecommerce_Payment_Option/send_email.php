<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';

session_start();

// Create a new PHPMailer instance
$mail = new PHPMailer(true);


    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'thaminduperera14@gmail.com';                     //SMTP username
    $mail->Password   = 'echroqbbnkxlhpmp';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;  

// Sender and recipient
$mail->setFrom('thaminduperera14@gmail.com', 'Kumara Stores');
$mail->addAddress('thaminduperera14@gmail.com', 'Kumara Stores');

// Email content
$mail->isHTML(true);
$mail->Subject = 'Payment Received';


// Function to Check if the totalSum session variable exists and use it in the email body
if (isset($_SESSION['totalSum'])) {
    $totalSum = $_SESSION['totalSum'];
    // Add the image and text to the email body
    $mail->Body = '
        <html>
        <body>
            <img src="https://pbs.twimg.com/profile_images/715431742996230144/Xh-fQOxI_400x400.jpg" alt="Logo" style="height: 100px; width: 100px; margin-bottom: 50px">
            <p style="font-weight: bold; font-size: 20px; margin-bottom: 80px;">Payment of Rs.' . $totalSum . ' has been received successfully.</p>
            <p style="font-size: 15px;">Thank You for banking with us.</p>
        </body>
        </html>';
} else {
    $mail->Body = 'Payment received successfully.';
}



// Send the email
if (!$mail->send()) {
    echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Email sent successfully!';
}

?>

