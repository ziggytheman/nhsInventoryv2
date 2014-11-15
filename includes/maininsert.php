<?php
include('includes/dbaccess.php');
include('includes/fn_insert_validations.php');
include('includes/fn_format.php');


$assetType = $make = $model = $name = "";
$mDate = $notes = $mTime = "";

$hasError = FALSE;
$returnMsg = " Insert information";
$noteError = "";

$insert = "n";
$update = "n";
$readonly = "";

if ($dbSuccess) {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $barcode = clean_input($_GET["barcode"]);
        if (!empty($barcode)) {
            //   SQL:    Select from Asset table
            include('includes/common_assetTable_sql.php');

            $noteRow = fn_format_maintenance_details($barcode, $dbSelected);
            $notes = "";
        } else {
            echo "barcode not found";
        }
    }
}
if ($dbSuccess) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
//        print_r($_POST);

        $barcode = clean_input($_POST["barcode"]);
        $assetType = clean_input($_POST["assetType"]);
        $make = clean_input($_POST["make"]);
        $model = clean_input($_POST["model"]);
        $name = clean_input($_POST["name"]);
        $mDate = clean_input($_POST["mDate"]);
        $noteRow = clean_input($_POST["noteRow"]);
        $serialNo = clean_input($_POST["serialNo"]);
        $location = clean_input($_POST["location"]);

        $notes = clean_input($_POST["notes"]);


//EDIT CHECKS for Insert


        $hasError = FALSE;
        if (empty($notes)) {
            $noteError = "Maintenance notes cannot be empty";
            $hasError = TRUE;
        }
        if (strlen($noteError) > 0) {
            $returnMsg = $noteError;
        }




        if (!$hasError) {
//Insert into DB
            $mTime = date("H:i:s");
            $mDate = date("Y-m-d");
            $tMH_SQLinsert = "INSERT INTO nhi_maintenance_history (";
            $tMH_SQLinsert .= "mh_dps_barcode, ";
            $tMH_SQLinsert .= "mh_date, ";
            $tMH_SQLinsert .= "mh_notes ";
            $tMH_SQLinsert .= ") ";

            $tMH_SQLinsert .= "VALUES (";
            $tMH_SQLinsert .= "'" . $barcode . "', ";
            $tMH_SQLinsert .= "'" . $mDate . " " . $mTime . "', ";
            $tMH_SQLinsert .= "'" . $notes . "' ";
            $tMH_SQLinsert .= ") ";


            if (mysqli_query($dbSelected, $tMH_SQLinsert)) {
                $returnMsg = "Maintenance Entry of Asset <strong>" . $barcode . "</strong>";
                $returnMsg .= " was successful.";
                $notes = "";

                //format the maintenance details
                $noteRow = fn_format_maintenance_details($barcode, $dbSelected);

                $notes = "";
            } else {
                $errorMsg = "FAILED to add insert Maintenance data.<br />";
                $errorMsg .= mysqli_error($dbSelected) . "<br /><br />";
                $returnMsg = dataError($errorMsg);
            }
        }
    }
} //db SUCCESS
?>

<form class ="assetDetails" method="post" action="index.php?content=assetMaintenanceInsert" >
    <div class="fieldSet">
        <fieldset>
            <legend>Asset Details
                <span class="links"><a href="index.php?content=assetEdit&barcode=<?php echo $barcode ?>">Edit</a></span>
                <span class="links"><a href="index.php?content=assetCheckIn&barcode=<?php echo $barcode ?>">Check-In</a></span>
                <span class="links"><a href="index.php?content=assetTestCheckout&barcode=<?php echo $barcode; ?>">Check-Out</a></span>
            </legend>

            <input type="hidden" name="update" value="<?php echo $update; ?>"/>
            <input type="hidden" name="insert" value="<?php echo $insert; ?>"/>
            <input type="hidden" name="assetType" value="<?php echo $assetType; ?>"/>
            <input type="hidden" name="make" value="<?php echo $make; ?>"/>
            <input type="hidden" name="model" value="<?php echo $model; ?>"/>
            <input type="hidden" name="name" value="<?php echo $name; ?>"/>
            <input type="hidden" name="mTime" value="<?php echo $mTime; ?>"/>
            <input type="hidden" name="mDate" value="<?php echo $mDate; ?>"/>
            <input type="hidden" name="serialNo" value="<?php echo $serialNo; ?>"/>
            <input type="hidden" name="location" value="<?php echo $location; ?>"/>

            <p>
                <label class="field" for="barcode">DPS Barcode</label>
                <input type="text" name="barcode" id="barcode" class="textboxr-300" readonly value="<?php echo str_pad($barcode, 10, "0", STR_PAD_LEFT); ?>"/>
            </p>
            <!--format asset table -->
            <?php include('includes/common_assetTable_format.php'); ?>


        </fieldset>
        <?php
        $test = new DateTime($mDate);
        ?>
        <div class="maintenance">
            <fieldset>
                <legend>Maintenance Details</legend>

                <p>
                    <label class="field" for="noteRow">Previous Notes</label>
                    <textarea  name="noteRow" id="notes" class="noteboxr-300" rows="10" readonly ><?php echo $noteRow; ?></textarea>
                </p>

                <p>
                    <label class="field" for="notes">Notes</label>
                    <textarea  name="notes" id="notes" class="notebox-300"  rows="10" autofocus ><?php echo $notes; ?></textarea>
                </p>

            </fieldset>
        </div>


    </div>
    <input type="submit" value="Update">
</form>
<script>
    $("#pageTitle").text("Maintenance - Update");
</script>
