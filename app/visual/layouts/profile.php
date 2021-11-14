<?php $data = $_POST['data'];

// Вызывает форму для обновления фото профиля
if(isset($_POST['load_foto'])) echo FormLoadFoto($_POST['userData']['login']);

// Вызывает форму для удаления товара
if (isset($_POST['delete_product'])) echo FormDeleteProduct($data[0]['login'], $_POST['delete_product']);

// Вызывает форму для удаления коментария
if (isset($_POST['delete_comment'])) echo FormDeleteComment($data[0]['login'], $_POST['delete_comment']);

?>

<div class="profile">
    <div class="width">
        <h2>Административная панель</h2>

        <div class="profile_nav">
            <a href="/profile/<?= $data[0]['login'] ?>">Профиль</a>

            <?php if ($data[0]['position'] == 'administrator' || $data[0]['position'] == 'moderator') { ?>
                <a href="/control/<?= $data[0]['login'] ?>">Управление</a>
            <?php } ?>

        </div>

        <div class="profile_wrapper">
            <div class="information" >
                <div class="profile">
                    <div class="profile_foto">
                        <img src="/public/images/foto_profiles/<?= $data[0]['foto'] ?>" alt="foto">

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
                                            <button name="delete_product" value="<?= $product['code'] ?>">Удалить</button>
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