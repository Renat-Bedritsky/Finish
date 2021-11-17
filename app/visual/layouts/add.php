<div class="title">
    <h2>Добавить товар</h2>
</div>

<div class="add_product">
    <form method="POST" name="add_product" enctype="multipart/form-data">
        Наименование товара:    <br><span class="add_product_name"><input minlength="2" name="name" value="" required></span><br>
        Описание товара:        <br><textarea rows="7" cols="60" minlength="5" name="description" value="" required></textarea><br>
        Фотография товара:      <br><input type="file" name="file" required><br>
        Категория:              <br><select name="category_code"><br>

                                    <?php
                                    foreach ($_POST['all'] as $category) { ?>
                                        <option value="<?= $category['code'] ?>"><?= $category['name'] ?></option>
                                    <?php } ?>

                                </select><br>
        Цена товара:            <br><span class="add_product_name"><input minlength="1" name="price" value="" required></span><br>
        <button name="enter">Добавить</button>
    </form>
</div>