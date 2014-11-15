<?php

function doesExist($dbSelected, $barcode) {
    $tasset_SQLselect = "Select ass_id ";
    $tasset_SQLselect .= "FROM nhi_asset ";
    $tasset_SQLselect .= "WHERE ass_dps_barcode = $barcode ";
   
    $tasset_SQLselect_Query = mysqli_query($dbSelected, $tasset_SQLselect);


    if ($row = mysqli_fetch_assoc($tasset_SQLselect_Query)) {
        return TRUE;
    } else {
        return FALSE;
    }
}
