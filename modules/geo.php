<?php
require $HOSTPATH."/inc/cities.php";
foreach ($acities as $key => $value) {
    $options.="<option vakue=$key>$key</option>";
}
if ($acities[$_COOKIE['city']]) {
    $c=$city=$_COOKIE['city'];
} else {
    include $HOSTPATH."/inc/API/SxGeo.php";
    $SxGeo = new SxGeo($HOSTPATH.'/inc/API/SxGeoCity.dat');
    $ip = $_SERVER['REMOTE_ADDR'];
    $user=$SxGeo->get($ip);
    $city=iconv("Windows-1251", "UTF-8", $user['city']['name_ru']);
    $c='notfound';
    foreach ($acities as $key => $value) {
        if ($key == $city) {
            $c=$city;
            break;
        }
    }
}
setcookie("pre", $city, time()+60*60*24);
