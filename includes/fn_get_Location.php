<?php

function getLocation($dbSelected, $barcode) {

    $time = $_SESSION['inventory_time'];
    $SQLselect = "Select getLocation($barcode) as 'location'";
  
    $SQLselect_Query = mysqli_query($dbSelected, $SQLselect);

    if ($row = mysqli_fetch_assoc($SQLselect_Query)) {
        $loc = $row['location'];
    } else {
        $loc = "N/A";
    }
    return $loc;
}
