<?php
require_once "../inc/configuration.php";
require_once "../inc/functions.php";
$table="queries";
$field='phrase';
if (!empty($_POST['search'])) {
    $post=mysql_real_escape_string(trim($_POST['search']));
    if(strpos($post, " ")!=false) {
        $parts=explode(' ', $post);
        array_unshift($parts, $post);
        foreach($parts as $part){
            $word=switcher($part, 1);
            $queries[]=$word;
            $qparts[]="SELECT * FROM ".$PREFIX."{$table} WHERE ".$field."  LIKE '".$word."%'";
        }
        $where="'".implode("%' or ".$field." LIKE '", $queries)."%'";
        $fullquery=implode(" UNION ", $qparts);
    }else{
        $word=switcher($post, 1);
        $where="'".$word."%'";
        $fullquery="SELECT * FROM ".$PREFIX."{$table} WHERE {$field} LIKE {$where}";
    }

    $result=mysql_query($fullquery);
    if ($result) {
        ?>
        <div class="search_result">
            <table>
        <?php 
        $categories=array();
        while($row=mysql_fetch_array($result)){                     
            $category=unserialize($row['url']);
            $categories=array_merge($categories, $category);
        }
        array_unique($categories);
        foreach($categories as $url=>$name){
        ?>
                <tr>
                    <td class="search_result-name">
                        <a href="<?php echo $url ?>"><?php echo $name; ?></a>
                    </td>
                    <td class="search_result-btn">
                        <a href="<?php echo $url; ?>">Перейти</a>
                    </td>
                </tr>
        <?php 
        }
        ?>
            </table>
        </div>
        <?php
    }
}
