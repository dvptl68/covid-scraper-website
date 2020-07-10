<?php

// require('../vendor/phpmailer/phpmailer/src/PHPMailer.php');
// require('../vendor/phpmailer/phpmailer/src/SMTP.php');

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


// Redirect to success page
header('Location: ../successUnsub.html');