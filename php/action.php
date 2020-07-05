<?php

// Function that redirects to failure page and terminates script
function failure() {
  header('Location: ../fail.html');
  exit();
}

// Check that the request method is post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') failure();

// Check that a country is selected
if (empty($_POST['country'])) failure();

//Check that a name is entered
if (empty($_POST['name'])) failure();

// Check that entered email is valid
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) failure();

// Read configuration data from file
$myfile = fopen("config.json", "r");
$config = json_decode(fread($myfile,filesize("config.json")), true);
fclose($myfile);

//Test email sending
$mail = new PHPMailer\PHPMailer\PHPMailer(true);

// Redirect to success page
header('Location: ../success.html');