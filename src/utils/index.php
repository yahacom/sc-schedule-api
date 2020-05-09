<?php

function p($arr) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

function getErrorMessage($message = '') {
    return ['error' => ['text' => $message]];
}
