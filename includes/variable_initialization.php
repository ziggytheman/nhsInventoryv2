<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_unset(); 
$_SESSION['errorMsg'] = "";
$_SESSION['statusMsg'] = "";
$_SESSION['debugx'] = 0;
$errorMsg="";
$returnMsg="";
$statusMsg="";
$_SESSION['rowX'] = 10;
$_SESSION['inventory_time'] = getConfigValue($dbSelected, 'inventory_time');


function getConfigValue($dbSelected,$key) {
    $SQLselect = "Select cfg_value ";
    $SQLselect .= "FROM nhi_configuration ";
    $SQLselect .= "WHERE cfg_key_value = '$key' ";
   
    $SQLselect_Query = mysqli_query($dbSelected, $SQLselect);


    if ($row = mysqli_fetch_assoc($SQLselect_Query)) {
        return $row['cfg_value'];
    } else {
        return -1;
    }
}


