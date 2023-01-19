<?php
$forAuth = true;
include 'includes/header.php';

// Заполняем данные пользователя
$name = $user['name'];
$email = $user['email'];

// Создаем массив для ошибок
$errors = [];
// проверяем отправку формы
if(isset($_POST['submit'])) {
    // Берем данные из формы
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $newPassword = $_POST['new_password'];
    $newPasswordConfirm = $_POST['new_password_confirm'];
    $avatar = $_FILES['avatar'];

    if($avatar['size']) {
        if($avatar['size'] > 1 * 1024 * 1024) {
            $errors['avatar'] = 'Incorrect file size';
        }

        if($avatar['type'] !== 'image/png' && $avatar['type'] !== 'image/jpeg') {
            $errors['avatar'] = 'Incorrect file type';
        }
    }

    // Проверка длины строки name
    $nameLen = mb_strlen($name);
    if($nameLen < 1 || $nameLen > 30) {
        $errors['name'] = 'Incorrect name length (1 - 30)';
    }

    // валидация на корректность email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Incorrect email';
    }
    // Подготовка запроса на уникальность email
    $emailQuery = $db->prepare("SELECT * FROM users WHERE email = :email AND id <> :user_id");
    // выполнение запроса
    $emailQuery->execute([
        'email' => $email,
        'user_id' => $user['id'],
    ]);
    // Получение первой строки из БД (массив или false)
    if($emailQuery->fetch()) {
        $errors['email'] = 'Email is exist';
    }

    // если указан новый пароль (т.е. если не пустая строка)
    if($newPassword) {
        // длина строки нового пароля
        $newPasswordLen = mb_strlen($newPassword);
        if($newPasswordLen < 3) {
            $errors['new_password'] = 'Incorrect new password length';
        }

        // сравниваем строки нового пароля и его повторения
        if($newPassword !== $newPasswordConfirm) {
            $errors['new_password_confirm'] = 'Incorrect confirmation';
        }

        // сравниваем хэш старого пароля из формы с хэшем пароля из БД
        if(md5($password) !== $user['password']) {
            $errors['password'] = 'Incorrect password';
        }
    }

    // если нет ошибок
    if(count($errors) === 0) {
        $avatarPath = $user['avatar_path'];
        if($avatar['size']) {
            @unlink($avatarPath);
            $avatarPath = uploadImage($avatar);
            $user['avatar_path'] = $avatarPath;
        }

        if(isset($_POST['avatar_delete'])) {
            @unlink($avatarPath);
            $avatarPath = null;
            $user['avatar_path'] = null;
        }

        // если указан новый пароль, то заполняем его хэш, иначе берем старый хэш из БД
        $password = $newPassword ? md5($newPassword) : $user['password'];
        // подготовка запроса
        $query = $db->prepare("UPDATE users SET name = :name, email = :email, password = :password, avatar_path = :avatar_path WHERE id = :user_id");
        // выполнение запроса
        $query->execute([
            'user_id' => $user['id'],
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'avatar_path' => $avatarPath,
        ]);

        // флаг успешного сохранения для вывода сообщения
        $successUpdate = true;
    }
}
?>

<h1>Profile</h1>
<?= isset($successUpdate) ? 'Success update' : '' ?>
<form action="profile.php" method="post" novalidate enctype="multipart/form-data">
    <label>
        Name:<br>
        <input type="text" name="name" value="<?= $name ?>">
        <?= $errors['name'] ?? '' ?>
    </label><br>
    <label>
        Avatar:<br>
        <?php if($user['avatar_path']): ?>
            <img src="<?= $user['avatar_path'] ?>" alt="" style="width: 200px;display: block"><br>
        <?php endif; ?>
        <input type="file" name="avatar">
        <?= $errors['avatar'] ?? '' ?>
    </label><br>
    <?php if($user['avatar_path']): ?>
        <label>
            <input type="checkbox" name="avatar_delete"> Delete avatar
        </label>
        <br>
    <?php endif; ?>
    <label>
        Email:<br>
        <input type="text" name="email" value="<?= $email ?>">
        <?= $errors['email'] ?? '' ?>
    </label><br>
    <label>
        Password:<br>
        <input type="password" name="password">
        <?= $errors['password'] ?? '' ?>
    </label><br>
    <label>
        New password:<br>
        <input type="password" name="new_password">
        <?= $errors['new_password'] ?? '' ?>
    </label><br>
    <label>
        New password confirm:<br>
        <input type="password" name="new_password_confirm">
        <?= $errors['new_password_confirm'] ?? '' ?>
    </label><br>
    <input type="submit" name="submit" value="Save">
</form>