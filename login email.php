<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(403);
    exit;
}

$name    = $_POST["name"] ?? "Unknown";
$phone   = $_POST["phone"] ?? "Unknown";
$success = $_POST["success"] ?? "NO";
$page    = $_POST["page"] ?? "Unknown";

$ip      = $_SERVER["REMOTE_ADDR"] ?? "Unknown";
$time    = date("d M Y, h:i A");

/* -------- EMAIL SETTINGS -------- */
$to = "rshomecaremaduraiofficial@gmail.com";
$subject = "Agreement Page Access Attempt";

/* -------- EMAIL MESSAGE -------- */
$message = "
Agreement access attempt received.

Name: $name
Phone: $phone
Access Granted: $success

Page URL:
$page

IP Address:
$ip

Time:
$time
";

/* -------- HEADERS -------- */
$headers  = "From: RS Home Care <rshomecaremaduraiofficial@gmail.com>\r\n";
$headers .= "Reply-To: rshomecaremaduraiofficial@gmail.com\r\n";

/* -------- SEND EMAIL -------- */
mail($to, $subject, $message, $headers);

echo "OK";
