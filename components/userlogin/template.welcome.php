<div style="width:100%;text-align:center">
<form method="post" action="<?php echo $GLOBALS['PATH'];?>/welcome">

    <table cellpadding="0" border="0"  style="margin: 150px auto;">
        <tr>
            <td colspan="2"><h1>Вход в личный кабинет</h1><br /></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $err ?></td>
        </tr>
        <tr>
            <td width="60">Логин:</td>
            <td><input class="textbox" name="user_login" style="width:200px;" type="text"></td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td><input class="textbox" name="user_password" style="width:200px;" type="password"></td>
        </tr>
        <tr>   
            <td colspan="2" align="right"><input type="submit" value="Войти" class="button"></td>
        </tr>
    </table>
</form>
</div>
