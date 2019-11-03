<?php

require_once(__DIR__ . "/../../settings/orchestrator.php");
require_once(__DIR__ . "/../settings/pags.php");

if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}

$account->logout();

header("location: " . WELCOME_PAGS);
die();