<?php

$data = $_POST['data'];
$user = $_POST['userData'];

// Вызывает форму для удаления коментария
if (isset($_POST['delete_comment'])) echo FormDeleteComment('/detail/'.$data[0]['code'], $_POST['delete_comment']);

// Вызывает форму для изменения коментария
if (isset($_POST['update_comment'])) echo FormUpdateComment('/detail/'.$data[0]['code'], $_POST);

?>

<div class="detail">
    <div class="width">
        <div class="detail_wrapper">
            <h2><?= $data[0]['name'] ?></h2>
            <p>Цена: <?= $data[0]['price'] ?> ₽</p>
            <img src="/public/images/foto_products/<?= $data[0]['image'] ?>" alt="<?= $data[0]['code'] ?>">
            <p><?= $data[0]['description'] ?></p>
            <form method="POST">
                
                <?php if (isset($user['login']) && $user['access'] == 'allowed') { ?>
                    <button name="plus" value="<?= $data[0]['code'] ?>">Добавить в корзину</button>
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

                                if (!empty($user) && $user['author_id'] == $comment['author_id'] && $user['position'] != 'banned') { ?>

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
            if (!empty($user) && $user['access'] == 'allowed' && $user['position'] != 'banned') { ?>

                <form method="POST" class="detail_comment_add">
                    <textarea rows="5" cols="60" minlength="3" name="content" value=""></textarea><br>
                    <button name="enter_comment">Отправить</button>
                </form>

            <?php } ?>

        </div>
    </div>
</div>