<?php

function isInventoryed($dbSelected, $barcode) {
    $SQLselect = "SELECT dtl_room  FROM nhi_inventory_details ";
    $SQLselect .= "WHERE dtl_timeframe = 'Fall-2014' ";
    $SQLselect .= "AND  dtl_barcode = '" . $barcode . "'";

    $SQLselect_Query = mysqli_query($dbSelected, $SQLselect);
    //print_r($SQLselect);
    
    if ($row = mysqli_fetch_assoc($SQLselect_Query)) {
 //       print_r($row);
        return TRUE;
        
    } else {
       // print_r("NOT FOUND");
        return FALSE;
        
    }
}
