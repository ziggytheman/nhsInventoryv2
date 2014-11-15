<?php
include('includes/fn_insert_validations.php');
include('includes/dbaccess.php');
$assetType = $make = $model = $name = $serialNo = $location = "";
$coDate = $coName = $coTelephone = $coEmail = $coRoom = $coNotes = $coTime = "";
$ciDate = $ciNotes = "";
$hasError = FALSE;
$returnMsg = "";
$coDateError = $coNameError = $coTelephoneError = $coEmailError = $coRoomError = "";
$ciDateError = "";
$insert = "n";
$update = "n";
$readonly = "";

if ($dbSuccess) {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $barcode = clean_input($_GET["barcode"]);
        if (!empty($barcode) && $barcode != 0) {  //   SQL:    Select from Asset table
            include('includes/common_assetTable_sql.php');
            $tCIO_SQLselect = "Select * ";
            $tCIO_SQLselect .= "FROM nhi_check_io, nhi_check_io_details ";
            $tCIO_SQLselect .= "WHERE ";
            $tCIO_SQLselect .= "ciod_dps_barcode = $barcode and ";
            $tCIO_SQLselect .= "cio_check_out_date > 0 and ";
            $tCIO_SQLselect .= "ciod_check_out_date = cio_check_out_date and ";
            $tCIO_SQLselect .= "ciod_check_in_date = 0";


            $tCIO_SQLselect_Query = mysqli_query($dbSelected, $tCIO_SQLselect);
//                $insert = true;
            if ($row = mysqli_fetch_assoc($tCIO_SQLselect_Query)) {
                $readonly = " readonly";
                $update = "y";
                $insert = "n";
                foreach ($row as $idx => $r) {
                    switch ($idx) {
                        case "cio_check_out_date":
                            $coDate = $r;
                            $test = new DateTime($coDate);
                            $coTime = date_format($test, "H:i:s");
                            break;
                        case "cio_name":
                            $coName = $r;
                            break;
                        case "cio_telephone":
                            $coTelephone = $r;
                            break;
                        case "cio_email":
                            $coEmail = $r;
                            break;
                        case "cio_room":
                            $coRoom = $r;
                            break;
                        case "cio_check_out_notes":
                            $coNotes = $r;
                            break;
                    }
                }
            } else {
                $insert = "y";
                $update = "n";
                $returnMsg = "This item has not been checked out";
                $readonly = " readonly";
            }
        } else {
            $returnMsg = "barcode not found";
            $readonly = " readonly";
        }
    }
}
if ($dbSuccess) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
//        print_r($_POST);
        $insert = clean_input($_POST["insert"]);
        $update = clean_input($_POST["update"]);
        $barcode = clean_input($_POST["barcode"]);
        $assetType = clean_input($_POST["assetType"]);
        $make = clean_input($_POST["make"]);
        $model = clean_input($_POST["model"]);
        $name = clean_input($_POST["name"]);
        $serialNo = clean_input($_POST["serialNo"]);
        $location = clean_input($_POST["location"]);

        $coDate = clean_input($_POST["coDate"]);
        $coName = clean_input($_POST["coName"]);
        $coTelephone = clean_input($_POST["coTelephone"]);
        $coEmail = clean_input($_POST["coEmail"]);
        $coRoom = clean_input($_POST["coRoom"]);
        $coNotes = clean_input($_POST["coNotes"]);
        $ciDate = clean_input($_POST["ciDate"]);
        $ciNotes = clean_input($_POST["ciNotes"]);
        $coTime = clean_input($_POST["coTime"]);

        $tCIO_SQLselect = "Select * ";
        $tCIO_SQLselect .= "FROM nhi_check_io, nhi_check_io_details ";
        $tCIO_SQLselect .= "WHERE ";
        $tCIO_SQLselect .= "ciod_dps_barcode = $barcode and ";
        $tCIO_SQLselect .= "cio_check_out_date > 0 and ";
        $tCIO_SQLselect .= "ciod_check_out_date = cio_check_out_date and ";
        $tCIO_SQLselect .= "ciod_check_in_date = 0";

        $tCIO_SQLselect_Query = mysqli_query($dbSelected, $tCIO_SQLselect);

        if ($row = mysqli_fetch_assoc($tCIO_SQLselect_Query)) {
            //         header("Location: index.php?content=assetCheckInProcess&barcode=$barcode");
        } else {
            $returnMsg = "Item  <b>" . $barcode . "</b> has not been checked out";
            $insert = "n";
            $update = "n";
        }
        if ($insert === "n") {
            $readonly = " readonly";
        }
        // }
