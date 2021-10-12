<?php
/**
 * Вывод  ввиде таблиц необходим css .flex-tablerow  .flex-tablecaption
 *
 * Пример
 * $check=array('text'=>'название','path'=>'alias', 'ordering'=>'порядок','display'=>'отображать');
 * $queryTables=helpFactory::activate('queries/QueryTables');
 * $queryOut=$queryTables->makeQuery('table name',$check,true);
 * 
 * $actions=array("/admin/?component=menu&edit="=>"id","/admin/?component=menu&del="=>"id");
 * $MyTable=helpFactory::activate('queries/Visitor/TableHTML',array('admin menu',$actions));
 * echo $queryTables->makeOutput($MyTable); 
 ul.flex-tablecaption {
    background: #fffcc8;
}
ul.flex-tablerow {
    display: flex;
    list-style-type: none;
    justify-content: space-around;
    padding: 0;
    margin: 0;
}
.flex-tablerow li {
    border: 1px solid #fff;
    width: 9%;
    text-align: center;
    padding-top: 5px;
    padding-bottom: 5px;
}
.container ul:nth-child(2n) {
    background: #f0f0f0;
}
ul.flex-tablerow:hover {
    background-color: #e7e7e9;
}
 */
class Form
{
    private $output="";
    public $fields;
    public $serialized=0;
    public $actions;
    public $table;
    private $beginType;
    private $endType;
    private $beginTag;
    private $endTag;
    private $beginElement;
    private $endElement;
    private $beginCaption;
    private $endCaption;
    private $flexClass="flex-tablerow";// flex-tablecaption
    private $flexCaption="flex-tablecaption";
    public function __construct()
    {
        $this->setType('flex');
    }
    public function setType($type,$class=''){//type(pattern visitor) flex table pdf csv  json xml
        if($type=='table'){
            $class=($class)?" class='{$class}'":"";
            $this->beginType="<table{$class}>";
            $this->endType="</table>";
            $this->beginCaption="<tr class=caption>";
            $this->endCaption="</tr>";
            $this->beginTag="<tr>";
            $this->endTag="</tr>";
            $this->beginElement="<td>";
            $this->endElement="</td>";
        }elseif($type=='flex'){
            $beginClass=($class)?" class='{$class}'":" class='{$this->flexClass}'";
            $this->beginType="";
            $this->endType="";
            $this->beginTag="<ul{$beginClass}>";
            $this->endTag="</ul>";
            $caption=($class)?" class='{$class} {$this->flexCaption}'":" class='{$this->flexClass} {$this->flexCaption}'";
            $this->beginCaption="<ul{$caption}>";
            $this->endCaption="</ul>";
            $this->beginElement="<li>";
            $this->endElement="</li>";
        }
    }
    public function makeTable($table, array $fields,$class="",$actions="",$out=false)
    {
        $this->actions=$actions;
        $this->table=$table;
        
        $this->output=$this->beginType;//<table{$class}>";
        if (self::is_assoc($fields)) {
            $this->output.=$this->beginCaption;
            $titles=array_values($fields);
            $fields=array_keys($fields);
            $this->fields=$fields;
            foreach ($titles as $n=>$title) {
                $this->output.="{$this->beginElement}{$title}{$this->endElement}";
            }
            if (is_array($this->actions)) {
                $this->output.="{$this->beginElement}Действия{$this->endElement}";
            }
            $this->output.=$this->endCaption;
            self::makeFields();
        } elseif (is_array($fields)) {
            $this->fields=$fields;
            self::makeFields();    
        } else {
            return 'error not massive!';
        }
        $this->output.=$this->endType;
        if ($out==false) {
            return $this->output;
        } else {
            echo $this->output;
        }
    }
    
    private function is_assoc($var)
    {
        return is_array($var) && array_diff_key($var, array_keys(array_keys($var)));
    }
    
    private function tryunserialize($name)
    {
        $array=@unserialize($name);
        if ($array===false) {
            return $name;
        } else {
            $value=$this->serialized[key($this->serialized)];
            return $array[$value];
        }
        
    }
    
    private function makeFields()
    {
        if (is_array($this->table)) {
            $first = array_slice($this->table, 0, 1);
            $second = array_slice($this->table, 1, 1);
            if (is_array($first[key($first)])) {
                $first1 = array_slice($first[key($first)], 0, 1);
                $first2 = array_slice($first[key($first)], 1, 1);
                $second1 = array_slice($second[key($second)], 0, 1);
                $second2 = array_slice($second[key($second)], 1, 1);
                $tab1=key($first1);
                $compare1=$first1[key($first1)];
                $tab2=key($first2);
                $compare2=$first2[key($first2)];
                $tab3=key($second2);
                $compare3=$second1[key($second1)];
                $compare4=$second2[key($second2)];
                $query="SELECT a.id as aid,a.*,b.id as bid,b.*,c.id as cid,c.* FROM ".$GLOBALS['PREFIX']."{$tab1} as a,".$GLOBALS['PREFIX']."{$tab2} as b,".$GLOBALS['PREFIX']."{$tab3} as c WHERE a.{$compare1}=b.{$compare2} and a.{$compare3}=c.{$compare4}";
            } else {
                $tab1=key($first);$compare1=$first[key($first)];
                $tab2=key($second);$compare2=$second[key($second)];
                $query="SELECT a.id as aid,a.*,b.id as bid FROM ".$GLOBALS['PREFIX']."{$tab1} as a,".$GLOBALS['PREFIX']."{$tab2} as b WHERE a.{$compare1}=b.{$compare2}";
            }
        } else {
            $query="SELECT * FROM ".$GLOBALS['PREFIX']."{$this->table}";
        }
        $res=mysql_query($query);
        while ($row=mysql_fetch_array($res)) {
            $this->output.=$this->beginTag;
            foreach ($this->fields as $num=>$name) {
                if (strpos($name, 'date')!==false) {
                    $row[$name]=date("Y-m-d H:i:s", $row[$name]);
                }
                if (strpos($name, 'phone')!==false) {
                    $var="<a href='tel:{$row[$name]}'>{$row[$name]}</a>";
                } elseif (strpos($name, 'mail')!==false) {
                    $var="<a href='mailto:{$row[$name]}'>{$row[$name]}</a>";
                } else {
                    $var=$row[$name];
                }
                if ($this->serialized!=0 && $name==key($this->serialized)) {
                    $var=$this->tryunserialize($row[$name]);
                }
                $this->output.="{$this->beginElement}{$var}{$this->endElement}";
            }
            if (is_array($this->actions)) {
                $this->output.=$this->beginElement;
                foreach ($this->actions as $link=>$id) {
                    if (strpos($link, 'del')!==false) {
                        $act="delete";
                    } elseif (strpos($link, 'edit')!==false) {
                        $act="edit";
                    } else {
                        $act="unknown";
                    }
                    $this->output.="<a href={$link}{$row[$id]}>{$act}</a> ";
                }
                $this->output.=$this->endElement;
            }
            $this->output.=$this->endTag;
        }
    }
}
