<?php // register.php
require_once('config.php');

// WE ASSUME NO ERRORS OCCURRED
$err = NULL;

// WAS EVERYTHING WE NEED POSTED TO THIS SCRIPT?
if ( (!empty($_POST["uid"])) && (!empty($_POST["pwd"])) && (!empty($_POST["vwd"])) )
{
    // YES, WE HAVE THE POSTED DATA. ESCAPE IT FOR USE IN A QUERY
    $uid = $mysqli->real_escape_string($_POST["uid"]);
    $pwd = $mysqli->real_escape_string($_POST["pwd"]);
    $vwd = $mysqli->real_escape_string($_POST["vwd"]);

    // DO THE PASSWORDS MATCH?
    if ($pwd != $vwd) $err .= "<br/>FAIL: CHOOSE AND VERIFY PASSWORDS DO NOT MATCH";

    // DOES THE UID ALREADY EXIST?
    $sql = "SELECT uid FROM users WHERE uid = '$uid' LIMIT 1";
    if (!$res = $mysqli->query($sql)) trigger_error( $mysqli->error, E_USER_ERROR );
    $num = $res->num_rows;
    if ($num) $err .= "<br/>FAIL: UID $uid IS ALREADY TAKEN.  CHOOSE ANOTHER";

    // IF THERE WERE NO ERRORS THAT PREVENT REGISTRATION
    if (!$err)
    {
        // MAKE THE UNIQUE USER KEY
        $uuk = md5($uid . $pwd . rand());
        $sql = "INSERT INTO users (uid, pwd, uuk) VALUES ('$uid', '$pwd', '$uuk')";
        if (!$res = $mysqli->query($sql)) trigger_error( $mysqli->error, E_USER_ERROR );

        // STORE THE USER-ID IN THE SESSION ARRAY
        $_SESSION["uid"] = $uid;

        // IS THE "REMEMBER ME" CHECKBOX SET?
        if (isset($_POST["rme"]))
        {
            remember_me($uuk);
        }

        // REGISTRATION AND LOGIN COMPLETE
        echo "<br/>WELCOME $uid. REGISTRATION COMPLETE.  YOU ARE LOGGED IN.";
        echo "<br/>CLICK <a href=\"/\">HERE</a> TO GO TO THE HOME PAGE";
        die();
    }

    // IF THERE WERE ERRORS
    else
    {
        echo $err;
        echo "<br/>SORRY, REGISTRATION FAILED";
    }
} // END OF FORM PROCESSING - PUT UP THE FORM
?>
<form method="post">
PLEASE REGISTER
<br/>CHOOSE USERNAME: <input name="uid" />
<br/>CHOOSE PASSWORD: <input name="pwd" type="password" />
<br/>VERIFY PASSWORD: <input name="vwd" type="password" />
<br/><input type="checkbox" name="rme" />KEEP ME LOGGED IN
<br/><input type="submit" value="REGISTER" />
</form>