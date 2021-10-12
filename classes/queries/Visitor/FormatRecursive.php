<?php
/**
 * Description of RecursiveMenu
 *
 * @author Vlad
 */
require_once 'RecursiveVisitor.php';

class FormatRecursive implements RecursiveVisitor
{
    private $QueryRecursive=null;
    private $recursive_out='';
    private $top=false;
    public $parent_id=0;
    public $level=0;
    public $items;
    public $treeHTML=array();
    public $active_items=array();
    public $symbol='';
    public $link='';
    public $name='';
    public $class='';
    public $rclass='recursive';
    public $mclass='menu ';
    public $tableSettings=[];//[names,],[url=>id,]
    private $type;    private $replaces;
    private $active='';
    public function __construct($parameters=false) 
    {
        $this->type=$parameters;
    }
    
    public function format(QueryRecursive $QueryRecursive)
    {

        if($this->type==false && empty($this->treeHTML)) {
            $error="select type from list ('select','list','table','div') or format array \$this->treeHTML";
            return $error;
        }
        $this->QueryRecursive=$QueryRecursive;
        //$fields=explode(",", $this->QueryRecursive->listfields);
        $arr=$fields=$this->QueryRecursive->fields;
        //var_dump($fields);
        //$arr=$fields;
        $name=(!in_array("name", $arr))?(!in_array("title", $arr))?(!in_array("text", $arr))?'':'text':'title':'name';
        $path=(!in_array("path", $arr))?(!in_array("url", $arr))?(!in_array("alias", $arr))?'':'alias':'url':'path';
        $key = array_search('id', $arr);
        unset($arr[$key]);
        $key = array_search($name, $arr);
        unset($arr[$key]);
        //$key = array_search($path, $arr);
        //unset($arr[$key]);
        $data=$this->attributeData($arr);
//print_r($fields);
        if($this->type=='select' && empty($this->treeHTML)) {
            if(count($this->active_items)>1) {
                $multiple=' multiple';
                $selectitem='';
            }else{
                $selectitem="<option class='{_class}' value='0'{_active}>select</option>\r\n";
            }
            $this->active='selected';
            //$name=(!in_array("name", $fields))?(!in_array("title", $fields))?(!in_array("text", $fields))?'':'text':'title':'name';
            $this->treeHTML['begin']="<select{$multiple} name=\"{$this->name}\" class=\"{$this->class}\">\r\n".$selectitem;
            
            $this->treeHTML['end']='</select>';
            $this->treeHTML['beginparent']="";
            $this->treeHTML['elementparent']="<option class='{_class}'{$data} value='{id}'{_active}>{".$name."}</option>\r\n";
            $this->treeHTML['endparent']="";
            $this->treeHTML['blockbeginchild']='';
            $this->treeHTML['beginchild']="";
            $this->treeHTML['elementchild']="<option class='{_class}'{$data} value='{id}'{_active}>{_symbol}{".$name."}</option>\r\n";
            $this->treeHTML['endchild']="";
            $this->treeHTML['blockendchild']="";
        }elseif($this->type=='list' && empty($this->treeHTML)) {
            $this->treeHTML['begin']="<ul id=\"ul_{_id}\" class=\"{$this->mclass}{$this->rclass}\">\r\n";
            $this->treeHTML['end']="</ul>\r\n";
            $this->treeHTML['beginparent']="<li>";
            $this->treeHTML['elementparent']="<a href='{_linkpart}{".$path."}'> {".$name."} </a> <span class='open'></span>";
            $this->treeHTML['endparent']="</li>\r\n";
            $this->treeHTML['blockbeginchild']="<ul id=\"ul_{_id}\" class=\"child {_class} parent_{_parent_id}\">\r\n";
            $this->treeHTML['beginchild']="<li>";
            $this->treeHTML['elementchild']="<a href='{_linkpart}{".$path."}'>{".$name."}</a>";
            $this->treeHTML['endchild']="</li>\r\n";
            $this->treeHTML['blockendchild']="</ul>\r\n";
        }elseif ($this->type=='table' && empty($this->treeHTML)) {
            $element="";
            foreach($fields as $field){
                
                $element.="<td>{".$field."}</td>";
                
            }
            if(!empty($this->tableSettings) && !empty($this->tableSettings[1])){
                    //$actions=explode($this->tableSettings[1]);
                $element_add="<td class='noclick'>";    
                foreach($this->tableSettings[1] as $url=>$fval){
                    $act=substr($url,strrpos($url,'&',-1)+1,-1);
                    $element_add.="<a class='{$act}' title='{$act}' href='{$url}{_{$fval}}'>{$act}</a>";
                }
                $element_add.="</td>";
            }
            $captions='';
            if(!empty($this->tableSettings) && !empty($this->tableSettings[0])){
                $captions="<tr id='tr_0' class='tr_level0 parent_0'>";
                foreach($this->tableSettings[0] as $column){
                    $captions.="<th>{$column}</th>";
                }
                $captions.="</tr>\r\n";
            }
            $this->treeHTML['begin']="<table class=\"recursive\">\r\n".$captions;
            
            $this->treeHTML['end']="</table>\r\n";
            $this->treeHTML['beginparent']="";
            $this->treeHTML['elementparent']="<tr id=\"tr_{_id}\" class=\"tr_{_class} parent_{_parent_id}\">".$element.$element_add."</tr>\r\n";
            $this->treeHTML['endparent']="";
            $this->treeHTML['blockbeginchild']="";
            $this->treeHTML['beginchild']="";
            $this->treeHTML['elementchild']="<tr id=\"tr_{_id}\" class=\"tr_{_class} parent_{_parent_id}\">".$element.$element_add."</tr>";
            $this->treeHTML['endchild']="";
            $this->treeHTML['blockendchild']="";
        }elseif($this->type=='checkbox' && empty($this->treeHTML)) {
            $this->active='checked';
            $this->treeHTML['begin']="";
            $this->treeHTML['end']="";
            $this->treeHTML['beginparent']="";
            $this->treeHTML['elementparent']="<div class=\"div_{_class}\"><input type=\"checkbox\"{$data} name=\"".$this->QueryRecursive->table."[]\" value=\"{id}\"{_active}>{".$name."}</div>\r\n";
            $this->treeHTML['endparent']="";
            $this->treeHTML['blockbeginchild']='';
            $this->treeHTML['beginchild']="";
            $this->treeHTML['elementchild']="<div class=\"div_{_class}\"><input type=\"checkbox\"{$data} name=\"".$this->QueryRecursive->table."[]\" value=\"{id}\"{_active}>{".$name."}</div>\r\n";
            $this->treeHTML['endchild']="";
            $this->treeHTML['blockendchild']="";
        }elseif ($this->type=='div' && empty($this->treeHTML)) {
            $error="not working yet";
            return $error;
        }
        //array_push($fields, '_class', 'symbol');
        $this->replaces=$fields;
        return $this->recursiveTree();
    }
    private function prepareString(string $string,array $value,$parent,$active)
    {
        foreach($this->replaces as $replace){
            //echo "<br><br>{".$replace."} --- <br>";
            //print_r($value);
            $string=str_replace("{".$replace."}", $value[$replace], $string);
        }
        $symbol=str_repeat($this->symbol, $this->level);
        $string=str_replace("{_symbol}", $symbol, $string);
        $string=str_replace("{_linkpart}", $this->link, $string);
        $string=str_replace("{_class}", "level{$this->level}", $string);
        $string=str_replace("{_active}", $active, $string);
        $string=str_replace("{_id}", $value['id'], $string);
        $string=str_replace("{_parent_id}", $parent, $string);
        
        return $string;
    }
    
