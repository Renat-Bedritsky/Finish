<?php

$data = $_POST['data'];
$user = $_POST['userData'];
echo '<pre>';
print_r($user);
echo '</pre>';

// Добавление в корзину
if (isset($_POST["plus"])) {
    $users->plusBasket($_POST["plus"]);
}

// Добавление коментария
if(isset($_POST['enter_comment'])) {
    $data = [
        'author_id' => $access['author_id'],
        'product_id' => $product['id'],
        'content' => $_POST['content']
    ];
    $comments->addComments($data);
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


// Вызывает форму для изменения коментария
if (isset($_POST['update_comment'])) {
    echo '<style>body {overflow: hidden;} .update_field {display: block;}</style>';
}
// Изменение коментария
if (isset($_POST['enter_update'])) {
    $result = $comments->updateComments($_POST['content'], $_POST['author_id'],$_POST['date']);
    header('Refresh: 0');
}

?>

<!-- Форма для изменения комментария (изначально скрыта) -->
<div class="update_field">
    <div class="update_field_wrapper">
        <form method="POST">
            <textarea rows="10" cols="60" minlength="3" name="content"><?= $_POST['content'] ?></textarea><br>
            <input type="hidden" name="author_id" value="<?= $_POST['author_id'] ?>">
            <input type="hidden" name="date" value="<?= $_POST['date'] ?>">
            <input type="submit" name="enter_update" value="Изменить">
            <a href="detail.php?category=<?= $_GET['category'] ?>&product=<?= $_GET['product'] ?>">Отмена</a>
        </form>
    </div>
</div>

<!-- Форма для удаления комментария (изначально скрыта) -->
<div class="delete_field">
    <div class="delete_field_wrapper">
        <form method="POST">
            <p>Удалить комментарий?</p>
            <button name="delete_comment_yes" value="<?= $_POST['delete_comment'] ?>">Удалить</button>
            <a href="detail.php?category=<?= $_GET['category'] ?>&product=<?= $_GET['product'] ?>">Отмена</a>
        </form>
    </div>
</div>

<div class="detail">
    <div class="width">
        <div class="detail_wrapper">
            <h2><?= $data[0]['name'] ?></h2>
            <p>Цена: <?= $data[0]['price'] ?> ₽</p>
            <img src="/public/images/foto_products/<?= $data[0]['image'] ?>" alt="<?= $data[0]['code'] ?>">
            <p><?= $data[0]['description'] ?></p>
            <form method="POST">
                
                <?php if (isset($user['login']) && $user['access'] == 'allowed') { ?>
                    <button name="plus" value="<?= $product['code'] ?>">Добавить в корзину</button>
                <?php } else { ?>
                    <span class="add_basket_detail"><a href="/autorization">Добавить в корзину</a></span>
                <?php }?>
                
            </form>
            <p>Автор: <a href="/profile/<?= $data[0]['author'] ?>"><?= $data[0]['author'] ?></a></p>
        </div>
        
        <div class="detail_comments">
            Комментарии:

            <?php
            foreach ($data['comments'] as $comment) { ?>

                <div class="comment">
                    <table>
                        <tr><td rowspan="5"><img src="/public/images/foto_profiles/<?= $comment['user']['foto'] ?>"></td></tr>

                        <tr>
                            <td><b><a href="/profile/<?= $comment['user']['login'] ?>"><?= $comment['user']['login'] ?></a></b></td>
                            <td><b style="color: rgb(12, 81, 94);"><?= $comment['user']['position'] ?></b></td>
                        </tr>

                        <tr><td colspan="2"><?= $comment['content'] ?></td></tr>
                        
                        <tr>
                            <td><?= $comment['date'] ?></td>

                            <td>

                                <?php if ($comment['user']['resolution'] == 'YES'){ ?>
                                    <form method="POST">
                                        <button class="delete_comment" name="delete_comment" value="<?= $comment['date'] ?>">Удалить</button>
                                    </form>
                                <?php } 

                                if (isset($user) && $user['author_id'] == $comment['author_id']) { ?>

                                    <form method="POST">
                                        <input type="hidden" name="content" value="<?= $comment['content'] ?>">
                                        <input type="hidden" name="author_id" value="<?= $comment['author_id'] ?>">
                                        <input type="hidden" name="date" value="<?= $comment['date'] ?>">
                                        <button class="update_comment" name="update_comment">Изменить</button>
                                    </form>

                                <?php } ?>

                            </td>
                        </tr>
                    </table>

                </div>

            <?php }
            if (isset($user) && $user['access'] == 'allowed' && $user['position'] != 'banned') { ?>

                <form method="POST" class="detail_comment_add">
                    <textarea rows="5" cols="60" minlength="3" name="content" value=""></textarea><br>
                    <button name="enter_comment">Отправить</button>
                </form>

            <?php } ?>

        </div>
    </div>
</div>