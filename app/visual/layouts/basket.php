<?php $basket = $_POST['basket']; ?>

<div class="basket">
    <div class="width">
        <h2>Корзина</h2>
        <p>Оформление заказа</p>

        <table class="basket_table">
            <tr>
                <td>Фото</td>
                <td>Название</td>
                <td>Количество</td>
                <td>Цена</td>
                <td>Стоимость</td>
            </tr>

            <?php
            foreach ($basket['products'] as $product) { ?>

                <tr>
                    <td><img src="/public/images/foto_products/<?= $product['image'] ?>"></td>
                    <td><a href="detail/<?= $product['code'] ?>"><?= $product['name'] ?></a></td>
                    <td>
                        <p><?= $product['count'] ?></p>
                        <form method="POST">
                            <button name="minus" value="<?= $product['code'] ?>">-</button>
                            <button name="plus" value="<?= $product['code'] ?>">+</button>
                        </form>
                    </td>
                    <td><?= $product['price'] ?> ₽</td>
                    <td><?= $product['count'] * $product['price'] ?> ₽</td>
                </tr>

            <?php } ?>

            <tr style="height:50px;">
                <td colspan="2">Итоговая стоимость:</td>
                <td colspan="2"></td>
                <td><?= $basket['total'] ?> ₽</td>
            </tr>
        </table>

        <div class="basket_order">
            <?php
            if ($basket['total'] > 0) { ?>
                <a href="/order">Оформить заказ</a>
            <?php } ?>
        </div>

        <div class="basket_clear">
            <?php
            if ($basket['total'] > 0) { ?>
                <a href="/basket/clear">Очистить</a>
            <?php } ?>
        </div>
    </div>
</div>