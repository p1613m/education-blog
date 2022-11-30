<?php
include 'includes/header.php';
?>

<?php
$posts = $db->query("SELECT * FROM posts ORDER BY date DESC")->fetchAll();
?>

<?php foreach ($posts as $post):
    $post = preparePost($post);
    ?>
    <article>
        <h2><?= $post['title'] ?></h2>
        <p><b><?= $post['date'] ?></b> <?= $post['author']['name'] ?></p>
        <p><?= $post['description'] ?></p>
        <p><a href="post.php?id=<?= $post['id'] ?>">Read more...</a></p>
    </article>
    <hr>
<?php endforeach; ?>

<?php
include 'includes/footer.php';
?>