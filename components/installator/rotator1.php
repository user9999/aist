<?php
if (!defined("SIMPLE_CMS")) die("Access denied"); 
$res=mysql_query("SELECT * FROM ".$PREFIX."frontpage where display=1 and type='image' order by position");
if(mysql_num_rows($res)==0){

} else {
?>
<div class="main-slider-wrapp">
	<div class="main-slider">
<?php
  while($row=mysql_fetch_row($res)){
	echo "<div class=\"main-slide\"><a href='{$row[5]}'><img src=\"/uploaded/front/".$row[1]."\" alt=\"".$row[2]."\"></a></div>";
  
  }
}
?>
</div>
</div>
