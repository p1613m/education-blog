<?php
include 'includes/header.php';
?>

<?php
$posts = [
    [
        'id' => 1,
        'title' => 'Post title',
        'date' => '17.11.2022',
        'author' => [
            'id' => 10,
            'name' => 'Victor',
        ],
        'description' => 'Post description'
    ],
    [
        'id' => 2,
        'title' => 'Post title 2',
        'date' => '16.11.2022',
        'author' => [
            'id' => 10,
            'name' => 'Victor',
        ],
        'description' => 'Post description 2'
    ]
];
?>

<?php foreach ($posts as $post): ?>
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