<?php // .php
require_once('register.php');
error_reporting(E_ALL);

class Password
{
    public static function hash($pass, $algo=PASSWORD_DEFAULT)
    {
        $text = trim($pass);
        return password_hash($pass, $algo);
    }

    public static function verify($pass, $hash)
    {
        return password_verify($pass, $hash);
    }
}


// INITIALIZE VARS FOR LATER USE IN THE HTML FORM
$pass = $hash = NULL;

// IF ANYTHING WAS POSTED SHOW THE DATA
if (!empty($_POST['pass']))
{
    $pass = $_POST['pass'];
    $hash = Password::hash($pass);
    echo "<br/>PASSWORD <b>$pass</b> YIELDS HASH ";
    echo "<i>$hash</i>";
}

if (!empty($_POST['hash']))
{
    $result = Password::verify($_POST['pass'], $_POST['hash']);
    if  ($result) echo "<br/>PASSWORD <b>{$_POST['pass']}</b>       PASSES        VERIFICATION WITH HASH <i>{$_POST['hash']}</i> ";
    if (!$result) echo "<br/>PASSWORD <b>{$_POST['pass']}</b> <b><i>FAILS</i></b> VERIFICATION WITH HASH <i>{$_POST['hash']}</i> ";
}


// CREATE THE FORM USING HEREDOC NOTATION
$form =<<<FORM
    "text/css">
.txt { width:60em; }
</style>

<form method="post">
<br><br>
<input class="txt" name="pass" value="$pass" autocomplete="off" />
<input type="submit" value="HASH THIS PASSWORD" />
<br><br>
<input class="txt" name="hash" value="$hash" autocomplete="off" />
<input type="submit" value="VERIFY $pass WITH THIS HASH" />
</form>
FORM;

echo $form;