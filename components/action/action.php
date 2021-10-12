<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
        
        render_to_template("components/catalog/template.tableHeader.php", array('title' => "<a href='{$GLOBALS[PATH]}/action'>Акции</a> ", 'showimg' => 1));

        $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,    b.waitingfor, b.description, b.special, b.available, b.country,a.name as brandname,a.altname as altbrandname FROM ".$PREFIX."catalog_brands as a, ".$PREFIX."catalog_items AS b, ".$PREFIX."catalog_models AS c WHERE b.model_id = c.id AND a.id=b.brand_id AND b.special!='' AND b.special!='0' ORDER BY a.name,c.name,b.description");
    
        $s = 0;
while ($row2 = mysql_fetch_row($res2)) {
    $s++;
    if ($row2[4]) { $row2[3] = $row2[4];
    }
    if ($row2[13]) { $row2[12] = $row2[13];
    }        
    $sid = 0;
    $res3 = mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item = '{$row2[1]}'");
    if ($r3 = mysql_fetch_row($res3)) {
        $row2[1] = $r3[1];
        $sid = $r3[0];
    }
    if($row2[10]>0) {
        $av=0;
    } elseif($row2[7]!="" && $row2[7]!=0) {
        $av=2;
    } else {
        $av=1;
    }
    render_to_template("components/catalog/template.tableIn1.php", array('ftitle' => $row2[3], 'btitle' => $row2[12], 'id' => $row2[0], 'name' => $row2[1], 'oem' => $row2[2], 'model' => $row2[3], 'price' => $row2[5], 'quantity' => $row2[6], 'description' => $row2[8], 'av' => $av, 'country' => $row2[11], 'sid' => $sid, 'showimg' => 1, 'action' => $row2[9]));
    
}
render_to_template("components/catalog/template.tableFooter.php", array());
?>
