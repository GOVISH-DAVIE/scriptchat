<?php //config.php
require_once('config.php');

error_reporting(E_ALL);


$pass  = 'password';
$hash1 = password_hash($pass, PASSWORD_DEFAULT);
$hash2 = password_hash($pass, PASSWORD_DEFAULT);
$hash3 = password_hash($pass, PASSWORD_DEFAULT);

$out = <<<EOD
<pre>
<p>PHP password_hash('$pass') yields
$hash1
$hash2
$hash3
</p>
EOD;

echo $out;

