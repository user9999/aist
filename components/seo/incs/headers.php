<?php
class headers extends vars{
  public $headers;//application/xhtml+xml
  function __construct(){
    $this->headers="Content-Type: ".$this->mime."; charset=".$this->charset;
  }
  public function output(){
    header($this->headers);
  }
}
?>