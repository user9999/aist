<?php
/**
 * Prepares recusive array from sql table
 * 
 * @author Vlad
 */
class QueryRecursive
{
    /**
     * output massive
     * 
     * array
     */
    public $resultArray;
    /**
     * serialized field (set name if exists if as name after as)
     * 
     * @var string 
     */
    public $serialized;
    /**
     * site language
     * 
     * @var string
     */
    public $language='ru';
    /**
     * Parent id
     * 
     * @var integer 
     */
    private $parent_field;
    /**
     * Count of top parents (for Visitor)
     * 
     * @var integer 
     */
    public $count;
    /**
     * Selected fields in table
     * 
     * @var array 
     */
    public $fields;
    /**
     * Table name 
     * 
     * @var string
     */
    public $table;
    
    public function __construct()
    {
        
    }
    /**
     * Lets visitor format data
     * 
     * @param  RecursiveVisitor $obj
     * @return string
     */
    public function makeOutput(RecursiveVisitor $obj)
    {
        return $obj->format($this);//->resultArray
    }
    /**
     * Makes array from sql Table
     *
     * @param  string $table
     * @param  string $parent_field
     * @param  string $listfields
     * @param  string $conditions
     * @return array
     */
    public function makeQuery($table,$parent_field,$listfields,$conditions='')
    {
        $query ="SELECT {$parent_field},{$listfields} FROM ".$GLOBALS['PREFIX']."{$table} {$conditions}";
        $result = mysql_query($query);
        $fields=explode(",",$listfields);
        foreach($fields as $field){
            $pos=strpos($field,'as');
            if($pos!==false){
                $field=substr($field,$pos+3);
            }
        }
        while ($row = mysql_fetch_assoc($result)) {
            $name_arr=unserialize($row[$this->serialized]);
            $row[$this->serialized]= $name_arr[$this->language];
            $this->resultArray[$row[$parent_field]][] = $row;
        }
        $prefields=explode(",", $listfields);
        $fields=array();
        foreach($prefields as $field){
            if(strpos($field, ' as ')!==false) {
                $fields[]=substr($field, strpos($field, ' as ')+4);
            }else{
                $fields[]=$field;
            }
        }
        $this->fields=$fields;
        $this->table=$table;
        $this->count=count($this->resultArray[0]);
        return $this->resultArray;
    }

}
