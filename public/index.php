<?php
require_once('../vendor/autoload.php');
require_once('../config/index.php');
use Slim\App;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new App(["settings" => $config]);

$app->run();
