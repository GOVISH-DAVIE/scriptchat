<?php // controlled.php
require_once('config.php');

// ACCESS TO THIS PAGE IS CONTROLLED
$uid = access_control();

echo "<br/>HELLO $uid AND WELCOME TO THE ACCESS CONTROLLED PAGE";

