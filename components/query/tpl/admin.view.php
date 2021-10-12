<table class="admin menu">
    <tr class="caption"><td>фраза</td><td>ссылка</td><td>Действия</td></tr>
<?php
foreach($TEMPLATE as $num=>$data){
?>     
    <tr><td><?php echo $data['phrase']?></td><td><?php echo $data['url']?></td><td><a href="/admin/?component=query&amp;action=Edit&amp;table=queries&amp;edit=<?php echo $data['id']?>">edit</a> <a href="/admin/?component=query&amp;del=<?php echo $data['id']?>">delete</a> </td></tr>
<?php
}
?>
            
</table>
