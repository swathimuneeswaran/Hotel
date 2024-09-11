<?php
// Check if form is submitted
if (isset($_POST["submit"])) {
    // Get form input values
    $firstName = $_POST['name_contact'];
    $lastName = $_POST['lastname_contact'];
    $email = $_POST['email_contact'];
    $phone = $_POST['phone_contact'];
    $message = $_POST['message_contact'];

    // Set the recipient email addresses
    $ownerEmail = "sakthivel.raja@zohocorp.com";  // Hotel owner's email
    $ownerName = "Hotel Owner";

    // Subject for the emails
    $subjectOwner = "New Availability Request from Website";
    $subjectCustomer = "Thank you for contacting us!";

    // Message body for the hotel owner
    $messageOwner = "
    <html>
    <head>
        <title>New Availability Request</title>
    </head>
    <body>
        <h2>New Message from Website</h2>
        <p><strong>Name:</strong> $firstName $lastName</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Message:</strong><br>$message</p>
    </body>
    </html>";

    // Message body for the customer
    $messageCustomer = "
    <html>
    <head>
        <title>Thank you for contacting us</title>
    </head>
    <body>
        <h2>Dear $firstName,</h2>
        <p>Thank you for reaching out to us. We have received your message and will get back to you soon.</p>
        <p><strong>Your message:</strong><br>$message</p>
        <p>Best Regards,<br>Your Company Name</p>
    </body>
    </html>";

    // Headers for the email (owner)
    $headersOwner  = "MIME-Version: 1.0" . "\r\n";
    $headersOwner .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headersOwner .= "From: $firstName $lastName <$email>" . "\r\n";  // Use customer's email as sender

    // Headers for the email (customer)
    $headersCustomer  = "MIME-Version: 1.0" . "\r\n";
    $headersCustomer .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headersCustomer .= "From: Hotel <$ownerEmail>" . "\r\n";  // Use hotel email as sender

    // Send email to the hotel owner
    if (mail($ownerEmail, $subjectOwner, $messageOwner, $headersOwner)) {
        // If email to the owner was sent successfully, send confirmation email to the customer
        if (mail($email, $subjectCustomer, $messageCustomer, $headersCustomer)) {
            echo "Your enquiry has been submitted successfully!";
        } else {
            echo "There was an error sending the confirmation email to you.";
        }
    } else {
        echo "There was an error sending your message.";
    }
}
?>
