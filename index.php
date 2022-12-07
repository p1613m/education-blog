<?php
include 'includes/header.php';
?>

<?php
$userId = $_GET['user_id'] ?? null;
$sqlString = "SELECT * FROM posts ORDER BY date DESC";

if($userId) {
    $sqlString = "SELECT * FROM posts WHERE user_id = " . intval($userId) . " ORDER BY date DESC";
}

// todo: paginate

$posts = $db->query($sqlString)->fetchAll();
?>

<?php foreach ($posts as $post):
    $post = preparePost($post);
    ?>
    <article>
        <h2><?= $post['title'] ?></h2>
        <p>
            <b><?= $post['date'] ?></b>
            <a href="index.php?user_id=<?= $post['author']['id'] ?>"><?= $post['author']['name'] ?></a>
        </p>
        <p><?= $post['description'] ?></p>
        <p><a href="post.php?id=<?= $post['id'] ?>">Read more...</a></p>
    </article>
    <hr>
<?php endforeach; ?>

<!-- todo: paginate links -->

<?php
include 'includes/footer.php';
?>