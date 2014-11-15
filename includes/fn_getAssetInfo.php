<?php

function getAssetInfo($dbSelected, $barcode) {
    include_once ('fn_isCheckout.php');
  
    $tasset_SQLselect = "Select ass_type, ass_model ";
    $tasset_SQLselect .= "FROM nhi_asset ";
    $tasset_SQLselect .= "WHERE ass_dps_barcode = $barcode ";

    $tasset_SQLselect_Query = mysqli_query($dbSelected, $tasset_SQLselect);

    $temp = "";

    if ($row = mysqli_fetch_assoc($tasset_SQLselect_Query)) {
        $temp = $row['ass_type'] . " " . $row['ass_model'] . " ";
        if (isCheckedOut($dbSelected, $barcode)) {
             $temp .= '<span class="error">Item already Checked out</span>';
        }
    } else {
        $temp = '<span class="error">Item Not Found</span>';
    }
    return $temp;
}
