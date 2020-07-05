<?php

require('../vendor/phpmailer/phpmailer/src/PHPMailer.php');
require('../vendor/phpmailer/phpmailer/src/SMTP.php');

// Function that redirects to failure page and terminates script
function failure() {
  header('Location: ../fail.html');
  exit();
}

// Check that the request method is post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') failure();

// Check that a country is selected
if (empty($_POST['country'])) failure();

// Check that a name is entered
if (empty($_POST['name'])) failure();

// Check that entered email is valid
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) failure();

// Read configuration data from file
$myfile = fopen('config.json', 'r');
$config = json_decode(fread($myfile,filesize('config.json')), true);
fclose($myfile);

// Test email sending
$mail = new PHPMailer\PHPMailer\PHPMailer(true);

$mail->IsSMTP();
$mail->Mailer = 'smtp';
$mail->SMTPDebug = 1;  
$mail->SMTPAuth = TRUE;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->Host = 'smtp.gmail.com';
$mail->Username = $config['username'];
$mail->Password = $config['password'];

$mail->IsHTML(true);
$mail->AddAddress($config['to']['email'], $config['to']['name']);
$mail->SetFrom($config['from']['email'], $config['from']['name']);
$mail->Subject = 'Test is Test Email sent via Gmail SMTP Server using PHP Mailer';
$content = '<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>';

$mail->MsgHTML($content); 
if(!$mail->Send()) {
  echo 'Error while sending Email.';
  var_dump($mail);
} else {
  echo 'Email sent successfully';
}

// Redirect to success page
header('Location: ../success.html');