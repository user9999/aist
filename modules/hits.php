<?php
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}
$res = mysql_query("select name, title, url, description,type from ".$PREFIX."frontpage where display=1 and type!='image' order by position");
$i=0;$out="";

while ($row=mysql_fetch_assoc($res)) {
    if ($i%3==0) {
        $out.="<div class=\"hits-row clearfix\">";
    }
    if ($row['type']=='product') {
        $id=substr($row['url'], (strpos($row['url'], 'item-')+5));
        $res1 = mysql_query("select a.id,a.price,a.provider from ".$PREFIX."catalog_items as a, ".$PREFIX."catalog_items2 as b where a.name=b.linked_item and b.id=".$id." limit 1");
        $row1=mysql_fetch_row($res1);
    }
    $out.="<div class=\"hits-col\">
							<div class=\"hits-block\">
								<a href=\"".$row['url']."\" class=\"hits-block-img tooltips\">
									<img src=\"/uploaded/front/".$row['name']."\" alt=\"\"><span>".$row['description']."</span>
								</a>
								<div class=\"hits-block-content clearfix\">
									<div class=\"hits-block-desc\">
										<h3 class=\"hits-block-title\">
											<a href=\"".$row['url']."\">".$row['title']."</a>
										</h3>
										<div class=\"hits-block-price\"><span class='h-price'>".$row1[1]."р. </span>/ ".$row1[2]."</div>
									</div>
									<button class=\"to-basket\" onclick=\"addToCart({$row1[0]}, {$row1[1]}, '');\"></button>
									<input type=hidden id=\"i{$row1[0]}\" value=\"1\">
								</div>
							</div>
						</div>";
    if (($i+1)%3==0) {
        $out.="</div>";
    }
    $i++;
}
echo $out;
