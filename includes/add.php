<?php
include('includes/fn_insert_validations.php');
$barcode = $serialno = $location = $locationOther = "";
$assetType = $make = $model = $name = $os = $cpu = $hdsize = $serviceTag = "";
$ram = $pdate = $condition = $tlp = $notes = "";
$barcodeError = $serialnoError = $locationError = $locationOtherError = "";
$returnMsg = "Complete form to add a new asset";
$hasBarcode = "Y";

if ($dbSuccess) {
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["barcode"])) {
        $barcode = clean_input($_GET["barcode"]);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect screen Data with $_POST
        $barcode = clean_input($_POST["barcode"]);
        $hasbarcode = clean_input($_POST["hasBarcode"]);
        $serialno = clean_input($_POST["serialno"]);
        $location = clean_input($_POST["location"]);
        $locationOther = clean_input($_POST["locationOther"]);
        $assetType = clean_input($_POST["assetType"]);
        $make = clean_input($_POST["make"]);
        $model = clean_input($_POST["model"]);
        $name = clean_input($_POST["name"]);
        $os = clean_input($_POST["os"]);
        $cpu = clean_input($_POST["cpu"]);
        $hdsize = clean_input($_POST["hdsize"]);
        $ram = clean_input($_POST["ram"]);
        $pdate = clean_input($_POST["pdate"]);
        $condition = clean_input($_POST["condition"]);
        $tlp = clean_input($_POST["tlp"]);
        $notes = clean_input($_POST["notes"]);
        $serviceTag = clean_input($_POST["serviceTag"]);

        $assetInserted = clean_input($_POST["assetInserted"]);

        $tAsset_SQLselect = "SELECT ";
        $tAsset_SQLselect .= "ass_dps_barcode ";
        $tAsset_SQLselect .= "FROM ";
        $tAsset_SQLselect .= "nhi_asset ";
        $tAsset_SQLselect .= "where ass_dps_barcode = $barcode ";

        $tAsset_SQLselect_Query = mysqli_query($dbSelected, $tAsset_SQLselect);
        //    $r=count(mysqli_fetch_assoc($tAsset_SQLselect_Query));

        $hasError = FALSE;
        $returnMsg = "";
        if (empty($barcode)) {
            $barcodeError = "A 10 digit Bar code is required";
            $hasError = TRUE;
        } elseif (!is_numeric($barcode)) {
            $barcodeError = "Bar code must be numeric";
            $hasError = TRUE;
        } elseif (count(mysqli_fetch_assoc($tAsset_SQLselect_Query)) > 0) {
            $barcodeError = "Bar code must be unique";
            $hasError = TRUE;
        }
        if (strlen($barcodeError) > 0) {
            $returnMsg .= $barcodeError . "; ";
        }

        if (empty($location)) {
            $locationError = "A Location is required";
            $hasError = TRUE;
        }
        if (strlen($locationError) > 0) {
            $returnMsg .= $locationError . "; ";
        }


        if ($location === "Other" && empty($locationOther)) {
            $locationOtherError = "An Other Location is required";
            $hasError = TRUE;
        }
        if (strlen($locationOtherError) > 0) {
            $returnMsg .= $locationOtherError . "; ";
        }
    }


    if (isset($assetInserted) && $assetInserted == '1' && !$hasError) {
//   $addAsset = assetInsert($dbSelected,$barcode,$serialno,$location,$locationOther,
//      $assetType,$make,$serviceTag,$model,$name,$os,$cpu,$hdsize,$ram,$pdate,$condtion,
//      $tlp, $notes);
        {  //   SQL:     $tnhi_Asset_SQLinsert
            $date = date("Y-m-d H:i:s");
            $tAsset_SQLinsert = "INSERT INTO nhi_asset (";
            $tAsset_SQLinsert .= "ass_dps_barcode, ";
            $tAsset_SQLinsert .= "ass_has_barcode, ";
            $tAsset_SQLinsert .= "ass_type, ";
            $tAsset_SQLinsert .= "ass_make, ";
            $tAsset_SQLinsert .= "ass_service_tag, ";
            $tAsset_SQLinsert .= "ass_model, ";
            $tAsset_SQLinsert .= "ass_name, ";
            $tAsset_SQLinsert .= "ass_serial_no, ";
            $tAsset_SQLinsert .= "ass_os, ";
            $tAsset_SQLinsert .= "ass_cpu, ";
            $tAsset_SQLinsert .= "ass_hd_size, ";
            $tAsset_SQLinsert .= "ass_ram, ";
            $tAsset_SQLinsert .= "ass_purchase_date, ";
            $tAsset_SQLinsert .= "ass_condition, ";
            $tAsset_SQLinsert .= "ass_location, ";
            $tAsset_SQLinsert .= "ass_location_other, ";
            $tAsset_SQLinsert .= "ass_tlp, ";
            $tAsset_SQLinsert .= "ass_notes, ";
            $tAsset_SQLinsert .= "ass_date_edited ";
            $tAsset_SQLinsert .= ") ";

            $tAsset_SQLinsert .= "VALUES (";
            $tAsset_SQLinsert .= "'" . str_pad($barcode, 10, "0", STR_PAD_LEFT) . "', ";
            $tAsset_SQLinsert .= "'" . strtoupper($hasBarcode) . "', ";
            $tAsset_SQLinsert .= "'" . $assetType . "', ";
            $tAsset_SQLinsert .= "'" . $make . "', ";
            $tAsset_SQLinsert .= "'" . strtoupper($serviceTag) . "', ";
            $tAsset_SQLinsert .= "'" . $model . "', ";
            $tAsset_SQLinsert .= "'" . $name . "', ";
            $tAsset_SQLinsert .= "'" . strtoupper($serialno) . "', ";
            $tAsset_SQLinsert .= "'" . $os . "', ";
            $tAsset_SQLinsert .= "'" . $cpu . "', ";
            $tAsset_SQLinsert .= "'" . $hdsize . "', ";
            $tAsset_SQLinsert .= "'" . $ram . "', ";
            $tAsset_SQLinsert .= "'" . $pdate . "', ";
            $tAsset_SQLinsert .= "'" . $condition . "', ";
            $tAsset_SQLinsert .= "'" . $location . "', ";
            $tAsset_SQLinsert .= "'" . $locationOther . "', ";
            $tAsset_SQLinsert .= "'" . $tlp . "', ";
            $tAsset_SQLinsert .= "'" . $notes . "', ";
            $tAsset_SQLinsert .= "'" . $date . "' ";
            $tAsset_SQLinsert .= ") ";
        }

        if (mysqli_query($dbSelected, $tAsset_SQLinsert)) {
            $returnMsg = "Asset <strong>" . $barcode . "</strong>";
            $returnMsg .= " was successfully added at " . $date . ".";
            $barcode = $serialno = $location = $locationOther = "";
            $assetType = $make = $model = $name = $os = $cpu = $hdsize = $serviceTag = "";
            $ram = $pdate = $condition = $tlp = $notes = "";
            $barcodeError = $serialnoError = $locationError = $locationOtherError = "";
            header("Location: index.php?content=assetSearch&returnMsg=$returnMsg");
        } else {
            $errorMsg = "FAILED to add new person.<br />";
            $errorMsg .= mysqli_error($dbSelected) . "<br />";
            $returnMsg = dataError($errorMsg);
        }

        unset($assetInserted);
    }



    include('includes/conditionDropDown.php');
    include('includes/typeDropDown.php');
}
?>
<form method="post" action="index.php?content=assetAdd">
    <div class="fieldSet">
        <fieldset>
            <legend>Add - Required Fields
                <span class="links"><a href="index.php?content=assetMaintenanceInsert&barcode=<?php echo $barcode; ?>">Maintenance</a></span>
                <span class="links"><a href="index.php?content=assetCheckIn&barcode=<?php echo $barcode; ?>">Check-In</a></span>
                <span class="links"><a href="index.php?content=assetTestCheckout&barcode=<?php echo $barcode; ?>">Check-Out</a></span>
            </legend>
            <input type="hidden" name="assetInserted" value="1"/>
            <p><label class="field" for="barcode">DPS Barcode</label>
                <input type="text" name="barcode" id="barcode" class="textbox-300" autofocus value="<?php echo $barcode; ?>"/>
                <span class="error"><?php echo $barcodeError ?></span>
                <label class="field" for="hasBarcode">Barcode?</label>
                <input type="text" name="hasBarcode" id="hasBarcode" class="textbox-20" value="<?php echo $hasBarcode; ?>"/>
            <p><label class="field" for="serialno">Serial Number</label>
                <input type="text" name="serialno" id="serialno" class="textbox-300" value="<?php echo $serialno; ?>"/>
                <span class="error"><?php echo $serialnoError; ?></span></p>
            <p><label class="field" for="location">Location</label>
                <input type="text" name="location" id="location" class="textbox-300" value="<?php echo $location; ?>"/>
                <span class="error"><?php echo $locationError; ?></span></p>

            <div id="otherLocation">
                <p><label class="field" for="locationOther">Other </label>
                    <input type="text" name="locationOther" id="locationother" class="textbox-300" value="<?php echo $locationOther; ?>"/>
                    <span class="error"><?php echo $locationOtherError; ?></span></p>
            </div>
        </fieldset>
    </div>

    <div class="fieldSet">
        <fieldset>
            <legend>Add - Optional Fields</legend>
            <p><label class="field" for="assetType">Type</label>
                <?php echo $assetTypeDropDown; ?>
            <p><label class="field" for="make">Make</label>
                <input type="text" name="make" id="make" class="textbox-300" value="<?php echo $make; ?>" /></p>

            <p><label class="field" for="serviceTag">Service Tag</label>
                <input type="text" name="serviceTag" id="serviceTag" class="textbox-300" value="<?php echo $serviceTag; ?>" /></p>


            <p><label class="field" for="model">Model</label>
                <input type="text" name="model" id="type" class="textbox-300" value="<?php echo $model; ?>"/></p>

            <p><label class="field" for="name">Name</label>
                <input type="text" name="name" id="name" class="textbox-300" value="<?php echo $name; ?>"/></p>

            <p><label class="field" for="os">Operating System</label>
                <input type="text" name="os" id="os" class="textbox-300" value="<?php echo $os; ?>"/></p>

            <p><label class="field" for="cpu">CPU</label>
                <input type="text" name="cpu" id="cpu" class="textbox-300" value="<?php echo $cpu; ?>"/></p>

            <p><label class="field" for="hdsize">HD Size</label>
                <input type="text" name="hdsize" id="hdsize" class="textbox-300" value="<?php echo $hdsize; ?>"/></p>

            <p><label class="field" for="ram">Ram</label>
                <input type="text" name="ram" id="ram" class="textbox-300" value="<?php echo $ram; ?>"/></p>

            <p><label class="field" for="pdate">Date of Purchase</label>
                <input type="date" name="pdate" id="pdate" class="textbox-300" value="<?php echo $pdate; ?>"/></p>

            <p><label class="field" for="condition">Condition</label> 
                <?php echo $conditionDropDown; ?>
            </p>

            <p><label class="field" for="tlp">TLP</label>

                <select name="tlp" id="tlp" class="option-300"/>
                <?php
                $selectedTrue = "";
                $selectedFalse = "";
                $selectedBlank = "";
                if ($tlp === "") {
                    $selectedBlank = "";
                } elseif ($tlp == "true") {
                    $selectedTrue = "selected";
                } elseif ($tlp == "false") {
                    $selectedFalse = "selected";
                }
                ?>
            <option <?php echo $selectedBlank; ?> value=""> </option>
            <option <?php echo $selectedTrue; ?> value="true">True</option>
            <option <?php echo $selectedFalse; ?> value="false">False</option>
            </select></p>
            <p><label class="field" for="notes">Notes</label>
                <textarea name="notes" id="notes" class="textarea" rows="5" cols="50"><?php echo $notes; ?></textarea></p>

        </fieldset>
        <input type="submit" value="Add">
    </div>
</form>

<script>
    $("#pageTitle").text("Add");
</script>