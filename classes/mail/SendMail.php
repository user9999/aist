<?php
class sendMail
{
	public function __construct()
	{
		
	}
	public function sendActivation($email,$pass)
    {
	  $from="robot@xn--80aacujpogtedm5od.xn--p1ai";
	  ini_set("sendmail_from", $from);
	  $lettitle="Активация почтового ящика";
    $message='Ваш код активации: '.$pass.' ';
	  mail($email, $lettitle, $message, "From: <" . $from . "> -f" . $from ) or 	die("Unfortunately, a server issue prevented delivery of your message.");
    }

	public function mailing($email,$title,$text)
    {
      require_once 'PHPMailer-master/PHPMailerAutoload.php';
      $mail = new PHPMailer;
      
      $mail->ClearAttachments(); // если в объекте уже содержатся вложения, очищаем их
      $mail->ClearCustomHeaders(); // то же самое касается заголовков письма
      $mail->ClearReplyTos(); 
      
      $mail->isSMTP();
      $mail->Host = 'smtp.yandex.ru';
      $mail->SMTPAuth = true;
      $mail->Username = 'st.birja@yandex.ru';
      $mail->Password = '$^gbn45^*()';
      $mail->SMTPSecure = 'ssl';
      $mail->Port = '465';
      
      $mail->CharSet = 'UTF-8';
      $mail->From = 'st.birja@yandex.ru'; // От кого ящик
      $mail->FromName = 'Столярная биржа';    // От кого Имя
      $mail->isHTML(true);
      $mail->ContentType = 'text/html'; // тип содержимого письма

      $mail->addAddress($email, $email);
      $mail->Subject = $title;
      $mail->Body = $text;
      //if($vlf) $mail->AddAttachment("$name_scr", "Скриншот_ошибки.png"); // добавляем вложение
      //$mail->AltBody = 'Текст письма Много текста. Второй текст';
      if($mail->send()){
        $spRod.='ДА';
      } else {
        $spRod.='НЕТ. Ошибка '.$mail->ErrorInfo;
      }
    }


}