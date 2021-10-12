<?php

// Copyright (C) 2005 Ilya S. Lyubinskiy. All rights reserved.
// Technical support: http://www.php-development.ru/
//
// YOU MAY NOT
// (1) Remove or modify this copyright notice.
// (2) Distribute this code, any part or any modified version of it.
//     Instead, you may link to the homepage of this code:
//     http://www.php-development.ru/javascripts/smart-forms.php.
// (3) Use this code as part of another product.
//     If you want to do it you should receive my permission.
//
// YOU MAY
// (1) Use this code or any modified version of it on your website.
//
// NO WARRANTY
// This code is provided "as is" without warranty of any kind, either
// expressed or implied, including, but not limited to, the implied warranties
// of merchantability and fitness for a particular purpose. You expressly
// acknowledge and agree that use of this code is at your own risk.


set_time_limit(0);
error_reporting(E_ALL);
ini_set("log_errors",     0);
ini_set("display_errors", 1);

// ----- Parse HTML ------------------------------------------------------------

function enclose($start, $end1, $end2)
{
  return "$start((?:[^$end1]|$end1(?!$end2))*)$end1$end2";
}

function parse($html, &$title, &$text, &$anchors)
{
  $pstring1 = "'[^']*'";
  $pstring2 = '"[^"]*"';
  $pnstring = "[^'\">]";
  $pintag   = "(?:$pstring1|$pstring2|$pnstring)*";
  $pattrs   = "(?:\\s$pintag){0,1}";

  $pcomment = enclose("<!--", "-", "->");
  $pscript  = enclose("<script$pattrs>", "<", "\\/script>");
  $pstyle   = enclose("<style$pattrs>", "<", "\\/style>");
  $pexclude = "(?:$pcomment|$pscript|$pstyle)";

  $ptitle   = enclose("<title$pattrs>", "<", "\\/title>");
  $panchor  = "<a(?:\\s$pintag){0,1}>";
  $phref    = "href\\s*=[\\s'\"]*([^\\s'\">]*)";

  $html = preg_replace("/$pexclude/iX", " ", $html);

  if ($title !== false)
    $title = preg_match("/$ptitle/iX", $html, $title) ? $title[1] : '';

  if ($text !== false)
  {
    $text = preg_replace("/<$pintag>/iX",   " ", $html);
    $text = preg_replace("/\\s+|&nbsp;/iX", " ", $text);
  }

  if ($anchors !== false)
  {
    preg_match_all("/$panchor/iX", $html, $anchors);
    $anchors = $anchors[0];

    reset($anchors);
    while (list($i, $x) = each($anchors))
      $anchors[$i] = preg_match("/$phref/iX", $x, $x) ? $x[1] : '';

    $anchors = array_unique($anchors);
  }
}


// ----- URL Functions ---------------------------------------------------------

// ----- Parse URL -----

function url_parse($url)
{
  $error_reporting = error_reporting(E_ERROR | E_PARSE);
  $url = parse_url($url);
  error_reporting($error_reporting);
  return $url;
}

// ----- Extract Scheme -----

function url_scheme($url, $scheme = 'http')
{
  if(!($url = url_parse($url))) return $scheme;
  return isset($url['scheme']) ? $url['scheme'] : $scheme;
}

// ----- Extract Host -----

define('URL_HOST_APPEND', 1);
define('URL_HOST_STRIP' , 2);

function url_host($url, $lower = true, $www = 0)
{
  if(!($url = url_parse($url))) return '';
  $url = $lower ? strtolower($url['host']) : $url['host'];
  if ($www == URL_HOST_APPEND && strpos($url, 'www.') !== 0) return 'www.' . $url;
  if ($www == URL_HOST_STRIP  && strpos($url, 'www.') === 0) return substr($url, 4);
  return $url;
}

// ----- Extract Path -----

function url_path($url)
{
  if(!($url = url_parse($url))) return '';
  $url = isset($url['path']) ? explode('/', $url['path']) : Array();
  if (reset($url) === '') array_shift($url);
  if (end  ($url) === '' || strpos(end($url), '.') !== false) array_pop($url);
  return implode('/', $url);
}

// ----- Extract Filename -----

function url_file($url, $convert = Array())
{
  if(!($url = url_parse($url))) return '';
  $url = isset($url['path']) ? end(explode('/', $url['path'])) : '';
  $url = (strpos($url, '.') !== false) ? $url : '';
  foreach ($convert as $i => $x) $url = preg_replace($i, $x, $url);
  return $url;
}


// ----- Extract Extension -----

function url_ext($url, $convert = Array())
{
  if(!($url = url_parse($url))) return '';
  $url = isset($url['path']) ? end(explode('/', $url['path'])) : '';
  $url = (strpos($url, '.') !== false) ? end(explode('.', $url)) : '';
  foreach ($convert as $i => $x) $url = preg_replace($i, $x, $url);
  return $url;
}

// ----- Extract Query -----

define('URL_QUERY_NOESCAPE', 0);
define('URL_QUERY_ESCAPE'  , 1);

