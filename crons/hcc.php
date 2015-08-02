<?php
// This file can be used if your server doesn't allow wget in cronjobs. You can run this file with php -f /this/file.php

// use the below if you password protect your folder with a .passwd file
$user = '';
$pass = '';
$context = stream_context_create(array(
    'http' => array(
        'header'  => "Authorization: Basic " . base64_encode("$user:$pass")
    )
));

file_get_contents('your/path/to/crons/HourlyCron.php', false, $context);