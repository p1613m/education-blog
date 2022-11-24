<?php
session_start();

// connect to db
$db = new PDO('mysql:host=localhost;dbname=blog-first', 'root', 'root');

/**
 * User
 */
$user = false;
if(isset($_SESSION['user_id'])) {
    $userQuery = $db->query("SELECT * FROM users WHERE id = " . intval($_SESSION['user_id']));
    $user = $userQuery->fetch();
}

if(isset($forAuth) && !$user) {
    redirect('login.php');
}


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