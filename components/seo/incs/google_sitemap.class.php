<?php
class google_sitemap{
	function generate($url,$path,$freq,$priority){
		$dom = new DOMDocument("1.0","utf-8");
		$root1 = $dom->createElement("urlset");
		$dom->appendChild($root1);
		$attr = $dom->createAttribute("xmlns");
		$root1->appendChild($attr);
		$text = $dom->createTextNode("http://www.google.com/schemas/sitemap/0.84");
		$attr->appendChild($text);
		foreach(glob($path."/*.html") as $page){
			$page=str_replace($path."/","",$page);
			$root = $dom->createElement("url");
			$root1->appendChild($root);
			$item = $dom->createElement("loc");
			$root->appendChild($item);
			$text = $dom->createTextNode($url.$page);
			$item->appendChild($text);
			$item = $dom->createElement("lastmod");
			$root->appendChild($item);
			$text = $dom->createTextNode(date("r",time()));
			$item->appendChild($text);
			$item = $dom->createElement("changefreq");
			$root->appendChild($item);
			$text = $dom->createTextNode($freq);
			$item->appendChild($text);
			$item = $dom->createElement("priority");
			$root->appendChild($item);
			$text = $dom->createTextNode($priority);
			$item->appendChild($text);
		}
		$dom->save($path."/sitemap.xml");
	}
}
?>