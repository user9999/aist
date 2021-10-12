<?php
class xml
{
    public $head;
    public $foot;
    public $type;
    public $content="";
    public $date;
    public $old="";
    public function xml($type, $title="", $link="", $description="", $atom="")
    {
        if ($atom=="") {
            $this->atom="http://".$_SERVER['SERVER_NAME']."/rss.html";
        } else {
            $this->atom=$atom;
        }
        $this->type=$type;
        if ($type=="map") {
            $this->date=date("Y-m-d", time());
        } else {
            $this->date=date("r", time());
        }
        switch ($type) {
        case "rss":
            $this->head="<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\"><channel><atom:link href=\"".$this->atom."\" rel=\"self\" type=\"application/rss+xml\" />\r\n<title>".$title."</title>\r\n<link>".$link."</link>\r\n<description>".$description."</description>\r\n<lastBuildDate>".$this->date."</lastBuildDate>\r\n<pubDate>".$this->date."</pubDate>";//iconv("CP1251","UTF-8",$description)
            $this->foot="</channel></rss>";
            break;
        case "map":
            if (file_exists("sitemap.xml")) {
                $this->old=str_replace("</urlset>", "", implode(file("sitemap.xml")));
            }
            $this->head="<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n";
            $this->foot="</urlset>";
            break;
        }
    }
    public function element($title, $link, $description="", $pubdate="")
    {
        $this->date=($pubdate=="")?$this->date:$pubdate;
        switch ($this->type) {
        case "rss":
            $item="\r\n<item><guid>".$link."</guid><title>".$title."</title><link>".$link."</link><description><![CDATA[ ".$description." ]]></description><pubDate>".$this->date."</pubDate></item>";
            break;
        case "map":
            $item="<url><loc>".htmlspecialchars($link)."</loc><changefreq>".$title."</changefreq><priority>".$description."</priority></url>\r\n";//<lastmod>".$this->date."</lastmod>
            break;
        }
        $this->content.=$item;
    }
    public function update($title, $link, $description)
    {
        $this->head="";
        $item="<url><loc>".$link."</loc><lastmod>".$this->date."</lastmod><changefreq>".$title."</changefreq><priority>".$description."</priority></url>\r\n";
        $this->content.=$item;
    }
    public function save($fname="")
    {
        $x=$this->head.$this->old.$this->content.$this->foot;
        switch ($this->type) {
        case "rss":
            $file=($fname=="")?"rss.xml":$fname.".xml";
            break;
        case "map":
            $file=($fname=="")?"sitemap.xml":$fname.".xml";
            break;
        }
        $fp=fopen($file, "w+");
        fwrite($fp, $x);
        fclose($fp);
    }
    public function out()
    {
        $x=$this->head.$this->old.$this->content.$this->foot;
        return $x;
    }
}
