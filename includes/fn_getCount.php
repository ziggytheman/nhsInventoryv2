<?php
function getCount($barcode) {
    $temp =0;
    for($x = 0; $x < count($barcode); $x++){
        if(strlen($barcode[$x]>0)){
            $temp = $temp +1;
        }
    }
    return $temp;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

