<?php

// Terminate script if request method is not post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit();

// Read configuration data from file
$myfile = fopen("config.json", "r");
$config = json_decode(fread($myfile,filesize("config.json")), true);
fclose($myfile);



// Redirect to success page
header('Location: ../success.html');