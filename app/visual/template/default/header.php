<?php $user = $_POST['userData']; ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_POST['title'] ?></title>
    <link rel="shortcut icon" href="/public/images/foto_products/mobile.jpg" type="image/png">
    <link rel="stylesheet" href="/public/css/style1.css">
    <link rel="stylesheet" href="/public/css/media1.css">
</head>

<body>

<div class="window">
    <div class="window_wrapper">
        <div class="header">
            <div class="header_wrapper width">
                <div>
                    <a href="index.php"><img src="/public/images/site-images/market.png" class="header_logo" alt="logo"></a>
                </div>

                <div class="header_nav">
			        <button class="header_nav_toggle"><label for="header_nav_toggle"></label></button>
				    <input type="checkbox" id="header_nav_toggle">
                    <ul>
                        <li><a href="/">Товары</a></li>
                        <li><a href="/categories">Категории</a></li>
                        <li><a href="/basket">Корзина</a></li>
                    </ul>
                </div>

                <?php

                if (isset($user['login']) && $user['access'] == 'allowed') { ?>

                    <div class="enter_account">
                        <div class="nav_account">
                            <ul>
                                <li>
                                    <a><?= $user['login'] ?></a>
                                    <ul>
                                        <li><a href="/profile/<?= $user['login'] ?>">Профиль</a></li>
                                        <?php if ($user['position'] == 'operator' || $user['position'] == 'administrator') { ?>
                                            <li><a href="/add">Добавить</a></li>
                                            <li><a href="/orders">Заказы</a></li>
                                        <?php } ?>
                                        <li><a href="/logout">Выход</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                <?php
                }
                else { ?>

                    <div class="enter_account">
                        <div><a href="/autorization">Войти</a></div>
                    </div>

                <?php } ?>

            </div>
        </div>