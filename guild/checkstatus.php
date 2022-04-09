<?php
error_reporting(0);
require_once '../function.php';
$id=$_POST['id'];
$end = "";
if(is_auth())
{
    if(have_ac_guild($id))
    {
        $end.="1;";
    }
    else
    {
        die("0;");
    }
}
else
{
    die("0;");
}
echo $end;
?>