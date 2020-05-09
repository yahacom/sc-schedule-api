<?php
error_reporting(E_ALL);
set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
});

require_once('../vendor/autoload.php');
require_once('../config/index.php');
require_once('../config/db.php');
require_once('../src/utils/index.php');
use Slim\App;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new App(["settings" => $config]);

$container = $app->getContainer();
$container['db'] = config_db();

$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $response->withHeader('Allow', implode(', ', $methods))
            ->withJson(getErrorMessage('Method not allowed'), 405);
    };
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $response
            ->withJson(getErrorMessage('Not found'), 404);
    };
};

$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $response
            ->withJson(getErrorMessage($exception->getMessage()), 500);
    };
};

$container['phpErrorHandler'] = function ($c) {
    return $c['errorHandler'];
};

require_once('../src/routes/sections.php');
require_once('../src/routes/schedule.php');

$app->run();
