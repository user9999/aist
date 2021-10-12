<form method="post">
    <table cellpadding="0" border="0">
        <tr>
            <td colspan="2"><h1>Вход в панель управления</h1></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $err ?></td>
        </tr>
        <tr>
            <td width="60">Логин:</td>
            <td><input class="textbox" name="admin_login" style="width:200px;" type="text"></td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td><input class="textbox" name="admin_password" style="width:200px;" type="password"></td>
        </tr>
        <tr>   
            <td colspan="2" align="right"><input type="submit" value="Войти" class="button"></td>
        </tr>
    </table>
</form>