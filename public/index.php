<?php

require("../vendor/autoload.php");

ini_set('xdebug.max_nesting_level', 500);

$settings = require_once ('../data/setting.php');

$app = new \App\App($settings);
$app->run();

