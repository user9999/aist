<?php
$modules=array("menufixed"=>array("name"=>"Фиксированное меню",
"file"=>"menufixed",
"description"=>"Заменит &lt;!--kvn_css--&gt; на подключение css &lt;!--kvn_scripts--&gt; на подключение скрипта",
"install"=>"",
"tpl_replace"=>array("<!--kvn_css-->"=>"<link rel=\"stylesheet\" href=\"<?=\$PATH?>/widgets/menufixed/menufixed.css\">
<!--kvn_css-->","<!--kvn_scripts-->"=>"<script src=\"<?=\$PATH?>/widgets/menufixed/menufixed.js\"></script>
<!--kvn_scripts-->")),
"scrollup"=>array("name"=>"Прокрутка вверх",
"file"=>"scrollup",
"description"=>"Заменит &lt;!--kvn_css--&gt; на подключение css, &lt;!--kvn_scripts--&gt; на подключение скрипта, &lt;!--kvn_widgets--&gt; на код виджета",
"install"=>"",
"tpl_replace"=>array("<!--kvn_widgets-->"=>"<div id=\"scrollup\"><img src=\"/widgets/scrollup/up.png\" class=\"up\" alt=\"up\"></div>
<!--kvn_widgets-->","<!--kvn_css-->"=>"	<link rel=\"stylesheet\" href=\"/widgets/scrollup/scrollup.css\" type=\"text/css\" media=\"screen\">
<!--kvn_css-->","<!--kvn_scripts-->"=>"<script src=\"/widgets/scrollup/scrollup.js\" type=\"text/javascript\"></script>
<!--kvn_scripts-->")
)
);
?>