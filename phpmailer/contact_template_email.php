<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';

$mail = new PHPMailer(true);

try {
    // Form fields
    $name_contact     = $_POST['name_contact'];
    $lastname_contact = $_POST['lastname_contact'];
    $email_contact    = $_POST['email_contact'];
    $phone_contact    = $_POST['phone_contact'];
    $message_contact  = $_POST['message_contact'];
    $verify_contact   = $_POST['verify_contact'];

    // Form validation
    if (trim($name_contact) == '') {
        echo '<div class="error_message">You must enter your Name.</div>';
        exit();
    } else if (trim($lastname_contact) == '') {
        echo '<div class="error_message">Please enter your Last Name.</div>';
        exit();
    } else if (trim($email_contact) == '') {
        echo '<div class="error_message">Please enter a valid email address.</div>';
        exit();
    } else if (!filter_var($email_contact, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="error_message">You have entered an invalid e-mail address.</div>';
        exit();
    } else if (trim($phone_contact) == '') {
        echo '<div class="error_message">Please enter a valid phone number.</div>';
        exit();
    } else if (!is_numeric($phone_contact)) {
        echo '<div class="error_message">Phone number can only contain numbers.</div>';
        exit();
    } else if (trim($message_contact) == '') {
        echo '<div class="error_message">Please enter your message.</div>';
        exit();
    } else if (!isset($verify_contact) || trim($verify_contact) == '') {
        echo '<div class="error_message">Please enter the verification number.</div>';
        exit();
    } else if (trim($verify_contact) != '4') {
        echo '<div class="error_message">The verification number you entered is incorrect.</div>';
        exit();
    }

    // Get the email's HTML content
    $email_html = file_get_contents('template-email.html');

    // Setup email content
    $e_content = "You have been contacted by <strong>$name_contact $lastname_contact</strong> with the following message:<br><br>$message_contact<br><br>You can contact $name_contact via email at $email_contact or by phone at $phone_contact";
    $body = str_replace('message', $e_content, $email_html);

    // Send email to admin
    $mail->setFrom('info@Paradise.com', 'Message from Paradise Hotel');
    $mail->addAddress('sanmithasree22@gmail.com', 'Admin');
    $mail->addReplyTo('noreply@Paradise.com', 'No Reply');
    $mail->isHTML(true);
    $mail->Subject = 'New Booking Received from ' . $name_contact;
    $mail->MsgHTML($body);

    $mail->send();

    // Send confirmation email to the user
    $mail->ClearAddresses();
    $mail->addAddress($email_contact); // User's email
    $mail->isHTML(true);
    $mail->Subject = 'Booking Confirmation';
    
    // Get confirmation email's HTML content
    $email_html_confirm = file_get_contents('confirmation.html');
    $confirmation_content = "Dear $name_contact $lastname_contact,<br><br>Thank you for your booking. We have successfully received your request.<br><br>Message: $message_contact<br><br>We will get back to you shortly!";
    $body = str_replace('message', $confirmation_content, $email_html_confirm);
    
    $mail->MsgHTML($body);
    $mail->send();

    // Success message
    echo '<div id="success_page">
            <div class="icon icon--order-success svg">
                 <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                  <g fill="none" stroke="#8EC343" stroke-width="2">
                     <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                     <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                  </g>
                 </svg>
             </div>
            <h5>Thank you!<span>Your booking has been successfully sent!</span></h5>
        </div>';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
