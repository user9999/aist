<?php
require_once 'Visitor.php';

class Json implements Visitor
{
    public function __construct() {
        
    }

    public function format(QueryTables $QueryTables)
    {
        return json_encode($QueryTables->resultArray, JSON_UNESCAPED_UNICODE);
    }
}