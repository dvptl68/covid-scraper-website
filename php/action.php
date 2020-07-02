<?php

$myfile = fopen("config.json", "r");
$config = json_decode(fread($myfile,filesize("config.json")), true);

// header('Location: ../success.html');