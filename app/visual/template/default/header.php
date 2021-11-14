<?php $user = $_POST['userData']; ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_POST['title'] ?></title>
    <link rel="shortcut icon" href="/public/images/foto_products/mobile.jpg" type="image/png">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/css/media.css">
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
                        <?php 
                        if (isset($user['login']) && $user['access'] == 'allowed') { ?>
                            <li><a href="/basket">Корзина</a></li>
                        <?php 
                        }
                        else { ?>
                            <li><a href="/autorization">Корзина</a></li>
                        <?php } ?>
                    </ul>
                </div>

                <?php

                if (isset($user['login']) && $user['access'] == 'allowed') { ?>

                    <div class="enter_account">
                        <div class="nav_account">
                            <ul>
                                <li>
                                    <a href="/"><?= $user['login'] ?></a>
                                    <ul>
                                        <li><a href="/profile/<?= $user['login'] ?>">Профиль</a></li>
                                        <li><a href="/addProduct">Добавить</a></li>
                                        <li><a href="/test.php">Тест</a></li>
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