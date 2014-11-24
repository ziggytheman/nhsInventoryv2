<?php

$q = intval($_GET['q']);

include('../htconfig/dbConfig.php');
include('dbaccess.php');


$sql = "SELECT ass_type, ass_model FROM nhi_asset WHERE ass_dps_barcode = '" . $q . "'";

$result = mysqli_query($dbSelected, $sql);

if ($row = mysqli_fetch_array($result)) {

    echo $row['ass_type'] . " ";
    echo $row['ass_model'] . " "; {
        $sql = "SELECT dtl_room  FROM nhi_inventory_details WHERE dtl_timeframe = 'Fall-2014' and  dtl_barcode = '" . $q . "'";

        $result = mysqli_query($dbSelected, $sql);
        if ($row = mysqli_fetch_array($result)) {
            echo '<span class="error">Item has been located in room ' . $row["dtl_room"] . " " . '</span>';
        }
    }
} else {
    echo '<span class="error">Item Not Found</span>';
}