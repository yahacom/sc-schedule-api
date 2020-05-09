<?php
require_once('../vendor/autoload.php');
require_once('../config/index.php');
require_once('../config/db.php');
use Slim\App;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new App(["settings" => $config]);

$container = $app->getContainer();
$container['db'] = config_db();

$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $response->withHeader('Allow', implode(', ', $methods))
            ->withJson(['error' => ['text' => 'Method not allowed']], 405);
    };
};

require_once('../src/routes/sections.php');

$app->run();
