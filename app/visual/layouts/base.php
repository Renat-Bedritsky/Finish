<?php $info = $_POST['info']; ?>

<div class="products">
    <div class="wrapper">
        <h2>Товары</h2>

        <div class="products_filter width">
            <form>
                Цена от <input type="number" name="min" value="<?php if (isset($_GET['min'])) echo $_GET['min'] ?>"> до <input type="number" name="max" value="<?php if (isset($_GET['max'])) echo $_GET['max'] ?>">
                <input type="checkbox" name="new" value="yes"> Новинка
                <button type="submit" name="" value="">Фильтр</button>
                <a href="index.php">Сброс</a>
            </form>
        </div>
        
        <div class="products_wrapper width">

            <?php
            $counter = 0;                                    // Счётчик постов (для пагинации)

            foreach ($info['products'] as $product) { ?>

                <div class="product">
                    <div class="product_wrapper">
                        <img src="/public/images/foto_products/<?= $product['image'] ?>" alt="foto">
                        <p><?= $product['name'] ?></p>
                        <p><?= $product['price'] ?> ₽</p>
                            
                        <form method="POST">
                            <button name="plus" value="<?= $product['code'] ?>">В корзину</button>
                            <a href="detail/<?= $product['code'] ?>">Подробнее</a>
                        </form>
                    </div>
                </div>

            <?php } ?>

        </div>
    </div>

    <!-- Форма для пагинации -->
    <div class="pages_pagination width">
        Страница: 
        <?php
        for ($i = 1; $i <= $info['page']; $i++) {
            $link = '/'.$i.$info['get']; ?>
            <span>
                <a href="<?= $link ?>"><?= $i ?></a>
            </span>
        <?php } ?>
    </div>
</div>