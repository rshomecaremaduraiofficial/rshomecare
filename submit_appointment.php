<?php
// Only proceed if POST request
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['client_name'] ?? '';
    $email = $_POST['client_email'] ?? '';
    $phone = $_POST['client_phone'] ?? '';
    $details = $_POST['appointment_details'] ?? '';

    // Generate Reference Number and Appointment Number
    $referenceNumber = 'RS-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()),0,5));
    $appointmentNumber = 'RSHC-' . rand(1000,9999);
    $status = "Confirmed";

    // Prepare email
    $to = "rshomecaremaduraiofficial@gmail.com";
    $subject = "New Appointment Request – RS Home Care";

    $body = "New appointment submitted:\n\n";
    $body .= "Client Name      : $name\n";
    $body .= "Client Email     : $email\n";
    $body .= "Phone            : $phone\n";
    $body .= "Appointment No   : $appointmentNumber\n";
    $body .= "Reference No     : $referenceNumber\n";
    $body .= "Status           : $status\n";
    $body .= "Appointment Info : $details\n";

    $headers = "From: no-reply@rshomecare.com" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Send email
    if(mail($to, $subject, $body, $headers)){
        // Redirect to thank you page with numbers
        header("Location: thankyou.html?ref=$referenceNumber&apt=$appointmentNumber&status=$status");
        exit;
    } else {
        echo "Error sending email. Please try again.";
    }
} else {
    echo "Invalid request.";
}
?>
