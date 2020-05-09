<?php

function config_db () {
    return function () {
        $dsn = "mysql:host=" . getenv('DB_HOST') . ";" .
                                "dbname=" . getenv('DB_NAME') . ";" .
                                "charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'), $options);
        return $pdo;
    };
};
