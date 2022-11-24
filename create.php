<?php
$forAuth = true;
include 'includes/header.php';

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
        $query = $db->prepare("INSERT INTO posts (title, description, content, user_id) VALUES (:title, :description, :content, :user_id)");
        $query->execute([
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'user_id' => $user['id'],
        ]);

        redirect('index.php');
    }
}
?>

    <h1>Create post</h1>
    <form action="create.php" novalidate method="post">
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
            <input type="submit" value="Create" name="submit">
        </div>
    </form>

<?php
include 'includes/footer.php';
