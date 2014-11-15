<?php

session_start();
if (strtoupper(substr(gethostname(), 0, 6)) === 'NOSOUP') {
    //echo 'This is a server using Windows!';
    $db = array(
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => 'tony',
        'database' => 'nhs_inventory');
} else {
    //echo 'This is a server not using Windows!';
    $db = array(
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => 'vikingso1',
        'database' => 'nhs_inventory');
}
?>