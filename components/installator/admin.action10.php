<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}

$script="<script type='text/javascript' src='".$PATH."/components/installator/tpl/js/template.js'></script>";
set_script($script);

$css="<link rel=\"stylesheet\" href=\"".$PATH."/components/installator/tpl/css/template.css\">\r\n";
set_css($css);
$select_layout="<select name='layout_name'><option value=0>Выбрать</option>";
foreach (glob($HOSTPATH."/!layout/*") as $layout) {
    $layout=str_replace($HOSTPATH."/!layout/", '', $layout);
    $select_layout.="<option value='{$layout}'>{$layout}</option>";
}
$select_layout.="</select>";

$select="<select id=select  name=template><option value='n1_tpl/15_folder'>новый</option>";
foreach (glob($HOSTPATH."/templates/*/template.php") as $file) {
    $file=str_replace($HOSTPATH."/templates/", '', $file);
    $file=str_replace("/template.php", '', $file);
    $select.="<option value='{$file}'>{$file}</option>";
    if (strpos($file, 'admin.')===false) {
        $ts.="{$file}; ";
    } else {
        $ats.="{$file}; ";
    }
}
$select.="</select>";

$technologies = file_get_contents($HOSTPATH."/components/installator/data/template/technologies.json");
$technologies = json_decode($technologies);
$select_tech="";
foreach ($technologies as $name=>$val) {
    $checked=($name=="JQuery")?" checked":"";
    $select_tech.="<label class=\"ui\" for=\"{$name}\">{$name}</label><input class=\"ui\" id=\"{$name}\" type=\"checkbox\" name=\"technology[]\" value=\"{$name}\"{$checked}>";
}
$tpl_types = file_get_contents($HOSTPATH."/components/installator/data/template/tpls.json");
$tpl_types = json_decode($tpl_types);



$select_tpl="";
foreach ($tpl_types as $name=>$val) {
    //var_dump($val->name);die();
    $checked=($name=="site")?" checked":"";
    $select_tpl.="<label class=\"ui\" for=\"{$name}\">{$val->name}</label><input class=\"ui\" id=\"{$name}\" type=\"radio\" name=\"tpltype\" value=\"{$name}\"{$checked}>";
}
//var_dump($technologies);

