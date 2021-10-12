<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");
?>
<div class="installator_help">
<div>
    <h2>Форматирование рекурсивных данных</h2>
    <p>Подготовка данных из таблицы: создаем объект $recurse=helpFactory::activate('queries/QueryRecursive');  возвращает массив значений </p>
    <p>Создаем массив из таблицы - $recurse->makeQuery('имя таблицы','поле parent','нужные поля через запятую','Условия(ORDER BY, WHERE и т.п.') - возвращает массив</p>
    <p>HTML элемент можно создать по умолчанию (значения:select,table,list,checkbox), либо сформировав произвольный в массиве $treeHTML,
        тогда значения в скобках должны совпадать со значениями вызываемых полей таблицы.</p>
    <p>Значения по умолчанию: {_symbol} заменяется на (obj->symbol)*уровень,<br>{_linkpart} заменяется на obj->link,<br>{_class} заменяется на ("level0","level1" и т.д.),<br>{_active} заменяется на checked или selected,<br>{_parent_id},{_id}</p>
    <p>Класс по умолчанию пытается выбрать нужное поля для вывода текста (для checkbox, select) из вариантов - name, title, text, для ссылок из вариантов - path, url, alias. Если это не походит можно в makeQuery указать поля следующим образом:
        'id,value as name,url as path,price'. В ссылку отправляет поле path.</p>
    <p>select, checkbox используют name и path, остальные поля попадут в data. Поле price в data-price='значение price' и т.д.</p>
    <p>Параметры которые можно передать в класс:</p>
    <p>active_items выбранные значения</p>
    <p>symbol - для селектов символы в отступе</p>
    <p>link - начальная часть ссылки</p>
    <p>treeHTML - массив</p>


    <fieldset><legend>Рекурсивный селект может быть мульти если active_items более 1-го можно(0,0)</legend>
    <pre>
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,alias','ORDER BY id');//
$select=helpFactory::activate('queries/Visitor/FormatRecursive','select');
$select->symbol="---";
$select->active_items=array(9,10,80);
$out=$select->format($recurse);
echo $out; 
   </pre>
<?php
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,alias','ORDER BY id');//
//print_r($array);
$select=helpFactory::activate('queries/Visitor/FormatRecursive','select');
$select->symbol="---";
$select->active_items=array(9,10,80);
$out=$select->format($recurse);
echo $out;
?>
</div>
</fieldset>
<div>
    <fieldset><legend>Рекурсивная таблица</legend>
    <pre>
$recurse=helpFactory::activate('queries/QueryRecursive');
//$array=$recurse->makeQuery('product','pid','id,name,alias,price','ORDER BY id');//
$table=helpFactory::activate('queries/Visitor/FormatRecursive','table');
$out=$table->format($recurse);
echo $out;
    </pre>
 <?php
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,alias,price','ORDER BY id');//
//print_r($array);
$table=helpFactory::activate('queries/Visitor/FormatRecursive','table');
$out=$table->format($recurse);
echo $out;
?>
</div>
</fieldset>
<div>
    <fieldset><legend>Рекурсивные checkbox</legend>
    <pre>
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,price','ORDER BY id');//
$checkbox=helpFactory::activate('queries/Visitor/FormatRecursive','checkbox');
$checkbox->active_items=array(10,81,82);
$out=$checkbox->format($recurse);
echo $out; 
    </pre>
 <?php

$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,price','ORDER BY id');//
//print_r($array);
$checkbox=helpFactory::activate('queries/Visitor/FormatRecursive','checkbox');
$checkbox->active_items=array(10,81,82);
$out=$checkbox->format($recurse);
echo $out;
?>
</div>
</fieldset>
<div>
    <fieldset><legend>Обычный селект</legend>
<pre>
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,alias','ORDER BY id');//
$select=helpFactory::activate('queries/Visitor/FormatRecursive','select');
$select->symbol="|--";
$out=$select->format($recurse);
echo $out;
</pre>
<?php
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,alias','ORDER BY id');//
$select=helpFactory::activate('queries/Visitor/FormatRecursive','select');
$select->symbol="|--";
$out=$select->format($recurse);
echo $out;
?>
</div>

</fieldset>
<div>
    <fieldset><legend>Списки</legend>
<pre>
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('menu_admin','parent_id','id,text as name,path as alias','ORDER BY ordering');
print_r($array)
<?php 
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('menu_admin','parent_id','id,text,path','ORDER BY ordering');
print_r($array);
?>
$list=helpFactory::activate('queries/Visitor/FormatRecursive','list');
$list->link='/admin/?component=';
$out=$list->format($recurse);
echo $out;
</pre>
<?php
//$recurse=helpFactory::activate('queries/QueryRecursive');
//$array=$recurse->makeQuery('menu_admin','parent_id','id,text as name,path','ORDER BY ordering');
$list=helpFactory::activate('queries/Visitor/FormatRecursive','list');
$out=$list->format($recurse);
echo $out;
?>
</div>
</fieldset>
<div>
    <fieldset><legend>Gentellela menu</legend>
    <pre>
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('menu_admin','parent_id','id,text,path','ORDER BY ordering');
$menu_recursive=helpFactory::activate('queries/Visitor/FormatRecursive');
<?php
$string = <<<EOT
\$treeHTML['begin']='<ul class="nav side-menu">';
\$treeHTML['end']='</ul>';
\$treeHTML['beginparent']="<li>";
\$treeHTML['elementparent']="<a href='/admin/?component={path}'> {text} </a> <span style='display:none' class='fa fa-chevron-down'></span>";
\$treeHTML['endparent']="</li>\\r\\n";

\$treeHTML['blockbeginchild']='<ul class="nav child_menu" style="display: none">';
\$treeHTML['beginchild']="<li>";
\$treeHTML['elementchild']="<a href='/admin/?component={path}'>{text}</a>";
\$treeHTML['endchild']="</li>\\r\\n";
\$treeHTML['blockendchild']="</ul>";
\$menu_recursive->treeHTML=\$treeHTML;
\$menu_recursive->link='/admin/?component=';
\$out=\$menu_recursive->format(\$recurse);
echo \$out;
EOT;
echo htmlentities($string);
?>
    </pre>
</div>
    </fieldset>
</div>

