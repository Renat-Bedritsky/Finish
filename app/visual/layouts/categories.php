<?php $categories = $_POST['categories'] ?>

<div class="categories">
    <div class="width">
        <div class="categories_wrapper">

            <?php
            foreach ($categories as $category) { ?>

                <div class="category">
                    <img src="<?= $category['image'] ?>">
                    <p><a href="<?= $category['code'] ?>/1"><?= $category['name'] ?></a></p>
                    <p><?= $category['description'] ?></p>
                </div>

            <?php } ?>

        </div>
    </div>
</div>