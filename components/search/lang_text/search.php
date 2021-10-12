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
    //render_to_template("components/catalog/template.tableHeader.php", array('title' => $GLOBALS['dblang_searchResult'][$GLOBALS['userlanguage']]." '$ph'", 'tt' => 1,'showimg'=>1));
    //get all items from this position
    /*
    $res2 = mysql_query("SELECT b.id AS bid, b.name AS bname, a.id, a.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity, b.description, d.name AS brandname, d.altname AS altbrandname, b.available, b.waitingfor, b.country
                            FROM ".$PREFIX."catalog_models AS c, ".$PREFIX."catalog_brands AS d, ".$PREFIX."catalog_items AS b
                            LEFT JOIN ".$PREFIX."catalog_items2 AS a ON b.name = a.linked_item
                            WHERE b.model_id = c.id AND b.brand_id = d.id AND b.waitingfor!='архив' AND
                            (a.name LIKE '%$phrase%' OR a.description LIKE '%$phrase%' OR a.keywords LIKE '%$phrase%' 
                            OR b.description LIKE '%$phrase%' OR b.oem LIKE '%$phrase%' OR b.oem_variants LIKE '%$phrase%' OR b.name LIKE '%$phrase%' 
                            OR c.name LIKE '%$phrase%' OR c.altname LIKE '%$phrase%') AND LOWER(b.country) LIKE '$country'".$qmodel." ORDER BY d.name,c.name,b.description");

    $s = 0;
    while ($row2 = mysql_fetch_row($res2)) {
    $s++;
    if ($row2[3]) $row2[1] = $row2[3];
    if ($row2[6]) $row2[5] = $row2[6];
    if ($row2[11]) $row2[10] = $row2[11];

    ///////////
    //echo $row2[12]."av - wf ".$row2[13]."<br />";
    if($row2[12]>0){
                $av=0;
    } elseif($row2[13]!=""){
                $av=2;
    } else {
                $av=1;
    }
    ////////////////
    */
    $query="SELECT * from ".$PREFIX."lang_text where language='{$GLOBALS['userlanguage']}' AND (title LIKE '%$phrase%' OR short LIKE '%$phrase%' OR content LIKE '%$phrase%' OR description LIKE '%$phrase%')";
    $res2 = mysql_query($query);
    //echo $query;
    render_to_template("components/search/template.searchHeader.php", array('phrase' => $phrase));
    if(mysql_num_rows($res2)>0) {
        while ($row2 = mysql_fetch_array($res2)) {
            render_to_template("components/search/template.searchContent.php", $row2);
        }
    } else {
        render_to_template("components/search/template.searchNone.php", array());
    }
    //$myrow['phrase']=$phrase;
    //var_dump($myrow);
    //echo "asdasdasd";
    render_to_template("components/search/template.searchFooter.php", array());
} else {
    set_title($GLOBALS['dblang_sExtended'][$GLOBALS['userlanguage']]);
    render_to_template("components/search/template.search.php", array('brand' => '', 'model' => '', 'oem' => '', 'description' => '', 'error' => 0));
}
?>