function url_query($url, $escape = 0, $exclude = Array())
{
  if(!($url = url_parse($url))) return '';
  if (!isset($url['query'])) return '';
  $url = preg_split('/(&(?!amp;)|&amp;)/', $url['query']);

  foreach ($url as $i => $x)
  {
    $x = explode('=', $x);
    if (in_array($x[0], $exclude)) unset($url[$i]);
  }

  return implode($escape ? '&amp;' : '&', $url);
}

// ----- Concat -----

function url_concat($base, $rel)
{
  $scheme = url_scheme($base);
  $host   = url_host  ($base);
  $path   = url_path  ($base);

  if ($rel{0} == '/')
       return "$scheme://$host$rel";
  else if ($path === '')
            return "$scheme://$host/$rel";
       else return "$scheme://$host/$path/$rel";
}

// ----- Normalize -----

function url_normalize($url,
                       $scheme  = 'http',
                       $www     = 0,
                       $convert = Array(),
                       $escape  = 0,
                       $exclude = Array())
{
  $scheme = url_scheme($url, $scheme);
  $host   = url_host  ($url, true, $www);
  $path   = url_path  ($url);
  $file   = url_file  ($url, $convert);
  $query  = url_query ($url, $escape, $exclude);

  if ($scheme === '' || $host === '') return '';

  if ($path === '')
       return "$scheme://$host/$file"       . ($query ? "?$query" : "");
  else return "$scheme://$host/$path/$file" . ($query ? "?$query" : "");
}


// ----- Check Link ------------------------------------------------------------

if (!function_exists('my_get_headers'))
{
  function my_get_headers($url, $follow = 5)
  {
    if ($follow <= 0) return false;

    $url = parse_url($url);
    if (!isset($url['host'])) return false;
    $url['path'] = isset($url['path']) ? $url['path'] : "/";

    $fp = fsockopen($url['host'], 80, $errno, $errstr, 5);
    if (!$fp) return false;

    $out  = "HEAD {$url['path']} HTTP/1.1\r\n";
    $out .= "Host: {$url['host']}\r\n";
    $out .= "Connection: Close\r\n\r\n";

    fwrite($fp, $out);

    for ($headers = ''; !feof($fp); )
    {
      $str = fgets($fp, 4096) . "\r\n";

      if (preg_match("/^HTTP\\/\\d+\\.\\d+\\s+200\\s+OK\\s*$/iX", $str))
      {
        fclose($fp);
        return true;
      }

      if (preg_match("/^Location:\\s*(\\S+)\\s*/$iX", $str, $matches))
      {
        fclose($fp);
        return my_get_headers($matches[1], $follow-1);
      }
    }

    fclose($fp);
    return false;
  }
}

function check($url, $trace = true)
{
  if ($trace)
  {
    echo htmlentities($url), '<br />';
    flush();
  }
  $error_reporting = error_reporting(E_ERROR | E_PARSE);
  $result = my_get_headers($url);
  error_reporting($error_reporting);
  if ($trace)
  {
    echo $result ? ' OK' : ' Битые ссылки' , '<br />';
    flush();
  }
  return $result;
}


// ----- Check Links -----------------------------------------------------------

// INPUT:
//
// $roots      - The function will parse only those URLs that start with
//               a string from $roots array.
// $urls       - Array containing URLs from which to start to spider website.
// $max        - Maximum number of pages to be checked.
// $www        - URL_HOST_APPEND = append "www.", URL_HOST_STRIP = strip "www.".
// $convert    - Array of file conversions.
// $exclude    - Array of names to be excluded from query.
// $extensions - Array of webpage extensions.
//
// OUTPUT:
//
// $errors     - Format:
//               $errors = Array(<page url> => <array of broken links>, ...);
//               <array of broken links> =
//                 Array(<checked url> => <url as extracted from webpage>, ...);
//
// SAMPLE CALL
//
// $result = checkall($roots = Array('http://domain.com/'),
//                    $urls  = Array('http://domain.com/'),
//                    $errors,
//                    1024,
//                    INDEX_HOST_STRIP,
//                    Array('/^index.\\w+$/' => ''),
//                    Array('id'));
//
// Spider only URLs from domain "domain.com".
// Start from URL "http://domain.com/".
// Check up to 1024 webpages.
// Strip "www." from domain names.
// Remove "index.*" from URLs.
// Remove "id" key from queries.

define('INDEX_HOST_APPEND', 1);
define('INDEX_HOST_STRIP',  2);

