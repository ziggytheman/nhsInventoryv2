<?php

function validateDetails($dbSelected,$barcode) {
    include_once ('fn_doesExist.php');
    $haserror = false;
    $x = 0;
    while(!$haserror and $x < count($barcode) and strlen($barcode[$x]>0)){
        $haserror = !doesExist($dbSelected,$barcode[$x]);
        $x++;
    }
    return $haserror;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

