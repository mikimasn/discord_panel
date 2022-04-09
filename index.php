<?php
$ist=false;
if(isset($_COOKIE['token']))
{
    $ist = true;
    $token = $_COOKIE['token'];
}
if(!$ist){
echo file_get_contents('notlogin.html');
}
else
{
    require_once 'panell.php';
}
?>