//EDIT CHECKS for Update

        if ($update === "y") {
            $hasError = FALSE;
            if (empty($ciDate)) {
                $ciDate = Date($ciDate);
            }
        }
        //echo "update $update <br/>";
        // echo "haserror $hasError <br/>";
        if ($update === "y" and !$hasError) { {  //   SQL:     $tnhi_CIO_SQLupdate
                $time = date("H:i:s");
                $tciod_SQLupdate = "UPDATE nhi_check_io_details SET ";
                $tciod_SQLupdate .= "ciod_check_in_date = " . "'" . $ciDate . " " . $time . "', ";
                $tciod_SQLupdate .= "ciod_check_in_notes = " . "'" . $ciNotes . "' ";
                $tciod_SQLupdate .= "WHERE ciod_dps_barcode = " . "'" . $barcode . "' ";
                $tciod_SQLupdate .= "AND   ciod_check_out_date = " . "'" . $coDate . " " . $coTime . "'";

                //print_r($tcio_SQLupdate);
                if (mysqli_query($dbSelected, $tciod_SQLupdate)) {
                    $returnMsg = "Check in of Asset <strong>" . $barcode . "</strong>";
                    $returnMsg .= " was successful.";
                } else {
                    $errorMsg = "FAILED to add update CI data.<br />";
                    $errorMsg .= mysqli_error($dbSelected) . "<br /><br />";
                    $returnMsg = dataError($errorMsg);
                }
            }
        }
    } // POST response
} //db SUCCESS
?>

<form class ="assetDetails" method="post" action="index.php?content=assetCheckInProcess" >
    <div class="fieldSet">
        <fieldset>
            <legend>Asset Details
                <span class="links"><a href="index.php?content=assetEdit&barcode=<?php echo $barcode ?>">Edit</a></span>
                <span class="links"><a href="index.php?content=assetMaintentnanceInsert&barcode=<?php echo $barcode ?>">Maintenance</a></span>
            </legend>

            <input type="hidden" name="update" value="<?php echo $update; ?>"/>
            <input type="hidden" name="insert" value="<?php echo $insert; ?>"/>
            <input type="hidden" name="assetType" value="<?php echo $assetType; ?>"/>
            <input type="hidden" name="make" value="<?php echo $make; ?>"/>
            <input type="hidden" name="model" value="<?php echo $model; ?>"/>
            <input type="hidden" name="name" value="<?php echo $name; ?>"/>
            <input type="hidden" name="coTime" value="<?php echo $coTime; ?>"/>
            <input type="hidden" name="serialNo" value="<?php echo $serialNo; ?>"/>
            <input type="hidden" name="location" value="<?php echo $location; ?>"/>

            <p>
                <label class="field" for="barcode">DPS Barcode</label>
                <input type="text" name="barcode" id="barcode" class="textboxr-300" readonly value="<?php
                echo str_pad($barcode, 10, "0", STR_PAD_LEFT);
                ;
                ?>"/>
            </p>
            <?php include('includes/common_assetTable_format.php'); ?>

        </fieldset>
        <?php
        $test = new DateTime($coDate);
        ?>
        <div class="checkout">
            <fieldset>
                <legend>Check-Out Details</legend>
                <p>
                    <label class="field" for="coDate">Check-out Date</label>
                    <input type="date" name="coDate" id="coDate" class="textbox-300" value="<?php echo date_format($test, 'Y-m-d'); ?>" <?php echo $readonly ?>/>
                    <span class="error"><?php echo $coDateError; ?></span>
                </p>
                <p>
                    <label class="field" for="coName">Name</label>
                    <input type="text" name="coName" id="coName" class="textbox-300" value="<?php echo $coName; ?>"<?php echo $readonly ?>/>
                    <span class="error"><?php echo $coNameError; ?></span>
                </p>
                <p>
                    <label class="field" for="coTelephone">Telephone</label>
                    <input type="tel" name="coTelephone" id="coTelephone" class="textbox-300" value="<?php echo $coTelephone; ?>"<?php echo $readonly; ?>/>
                    <span class="error"><?php echo $coTelephoneError; ?></span>
                </p>
                <p>
                    <label class="field" for="coEmail">e-Mail</label>
                    <input type="email" name="coEmail" id="coEmail" class="textbox-300" value="<?php echo $coEmail; ?>"<?php echo $readonly; ?>/>
                    <span class="error"><?php echo $coEmailError; ?></span>
                </p>
                <p>
                    <label class="field" for="coRoom">Room</label>
                    <input type="text" name="coRoom" id="coRoom" class="textbox-300" value="<?php echo $coRoom; ?>"<?php echo $readonly; ?>/>
                    <span class="error"><?php echo $coRoomError; ?></span>  
                </p>
                <p>
                    <label class="field" for="coNotes">Notes</label>
                    <textarea  name="coNotes" id="coNotes" class="textbox-300" <?php echo $readonly; ?>/><?php echo $coNotes; ?></textarea>
                </p>

            </fieldset>
        </div>
        <?php
        $test = new DateTime($ciDate);
        ?>
        <div class="checkin">
            <fieldset>
                <legend>Check-In Details</legend>
                <p>
                    <label class="field" for="ciDate">Check-in Date</label>
                    <input type="date" name="ciDate" id="ciDate" class="textbox-300" value="<?php echo date_format($test, 'Y-m-d'); ?>"/>
                    <span class="error"><?php echo $ciDateError; ?></span> 
                </p>

                <p>
                    <label class="field" for="ciNotes">Notes</label>
                    <textarea  name="ciNotes" id="ciNotes" class="textbox-300"/><?php echo $ciNotes; ?></textarea>
                </p>

            </fieldset>
        </div> 

    </div>
    <input type="submit" value="Update">
</form>
<script>
    $("#pageTitle").text("Check-In");
</script>

