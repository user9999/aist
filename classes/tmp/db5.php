<?php
$link = mysqli_connect($DATABASE_HOST, $DATABASE_LOGIN, $DATABASE_PASSWORD)
    or die('Could not connect');
$db = mysqli_select_db($DATABASE_NAME, $link)
    or die('Could not select db');

mysqli_query('SET NAMES utf8');
mysqli_query('SET character_set_server=utf8');