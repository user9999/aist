<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
}
function generate_password($number)
{
    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0',
                 '(',')','[',']','!','?',
                 '&','^','%','@','*','$',
                 '<','>','/','|','+','-',
                 '{','}','~');
    // Генерируем пароль
    $pass = "";
    for($i = 0; $i < $number; $i++){
        // Вычисляем случайный индекс массива
        $index = rand(0, count($arr) - 1);
        $pass .= $arr[$index];
    }
    return $pass;
}
set_title("Партнерская программа интернет-магазина");
set_meta("партнерская программа, интернет-магазин, кузовные запчасти, запчасти DAF, запчасти Iveco, запчасти MAN, запчасти Mercedes, запчасти Scania, запчасти Volvo, запчасти RENAULT", "Партнерская программа интернет-магазина ".$SITE_TITLE);
if(!$_GET['id']) {
    $row=mysql_query('select title,rule from '.$PREFIX.'partner_rules where id=1');
    $res=mysql_fetch_row($row);
    render_to_template("components/partner/template.top.partner.php", array('title'=>$res[0]));
    render_to_template("components/partner/template.partner.php", array('content'=>$res[1]));
} elseif(strpos($_GET['id'], "activate-")!==false) {
    $code=substr($id, 9);
    
    $res=mysql_query('select email,name from '.$PREFIX.'partner_users where activation="'.$code.'" limit 1');
    $row=mysql_fetch_row($res);
    
    mysql_query('update '.$PREFIX.'partner_users set activation="0" where activation="'.$code.'"');
    $warn='Вы подтвердили свой email и можете войти в личный кабинет введя свой email в качестве логина и пароль';
    $code=md5(rand());
    mysql_query("INSERT INTO '.$PREFIX.'submission values('".$row[0]."','".$row[1]."','0','".$code."',".time().")");

    render_to_template("components/partner/template.top.partner.php", array('title'=>'Успешная регистрация в партнерской программе','error'=>$warn));
    render_to_template("components/partner/template.login.php", array());
} elseif($_GET['id']=='login') {


    if (isset($_SESSION['partnerid'])) {
        $res=mysql_query('select blok from '.$PREFIX.'partner_users where id='.$_SESSION['partnerid']);
        $row=mysql_fetch_row($res);
        if($row[0]!='') {
            $err="Ваш аккаунт заблокирован. Причины:<br>".stripslashes($row[4]);
        } else {
            header("Location: $PATH/account");
        }
    }
    $err = "";
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $res=mysql_query("select id,email,name,activation,blok from ".$PREFIX."partner_users where email='".mysql_real_escape_string($_POST['login'])."' and password='".md5($_POST['password'])."' limit 1");
        //echo "select mail,name,activation from partner_users where email='".mysql_real_escape_string($_POST['login'])."' and password='".md5($_POST['password'])."' limit 1";
        if (mysql_num_rows($res)==1) {
            $row=mysql_fetch_row($res);
            if($row[3]!='0') {
                $err="Ваш аккаунт еще не активирован.";
            } elseif($row[4]!='') {
                $err="Ваш аккаунт заблокирован. Причины:<br>".stripslashes($row[4]);
            } else {
                $_SESSION['partnerid']=$row[0];
                $_SESSION['pname']=$row[2];
                $_SESSION['email']=$row[1];
                header("Location: $PATH/account");
            }
        } else {
            $err = "Логин и/или пароль введены неверно.";
        }
    }



    render_to_template("components/partner/template.top.partner.php", array('title'=>'Вход для партнеров','error'=>$err));
    render_to_template("components/partner/template.login.php", array());
} elseif($_GET['id']=='remember') {
    if($_POST['remember']) {
        $err='';
        $res=mysql_query('select id,name,activation,blok from '.$PREFIX.'partner_users where email="'.addslashes($_POST['email']).'" limit 1');
        if(mysql_num_rows($res)==0) {
            $err='Такого email не зарегистрировано.';
        } else {
            $row=mysql_fetch_row($res);
            $err=($row[2])?'Ваш аккаунт еще не активирован<br>':'';
            $err.=($row[3])?'Ваш аккаунт заблокирован.':'';
        }
        if($err=='') {
            $pass=generate_password(9);
            mysql_query('update '.$PREFIX.'partner_users set password="'.md5($pass).'" where id='.$row[0]);
      
            $lettitle='Напоминание пароля '.$PATH;
            $umail=$_POST['email'];
            $from=$ADMIN_EMAIL;
            $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $lettitle))."?=";
            $mess='Здравствуйте '.$row[1].'. Вы заказали напоминание пароля. Ваш новый пароль: '.$pass.'<br>Письмо сгенерировано роботом партнерской программы сайта <a href="'.$PATH.'">'.$SITE_TITLE.'</a>';
            $mess=iconv("UTF-8", "koi8-r", $mess);
            $headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
            mail($umail, $ltitle, $mess, $headers);
            $err='Новый пароль отправлен на ваш почтовый ящик.';
        }
    }
  
  

    render_to_template("components/partner/template.top.partner.php", array('title'=>'Напоминание пароля','error'=>$err));
    render_to_template("components/partner/template.remember.php", array());

} elseif($_GET['id']=='register') {
    if($_POST['register']) {
        $err='';
        $frm_name=mysql_real_escape_string(strip_tags($_POST['name']));
        if($_POST['pass']!=$_POST['pass1']) { $err='Не совпадают пароли<br>';
        }
        if(strlen($frm_name)<5) { $error.='Слишком короткое имя заказчика.<br />';
        }
        if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $_POST['email'])) { $err.='Неверный e-mail.<br />';
        }
        if($err=='') {
            $letter=($_POST['letters']==1)?1:0;
            $code=$_POST['email'].time();
            $code=md5($code);
            mysql_query('insert into '.$PREFIX.'partner_users values("","'.$_POST['email'].'","'.$frm_name.'","'.md5($_POST['pass']).'","'.$code.'",'.$letter.',"")');
            //echo "<!--".'insert into partner_users values("","'.$_POST['email'].'","'.$frm_name.'","'.md5($_POST['pass']).'","'.$code.'",'.$letter.')'."-->";
            $warn='На вашу почту отправлена ссылка для активации аккаунта. После перехода по ней вы сможете окончить регистрацию и приступить к работе.';
            render_to_template("components/partner/template.top.partner.php", array('title'=>'Регистрация в партнерской программе'));
            render_to_template("components/partner/template.partner.php", array('content'=>$warn));
      
            $mess='ссылка для активации '.$PATH.'/partner/activate-'.$code;
            mail($_POST['email'], 'Регистрация в партнерской программе '.$SITE_TITLE, $mess);
        } else {
            render_to_template("components/partner/template.top.partner.php", array('title'=>'Регистрация в партнерской программе'));
            render_to_template("components/partner/template.register.php", array('name'=>$_POST['name'],'email'=>$_POST['email'],'error'=>$err));
        }
    
    } else {
        render_to_template("components/partner/template.top.partner.php", array('title'=>'Регистрация в партнерской программе'));
        render_to_template("components/partner/template.register.php", array());
    }
}
?>
