<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function createRoomDropDown($dbSelected) {
//create condition value dropdown values
    $tSQLselect = "SELECT ";
    $tSQLselect .= "loc_room ";
    $tSQLselect .= "FROM ";
    $tSQLselect .= "nhi_locations ";
    $tSQLselect .= "order by loc_room ";


    $tSQLselect_Query = mysqli_query($dbSelected, $tSQLselect);

    $DropDown = "";
    $DropDown .= " <option value=\"\"> </option>\n";
    while ($row = mysqli_fetch_assoc($tSQLselect_Query)) {

        foreach ($row as $idx => $r) {
            $DropDown .= "              <option value=\"$r\"></option>\n";
        }
    }
    mysqli_free_result($tSQLselect_Query);

    return $DropDown;
}