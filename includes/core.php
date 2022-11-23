<?php
// connect to db
$db = new PDO('mysql:host=localhost;dbname=blog-first', 'root', 'root');

/**
 * User
 */
$user = false;


/**
 * Functions
 */
function dump($parameter) {
    echo '<pre>';
    var_dump($parameter);
    echo '</pre>';
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}