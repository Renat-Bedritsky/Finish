<?php $data = $_POST['data'];
echo '<pre>';
print_r($data);
echo '</pre>';

// Вызывает форму для обновления фото профиля
if(isset($_POST['load_foto'])) {
    echo '<style>body {overflow: hidden;} .update_foto {display: block;}</style>';
}
// Обновление фото профиля
if (isset($_POST['update_foto'])) {
    updateFoto($table['foto']);
}

// Вызывает форму для удаления товара
if (isset($_POST['delete_product'])) {
    echo '<style>body {overflow: hidden;} .delete_product {display: block;}</style>';
}
// Удаление товара
if (isset($_POST['delete_product_yes'])) {
    $products->deleteProduct($_POST['delete_product_yes']);
    header('Refresh: 0');
}

// Вызывает форму для удаления коментария
if (isset($_POST['delete_comment'])) {
    echo '<style>body {overflow: hidden;} .delete_field {display: block;}</style>';
}
// Удаление коментария
if (isset($_POST['delete_comment_yes'])) {
    $comments->deleteComments($_POST['delete_comment_yes']);
    header('Refresh: 0');
}

?>

<!-- Форма для удаления коментария (изначально скрыта) -->
<div class="delete_field">
    <div class="delete_field_wrapper">
        <form method="POST">
            <p>Удалить комментарий?</p>
            <button name="delete_comment_yes" value="<?= $_POST['delete_comment'] ?>">Удалить</button>
            <a href="profile.php?user=<?= $_GET['user'] ?>">Отмена</a>
        </form>
    </div>
</div>

<!-- Форма для удаления товара (изначально скрыта) -->
<div class="delete_product">
    <div class="delete_product_wrapper">
        <form method="POST">
            <p>Удалить товар?</p>
            <button name="delete_product_yes" value="<?= $_POST['delete_product'] ?>">Удалить</button>
            <a href="profile.php?user=<?= $_GET['user'] ?>">Отмена</a>
        </form>
    </div>
</div>

<!-- Форма для обновления фото (изначально скрыта) -->
<div class="update_foto">
    <div class="update_foto_wrapper">
        <form method="POST" name="add_product" enctype="multipart/form-data">
            <input type="file" name="file" required><br>
            <button name="update_foto">Загрузить</button>
            <a href="profile.php?user=<?= $_GET['user'] ?>">Отмена</a>
        </form>
    </div>
</div>

<div class="profile">
    <div class="width">
        <h2>Административная панель</h2>

        <div class="profile_nav">
            <a href="profile.php?user=<?= $data[0]['login'] ?>">Профиль</a>

            <?php
            if ($data[0]['position'] == 'administrator' || $data[0]['position'] == 'moderator') { ?>

                <a href="/control">Управление</a>

            <?php } ?>

        </div>

        <div class="profile_wrapper">
            <div class="information" >
                <div class="profile">
                    <div class="profile_foto">
                        <img src="<?= $data[0]['foto'] ?>" alt="foto">

                        <?php // Обновить фото
                        if ($data[0]['login'] == $_POST['userData']['login']) { ?>
                        
                            <form method="POST">
                                <input type="submit" name="load_foto" value="Загрузить фото">
                            </form>

                        <?php } ?>

                    </div>

                    <div class="profile_info">
                        <table>
                            <tr>
                                <td>Логин</td>
                                <td><?= $data[0]['login'] ?></td>
                            </tr>
                            <tr>
                                <td>Доступ</td>
                                <td><?= $data[0]['position'] ?></td>
                            </tr>
                            <tr>
                                <td>Количество товаров</td>
                                <td><?= count($data['products']) ?></td>
                            </tr>
                            <tr>
                                <td>Количество коментариев</td>
                                <td><?= count($data['comments']) ?></td>
                            </tr>
                            <tr>
                                <td>Дата регистрации</td>
                                <td><?= $data[0]['date'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="search_user">
                    <form method="POST">
                        Найти пользователя<br>
                        <input type="text" name="search_user" minlength="1" required>
                        <button>Поиск</button>
                    </form>

                    <?php
                    if (isset($data['search']) && $data['search'] != '') {
                        foreach ($data['search'] as $value) { ?>
                            <p><a href="/profile/<?= $value ?>"><?= $value ?></a></p>
                        <?php } 
                    }?>

                </div>

                <div class="profile_products">
                    <h3>Товары пользователя</h3>
                    <table>

                        <?php
                        foreach ($data['products'] as $product) { ?>
                            <tr>
                                <td><a href="/detail/<?= $product['code'] ?>"><?= $product['name'] ?></a></td>

                                <td>
                                    <?php if ($data['resolution'] == 'YES') { ?>
                                        <form method="POST">
                                            <button name="delete_product" value="<?= $product['id'] ?>">Удалить</button>
                                        </form>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>

                    </table>
                </div>

                <div class="profile_comments">
                    <h3>Коментарии пользователя</h3>
                    <table>

                        <?php
                        foreach ($data['comments'] as $comment) { ?>
                            <tr>
                                <td>
                                    <a href="/detail/<?= $comment['product_code'] ?>"><?= $comment['content'] ?></a>
                                </td>

                                <td>
                                    <?php if ($data['resolution'] == 'YES') { ?>
                                        <form method="POST">
                                            <button name="delete_comment" value="<?= $comment['date'] ?>">Удалить</button>
                                        </form>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>