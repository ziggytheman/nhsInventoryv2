<?php

function fn_format_maintenance_details($barcode, $dbSelected) {
    $tMH_SQLselect = "Select * ";
    $tMH_SQLselect .= "FROM nhi_maintenance_history ";
    $tMH_SQLselect .= "WHERE mh_dps_barcode = $barcode ";
    $tMH_SQLselect .= "ORDER BY mh_date desc ";

    $tMH_SQLselect_Query = mysqli_query($dbSelected, $tMH_SQLselect);
    $noteRow = "";

    while ($row = mysqli_fetch_assoc($tMH_SQLselect_Query)) {

        foreach ($row as $idx => $r) {
            switch ($idx) {
                case "mh_date":
                    $date = $r;
                    break;
                case "mh_notes":
                    $notes = $r;
                    break;
            }
        }

        $noteRow .= "$date" . ": " . $notes . "\n\n";
    }
    return $noteRow;
}

?>