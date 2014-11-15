<?php

/* 		INCLUDE FILE:   fn_authorise.php
 *
 * 		folder:			includes/
 *
 * 		used in:        index.php
 *
 * 		version:    	0901   date: 2010-07-01
 *
 * 		purpose:		test $username, $password for authorisation
 *
 * 	===========================================================================
 */

function userAuthorised($username, $password, $dbSelected) {

    $md5Password = md5($password);
    $tUser_SQLselect = "SELECT ID, username, password, accessLevel FROM nhi_user ";
    $tUser_SQLselect .= "WHERE username = '" . $username . "' ";

    $tUser_SQLselect_Query = mysqli_query($dbSelected, $tUser_SQLselect);

    while ($row = mysqli_fetch_assoc($tUser_SQLselect_Query)) {
        $userID = $row['ID'];
        $username = $row['username'];
        $passwordRetrieved = $row['password'];
        $accessLevel = $row['accessLevel'];
    }

    if (!empty($passwordRetrieved) AND ($md5Password == $passwordRetrieved)) {

        setcookie("accessLevel", $accessLevel, time() + 7200, "/");
        setcookie("userID", $userID, time() + 7200, "/");
        setcookie("loginAuthorised", "loginAuthorised", time() + 7200, "/");
        setcookie("username", $username, time() + 7200, "/");

        $returnCode = true;

       $sessionLogged = insertLogin($userID, $dbSelected);
      
        if (!$sessionLogged) {
            setcookie("sessionLogging", "failed", time() + 300, "/");
        }
    } else {
        $returnCode = false;
    }

    return $returnCode;
}

function insertLogin($userID, $dbSelected) {
    $success = false;
    //	Get current date-time in MySQL format
    $nowTimeStamp = date("Y-m-d H:i:s");
    //	Get user's IP address
    $userIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_SPECIAL_CHARS);

    $insertLogin_SQL = 'INSERT INTO nhi_accesslog 
        (userID, 
	 timeLogin, 
	 IPaddress) VALUES (
	' . $userID . ',
	"' . $nowTimeStamp . '",
	"' . $userIP . '"
	)';

    if (mysqli_query($dbSelected, $insertLogin_SQL)) {
        $success = true;
    } else {
        $success = $insertLogin_SQL . "<br />" . mysqli_error($dbSelected);
    }

    return $success;
}

?>