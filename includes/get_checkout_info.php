<?php {  //   SQL:    Select from Asset table
    $tcheckout_SQLselect = "Select cio_name, cio_check_out_date ";
    $tcheckout_SQLselect .= "FROM nhi_check_io, nhi_check_io_details ";
    $tcheckout_SQLselect .= "WHERE ";
    $tcheckout_SQLselect .= "ciod_dps_barcode = $barcode and ";
    $tcheckout_SQLselect .= "ciod_check_out_date = cio_check_out_date and ";
    $tcheckout_SQLselect .= "ciod_check_in_date = 0";
    $tcheckout_SQLselect_Query = mysqli_query($dbSelected, $tcheckout_SQLselect);
}
   $coStyle = "";

if ($row = mysqli_fetch_assoc($tcheckout_SQLselect_Query)) {
    $checkout_info = $row['cio_name'];
    $checkout_info .= " ";
    $checkout_info .= date("m-d-Y", strtotime($row['cio_check_out_date']));
    $coStyle = "background-color:beige; border-color:red";
} else
    $checkout_info = "Available";