//Создание из готового шаблона
if($_POST['layout']){
    require_once $HOSTPATH.'/components/installator/copy_files.php';
    include($HOSTPATH.'/inc/simple_html_dom.php');
    $layout_name=mysql_real_escape_string($_POST['layout_name']);
    $layoutdir=$_POST['layout'];
    if(!is_dir($HOSTPATH."/templates/".$layoutdir."/")){
        mkdir($HOSTPATH."/templates/".$layoutdir."/");
    }
    foreach(glob($HOSTPATH."/!layout/".$layout_name."/*.html") as $mytpl){//$doc->loadHTMLFile($file, LIBXML_NOWARNING | LIBXML_NOERROR);
        $html = file_get_html($mytpl);
        $tplname=str_replace($HOSTPATH."/!layout/".$layout_name."/",'',$mytpl);
        if($html->find('title',0)){
            $html->find('title',0)->innertext = "<?php echo \$PAGE_TITLE ?>";
        }else{
            $el=$html->find('head',0)->innertext;
            $html->find('head',0)->innertext="<title><?php echo \$PAGE_TITLE ?></title>\r\n".$el;
        }
        if($html->find('meta[name=keywords]',0)!=null){
            $html->find('meta[name=keywords]',0)->setAttribute("content","<?php echo \$META_KEYWORDS ?>\">");
        }else{
            $el=$html->find('head',0)->innertext;
            $el=str_replace("</title>","</title>\r\n<meta name=\"keywords\" content=\"<?php echo \$META_KEYWORDS ?>\">",$el);
            $html->find('head',0)->innertext=$el;
        }
        if($html->find('meta[name=description]',0)!=null){
            $html->find('meta[name=description]',0)->setAttribute("content","<?php echo \$META_DESCRIPTION ?>\">");
        }else{
            $el=$html->find('head',0)->innertext;
            $el=str_replace("</title>","</title>\r\n<meta name=\"description\" content=\"<?php echo \$META_DESCRIPTION ?>\">",$el);
            $html->find('head',0)->innertext=$el;
        }
        //var_dump($html->plaintext);die();
        foreach($html->find('module') as $module){
            $module_id=$module->getAttribute('id');
            $innermod=preg_replace('/>(\s+)</',">\r\n".'${1}'."<",$module->innertext);
            //echo $HOSTPATH.'/modules/'.$layoutdir.".".$module_id.".php";
            if(!file_exists($HOSTPATH.'/modules/'.$layoutdir.".".$module_id.".php")){
                $fp=fopen($HOSTPATH.'/modules/'.$layoutdir.".".$module_id.".php","w+");
                fwrite($fp,$innermod);
                fclose($fp);
            }
            $query="INSERT INTO ".$PREFIX."modules SET module='{$layoutdir}.{$module_id}',position='{$layoutdir}.{$module_id}',name='{$layoutdir}.{$module_id}'";
            $result=mysql_query($query);
            $module->outertext="<?php load_module('{$layoutdir}.{$module_id}',0)?>";
        }
        foreach($html->find('content') as $content){
            $content_id=$content->getAttribute('id');
            //var_dump($content->innertext);
            $innernodes=preg_replace('/>(\s+)</',">\r\n".'${1}'."<",$content->innertext);
            $url_path=str_replace(".html","",$tplname);
            $query="SELECT id FROM ".$PREFIX."module_text WHERE path='{$url_path}' and position='{$content_id}'";
            $result=mysql_query($query);
            if(mysql_num_rows($result)==0){
                
                $query="INSERT INTO ".$PREFIX."module_text SET path='{$url_path}', text='{$innernodes}', position='{$content_id}'";
                $result=mysql_query($query);
            }
            $content->outertext="<?php echo get_moduletext('{$content_id}')?>";
            //$content->remove();
        }

        
        $linkshtml=array();
        $styleflag=0;
        foreach($html->find('link') as $link){
           // dump_html_tree($link);
            //var_dump($link->href);
            $el=$link->getAttribute('href');
            if(strpos($el,"{$layoutdir}/style.css")==false){
                $styleflag=1;
            }
            if(substr($el,0,4)!="http" && substr($el,0,2)!="//"){
                $link->attr['url']="<?php echo \$PATH ?>/templates/<?php echo \$TEMPLATE ?>/".$el;
                $linkshtml[]=$el;
            }
        }
        $srchtml=array();
        foreach($html->find('script') as $script){
            $el=$script->getAttribute('src');
            if(substr($el,0,4)!="http" && substr($el,0,2)!="//"){
               //
               $srchtml[]=$el;
            }
        }
        
        foreach($html->find('img') as $img){
            $el=$img->getAttribute('src');
            if(substr($el,0,4)!="http" && substr($el,0,2)!="//"){
               $img->attr['src']="<?php echo \$PATH ?>/templates/<?php echo \$TEMPLATE ?>/".$el;
            }
        }
        foreach($html->find('a') as $a){
            $href=$a->getAttribute('href');
            if(substr($href,0,7)=="mailto:"){
               $email=mysql_real_escape_string(substr($href,7));
               $a->attr['href']="mailto:<?php echo get_settings('email')?>";
               $a->innertext="<?php echo get_settings('email')?>";
               $query="SELECT id FROM ".$PREFIX."settings WHERE alias='email'";
               $result=mysql_query($query);
               if(mysql_num_rows($result)==0){
                   $query="INSERT INTO ".$PREFIX."settings SET alias='email',value1='{$email}'";
                   $result=mysql_query($query);
               }
            }
            if(substr($href,0,4)=="tel:"){
               $phone=mysql_real_escape_string(substr($href,4));
               $a->attr['href']="tel:<?php echo get_settings('phone')?>";
               $a->innertext="<?php echo get_settings('phone')?>";
               $query="SELECT id FROM ".$PREFIX."settings WHERE alias='phone'";
               $result=mysql_query($query);
               if(mysql_num_rows($result)==0){
                   $query="INSERT INTO ".$PREFIX."settings SET alias='phone',value1='{$phone}'";
                   $result=mysql_query($query);
               }
            }
        }
        
        
        
        
        
        
        foreach($html->find('comment') as $comment){
            if(substr($comment->innertext,0,11)=='<!--content'){
                $mod=str_replace("<!--content","",$comment->innertext);
                $mod=str_replace("-->","",$mod);
                $mod=trim($mod,"_-");
                if($mod==""){
                    $comment->innertext="<?php echo \$PAGE_BODY ?>";
                }else{
                    $comment->innertext="<?php echo get_moduletext('comment_{$mod}')?>";
                    
                    $query="SELECT id FROM ".$PREFIX."module_text WHERE path='comment_{$mod}'";
                    $result=mysql_query($query);
                    if(mysql_num_rows($result)==0){
                        $query="INSERT INTO ".$PREFIX."module_text SET path='comment_{$mod}',text='--comment_{$mod}--'";
                        $result=mysql_query($query);
                    }
                }
            }
        }
        foreach($linkshtml as $link){

            $html=str_replace($link,"<?php echo \$PATH ?>/templates/<?php echo \$TEMPLATE ?>/".ltrim($link,"/"),$html);
        }
        foreach($srchtml as $src){
            //echo $src."----<b> copied</b><br>";
            $html=str_replace($src,"<?php echo \$PATH ?>/templates/<?php echo \$TEMPLATE ?>/".ltrim($src,"/"),$html);
        }
        if($styleflag==1){
            $stylecss="<link rel=\"stylesheet\" href=\"<?php echo \$PATH ?>/templates/<?php echo \$TEMPLATE ?>/style.css\">\r\n";
            $html=str_replace("<!--kvn_css-->",$stylecss."<!--kvn_css-->\r\n",$html);
            $fp=fopen($HOSTPATH."/templates/{$layoutdir}/style.css","w+");
            $csscontent="/*more_styles*/\r\n";
            fwrite($fp, $csscontent);
            fclose($fp);
        }
        if($tplname=="index.html"){
            $tplpart="";
        }else{
            $tplpart=str_replace("html","",$tplname);
        }
        //$alias=mysql_real_escape_string($_POST['alias']);
         if(!file_exists($HOSTPATH."/templates/{$layoutdir}/{$tplpart}template.php")){
            //$html=str_replace(" <","\r\n<",$html);
             
             //include_once($HOSTPATH."/inc/format_html.php");
            // $format = new Format;
             //$formatted_html = $format->HTML($html);
            
            $html=str_replace("</head>","<!--kvn_css-->\r\n<!--kvn_css_user-->\r\n<?php echo \$GLOBALS['CSS'];?>\r\n <!--kvn_scripts-->\r\n<!--kvn_script_user-->\r\n<?php echo \$GLOBALS['SCRIPT'];?>\r\n</head>",$html);
            $html=str_replace("</body>","<!--kvn_widgets-->\r\n</body>",$html);
            $html=preg_replace('/>(\s+)</',">\r\n".'${1}'."<",$html);
            $fp=fopen($HOSTPATH."/templates/{$layoutdir}/{$tplpart}template.php","w+");
            fwrite($fp, $html);
            fclose($fp);
            //$html->save($HOSTPATH."/templates/{$layoutdir}/{$tplpart}template.php");
        }
    }
    copy_files($HOSTPATH."/!layout/".$layout_name."/",$layoutdir,$layout_name);
}
//Создание нового шаблона
if ($_POST['alias']) {
    $tpltype=mysql_real_escape_string($_POST['tpltype']);
    //var_dump($_POST);die();
    $jsReplace="<!--kvn_scripts-->\r\n";
    $cssReplace="<!--kvn_css-->\r\n";
    foreach ($_POST['technology'] as $number=>$name) {
        //echo $name;
        //var_dump($technologies->$name);//['css'];
        $cssReplace.=$technologies->$name->css."\r\n";
        $jsReplace.=($technologies->$name->js->development)?$technologies->$name->js->development."\r\n":$technologies->$name->js->production."\r\n";
    }
     //var_dump($_POST); 
    $module='';
    
    if ($_POST['template']!='n1_tpl/15_folder') {
        $module=$_POST['alias'].".";
        $path=$_POST['template'];
 
    } else {
        $path=$_POST['alias'];
        //die('here');
        //echo $HOSTPATH."/templates/".$_POST['alias'];die();
        if (!is_dir($HOSTPATH."/templates/".$_POST['alias'])) {
            mkdir($HOSTPATH."/templates/".$_POST['alias']);
        }
        if (!is_dir($HOSTPATH."/templates/".$_POST['alias']."/images")) {
            mkdir($HOSTPATH."/templates/".$_POST['alias']."/images");
        }
        if (!is_dir($HOSTPATH."/templates/".$_POST['alias']."/js")) {
            mkdir($HOSTPATH."/templates/".$_POST['alias']."/js");
        }
        if (!is_dir($HOSTPATH."/templates/".$_POST['alias']."/css")) {
            mkdir($HOSTPATH."/templates/".$_POST['alias']."/css");
        }
        if (!is_dir($HOSTPATH."/templates/".$_POST['alias']."/html")) {
            mkdir($HOSTPATH."/templates/".$_POST['alias']."/html");
        }
        if (!is_dir($HOSTPATH."/templates/".$_POST['alias']."/common")) {
            mkdir($HOSTPATH."/templates/".$_POST['alias']."/common");
        }
        
        
        $cssbegin="";
        $cssend="style.css";
        $cssendm="m.";
        if ($_POST['processor']=='less') {
            if (!is_dir($HOSTPATH."/templates/".$_POST['alias']."/less")) {
                mkdir($HOSTPATH."/templates/".$_POST['alias']."/less");
            }
            $processor="<link rel='stylesheet/less' href='<?php echo \$PATH ?>/templates/<?php echo \$TEMPLATE ?>/less/style.less'>
    <script src='//cdn.jsdelivr.net/npm/less@3.13' ></script>";
            $cssbegin = file_get_contents($HOSTPATH."/components/installator/parts/template/{$tpltype}/less/head.less");
            $cssend="less/style.less";
        } elseif ($_POST['processor']=='saas') {
            $processor="";
        } elseif ($_POST['processor']=='stylus') {
            $processor="";
        } else {
            $processor="<link rel='stylesheet' type='text/css' href='<?php echo \$PATH ?>/templates/<?php echo \$TEMPLATE ?>/style.css'>";
        }

//

        $css="@charset 'UTF-8';\r\n\r\n".$cssbegin;
        if ($_POST['css_reset']) {
            $css.=file_get_contents($HOSTPATH."/components/installator/parts/template/{$tpltype}/css/reset.css");
        }
        if ($_POST['framework']=='flex') {
            $css.=file_get_contents($HOSTPATH."/components/installator/parts/template/{$tpltype}/css/flex.css");
        }

        $css.=file_get_contents($HOSTPATH."/components/installator/parts/template/{$tpltype}/".$cssend);
        $fp=fopen($HOSTPATH."/templates/".$_POST['alias']."/".$cssend, "w+");
        fwrite($fp, $css);
        fclose($fp);
        
        


        
        copy($HOSTPATH."/components/installator/parts/template/{$tpltype}/js/script.js", $HOSTPATH."/templates/".$_POST['alias']."/js/script.js");
        foreach (glob($HOSTPATH."/components/installator/parts/template/{$tpltype}/images/*") as $img) {
            $iname=str_replace($HOSTPATH."/components/installator/parts/template/{$tpltype}/images/", "", $img);
            copy($img, $HOSTPATH."/templates/".$_POST['alias']."/images/".$iname);
        }
        foreach (glob($HOSTPATH."/components/installator/parts/template/{$tpltype}/common/*") as $file) {
            $fname=str_replace($HOSTPATH."/components/installator/parts/template/{$tpltype}/common/", "", $file);
            copy($file, $HOSTPATH."/templates/".$_POST['alias']."/common/".$fname);
        }
    }
    
    
    //общее для шаблонов доп и новых
    if ($_POST['processor']=='less') {
        $cssendm="less/m.style.less";
        $processor="<link rel='stylesheet/less' href='<?php echo \$PATH ?>/templates/<?php echo \$TEMPLATE ?>/less/style.less'>
    <script src='//cdn.jsdelivr.net/npm/less@3.13' ></script>";
    } elseif ($_POST['processor']=='stylus') {
        
    } else {
        $processor="<link rel='stylesheet' type='text/css' href='<?php echo \$PATH ?>/templates/<?php echo \$TEMPLATE ?>/style.css'>";
    }

    $tpl = file_get_contents($HOSTPATH."/components/installator/parts/template/{$tpltype}/template.php");
    $tpl = str_replace("<!--css_processor-->", $processor, $tpl);
    $tpl = str_replace("<!--kvn_css-->", $cssReplace, $tpl);
    $tpl = str_replace("<!--kvn_scripts-->", $jsReplace, $tpl);

    $fp=fopen($HOSTPATH."/templates/".$path."/{$module}template.php", "w+");
    fwrite($fp, $tpl);
    fclose($fp);
    
    if ($_POST['mobile']) {
        if(!file_exists($HOSTPATH."/templates/".$path."/m.template.php")){
            $tpl = file_get_contents($HOSTPATH."/components/installator/parts/template/{$tpltype}/m.template.php");
            $tpl = str_replace("<!--css_processor-->", $processor, $tpl);
            $fp=fopen($HOSTPATH."/templates/".$path."/m.template.php", "w+");
            fwrite($fp, $tpl);
            fclose($fp);
        }
        if(!file_exists($HOSTPATH."/templates/".$_POST['alias']."/".$cssendm)){
            $css.=file_get_contents($HOSTPATH."/components/installator/parts/template/{$tpltype}/".$cssendm);
            $fp=fopen($HOSTPATH."/templates/".$_POST['alias']."/".$cssendm, "w+");
            fwrite($fp, $css);
            fclose($fp);
        }
        if(!file_exists($HOSTPATH."/templates/".$path."/js/m.script.js")){
            copy($HOSTPATH."/components/installator/parts/template/{$tpltype}/js/m.script.js", $HOSTPATH."/templates/".$path."/js/m.script.js");
        }
    }

    done("Шаблон создан");
} 

