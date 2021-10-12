</tbody>
</table>
<?php
if(strpos($_GET['id'], "plastic")===false && strpos($_GET['view'], "search")===false && strpos($_GET['view'], "action")===false && strpos($_GET['id'], "waitingfor")===false && strpos($_GET['id'], "bamper")===false && strpos($_GET['id'], "wings")===false && strpos($_GET['id'], "cowl")===false && strpos($_GET['id'], "grille")===false && strpos($_GET['id'], "step")===false) {
    if($_GET['stat']=='archive') {
        $page=str_replace("&stat=archive", "", $_SERVER['REQUEST_URI']); 
        $link="<a href=\"$page\">в продаже</a>";
    } else {
        $page=$_SERVER['REQUEST_URI']."&stat=archive";
        $link="<a href=\"$page\">архив деталей, временно не поставляемых см. здесь &gt;&gt;</a>";
    }
    echo $link;
}
?>
</div>