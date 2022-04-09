<?php
$url= $_SERVER['REQUEST_URI'];
$sklad=explode('/',$url);
if($sklad[2]!="guild"||count($sklad)<3)
{
echo file_get_contents('404.html');
}
?>