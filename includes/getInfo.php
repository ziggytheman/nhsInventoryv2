<?php

$q = intval($_GET['q']);

include('../htconfig/dbConfig.php');
include('dbaccess.php');
include('fn_isCheckout.php');

$sql = "SELECT ass_type, ass_model FROM nhi_asset WHERE ass_dps_barcode = '" . $q . "'";

$result = mysqli_query($dbSelected, $sql);

if ($row = mysqli_fetch_array($result)) {

    echo $row['ass_type'] . " ";
    echo $row['ass_model'] . " ";
    
    if (isCheckedOut($dbSelected,$q)) {
    echo '<span class="error">Item already Checked out</span>';
    }
} else {
    echo '<span class="error">Item Not Found</span>';
}
?>

select `nhs_inventory`.`nhi_asset`.`ass_dps_barcode` AS `Barcode`,concat(`nhs_inventory`.`nhi_asset`.`ass_type`,' ',`nhs_inventory`.`nhi_asset`.`ass_model`) AS `Details`,`nhs_inventory`.`nhi_asset`.`ass_location` AS `Location` from `nhs_inventory`.`nhi_asset` order by `nhs_inventory`.`nhi_asset`.`ass_location`,`nhs_inventory`.`nhi_asset`.`ass_dps_barcode`