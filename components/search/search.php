<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 

foreach($_GET as $k=>$v) {
    $_GET[$k]=mb_strtolower($_GET[$k], 'utf8');
}

if (isset($_GET['frm_searchfield']) && strlen(trim($_GET['frm_searchfield'])) > 2) {
    //category
    $phrase = htmlspecialchars(mysql_escape_string($_GET['frm_searchfield']));
    $ph = $phrase;
    $phrase = str_replace(" ", "%", $phrase);

    set_title($GLOBALS['dblang_searchResult'][$GLOBALS['userlanguage']]." '$ph'");
    render_to_template("components/catalog/template.tableHeader.php", array('title' => $GLOBALS['dblang_searchResult'][$GLOBALS['userlanguage']]." '$ph'", 'tt' => 1,'showimg'=>1));
    //get all items from this position
    $country = "%%";
    $rez = mysql_query("SELECT DISTINCT country FROM ".$PREFIX."catalog_items");
    while ($roz = mysql_fetch_row($rez)) {
        if (strpos(mb_strtolower($phrase, 'UTF-8'), mb_strtolower($roz[0], 'UTF-8')) !== false) {
            $country = mb_strtolower("%" . $roz[0] . "%", 'UTF-8');
            $phrase = str_replace(mb_strtolower($roz[0], 'UTF-8'), "", $phrase); 
        }
    }
    $qmodel="";
    $amodels=Array("daf"=>"Daf","iveco"=>"Iveco","man"=>"Man","renault"=>"Renault","scania"=>"Scania","volvo"=>"Volvo","mercedes"=>"M-B","даф"=>"Daf","ивеко"=>"Iveco","ман"=>"Man","рено"=>"Renault","скания"=>"Scania","вольво"=>"Volvo","мерседес"=>"M-B");
    foreach($amodels as $akey=>$aval){
        if (strpos(mb_strtolower($phrase, 'UTF-8'), $akey) !== false) {
            $qmodel=" AND (d.name LIKE '%".$aval."%' OR d.altname LIKE '%".$aval."%')";
            $phrase=str_replace($akey, "", $phrase);
        }
    }    
    $res2 = mysql_query(
        "SELECT b.id AS bid, b.name AS bname, a.id, a.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity, b.description, d.name AS brandname, d.altname AS altbrandname, b.available, b.waitingfor, b.country
							FROM ".$PREFIX."catalog_models AS c, ".$PREFIX."catalog_brands AS d, ".$PREFIX."catalog_items AS b
							LEFT JOIN ".$PREFIX."catalog_items2 AS a ON b.name = a.linked_item
							WHERE b.model_id = c.id AND b.brand_id = d.id AND b.waitingfor!='архив' AND
							(a.name LIKE '%$phrase%' OR a.description LIKE '%$phrase%' OR a.keywords LIKE '%$phrase%' 
							OR b.description LIKE '%$phrase%' OR b.oem LIKE '%$phrase%' OR b.oem_variants LIKE '%$phrase%' OR b.name LIKE '%$phrase%' 
							OR c.name LIKE '%$phrase%' OR c.altname LIKE '%$phrase%') AND LOWER(b.country) LIKE '$country'".$qmodel." ORDER BY d.name,c.name,b.description"
    );

    $s = 0;
    while ($row2 = mysql_fetch_row($res2)) {
        $s++;
        if ($row2[3]) { $row2[1] = $row2[3];
        }
        if ($row2[6]) { $row2[5] = $row2[6];
        }
        if ($row2[11]) { $row2[10] = $row2[11];
        }

        ///////////
        //echo $row2[12]."av - wf ".$row2[13]."<br />";
        if($row2[12]>0) {
            $av=0;
        } elseif($row2[13]!="") {
            $av=2;
        } else {
            $av=1;
        }
        ////////////////


        render_to_template("components/catalog/template.tableIn1.php", array('id' => $row2[0], 'name' => $row2[1], 'oem' => $row2[4], 'btitle' => $row2[10], 'ftitle' => $row2[5], 'model' => $row2[5], 'price' => $row2[7], 'quantity' => $row2[8], 'description' => $row2[9], 'av' => $av, 'sid' => $row2[2], 'country' => $row2[14], 'mlinks' => 1,'showimg'=>1));
    }
    if ($s == 0) { echo "<tr><td colspan=8>".$GLOBALS['dblang_searchResult'][$GLOBALS['userlanguage']]."</td></tr>";
    }
        
    render_to_template("components/catalog/template.tableFooter.php", array());
    
} elseif (isset($_GET['frm_asearch_brand'])) {
    $brand = htmlspecialchars(mysql_escape_string($_GET['frm_asearch_brand']));
    $model = htmlspecialchars(mysql_escape_string($_GET['frm_asearch_model']));
    $oem = htmlspecialchars(mysql_escape_string($_GET['frm_asearch_oem']));
    $country = htmlspecialchars(mysql_escape_string($_GET['frm_asearch_country']));
    $description = htmlspecialchars(mysql_escape_string($_GET['frm_asearch_description']));
    $error = 0;
    
    if (!(strlen($brand) >= 3 || strlen($model) >=3 || strlen($oem) >= 3 || strlen($description) >= 3 || strlen($country) >= 3)) {
        $error = 1;
    }
    
    set_title($GLOBALS['dblang_sExtended'][$GLOBALS['userlanguage']]);
    render_to_template("components/search/template.search.php", array('brand' => $brand, 'model' => $model, 'oem' => $oem, 'description' => $description, 'country' => $country, 'error' => $error));
    
    if (strlen($brand) >= 3 || strlen($model) >= 1 || strlen($oem) >= 3 || strlen($description) >= 3 || strlen($country) >= 3) {
        $res2 = mysql_query(
            "SELECT b.id AS bid, b.name AS bname, a.id, a.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity, b.description, d.name AS brandname, d.altname AS altbrandname, b.available, b.waitingfor, b.country
							FROM ".$PREFIX."catalog_models AS c, ".$PREFIX."catalog_brands AS d, ".$PREFIX."catalog_items AS b
							LEFT JOIN ".$PREFIX."catalog_items2 AS a ON b.name = a.linked_item
							WHERE b.model_id = c.id AND b.brand_id = d.id AND b.waitingfor!='архив' AND
							(
								(a.description LIKE '%$description%' OR b.description LIKE '%$description%') AND
								(d.name LIKE '%$brand%' OR d.altname LIKE '%$brand%') AND
								(c.name LIKE '%$model%' OR c.altname LIKE '%$model%') AND
								(b.oem LIKE '%$oem%' OR b.oem_variants LIKE '%$phrase%') AND b.country LIKE '%$country%'
							)
							"
        );
                            
        render_to_template("components/catalog/template.tableHeader.php", array('title' => "Результаты поиска", 'tt' => 1,'showimg'=>1));
        while ($row2 = mysql_fetch_row($res2)) {
            $s++;
            if ($row2[3]) { $row2[1] = $row2[3];
            }
            if ($row2[6]) { $row2[5] = $row2[6];
            }


            ///////////
            //echo $row2[12]."av - wf ".$row2[13]."<br />";
            if($row2[12]>0) {
                $av=0;
            } elseif($row2[13]!="") {
                $av=2;
            } else {
                $av=1;
            }
            ////////////////


            render_to_template("components/catalog/template.tableIn.php", array('id' => $row2[0], 'name' => $row2[1], 'oem' => $row2[4], 'btitle' => $row2[10], 'ftitle' => $row2[5], 'model' => $row2[5], 'price' => $row2[7], 'quantity' => $row2[8], 'description' => $row2[9], 'av' => $av, 'sid' => $row2[2], 'country' => $row2[14],'showimg'=>1));
        }
        render_to_template("components/catalog/template.tableFooter.php", array());
        
    } else { $error = 1;
    }
}
    
else {
    set_title($GLOBALS['dblang_sExtended'][$GLOBALS['userlanguage']]);
    render_to_template("components/search/template.search.php", array('brand' => '', 'model' => '', 'oem' => '', 'description' => '', 'error' => 0));
}
?>
