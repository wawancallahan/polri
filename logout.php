<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';

session_destroy();

header('location: index.php');
die();