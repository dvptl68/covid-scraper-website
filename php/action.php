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

//Aggregate signup data into associative array
$data = [
  'country' => $_POST['country'],
  'state' => $_POST['state'] ?: '',
  'county' => $_POST['county'] ?: '',
  'name' => $_POST['name'],
  'email' => $_POST['email']
];

// Read configuration data from file
$myfile = fopen('config.json', 'r');
$config = json_decode(fread($myfile, filesize('config.json')), true);
fclose($myfile);

// Create mail object for data extraction
$mail = new PHPMailer\PHPMailer\PHPMailer(true);

// Set up mail account
$mail->IsSMTP();
$mail->Mailer = 'smtp';
$mail->SMTPDebug = 1;  
$mail->SMTPAuth = TRUE;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->Host = 'smtp.gmail.com';
$mail->Username = $config['username'];
$mail->Password = $config['password'];

// Set email content
$mail->IsHTML(false);
$mail->AddAddress($config['to']['email'], $config['to']['name']);
$mail->SetFrom($config['from']['email'], $config['from']['name']);
$mail->Subject = 'new user registration';
$content = json_encode($data);
$mail->MsgHTML($content); 

// Send email and redirect to failure page if it is not sent successfully
if(!$mail->Send()) failure();

// Redirect to success page
header('Location: ../success.html');