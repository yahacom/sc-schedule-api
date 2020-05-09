<?php
require_once('../vendor/autoload.php');

use Slim\App;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new App(["settings" => $config]);

$app->run();
