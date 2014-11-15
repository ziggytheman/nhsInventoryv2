<?php

$tAsset_SQLselect = "Select ass_type, ass_make, ass_model, ass_name, ass_location, ass_serial_no ";
$tAsset_SQLselect .= "FROM nhi_asset ";
$tAsset_SQLselect .= "WHERE ass_dps_barcode = $barcode ";

$tAsset_SQLselect_Query = mysqli_query($dbSelected, $tAsset_SQLselect);
if ($row = mysqli_fetch_assoc($tAsset_SQLselect_Query)) {
    foreach ($row as $idx => $r) {
        switch ($idx) {
            case "ass_type":
                $assetType = $r;
                break;
            case "ass_make":
                $make = $r;
                break;
            case "ass_model":
                $model = $r;
                break;
            case "ass_name":
                $name = $r;
                break;
            case "ass_serial_no":
                $serialNo = strtoupper($r);
                break;
            case "ass_location":
                $location = $r;
                break;
        }
   }
    
   // if (mysqli_query($dbSelected, $tAsset_SQLselect)) {

    } else {
        $errorMsg = "FAILED to retrieve asset data.<br />";
        $errorMsg .= mysqli_error($dbSelected) . "<br /><br />";
        $returnMsg = dataError($errorMsg);
    }
    include("includes/common_checkioTable_sql.php");

//}
?>