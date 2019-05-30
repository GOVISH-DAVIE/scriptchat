<?php //create.php
require_once('config.php');
$sql
= "CREATE TABLE users
( _key INT         NOT NULL AUTO_INCREMENT
, uid  VARCHAR(16) NOT NULL DEFAULT '?'
, pwd  VARCHAR(16) NOT NULL DEFAULT '?'
, uuk  VARCHAR(32) NOT NULL DEFAULT '?'
, PRIMARY KEY (_key)
)
"
;
if (!$res = $mysqli->query($sql)) trigger_error( $mysqli->error, E_USER_ERROR );

