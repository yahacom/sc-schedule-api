<?php
require_once('../vendor/autoload.php');

$dotEnv = Dotenv\Dotenv::createImmutable('../');

$dotEnv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'])->notEmpty();

$dotEnv->load();
