<!-- get done canceled -->

<?php if (isset($_POST['view_order'])) echo FormViewOrder($_POST['view_order']); ?>

<div class="orders">
    <div class="width">
        <h2>Заказы</h2>

        <div class="orders_wrapper">
            <div class="orders_new">
                <div class="orders_new_wrapper">
                    <h3>Не выполненые</h3>

                    <?php foreach ($_POST['orders']['new_orders'] as $path) { ?>
                    <table>
                        <tr>
                            <td><?= $path['name'] ?></td>
                        </tr>

                        <tr><td><?= $path['phone'] ?></td></tr>

                        <tr><td><?= $path['email'] ?></td></tr>

                        <?php foreach ($path['products'] as $product) { ?>
                            <tr class="orders_product_name"><td><?= $product['name'] ?></td></tr>
                            <tr class="orders_product_count"><td>Количество: <?= $product['count'] ?></td></tr>
                        <?php } ?>

                        <tr><td>Итого: <?= $path['total'] ?></td></tr>

                        <tr><td><?= $path['created_at'] ?></td></tr>

                        <tr>
                            <td>
                                <form method=POST>
                                    <button name="view_order" value="<?= $path['id'] ?>">Оформить</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                    <?php } ?>

                </div>
            </div>

            <div class="orders_done">
                <div class="orders_done_wrapper">
                    <h3>Выполненые</h3>

                    <?php foreach ($_POST['orders']['done_orders'] as $path) { ?>
                    <table>
                        <tr>
                            <td><?= $path['name'] ?></td>
                        </tr>

                        <tr><td><?= $path['phone'] ?></td></tr>

                        <tr><td><?= $path['email'] ?></td></tr>

                        <?php foreach ($path['products'] as $product) { ?>
                            <tr class="orders_product_name"><td><?= $product['name'] ?></td></tr>
                            <tr class="orders_product_count"><td>Количество: <?= $product['count'] ?></td></tr>
                        <?php } ?>

                        <tr><td>Итого: <?= $path['total'] ?></td></tr>

                        <tr><td><?= $path['updated_at'] ?></td></tr>

                        <tr><td><b><?= $path['status'] ?></b></td></tr>
                    </table>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>