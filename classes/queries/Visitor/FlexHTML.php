<?php
require_once 'Visitor.php';

class FlexHtml implements Visitor
{
    private $flexClass="flex-tablerow";
    private $flexCaption="flex-tablecaption";
    private $queryObject=null;
    private $actions='';
    private $out="";
    
    public function __construct(Array $values=null) 
    {
        if(isset($values[0]) && $values[0]!=''){
            $this->flexClass=$values[0];
        }
        if(isset($values[1])){
            $this->actions=$values[1];
        }
    }

    public function format(QueryTables $QueryTables)
    {
        $this->queryObject=$QueryTables;
        if($QueryTables->titles){
            $this->out.="<ul class='{$this->flexClass} {$this->flexCaption}'>";
            foreach ($QueryTables->titles as $n=>$title) {
                $this->out.="<li>{$title}</li>";
            }
            if($this->actions){
                $this->out.="<li>actions</li>";
            }
            $this->out.="</ul>";
        }
        //print_r($QueryTables->fields);
        foreach($QueryTables->resultArray as $num=>$value){
           $this->out.="<ul id='row{$num}' class='{$this->flexClass}'>";
           $this->makeFields($value); 
           $this->out.="</ul>";
        }
        return $this->out;
    }
    private function makeFields($value)
    {
        foreach ($this->queryObject->fields as $num=>$name){
            $this->out.="<li>".$value[$name]."</li>";

        }
        if($this->actions){
            $this->out.="<li>";
            
            foreach ($this->actions as $link=>$field){
                $act=substr($link,strrpos($link,'&',-1)+1,-1);
                $this->out.="<a title='{$act}' class='{$act}' href='{$link}$value[$field]'>{$act}</a> ";
            }
           $this->out.="</li>";
        }
        
    }
}