<?php
require_once 'Visitor.php';

class TableHtml implements Visitor
{
    private $tableClass='';
    private $queryObject=null;
    private $actions='';
    private $out="";
    
    public function __construct(Array $values=null) 
    {
        if(isset($values[0]) && $values[0]!=''){
            $this->tableClass=$values[0];
        }
        if(isset($values[1])){
            $this->actions=$values[1];
        }
    }

    public function format(QueryTables $QueryTables)
    {
        $this->queryObject=$QueryTables;
        $this->out="<table class='{$this->tableClass}'>";
        if($QueryTables->titles){
            $this->out.="<tr class='caption'>";
            foreach ($QueryTables->titles as $n=>$title) {
                $this->out.="<td>{$title}</td>";
            }
            if($this->actions){
                $this->out.="<td>actions</td>";
            }
            $this->out.="</tr>";
        }
        //print_r($QueryTables->fields);
        foreach($QueryTables->resultArray as $num=>$value){
           $this->out.="<tr id='row{$num}' class='{$this->flexClass}'>";
           $this->makeFields($value); 
           $this->out.="</tr>";
        }
        $this->out.="</table>";
        return $this->out;
    }
    private function makeFields($value)
    {
        foreach ($this->queryObject->fields as $num=>$name){
            $this->out.="<td>".$value[$name]."</td>";

        }
        if($this->actions){
            $this->out.="<td>";
            
            foreach ($this->actions as $link=>$field){
                $act=substr($link,strrpos($link,'&',-1)+1,-1);
                $this->out.="<a title='{$act}' class='{$act}' href='{$link}$value[$field]'>{$act}</a> ";
            }
           $this->out.="</td>";
        }
        
    }
}