<?php
session_start();
require_once('simplecaptcha.class.php');
$img=array("config/fon1.png","config/fon2.png","config/fon3.png","config/fon4.png","config/fon5.png","config/fon6.png","config/fon7.png","config/fon8.png","config/fon9.png","config/fon10.png");
$font=array("config/ZhikharevCTT.ttf","config/BRADHITC.TTF","config/SF Hollywood Hills.ttf","config/STEREOFI.TTF","config/AnthologY.ttf","config/CATHSGBR.TTF","config/Arkhive.ttf","config/TRIXIE.TTF","config/JournalSans.ttf","config/KremlinCTT.ttf");
$a=mt_rand(0,9);
$r=mt_rand(0,255);
$num=mt_rand(3,5);
$g=mt_rand(0,255);
$n=mt_rand(0,9);
$b=mt_rand(0,255);
$color=(($r+$b+$g)<250)?'ffffff':'000000';
$col=dechex($r).dechex($g).dechex($b);
$config['BackgroundImage'] = $img[$a];//Background Image
$config['BackgroundColor'] = $col;//Background Color- HEX
$config['Height']=30;//image height - same as background image
$config['Width']=100;//image width - same as background image
$config['Font_Size']=23;//text font size
$config['Font']=$font[$n];//"BRADHITC.TTF";'config/MINISYST.TTF';
$config['TextMinimumAngle']=12;//text angle to the left
$config['TextMaximumAngle']=33;//text angle to the right
$config['TextColor']=$color;//Text Color - HEX
$config['TextLength']=$num;//Number of Captcha Code Character
$config['Transparency']=50;//Background Image Transparency
$captcha = new SimpleCaptcha($config);
$_SESSION['string'] = $captcha->Code;
?>