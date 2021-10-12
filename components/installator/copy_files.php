<?php
function copy_files($path, $layoutdir, $layout_name)
{
    global $HOSTPATH;
    if (is_dir($path)) { // dir
        $path=rtrim($path, "/");
        $mkpath=str_replace("/!layout/{$layout_name}/", "/templates/{$layoutdir}/", $path);

        if (!is_dir($mkpath)) {
            mkdir($mkpath);
        }

        $dir = opendir($path);
        while ($item = readdir($dir)) {
            if ($item == '.' || $item == '..') {
                continue;
            }
         
            copy_files($path.'/'.$item, $layoutdir, $layout_name);
        }
      
        closedir($dir);
    } else {
        $copy=str_replace("/!layout/{$layout_name}/", "/templates/{$layoutdir}/", $path);
        if (!file_exists($copy)) {
            copy($path, $copy);
        }
    }
}
