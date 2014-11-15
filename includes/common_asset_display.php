<?php {  //   SQL:    Select from Asset table
    $tAsset_SQLselect = "Select * ";
    $tAsset_SQLselect .= "FROM nhi_asset ";
    $tAsset_SQLselect .= "WHERE ass_dps_barcode = $barcode ";

    $tAsset_SQLselect_Query = mysqli_query($dbSelected, $tAsset_SQLselect);
}

if ($row = mysqli_fetch_assoc($tAsset_SQLselect_Query)) {
    foreach ($row as $idx => $r) {
        switch ($idx) {
            case "ass_dps_barcode":
                $barcode = str_pad($r, 10, "0", STR_PAD_LEFT);
                break;
            case "ass_has_barcode":
                if($r !== "") {
                    $hasBarcode = strtoupper($r);
                }else {
                    $hasBarcode = "Y";
                }
                break;
            case "ass_type":
                $assetType = $r;
                break;
            case "ass_make":
                $make = $r;
                break;
            case "ass_service_tag":
                $serviceTag = strtoupper($r);
                break;
            case "ass_model":
                $model = $r;
                break;
            case "ass_name":
                $name = $r;
                break;
            case "ass_serial_no":
                $serialno = strtoupper($r);
                break;
            case "ass_os":
                $os = $r;
                break;
            case "ass_cpu" :
                $cpu = $r;
                break;
            case "ass_hd_size":
                $hdsize = $r;
                break;
            case "ass_ram" :
                $ram = $r;
                break;
            case "ass_purchase_date":
                $pdate = $r;
                break;
            case "ass_condition" :
                $condition = $r;
                break;
            case "ass_location" :
                $location = $r;
                break;
            case "ass_location_other":
                $locationOther = $r;
                break;
            case "ass_tlp":
                $tlp = $r;
                break;
            case "ass_notes":
                $notes = $r;
                break;
            case "ass_date_added":
                $dateAdded = $r;
                break;
            case "ass_date_edited":
                $dateEdited = $r;
                break;
        }
    }
} else {
    $errorMsg = "FAILED to select asset.<br />";
    $errorMsg .= mysqli_error($dbSelected) . "<br /><br />";
    $returnMsg = dataError($errorMsg);
}

