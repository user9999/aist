<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
set_title("Подписка на обновления");
//var_dump($_GET);
mysql_query("delete from ".$PREFIX."submission where code!=0 and subdate<".time()-7*24*60*60);
if(preg_match("!^[^\s@]+@[^\s\.]+\.[^\s\.@]+$!is", trim($_POST['submail']), $match) && strlen(trim($_POST['uname']))>2) { { { { { { { { { { { { { { { { { { { { { { { { { { {
    $submail=trim($_POST['submail']);
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
}
    $email=mysql_real_escape_string($submail);
    $res=mysql_query("select code from ".$PREFIX."submission where email='$email'");
    if(mysql_num_rows($res)==0) { { { { { { { { { { { { { { { { { { { { { { { { { { {
        $code=md5(rand());
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
    }
        $unsub=md5($email.rand(10, 9999));
        $name=mysql_real_escape_string(trim($_POST['uname']));

        mysql_query("insert into ".$PREFIX."submission set email='$email',name='$name',code='$code',unsub='$unsub',subdate='".time()."'");
if(file_exists("inc/mail.system.templates.php")) {
    include_once "inc/mail.system.templates.php";
}
        $replacearray=array('{:sitetitle:}','{:url:}','{:username:}','{:usermail:}','{:subscribe:}','{:unsubscribe:}');
        $newvalues=array($PAGE_TITLE,$PATH,trim($_POST['uname']),$submail,$code,$unsub);
        
        $lettitle=str_replace($replacearray, $newvalues, $mailsystemtemplates['presubmission'][0]);
        $mess=str_replace($replacearray, $newvalues, $mailsystemtemplates['presubmission'][1]);
        
        $from=$ADMIN_EMAIL;
        $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $lettitle))."?=";
        $mess=iconv("UTF-8", "koi8-r", $mess);
        $headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
		mail($submail,$ltitle,$mess,$headers );
		$error="Через несколько минут вам придет письмо с нашего сайта. Для подтверждения подписки вам необходимо перейти по ссылке в письме.";
		render_to_template("components/submission/template.submit.php", array('error' => $error));
	} else {
		$error="Этот email уже пожписан на рассылку";
		render_to_template("components/submission/template.form.php", array('error' => $error));	
	}
} elseif($_POST['submit']){
	$error="Неверно введен email, либо слишком короткое имя";
	render_to_template("components/submission/template.form.php", array('error' => $error));
} elseif(!$_GET['m']){
	render_to_template("components/submission/template.form.php", array('error' => ""));
}
if($_GET['m']){
	$email=mysql_real_escape_string($_GET['m']);
	if($_GET['s']){
		$code=preg_replace("![^a-fA-F0-9]!","",$_GET['s']);
		$res=mysql_query("select name,code,unsub from ".$PREFIX."submission where email='$email'");
		$row=mysql_fetch_row($res);
		if($row[1]!='0' && $row[1]==$code){
			mysql_query("update ".$PREFIX."submission set code='0' where email='$email'");
			if(file_exists("inc/mail.system.templates.php")){
				include_once "inc/mail.system.templates.php";
			}
		
			$replacearray=array('{:sitetitle:}','{:url:}','{:username:}','{:usermail:}','{:subscribe:}','{:unsubscribe:}');
			$newvalues=array($PAGE_TITLE,$PATH,$row[0],$email,$row[1],$row[2]);
			$lettitle=str_replace($replacearray,$newvalues,$mailsystemtemplates['submission'][0]);
			$mess=str_replace($replacearray,$newvalues,$mailsystemtemplates['submission'][1]);
		
			$from=$ADMIN_EMAIL;
			$ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $lettitle))."?=";
			$mess=iconv("UTF-8", "koi8-r", $mess);
			$headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
			mail($email,$ltitle,$mess,$headers );
			$error="Email подтвержден. Спасибо, что подписались на наши новости.";			
		} elseif($row[0]=='0'){
			$error="Ваша подписка уже активирована";
		} else {
			$error="Ошибка: Неверные данные";
		}
	} elseif($_GET['u']){
		$unsub=mysql_real_escape_string($_GET['u']);
		mysql_query("delete from ".$PREFIX."submission where email='$email' and unsub='$unsub'");
		$error="Ваш email удален из базы.";	
	} else {
		$error="Ошибка: Неверные код";
	}
	render_to_template("components/submission/template.submit.php", array('error' => $error));
}
?>