?>
<br><br>
<p>Существующие шаблоны: <?=$ts?><br> админка: <?=$ats?></p><br>
<form method=post>
    <table>
        <tr>
            <td>(или добавить для компонента)</td><td><?=$select?></td></tr>
        <tr>
            <td>Alias</td><td><input type="text" class="ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all" name="alias"><span class='template'>.template.php</span></td></tr>
        <tr> <td>Препроцессор</td>
            <td>
                <select class="uiselect" name='processor'>
                    <option value="no">не нужен</option>
                    <option value="less">less</option>
                    <option value="saas" disabled>saas</option>
                    <option value="stylus" disabled>stylus</option>
            </td>
           <tr> <td>Обнуление CSS</td><td><label class="ui" for="reset">reset</label><input class="ui" id="reset" type="checkbox" name="css_reset" checked></td></tr>
           <tr> <td>Шаблон</td><td><?=$select_tpl?></td>
           
           <tr> <td>Технологии</td><td><?=$select_tech?></td>
           <!--<tr> <td>UI Kit</td><td><label class="ui" for="JQueryUI">JQueryUI</label><input class="ui" id="JQueryUI" type="checkbox" name="uikit[]" value="JQueryUI"> <label class="ui" for="zino-ui">Zino-UI</label><input class="ui" id="zino-ui" type="checkbox" name="uikit[]" value="zino-ui" disabled> <label class="ui" for="jeasyui">Jquery Easy UI</label><input class="ui" id="jeasyui" type="checkbox" name="uikit[]" value="jeasyui" disabled><label class="ui" for="jQWidgets">jQWidgets</label><input class="ui" id="jQWidgets" type="checkbox" name="uikit[]" value="jQWidgets" disabled><label class="ui" for="primeUI">primeUI</label><input class="ui" id="primeUI" type="checkbox" name="uikit[]" value="primeUI" disabled></td>-->
           
           <tr> <td>Framework</td><td><label class="ui" for="flex">flex</label><input class="ui" id="flex" type="radio" name="framework" value="flex"> <label class="ui" for="bootstrap">bootstrap</label><input class="ui" id="bootstrap" type="radio" name="framework" value="bootstrap"> <label class="ui" for="skeleton">skeleton</label><input class="ui" id="skeleton" type="radio" name="framework" value="skeleton"> <label class="ui" for="Semantic-UI">Semantic-UI</label><input class="ui" id="Semantic-UI" type="radio" name="framework" value="Semantic-UI"> <label class="ui" for="Foundation">Foundation</label><input class="ui" id="Foundation" type="radio" name="framework" value="Foundation"> <label class="ui" for="none">none</label><input class="ui" id="none" type="radio" name="framework" value="none" checked></td>
           <tr> <td>Версия для мобильных устройств</td><td><label class="ui" for="mobile">Включить</label><input class="ui" id="mobile" type="checkbox" name="mobile"></td>
        </tr>
    </table>
<input type=submit class=button2 name=submit value="Создать">
</form>
<form method=post>
    <table><caption>Или создать из верстки (Заменит любые комменты вида &lt!--content_...--&gt на данные из базы(Должен быть установлен компонент module_text - Тексты модулей!)), Все данные внутри тегов &ltcontent id='имя_блока'&gt сохранит в тексты модулей в базу. Из &ltmodule id='имя_модуля'&gt создаст модуль в папке /modules/Alias.имя_модуля.php</caption>
       <td>Alias</td><td><input type="text" class="ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all" name="layout" required></td></tr>
    <tr><td>Верстка</td><td><?=$select_layout?></td></tr>
    </table>
    <input type=submit class=button2 name=submit value="Создать">
</form>
