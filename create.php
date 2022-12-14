<?php
$forAuth = true;
include 'includes/header.php';

$errors = [];
if(isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $content = trim($_POST['content']);
    $image = $_FILES['image'];

    // объявляем массив с разрешенными типами файлов
    $types = [
        'image/jpeg',
        'image/png',
        'image/gif',
    ];
    // проверяем входит ли тип файла в разрешенные типы
    if(!in_array($image['type'], $types)) {
        $errors['image'] = 'Incorrect file type';
    }
    // проверяем размер файла в байтах
    if($image['size'] > 1 * 1024 * 1024) {
        $errors['image'] = 'Incorrect image size';
    }

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
        // разбиваем строку название файла на массив используя разделитель '.'
        $extensionArray = explode('.', $image['name']);
        // получаем последний элемент массива, т.е. extension
        $extension = $extensionArray[count($extensionArray) - 1];
        // генерируем уникальное имя файла и подставляем расширение файла
        $fileName = uniqid() . '.' . $extension;
        // указываем путь к файлу от корня
        $imagePath = 'images/' . $fileName;

        // перемещаем файл из временной директории в нашу
        move_uploaded_file($image['tmp_name'], $imagePath);

        $query = $db->prepare("INSERT INTO posts (title, description, content, user_id, image_path) VALUES (:title, :description, :content, :user_id, :image_path)");
        $query->execute([
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'user_id' => $user['id'],
            'image_path' => $imagePath,
        ]);

        redirect('index.php');
    }
}
?>

    <h1>Create post</h1>
    <form action="create.php" novalidate method="post" enctype="multipart/form-data">
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
            <label>
                Post image:<br>
                <input type="file" name="image">
                <?= $errors['image'] ?? '' ?>
            </label>
        </div>

        <div>
            <input type="submit" value="Create" name="submit">
        </div>
    </form>

<?php
include 'includes/footer.php';
