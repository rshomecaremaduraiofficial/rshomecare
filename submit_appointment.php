<?php
// Get form data
$name = $_POST['client_name'];
$email = $_POST['client_email'];
$phone = $_POST['client_phone'];
$details = $_POST['appointment_details'];

// Generate Reference Number and Appointment Number
$referenceNumber = 'RS-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()),0,5));
$appointmentNumber = 'RSHC-' . rand(1000,9999);
$status = "Confirmed"; // or Pending

// Build email content
$subject = "New Appointment Request – RS Home Care";
$to = "rshomecaremaduraiofficial@gmail.com";

$body = "New appointment submitted:" . PHP_EOL . PHP_EOL;
$body .= "Client Name      : $name" . PHP_EOL;
$body .= "Client Email     : $email" . PHP_EOL;
$body .= "Phone            : $phone" . PHP_EOL;
$body .= "Appointment No   : $appointmentNumber" . PHP_EOL;
$body .= "Reference No     : $referenceNumber" . PHP_EOL;
$body .= "Status           : $status" . PHP_EOL;
$body .= "Appointment Info : $details" . PHP_EOL;

// Optional: add headers
$headers = "From: no-reply@rshomecare.com" . "\r\n" .
           "Reply-To: $email" . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

// Send email
if(mail($to, $subject, $body, $headers)){
    // Redirect to thank you page
    header("Location: thankyou.html?ref=$referenceNumber&apt=$appointmentNumber");
    exit;
}else{
    echo "Error sending email. Please try again.";
}
?>
