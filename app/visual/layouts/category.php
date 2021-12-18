<?php $info = $_POST['category']; ?>

<div class="products">
    <div class="wrapper">
        <div class="categories">
            <div class="width">
                <h2><?= $info['category_info']['name'] ?></h2>
            </div>
        </div>

        <div class="products_filter width">
            <form action="/<?= $info['category_info']['code'] ?>/1">
                Цена от <input type="number" name="min" value="<?php if (isset($_GET['min'])) echo $_GET['min'] ?>"> до <input type="number" name="max" value="<?php if (isset($_GET['max'])) echo $_GET['max'] ?>">
                <input type="checkbox" name="new" value="yes"> Новинка
                <button type="submit" name="" value="">Фильтр</button>
                <a href="/<?= $info['category_info']['code'] ?>">Сброс</a>
            </form>
        </div>
                    
        <div class="products_wrapper width">

            <?php foreach ($info['products'] as $product) { ?>

                <div class="product">
                    <div class="product_wrapper">
                        <img src="/public/images/foto_products/<?= $product['image'] ?>" alt="<?= $product['code'] ?>">
                        <p><?= $product['name'] ?></p>
                        <p><?= $product['price'] ?> BYN</p>
                                        
                        <form method="POST">
                            <button name="plus" value="<?= $product['code'] ?>">В корзину</button>
                            <a href="/detail/<?= $product['code'] ?>">Подробнее</a>
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
            $link = '/'.$info['category_info']['code'].'/'.$i.$info['get']; ?>
            <span>
                <a href="<?= $link ?>"><?= $i ?></a>
            </span>
        <?php } ?>
    </div>
</div>