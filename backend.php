<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") exit;

$to = "rshomecaremaduraiofficial@gmail.com";
$subject = "New Signed Agreement – RS Home Care";

$name = $_POST['name'];
$phone = $_POST['phone'];
$messageText = $_POST['message'];
$signatureData = $_POST['signature'];

$uploadDir = "uploads/";
if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

/* SAVE SIGNATURE IMAGE */
$signatureFile = $uploadDir . "signature_" . time() . ".png";
$signatureData = str_replace('data:image/png;base64,', '', $signatureData);
file_put_contents($signatureFile, base64_decode($signatureData));

/* SAVE UPLOADED FILE */
$fileTmp = $_FILES['agreement_file']['tmp_name'];
$fileName = $uploadDir . time() . "_" . basename($_FILES['agreement_file']['name']);
move_uploaded_file($fileTmp, $fileName);

/* EMAIL SETUP */
$boundary = md5(time());
$headers = "From: RS Home Care <no-reply@yourdomain.com>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";

$body = "--$boundary\r\n";
$body .= "Content-Type: text/plain\r\n\r\n";
$body .= "Name: $name\nPhone: $phone\nMessage: $messageText\n\n";

/* ATTACH FILE */
foreach ([$fileName, $signatureFile] as $file) {
  $content = chunk_split(base64_encode(file_get_contents($file)));
  $body .= "--$boundary\r\n";
  $body .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\r\n";
  $body .= "Content-Disposition: attachment; filename=\"".basename($file)."\"\r\n";
  $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
  $body .= $content . "\r\n";
}

$body .= "--$boundary--";

mail($to, $subject, $body, $headers);

echo "<script>alert('Agreement submitted successfully!');location.href='index.html';</script>";
?>