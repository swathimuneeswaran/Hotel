<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php_lib/src/Exception.php';
require 'php_lib/src/PHPMailer.php';
require 'php_lib/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $firstName = $_POST['name_contact'];
    $lastName = $_POST['lastname_contact'];
    $email = $_POST['email_contact'];
    $phone = $_POST['phone_contact'];
    $message = $_POST['message_contact'];

    
    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($message)) {
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();                              
            $mail->Host       = 'smtp.gmail.com';         
            $mail->SMTPAuth   = true;                      
            $mail->Username   = 'swathimuneeswaran255@gmail.com';   //owner email
            $mail->Password   = 'ppaw jsbd ppmm ekjy';       
            $mail->SMTPSecure = 'tls';                     
            $mail->Port       = 587;                       
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            
            $mail->setFrom('swathimuneeswaran255@gmail.com', 'Hotel Turmeric');  //owner email
            $mail->addAddress($email, $firstName . ' ' . $lastName); 
            $mail->isHTML(true); 
            $mail->Subject = 'Thank You for Your Message';
            $mail->Body    = "Dear $firstName,<br><br>Thank you for reaching out to us. We have received your message and will get back to you soon.<br><br>Best regards,<br>Hotel Turmeric";
            $mail->send();

            
            $mail->clearAddresses(); 
            $mail->addAddress('swathimuneeswaran255@gmail.com', 'Owner Name'); //owner email
            $mail->isHTML(true); 
            $mail->Subject = 'Hotel Booking';
            $mail->Body    = "<strong>First Name:</strong> $firstName<br>
                              <strong>Last Name:</strong> $lastName<br>
                              <strong>Email:</strong> $email<br>
                              <strong>Phone:</strong> $phone<br>
                              <strong>Message:</strong><br>$message";
            $mail->send();

            echo 'Message has been sent successfully';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Please fill all the required fields.';
    }
}
?>
