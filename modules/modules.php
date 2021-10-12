<?php
$modules=array("rotator"=>array("name"=>"Ротатор",
"file"=>"rotator",
"install"=>"checked",
"tpl_replace"=>array("<!--kvn_rotator-->"=>"<?php load_module(\"[position]\", 0); ?>","<!--kvn_scripts_rotator-->"=>"<script src=\"/js/plugins.js\"></script>
<script src=\"/js/scripts.js\"></script>"),
"query"=>array("INSERT INTO `".$PREFIX."modules` (`module`, `position`, `ordering`, `admin`,`name`) VALUES('[module]', '[position]', 4, 0,'rotator')","INSERT INTO `kvn_frontpage` (`id`, `name`, `title`, `position`, `display`, `url`, `description`, `type`, `section`) VALUES
(1, '1457819005.png', 'Образец', 0, 1, 'http://shop.xn----itbaaykendmcmf4a0p.xn--p1ai/static/delivery', '', 'image', '');")),
"hits"=>array("name"=>"Хиты продаж",
"file"=>"hits",
"install"=>"",
"tpl_replace"=>array("<!--kvn_hits-->"=>"<?php load_module(\"[position]\", 0); ?>"),
"query"=>array("INSERT INTO `".$PREFIX."modules` (`module`, `position`, `ordering`, `admin`,`name`) VALUES('[module]', '[position]', 4, 0,'hits')")),
"menu_main"=>array("name"=>"Главное меню",
"file"=>"menu_main",
"description"=>"Меню сайта - Заменяет &lt;!--kvn_menu_main--&gt; на код меню",
"install"=>"checked",
"tpl_replace"=>array("<!--kvn_menu_main-->"=>"<?php load_module(\"[position]\", 0); ?> "),
"query"=>array("INSERT INTO `".$PREFIX."modules` (`module`, `position`, `ordering`, `admin`,`name`) VALUES('[module]', '[position]', 4, 0,'menu_main')")),
"languages"=>array("name"=>"Мультиязычность",
"file"=>"languages",
"install"=>"",
"tpl_replace"=>array("<!--kvn_languages-->"=>"<div class=languages><?php load_module(\"languages\", 0); ?></div>"),
"css_replace"=>array("/*languages*/"=>"
.languages {
    position: fixed;
    width: 30px;
    overflow: auto;
}
.languages a {
    display: block;
}
.languages img {
    margin: 0;
    padding: 0;
    display: block;
}"),
"query"=>array("INSERT INTO `".$PREFIX."modules` (`module`, `position`, `ordering`, `admin`,`name`) VALUES('[module]', '[position]', 4, 0,'languages')")),
"geo"=>array("name"=>"Определение города",
"file"=>"geo",
"install"=>"",
"components"=>array("geo"),
"modules"=>array(),
"lang"=>array("dblang_yourcity"=>array("ru"=>"Ваш город?"),"dblang_cities"=>array("ru"=>"Добро пожаловать"),"dblang_anothercity"=>array("ru"=>"Выбрать другой город")),
"index_replace"=>array("//includes_end"=>"//includes_end\nrequire_once(\"modules/geo.php\");"),
"css_replace"=>array("/*more_styles*/"=>"#cityoverlay{
    position: fixed;
    top: 0;
    left: 0;
    display: none;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.65);
    z-index: 999;
    -webkit-animation: fade .6s;
    -moz-animation: fade .6s;
    animation: fade .6s;
    overflow: auto;
}
.popup {
    top: 25%;
    left: 0;
    right: 0;       
    font-size: 14px;
    margin: auto;
    width: 85%;
    min-width: 320px;
    max-width: 600px;
    position: absolute;
    padding: 15px 20px;
    border: 1px solid #383838;
    background: #fefefe;
    z-index: 1000;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    -ms-border-radius: 4px;
    border-radius: 4px;
    font: 14px/18px 'Tahoma', Arial, sans-serif;
    -webkit-box-shadow: 0 15px 20px rgba(0,0,0,.22),0 19px 60px rgba(0,0,0,.3);
    -moz-box-shadow: 0 15px 20px rgba(0,0,0,.22),0 19px 60px rgba(0,0,0,.3);
    -ms-box-shadow: 0 15px 20px rgba(0,0,0,.22),0 19px 60px rgba(0,0,0,.3);
    box-shadow: 0 15px 20px rgba(0,0,0,.22),0 19px 60px rgba(0,0,0,.3);
    -webkit-animation: fade .6s;
    -moz-animation: fade .6s;
    animation: fade .6s;
}
.popup h4{font-size:20px;padding:15px 0 15px 0;text-align: center;}
.popup p{
font-size:16px;
padding:40px 0 45px 0;text-align: center;
}
.popup select{width: 240px;
    display: block;
    margin: 0 auto;
    padding-left: 40px;}
.close {
    top: 10px;
    right: 10px;
    width: 32px;
    height: 32px;
    position: absolute;
    border: none;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    background-color: rgba(0, 131, 119, 0.9);
    -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    cursor: pointer;
    outline: none;
}
.close:before {
    color: rgba(255, 255, 255, 0.9);
    content: \"X\";
    font-family:  Arial, Helvetica, sans-serif;
    font-size: 14px;
    font-weight: normal;
    text-decoration: none;
    text-shadow: 0 -1px rgba(0, 0, 0, 0.9);
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
    transition: all 0.5s;
}
.close1 {
padding-top: 5px;
    margin-top: -5px;
    width: 32px;
    margin-left: 50px;
    height: 27px;
    color: #000;
    position: absolute;
    border: none;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    background-color: rgba(0, 131, 119, 0.9);
    -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    cursor: pointer;
    outline: none;
}
/* кнопка закрытия при наведении */
.close:hover {
    background-color: rgba(252, 20, 0, 0.8);
}
.city{
	color: #fff;
    position: fixed;
    right: 0;
    top: 0;
    background: #555;
    padding: 10px;
}
"),
"tpl_replace"=>array("<!--kvn_scripts-->"=>"<script type=\"text/javascript\">
\$(document).ready(function () {
\$('.city').on('change', function() {
  \$.cookie('city', this.value, { expires: 365, path: '/' });
  location.reload();
});
\$('#mycity').click(function(event) {
	event.preventDefault();
  \$.cookie('city', \$.cookie('pre'), { expires: 365, path: '/' });
  location.reload();
});
\$('#mycity1').click(function(event) {
	event.preventDefault();
  \$.cookie('city', \$.cookie('pre'), { expires: 365, path: '/' });
  location.reload();
});
});
</script>
<?php
if(!\$_COOKIE['city']){
?>
<script type=\"text/javascript\">
	var delay_popup = 1000;
	setTimeout(\"document.getElementById('cityoverlay').style.display='block'\", delay_popup);
</script>
<?php
}
?>
<!--kvn_scripts-->","<!--kvn_widgets-->"=>"<div id=\"cityoverlay\">
    <div class=\"popup\">
        <h4><?= \$GLOBALS['dblang_cities'][\$userlanguage] ?></h4>
        <p>
            <?= \$GLOBALS['dblang_yourcity'][\$userlanguage] ?>  <a id=mycity href=\"/\"><?=\$city ?> </a> <span class=close1 id=mycity1>OK</span>
         </p>
         
         <select class=city id=city name=city><option value=select><?= \$GLOBALS['dblang_anothercity'][\$userlanguage] ?></option>
<?php
foreach(\$acities as \$key=>\$value){
	echo \"<option value='\$key'>\$key</option>\";
}
?>		 
		 </select>
    </div>
</div><!--kvn_widgets-->"),
"query"=>array()),
);
