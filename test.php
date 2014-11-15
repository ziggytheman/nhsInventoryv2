<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include('htconfig/dbConfig.php');
        include('includes/dbaccess.php');
        include('includes/fn_isCheckout.php');
        include('includes/fn_doesExist.php');
        $b = array(3,4,5); 
        $x = 0;
        
        
        echo " isCheckedOut</br>";
                if(isCheckedOut($dbSelected, $b[$x])) {
            echo "Found it</br>";
        }
        else {
            echo " something wrong</br>";
        }
        
        echo " DOESEXIST </br>";
        if(doesExist($dbSelected, $b[$x])) {
            echo "Found it</br>";
        }
        else {
            echo " something wrong</br>";
        }
/*
        $username = "admin";
        $password = "tony";

        $md5Password = md5($password);
        $tUser_SQLselect = "SELECT ID, username, password, accessLevel FROM nhi_user ";
        $tUser_SQLselect .= "WHERE username = '" . $username . "' ";

        $tUser_SQLselect_Query = mysqli_query($dbSelected, $tUser_SQLselect);

        while ($row = mysqli_fetch_assoc($tUser_SQLselect_Query)) {

            $userID = $row['ID'];
            $username = $row['username'];
            $passwordRetrieved = $row['password'];
            $accessLevel = $row['accessLevel'];

            $success = false;
            //	Get current date-time in MySQL format
            $nowTimeStamp = date("Y-m-d H:i:s");
            //	Get user's IP address
            //$userIP = $_SERVER['REMOTE_ADDR'];
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
                echo "Here Success <br/>";
            } else {
                $success = $insertLogin_SQL . "<br />" . mysqli_error($dbSelected);
                echo "Here error $success <br/>";
            }
        }
 */
 
        ?>

    </body>
</html>
