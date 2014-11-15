<?php
{ //create Asset type dropdown values
        $tAssetType_SQLselect = "SELECT ";
        $tAssetType_SQLselect .= "hw_type ";
        $tAssetType_SQLselect .= "FROM ";
        $tAssetType_SQLselect .= "nhi_asset_type ";
        $tAssetType_SQLselect .= "order by hw_type ";

        $tAssetType_SQLselect_Query = mysqli_query($dbSelected, $tAssetType_SQLselect);

        $assetTypeDropDown = "\n<select name=\"assetType\" id=\"assetType\" class=\"option-300\"> \n";
        $assetTypeDropDown .= " <option value=\"default\"> </option>\n";
        while ($row = mysqli_fetch_assoc($tAssetType_SQLselect_Query)) {

            foreach ($row as $idx => $r) {
               if($r == $assetType){
               $selectedFlag = "selected";
           }  else {
               $selectedFlag = "";
           }
                $assetTypeDropDown .= "  <option $selectedFlag value=\"$r\">$r</option>\n";
            }
        }
        $assetTypeDropDown .= "</select> \n";
        mysqli_free_result($tAssetType_SQLselect_Query);
    }

?>