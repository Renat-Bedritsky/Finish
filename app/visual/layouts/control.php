<?php

$user = $_POST['userData'];
$logins = $_POST['logins'];

if(isset($_POST['update_position'])) echo FormUpdatePosition($_POST);

?>

<div class="control">
    <div class="width">
        <h2>Административная панель</h2>

        <div class="control_nav">
                <a href="/profile/<?= $_POST['focus'] ?>">Профиль</a>
                <a href="/control/<?= $_POST['focus'] ?>">Управление</a>
        </div>

        <div class="control_wrapper">
            <div class="information" >
                <div class="users">
                    <table>
                        <tr>
                            <td>Логин</td>
                            <td>Статус</td>
                            <td>Править</td>
                        </tr>

                        <?php foreach ($logins as $value) { ?>

                            <tr>
                                <td><a href="/profile/<?= $value['login'] ?>"><?= $value['login'] ?></a></td>
                                <td><?= $value['position'] ?></td>
                                <td>
                                    <form method="POST">
                                        <button name="update_position" value="<?= $value['login'] ?>">Изменить</button>
                                    </form>
                                </td>
                            </tr>

                        <?php } ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>