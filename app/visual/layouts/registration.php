<div class="registration_title">
    <?php echo $_POST['h1']; ?>
</div>

<div class="registration">
    <form method="POST">
        Логин<br>
        <input type="text" name="login" minlength="3" maxlength="15" value="" required><br>
        Пароль<br>
        <input type="password" name="password_1" minlength="5" value="" required><br>
        Ещё раз<br>
        <input type="password" name="password_2" minlength="5" value="" required><br>
        <button name="enter">Регистрация</button>
    </form>
</div>