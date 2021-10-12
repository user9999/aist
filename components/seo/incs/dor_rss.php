<?php
if($this->rss_count=0){
	$title=explode(",",$key);
	$this->rss_title=$title[0];
	$this->rss_count++;
} elseif($this->rss_count>0 && $this->rss_count<9){



}
if($this->rss_count==19 || ($this->pg_amt-2)==$this->rss_cycle){
	$dom = new DOMDocument("1.0","utf-8");
	$root1 = $dom->createElement("rss");
	$dom->appendChild($root1);
	$pr = $dom->createAttribute("version");
	$root1->appendChild($pr);
	$prValue = $dom->createTextNode("2.0");
	$pr->appendChild($prValue);
	$root = $dom->createElement("channel");
	$root1->appendChild($root);
}
$this->rss_cycle++;
?>