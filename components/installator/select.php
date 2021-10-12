<?php
$res=mysql_query("select a.*,$queries from table as a,lang as b where a.id=b.rel_id and b.table_name='$table' and b.language='{$GLOBALS['userlanguage']}'");
while($row=mysql_fetch_assoc($res)){
	
}