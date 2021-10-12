<?php
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
} ?>
<?php
//var_dump($GLOBALS[LANGUAGES]);
$out="";
foreach ($GLOBALS[LANGUAGES] as $name=>$path) {
    if ($GLOBALS[LDISPLAY][$name]==1) {
        $link=($path=='default')?" ".$name." /":"<img src='{$path}' alt='{$name}'>";
        $out.="<a href=\"#\" onclick=\"setL('{$name}')\">$link</a>";
    }
}


echo $out;
?>
<script>
function setL(lang) {
$.cookie("language", lang, {expires: 360, path: '/'});
window.location.reload();
}
</script>