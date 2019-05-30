<?php //public.php
require_once('config.php');

// ACCESS TO THIS PAGE IS TESTED BUT NOT CONTROLLED
if ($uid = access_control(TRUE))
{
    echo "<br/>HELLO $uid AND WELCOME TO THE PUBLIC PAGE";
}
else
{
    echo "<br/>HELLO THERE.";
    echo "<br/>YOU MIGHT WANT TO <a href=\"register.php\">REGISTER</a> ON THIS SITE";
    echo "<br/>IF YOU ARE ALREADY REGISTERED, YOU CAN <a href=\"login.php\">LOG IN HERE</a>";
}



