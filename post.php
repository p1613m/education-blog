<?php
include 'includes/header.php';
?>

<?php
$post = getPost($_GET['id']);
if(!$post) {
    redirect('index.php');
}
?>

<h1><?= $post['title'] ?></h1>
<img src="<?= $post['image_path'] ?>" alt="" style="width: 400px">
<p>
    <b><?= $post['date'] ?></b>
    <a href="index.php?user_id=<?= $post['author']['id'] ?>"><?= $post['author']['name'] ?></a>
</p>
<p><?= $post['description'] ?></p>
<p><?= $post['content'] ?></p>

<?php if(hasAccess($post)): ?>
    <a href="edit.php?id=<?= $post['id'] ?>">Edit</a> |
    <a href="delete.php?id=<?= $post['id'] ?>">Delete</a>
<?php endif; ?>

<?php
include 'includes/footer.php';
?>
