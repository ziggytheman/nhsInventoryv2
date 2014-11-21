<?php

function updateDetails($dbSelected, $barcode, $room, $timeFrame) {
    //print_r(" here in UD " .$room ." " .$timeFrame);
    //var_dump($barcode);
    $haserror = false;
    $x = 0;
    while (!$haserror and $x < count($barcode)) {
        if (strlen($barcode[$x]) > 0) {
            //format and write each record

            $SQLinsert = "INSERT INTO nhi_inventory_details (";
            $SQLinsert .= "dtl_timeframe, ";
            $SQLinsert .= "dtl_room, ";
            $SQLinsert .= "dtl_barcode ";
            $SQLinsert .= ") ";

            $SQLinsert .= "VALUES (";
            $SQLinsert .= "'" . $timeFrame . "', ";
            $SQLinsert .= "'" . $room . "', ";
            $SQLinsert .= "'" . $barcode[$x] . "' ";
            $SQLinsert .= ") ";

            print_r($SQLinsert);

            if (mysqli_query($dbSelected, $SQLinsert)) {
                $returnMsg = "Check out ";
                $returnMsg .= " was successful.";
                $returnMsg .= ".<br />";
            } else {
                $errorMsg = "FAILED to add insert CO detail data.<br />";
                $errorMsg .= mysqli_error($dbSelected) . "<br /><br />";
                $returnMsg = dataError($errorMsg);
                $rollBack = TRUE;
                $haserror = true;
            }
        }
        $x++;
    }

    return $haserror;
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

