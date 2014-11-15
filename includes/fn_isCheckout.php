<?php

function isCheckedOut($dbSelected, $barcode) {
    $tcheckout_SQLselect = "Select cio_name ";
    $tcheckout_SQLselect .= "FROM nhi_check_io, nhi_check_io_details ";
    $tcheckout_SQLselect .= "WHERE ";
    $tcheckout_SQLselect .= "ciod_dps_barcode = $barcode and ";
    $tcheckout_SQLselect .= "ciod_check_out_date = cio_check_out_date and ";
    $tcheckout_SQLselect .= "ciod_check_in_date = 0";
    
    //print_r($tcheckout_SQLselect);

    $tcheckout_SQLselect_Query = mysqli_query($dbSelected, $tcheckout_SQLselect);


    if (mysqli_fetch_assoc($tcheckout_SQLselect_Query)) {
        return TRUE;
    } else {
        return FALSE;
    }
}
