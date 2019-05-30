<?php //login.php
require_once('config.php');

// WAS EVERYTHING WE NEED POSTED TO THIS SCRIPT?
if ( (!empty($_POST["uid"])) && (!empty($_POST["pwd"])) )
{
    // YES, WE HAVE THE POSTED DATA. ESCAPE IT FOR USE IN A QUERY
    $uid = $mysqli->real_escape_string($_POST["uid"]);
    $pwd = $mysqli->real_escape_string($_POST["pwd"]);

    // CONSTRUCT AND EXECUTE THE QUERY - COUNT THE NUMBER OF ROWS RETURNED
    $sql = "SELECT uid, uuk FROM users WHERE uid = '$uid' AND pwd = '$pwd' LIMIT 1";
    $res = $mysqli->query($sql);

    // IF THE QUERY FAILED, GIVE UP
    if (!$res) trigger_error( $mysqli->error, E_USER_ERROR );

    // THERE SHOULD BE ONE ROW IF THE VALIDATION WAS PROCESSED SUCCESSFULLY
    $num = $res->num_rows;
    if ($num)
    {
        // RETRIEVE THE ROW FROM THE QUERY RESULTS SET
        $row = $res->fetch_assoc();

        // STORE THE USER-ID IN THE SESSION ARRAY
        $_SESSION["uid"] = $row["uid"];

        // IS THE "REMEMBER ME" CHECKBOX SET?
        if (isset($_POST["rme"]))
        {
            remember_me($row["uuk"]);
        }

        // REDIRECT TO THE ENTRY PAGE OR TO THE HOME PAGE
        if (isset($_SESSION["entry_uri"]))
        {
            header("Location: {$_SESSION["entry_uri"]}");
            exit;
        }
        else
        {
            header("Location: /");
            exit;
        }
    } // END OF SUCCESSFUL VALIDATION
    else
    {
        echo "SORRY, VALIDATION FAILED USING $uid AND $pwd \n";
    }
} // END OF FORM PROCESSING - PUT UP THE LOGIN FORM
?>
<form method="post">
PLEASE LOG IN
<br/>UID: <input name="uid" />
<br/>PWD: <input name="pwd" type="password" />
<br/><input type="checkbox" name="rme" />KEEP ME LOGGED IN
<br/><input type="submit" value="LOGIN" />
</form>