




<form method="post">

    <table cellpadding="0" border="0">
        <tr>
            <td colspan="2"><h1>Панель управления</h1></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $err ?></td>
        </tr>
        <tr>
            <td width="60"><label class="control-label col-md-4" for="first-name">Логин: 
                  </label></td>
            <td><input class="textbox form-control col-md-4 col-xs-12" name="admin_login" style="width:200px;" type="text"></td>
        </tr>
        <tr>
            <td><label class="control-label col-md-4" for="first-name">Пароль: 
                  </label></td>
            <td><input class="textbox form-control col-md-4 col-xs-12" name="admin_password" style="width:200px;" type="password"></td>
        </tr>
        <tr>   
            <td colspan="2" align="right"><input type="submit" value="Войти" class="btn btn-success button"></td>
        </tr>
    </table>
</form>