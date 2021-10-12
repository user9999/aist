<?php
class Select
{
    public function __construct()
    {
        
    }
    public function makeSelect(array $data,$active,$name,$class="",$out=true)
    {
        $class=($class!="")?" class='{$class}'":"";
        $select="<select name='{$name}'{$class}>\r\n<option value='0'>Выбрать</option>";
        foreach ($data as $num=>$title) {
            $selected='';
            if ($active) {
                $selected=($active==$num)?" selected":"";
            }
            $select.="<option value='{$num}'{$selected}>{$title}</option>\r\n";
        }
        $select.="</select>";
        if ($out==true) {
            echo $select;
        } else {
            return $select;
        }
    }
}
