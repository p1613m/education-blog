<?php
$forAuth = true;
include 'includes/header.php';

$post = getPost($_GET['id']);
if(!hasAccess($post)) {
    redirect('index.php');
}

$title = $post['title'];
$description = $post['description'];
$content = $post['content'];

$errors = [];
if(isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $content = trim($_POST['content']);

    $titleLength = mb_strlen($title);
    if(!$title || $titleLength > 255) {
        $errors['title'] = 'Incorrect title';
    }

    $descriptionLength = mb_strlen($description);
    if(!$description || $descriptionLength > 500) {
        $errors['description'] = 'Incorrect description';
    }

    if(!$content) {
        $errors['content'] = 'Field is required';
    }

    if(count($errors) === 0) {
        $query = $db->prepare("UPDATE posts SET title = :title, description = :description, content = :content WHERE id = :id");
        $query->execute([
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'id' => $post['id'],
        ]);
        redirect('post.php?id=' . $post['id']);
    }
}

?>

<h1>Edit post</h1>
<form action="edit.php?id=<?= $post['id'] ?>" novalidate method="post">
    <div>
        <label>
            Post title:<br>
            <input type="text" placeholder="Post title" name="title" value="<?= $title ?? '' ?>">
            <?= $errors['title'] ?? '' ?>
        </label>
    </div>
    <div>
        <label>
            Post description:<br>
            <textarea placeholder="Post description" name="description"><?= $description ?? '' ?></textarea>
            <?= $errors['description'] ?? '' ?>
        </label>
    </div>
    <div>
        <label>
            Post content:<br>
            <textarea placeholder="Post content" name="content"><?= $content ?? '' ?></textarea>
            <?= $errors['content'] ?? '' ?>
        </label>
    </div>

    <div>
        <input type="submit" value="Edit" name="submit">
    </div>
</form>

