<?php
require_once('../vendor/autoload.php');

$dotEnv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotEnv->load();
$dotEnv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'])->notEmpty();
