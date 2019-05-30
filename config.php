<?php //config.php

error_reporting(E_ALL);

// REQUIRED FOR PHP 5.1+
date_default_timezone_set('Africa/Nairobi');

// THE LIFE OF THE "REMEMBER ME" COOKIE
define('REMEMBER', 60*60*24*7); // ONE WEEK IN SECONDS

// WE WANT TO START THE SESSION ON EVERY PAGE
session_start();

// CONNECTION AND SELECTION VARIABLES FOR THE DATABASE
$db_host = "localhost"; 
$db_name = "mydb";        
$db_user = "root";
$db_word = "";

// OPEN A CONNECTION TO THE DATA BASE SERVER AND SELECT THE DB
$mysqli = new mysqli($db_host = "localhost", $db_user = "root", $db_word = "", $db_name = "mydb");

// DID THE CONNECT/SELECT WORK OR FAIL?
if ($mysqli->connect_errno)
{
    $err
    = "CONNECT FAIL: "
    . $mysqli->connect_errno
    . ' '
    . $mysqli->connect_error
    ;
    trigger_error($err, E_USER_ERROR);
}

// DEFINE THE ACCESS CONTROL FUNCTION
function access_control($test=FALSE)
{
    // REMEMBER HOW WE GOT HERE
    $_SESSION["entry_uri"] = $_SERVER["REQUEST_URI"];

    // IF THE UID IS SET, WE ARE LOGGED IN
    if (isset($_SESSION["uid"])) return $_SESSION["uid"];

    // IF WE ARE NOT LOGGED IN - RESPOND TO THE TEST REQUEST
    if ($test) return FALSE;

    // IF THIS IS NOT A TEST, REDIRECT TO CALL FOR A LOGIN
    header("Location: login.php");
    exit;
}

// DEFINE THE "REMEMBER ME" COOKIE FUNCTION
function remember_me($uuk)
{
    // CONSTRUCT A "REMEMBER ME" COOKIE WITH THE UNIQUE USER KEY
    $cookie_name    = 'uuk';
    $cookie_value   = $uuk;
    $cookie_expires = time() + date('Z') + REMEMBER;
    $cookie_path    = '/';
    $cookie_domain  = NULL;
    $cookie_secure  = FALSE;
    $cookie_http    = TRUE; // HIDE COOKIE FROM JAVASCRIPT (PHP 5.2+)

    // SEE http://php.net/manual/en/function.setcookie.php
    setcookie
    ( $cookie_name
    , $cookie_value
    , $cookie_expires
    , $cookie_path
    , $cookie_domain
    , $cookie_secure
    , $cookie_http
    )
    ;
}


// DETERMINE IF THE CLIENT IS ALREADY LOGGED IN BECAUSE OF THE SESSION ARRAY
if (!isset($_SESSION["uid"]))
{

    // DETERMINE IF THE CLIENT IS ALREADY LOGGED IN BECAUSE OF "REMEMBER ME" FEATURE
    if (isset($_COOKIE["uuk"]))
    {
        $uuk = $mysqli->real_escape_string($_COOKIE["uuk"]);
        $sql = "SELECT uid FROM user WHERE uuk = '$uuk' LIMIT 1";
        $res = $mysqli->query($sql);

        // IF THE QUERY SUCCEEDED
        if ($res)
        {
            // THERE SHOULD BE ONE ROW
            $num = $res->num_rows;
            if ($num)
            {
                // RETRIEVE THE ROW FROM THE QUERY RESULTS SET
                $row = $res->fetch_assoc();

                // STORE THE USER-ID IN THE SESSION ARRAY
                $_SESSION["uid"] = $row["uid"];

                // EXTEND THE "REMEMBER ME" COOKIE
                remember_me($uuk);
            }
        }
    }
}