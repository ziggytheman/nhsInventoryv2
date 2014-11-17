<?php

function isRoomValid($dbSelected, $room) {
    $SQLselect = "Select loc_id ";
    $SQLselect .= "FROM nhi_locations ";
    $SQLselect .= "WHERE loc_room = '$room' ";
   
    $SQLselect_Query = mysqli_query($dbSelected, $SQLselect);

    if ($row = mysqli_fetch_assoc($SQLselect_Query)) {
        return TRUE;
    } else {
        return FALSE;
    }
}
