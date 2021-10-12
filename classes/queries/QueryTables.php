<?php
/*
 * examples
 * получение массива (fetch_row_all)-true, по умолчанию (fetch_array) или false
 * $queryTables=helpFactory::activate('queries/QueryTables');
 * $queryOut=$queryTables->makeQuery('menu_admin',$check,true);
 * 
 * паттерн Visitor
 * получение в виде json
 * $Json=helpFactory::activate('queries/Visitor/Json');
 * echo $queryTables->makeOutput($Json);
 * 
 * получение в виде flex списка array('html_class', ссылки в get(редактирование, удаление)-$array)
 * $Flex=helpFactory::activate('queries/Visitor/FlexHTML',array('',$actions));
 * echo $queryTables->makeOutput($Flex);//echo 
 * 
 * получение в виде таблицы table
 * $MyTable=helpFactory::activate('queries/Visitor/TableHTML',array('admin menu',$actions));
 * echo $queryTables->makeOutput($MyTable);//echo 
 */

class QueryTables
{
    public $fields;
    public $serialized=0;
    public $table;
    public $titles=false;
    public $resultArray;
    public $xml=array();
    public $where="";
    public function __construct()
    {
        
    }
    public function makeOutput(Visitor $obj){
        return $obj->format($this);//->resultArray
    }
    public function makeQuery($table, array $fields,bool $type=false)//,$class="",$actions="",$out=false
    {
        $this->table=$table;
        if (self::is_assoc($fields)) {
            $this->titles=array_values($fields);
            $this->fields=array_keys($fields);
            self::makeFields();
        } elseif (is_array($fields)) {
            $this->fields=$fields;
            self::makeFields();    
        } else {
            return 'error not massive!';
        }
        if($type==false){
            return $this->resultArray;
        }else{
            
            if($this->titles){
                foreach($this->titles as $names){
                    //$minArray[0][]=$names;
                    $this->min_array[0][]=$names;
                }
            }
            ksort($this->min_array);
            return  $this->min_array;
             
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
    
    private function makeFields():void
    {
        if (is_array($this->table)) {
            $first = array_slice($this->table, 0, 1);
            $second = array_slice($this->table, 1, 1);
            $this->where=($this->where!='')?" and ".$this->where:'';
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
                
                $query="SELECT a.id as aid,a.*,b.id as bid,b.*,c.id as cid,c.* FROM ".$GLOBALS['PREFIX']."{$tab1} as a,".$GLOBALS['PREFIX']."{$tab2} as b,".$GLOBALS['PREFIX']."{$tab3} as c WHERE a.{$compare1}=b.{$compare2} and a.{$compare3}=c.{$compare4}{$this->where}";
                //echo $query;
            } else {
                $tab1=key($first);$compare1=$first[key($first)];
                $tab2=key($second);$compare2=$second[key($second)];
                $query="SELECT a.id as aid,a.*,b.id as bid FROM ".$GLOBALS['PREFIX']."{$tab1} as a,".$GLOBALS['PREFIX']."{$tab2} as b WHERE a.{$compare1}=b.{$compare2}{$this->where}";
                //echo $query;
            }
        } else {
            $this->where=($this->where!='')?" WHERE ".$this->where:'';
            $query="SELECT * FROM ".$GLOBALS['PREFIX']."{$this->table}{$this->where}";
        }
        $this->mysql_res=mysql_query($query);
        $node=1;
        while ($row=mysql_fetch_array($this->mysql_res)) {
            $row_min=array();
            //$this->xml[]
            foreach ($this->fields as $name) {
                if (strpos($name, 'date')!==false) {
                    $row[$name]=date("Y-m-d H:i:s", $row[$name]);
                }elseif ($this->serialized!=0 && $name==key($this->serialized)) {
                    $row[$name]=$this->tryunserialize($row[$name]);
                }
                $row_min[]=$row[$name];
                $this->xml['node'.$node][$name]=$row[$name];
            }
            $this->resultArray[$row['id']]=$row;
            $this->min_array[$row['id']]=$row_min;
            $node++;
        }
    }
}
