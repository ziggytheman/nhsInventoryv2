<?php

function doesExist($dbSelected, $barcode) {
    $SQLselect = "Select ass_id ";
    $SQLselect .= "FROM nhi_asset ";
    $SQLselect .= "WHERE ass_dps_barcode = $barcode ";
   
    $SQLselect_Query = mysqli_query($dbSelected, $SQLselect);


    if ($row = mysqli_fetch_assoc($SQLselect_Query)) {
        return TRUE;
    } else {
        return FALSE;
    }
}
