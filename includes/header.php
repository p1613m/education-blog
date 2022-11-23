<?php
include 'core.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
</head>
<body>

<nav>
    <b><a href="index.php">Home</a></b> |

    <?php if ($user): ?>
        <a href="create.php">Create post</a> |
        <a href="#">My posts</a> |
        <a href="#">Logout</a>
    <?php else: ?>
        <a href="registration.php">Registration</a> |
        <a href="login.php">Login</a>
    <?php endif; ?>
</nav>