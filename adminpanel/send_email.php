<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../Composer/vendor/autoload.php';

function sendEmailWithAttachment($email, $subject, $body, $attachmentContent, $attachmentName)
{
    $mail = new PHPMailer(true);
    try {
        // Set up PHPMailer
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'pawpawpikpik0@gmail.com'; // SMTP username
        $mail->Password = 'xuhe uljs bvvb yfth'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('pawpawpikpik@gmail.com', 'Paws Store');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Attach the PDF
        $mail->addStringAttachment($attachmentContent, $attachmentName);

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
?>