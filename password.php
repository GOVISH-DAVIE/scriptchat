<?php //password.php
require_once('config.php');

// ACCESS TO THIS PAGE IS CONTROLLED
$uid = access_control();

// WE ASSUME NO ERRORS OCCURRED
$err = NULL;

// WAS EVERYTHING WE NEED POSTED TO THIS SCRIPT?
if ( (!empty($_POST["old"])) && (!empty($_POST["pwd"])) && (!empty($_POST["vwd"])) )
{
    // YES, WE HAVE THE NEEDED DATA. ESCAPE IT FOR USE IN A QUERY
    $uid = $mysqli->real_escape_string($uid);
    $old = $mysqli->real_escape_string($_POST["old"]);
    $pwd = $mysqli->real_escape_string($_POST["pwd"]);
    $vwd = $mysqli->real_escape_string($_POST["vwd"]);

    // DO THE PASSWORDS MATCH?
    if ($pwd != $vwd) $err .= "<br/>FAIL: CHOOSE AND VERIFY PASSWORDS DO NOT MATCH";

    // DOES THE UID AND OLD PASSWORD COMBINATION EXIST?
    $sql = "SELECT uid FROM users WHERE uid = '$uid' AND pwd = '$old' LIMIT 1";
    if (!$res = $mysqli->query($sql)) trigger_error( $mysqli->error, E_USER_ERROR );
    $num = $res->num_rows;
    if ($num != 1) $err .= "<br/>FAIL: $uid DOES NOT HAVE PASSWORD $old";

    // IF THERE WERE NO ERRORS TO PREVENT THE PASSWORD CHANGE
    if (!$err)
    {
        // UPDATE THE TABLE TO CHANGE THE PASSWORD
        $sql = "UPDATE users SET pwd = '$pwd' WHERE uid = '$uid' AND pwd = '$old' LIMIT 1";
        if (!$res = $mysqli->query($sql)) trigger_error( $mysqli->error, E_USER_ERROR );

        // PASSWORD CHANGE IS COMPLETE
        echo "<br/>THANK YOU, $uid. PASSWORD CHANGE IS COMPLETE.";
        echo "<br/>CLICK <a href=\"/\">HERE</a> TO GO TO THE HOME PAGE";
        die();
    }

    // IF THERE WERE ERRORS
    else
    {
        echo $err;
        echo "<br/>SORRY, PASSWORD CHANGE FAILED";
    }
} // END OF FORM PROCESSING - PUT UP THE FORM
?>
<form method="post">
CHANGE YOUR PASSWORD
<br/>FORMER PASSWORD: <input name="old" type="password" />
<br/>CHOOSE PASSWORD: <input name="pwd" type="password" />
<br/>VERIFY PASSWORD: <input name="vwd" type="password" />
<br/><input type="submit" value="CHANGE" />
</form>