function checkall($roots, $urls, &$errors,
                  $max        = 1024,
                  $www        = 0,
                  $convert    = Array(),
                  $exclude    = Array(),
                  $extensions = Array('', 'asp', 'aspx', 'cgi', 'htm', 'html', 'php', 'pl'))
{
  $time    = microtime(true);
  $parsed  = 0;
  $errors  = Array('' => Array());
  $checked = Array();

  foreach ($urls as $i => $url)
  {
    $urls[$i] = url_normalize($url, 'http', $www, $convert, 0, $exclude);
    $errors[$url] = Array();
  }

  for ($ind = 0; $ind < count($urls); $ind++)
  {
    if (trim($urls[$ind]) === '')
    {
      unset($urls[$ind]);
      continue;
    }

    // ----- Get Contents -----

    $error_reporting = error_reporting(E_ERROR | E_PARSE);
    $html = file_get_contents($urls[$ind]);
    error_reporting($error_reporting);

    if (!isset($checked[$urls[$ind]]) && $checked[$urls[$ind]] = $html === false)
    {
      $errors[''][$urls[$ind]] = $urls[$ind];
      continue;
    }

    // ----- Parse URL -----

    $parsed++;
    $title = false;
    $text  = false;
    parse($html, $title, $text, $anchors);

    // ----- Extract Anchors -----

    foreach ($anchors as $i => $x)
    {
      // Reduce URL

      $y = preg_replace("/#.*/X", "", $x);
      if ($y == '' || preg_match("/^(\\w)+:(?!\/\/)/X", $y)) continue;
      if (!preg_match("/^(\\w)+:\/\//X", $y)) $y = url_concat($urls[$ind], $y);
      $y = url_normalize($y, 'http', $www, $convert, 0, $exclude);

      // Check URL

      if (!isset($checked[$y]))
      {
        if ($checked[$y] = check($y) === false)
        {
          $errors[$urls[$ind]][$y] = $x;
          continue;
        }
      }
      else if ($checked[$y]) $errors[$urls[$ind]][$y] = $x;

      // Add to parse list

      $in_root = false;
      foreach ($roots as $i => $root)
        $in_root = $in_root || strpos($y, $root) === 0;

      if ($in_root && in_array(url_ext($y), $extensions))
        if (!in_array($y, $urls) && (count($urls) < $max)) $urls[] = $y;
    }
  }

  return Array("time" => microtime(true)-$time, "parsed" => $parsed, "checked" => count($checked));
}


// ----- Use It ----------------------------------------------------------------

// ----- HTML -----

?>

<!DOCTYPE html PUBLIC
          "-//W3C//DTD XHTML 1.0 Transitional//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>

<title>Link Checker</title>

<style type="text/css">

table { border-collapse: collapse; }

td    { padding: 0px 5px 1px 0px; }

li { padding-bottom: 2px; }

a.header
{
  text-decoration: none;
  font-weight: 900;
  color: #0000A0;
}

a.broken
{
  text-decoration: none;
  color: #006000;
}

</style>

<script type="text/javascript">

var scrollstop = false;

function scrolltoend()
{
  scrollBy(0, 1000);
  scrollBy(0, 1000);
  if (!scrollstop) setTimeout("scrolltoend()", 10);
}

scrolltoend();

</script>

</head>
<body onload="scrollstop = true;">

<h3>Link Checker</h3>

<?php

// ----- Check Links -----

$roots    = Array($_POST['url'],
                  url_normalize($_POST['url'], 'http', URL_HOST_APPEND),
                  url_normalize($_POST['url'], 'http', URL_HOST_STRIP));
$urls     = Array($_POST['url']);

$maxpages = (integer)$_POST['maxpages'];
if (($_SERVER['SERVER_NAME'] == 'localhost') ||
    ($_SERVER['SERVER_NAME'] == 'php-development.ru') ||
    ($_SERVER['SERVER_NAME'] == 'www.php-development.ru'))
  if ($maxpages > 8) $maxpages = 8;

$host     = 0;
if ($_POST['www'] == "strip" ) $host = INDEX_HOST_STRIP;
if ($_POST['www'] == "append") $host = INDEX_HOST_APPEND;

$index    = Array();
if ($_POST['index'] == "strip" ) $index = Array('/^index.\\w+$/' => '');
if ($_POST['index'] == "append") $index = Array('/^$/' => $_POST['index_append']);

$exclude  = preg_split('/\\s+/', $_POST['ses']);

$external = isset($_POST['external']);

$ext      = preg_split('/\\s+/', $_POST['ext']);
$ext[]    = '';

$result   = checkall($roots, $urls, $errors, $maxpages, $host, $index, $exclude, $ext);

// ----- Results -----

?>

<h4>Результат</h4>

<table>

<tr>
  <td>Root&nbsp;location:</td>
  <td><?=$_POST['url'];?></td>
</tr>
<tr>
  <td>Execution&nbsp;time:</td>
  <td><?=number_format($result['time'], 2, '.', '');?> secs</td>
</tr>
<tr>
  <td>Pages&nbsp;Parsed:</td>
  <td><?=$result['parsed'];?></td>
</tr>
<tr>
  <td>URLs&nbsp;Checked:</td>
  <td><?=$result['checked'];?></td>
</tr>
</table>

<h4>Битые ссылки</h4>

<ol>

<?php

// ----- Broken Links -----

ksort($errors);
foreach ($errors as $i => $x)
  if (count($x))
  {
    echo '<li>';
    echo "<a class=\"header\" href=\"$i\">" . htmlentities($i) . "</a><br />";
    foreach ($x as $j => $y)
      echo "<a class=\"broken\" href=\"$j\">" . htmlentities($y) . "</a><br />";
    echo '</li>';
  }

?>

</ol>

</body>
</html>
