<?php

require('../vendor/phpmailer/phpmailer/src/PHPMailer.php');
require('../vendor/phpmailer/phpmailer/src/SMTP.php');

// Function that redirects to failure page and terminates script
function failure() {
  header('Location: ../failUnsub.html');
  exit();
}

// Check that the request method is post
if ($_SERVER['REQUEST_METHOD'] !== 'GET') failure();

// Check that an email address is given
if (empty($_GET['email'])) failure();

// Check that a name is given
if (empty($_GET['name'])) failure();

// Check that a country is given
if (empty($_GET['country'])) failure();

// Check that a state is given
if (empty($_GET['state'])) failure();

// Check that a county is given
if (empty($_GET['county'])) failure();

//Aggregate unsubscribe data into associative array
$data = [
  'country' => $_GET['country'],
  'state' => $_GET['state'] ?: '',
  'county' => $_GET['county'] ?: '',
  'name' => $_GET['name'],
  'email' => $_GET['email']
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
$mail->Username = $config['address'];
$mail->Password = $config['password'];

// Set email content
$mail->IsHTML(false);
$mail->AddAddress($config['address'], $config['toName']);
$mail->SetFrom($config['address'], $config['fromName']);
$mail->Subject = 'remove user';
$content = json_encode($data);
$mail->MsgHTML($content);

// Send email and redirect to failure page if it is not sent successfully
if(!$mail->Send()) failure();

// Redirect to success page
header('Location: ../successUnsub.html');