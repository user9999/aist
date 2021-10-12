<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
<title>автосерфинг</title>
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="" />
<meta name="copyright" content="" />
<meta name="generator" content="" />
<meta name="reply-to" content="" />
</head>
<?php

?>
<frameset rows="100,*">
<frame src="subframe.php?url=<?=$fr_var;?>&id=<?=$id;?>&ref_site=<?=$ref_site;?>" name="subframe" />
<frame src="submit.php?url=<?=$var;?>" name="subgo" />
</frameset>
</html>