    private function attributeData($arr)
    {
        if(!empty($arr)) {
            $res_array=array();
            foreach($arr as $value){
                $res_array[]="data-{$value}=\"{".$value."}\"";
            }
            $data=" ".implode(" ", $res_array);
        }else{
            $data="";
        }
        return $data;
    }
    
    private function recursiveTree($parent=0)
    {
        if (isset($this->QueryRecursive->resultArray[$this->parent_id])) { //Если категория с таким parent_id существует $this->parent_id
            $count= count($this->QueryRecursive->resultArray[$this->parent_id]); //$this->parent_id
            foreach ($this->QueryRecursive->resultArray[$this->parent_id] as $name=>$value) { //Обходим $this->parent_id
                $active=(in_array($value['id'], $this->active_items))?" {$this->active}":"";
                if(!$i) {
                    if(!$this->top) {//начало (для)первый вход 1 раз 
                        //echo "-- ul begin mainblock;<br>\r\n";
                        $main=$this->QueryRecursive->count;
                        $this->top=1;
                        $string=$this->treeHTML['begin'];//$treeHTML['top'];
                        $string=$this->prepareString($string, $value, $parent, $active);
                        $this->recursive_out.=$string;
                    }else{//начало дочернего элемента
                        //echo "ul begin blockchild<br>\r\n";
                        $string=$this->treeHTML['blockbeginchild'];//$treeHTML['begin'];
                        
                        $string=$this->prepareString($string, $value, $parent, $active);
                        
                        $this->recursive_out.=$string;
                    }
                }
                if($this->level==0) {//родит блок
                    //echo $this->level."li beginparent\r\n";
                    //echo " element parent\r\n<br>";
                    $string=$this->treeHTML['beginparent'].$this->treeHTML['elementparent'];//$treeHTML['parent'];
                    $string=$this->prepareString($string, $value, $parent, $active);
                    $this->recursive_out.=$string;
                }else{//child
                    //echo "li beginchild\r\n "
                    //echo  "element child\r\n";
                    $string=$this->treeHTML['beginchild'].$this->treeHTML['elementchild'];//$treeHTML['child'];
                    $string=$this->prepareString($string, $value, $parent, $active);
                    $this->recursive_out.=$string;
                }
                $this->level = $this->level + 1; //Увеличиваем уровень вложености
                //Рекурсивно вызываем эту же функцию, но с новым $parent_id и $level
                
                
                $this->parent_id=$value["id"];//
                $this->recursiveTree($this->parent_id);//
                
                
                $this->level = $this->level - 1; //Уменьшаем уровень вложености
                $i++;
                if($this->level==0) {
                    //echo "/li parent <br>\r\n";
                    $this->recursive_out.=$this->treeHTML['endparent'];
                }else{
                    //echo "/li  child <br>\r\n";
                    $this->recursive_out.=$this->treeHTML['endchild'];
                }
            
                if($count==$i) {//ok
                    if($main && $main==$i) {
                        $this->recursive_out.=$this->treeHTML['end'];//$treeHTML['totalend']."\r\n";//</table>
                        //echo "mainblock end /ul<br>";
                        return $this->recursive_out;
                    }else{
                        $this->recursive_out.=$this->treeHTML['blockendchild'];//$treeHTML['end']."\r\n";//$treeHTML['end'];
                        //echo "/ul child\r\n";
                    }
                }
            }
        }
    }
}
