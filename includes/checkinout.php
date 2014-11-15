<?php
include('includes/fn_insert_validations.php');
include('includes/dbaccess.php');
$assetType = $make = $model = $name = "";
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
        if (!empty($barcode)) {  //   SQL:    Select from Asset table
            $tAsset_SQLselect = "Select ass_type, ass_make, ass_model, ass_name ";
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
                    }
                }
                $tCIO_SQLselect = "Select * ";
                $tCIO_SQLselect .= "FROM nhi_check_io ";
                $tCIO_SQLselect .= "WHERE cio_dps_barcode = $barcode ";
                $tCIO_SQLselect .= "AND cio_check_out_date > 0 ";
                $tCIO_SQLselect .= "AND cio_check_in_date = 0 ";

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
                                $coTime = date_format($test,"H:i:s");
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
                }
            } 
        }else {
                echo "barcode not found";
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

        $coDate = clean_input($_POST["coDate"]);
        $coName = clean_input($_POST["coName"]);
        $coTelephone = clean_input($_POST["coTelephone"]);
        $coEmail = clean_input($_POST["coEmail"]);
        $coRoom = clean_input($_POST["coRoom"]);
        $coNotes = clean_input($_POST["coNotes"]);
        $ciDate = clean_input($_POST["ciDate"]);
        $ciNotes = clean_input($_POST["ciNotes"]);
        $coTime = clean_input($_POST["coTime"]);
        
        if ($insert === "n") {
            $readonly = " readonly";
        }
//EDIT CHECKS for Insert

        if ($insert === "y") {
            $hasError = FALSE;
            if (empty($coDate)) {
                $coDateError = "A Check Out Date is required";
                $hasError = TRUE;
            }
            if (strlen($coDateError) > 0) {
                $returnMsg .= $coDateError . "; ";
            }

            if (empty($coName)) {
                $coNameError = "A Name is required";
                $hasError = TRUE;
            }
            if (strlen($coNameError) > 0) {
                $returnMsg .= $coNameError . "; ";
            }

            if (empty($coTelephone)) {
                $coTelephoneError = "A Telephone Number is required";
                $hasError = TRUE;
            }
            if (strlen($coTelephoneError) > 0) {
                $returnMsg .= $coTelephoneError . "; ";
            }

            if (empty($coEmail)) {
                $coEmailError = "An e-Mail address is required";
                $hasError = TRUE;
            }
            if (strlen($coEmailError) > 0) {
                $returnMsg .= $coEmailError . "; ";
            }

            if (empty($coRoom)) {
                $coRoomError = "A Room number is required";
                $hasError = TRUE;
            }
            if (strlen($coRoomError) > 0) {
                $returnMsg .= $coRoomError . "; ";
            }
        }

        if ($insert === "y" && !$hasError) {
//Insert into DB
            $coTime = date("H:i:s"); 
            $tCio_SQLinsert = "INSERT INTO nhi_check_io (";
            $tCio_SQLinsert .= "cio_dps_barcode, ";
            $tCio_SQLinsert .= "cio_check_out_date, ";
            $tCio_SQLinsert .= "cio_name, ";
            $tCio_SQLinsert .= "cio_telephone, ";
            $tCio_SQLinsert .= "cio_email, ";
            $tCio_SQLinsert .= "cio_room, ";
            $tCio_SQLinsert .= "cio_check_out_notes ";
            $tCio_SQLinsert .= ") ";

            $tCio_SQLinsert .= "VALUES (";
            $tCio_SQLinsert .= "'" . $barcode . "', ";
            $tCio_SQLinsert .= "'" . $coDate . " " .$coTime."', ";
            $tCio_SQLinsert .= "'" . $coName . "', ";
            $tCio_SQLinsert .= "'" . $coTelephone . "', ";
            $tCio_SQLinsert .= "'" . $coEmail . "', ";
            $tCio_SQLinsert .= "'" . $coRoom . "', ";
            $tCio_SQLinsert .= "'" . $coNotes . "' ";
            $tCio_SQLinsert .= ") ";


            if (mysqli_query($dbSelected, $tCio_SQLinsert)) {
                $returnMsg = "Check out of Asset <strong>" . $barcode . "</strong>";
                $returnMsg .= " was successful.";
                $returnMsg .= ".<br /><br />";
            } else {
                $errorMsg = "FAILED to add insert CO data.<br />";
                $errorMsg .= mysqli_error($dbSelected) . "<br /><br />";
                $returnMsg = dataError($errorMsg);
            }
        }
    }
//EDIT CHECKS for Update

    if ($update === "y") {
        $hasError = FALSE;
        if (empty($ciDate)) {
            $ciDateError = "A Check In Date is required";
            $hasError = TRUE;
        }
        if (strlen($ciDateError) > 0) {
            $returnMsg .= $ciDateError . "; ";
        }
    }
    //echo "update $update <br/>";
   // echo "haserror $hasError <br/>";
    if ($update === "y" and !$hasError) { {  //   SQL:     $tnhi_CIO_SQLupdate
            $time = date("H:i:s");
            $tcio_SQLupdate = "UPDATE nhi_check_io SET ";
            $tcio_SQLupdate .= "cio_check_in_date = " . "'" . $ciDate . " " .$time."', ";
            $tcio_SQLupdate .= "cio_check_in_notes = " . "'" . $ciNotes . "' ";
            $tcio_SQLupdate .= "WHERE cio_dps_barcode = " . "'" . $barcode . "' ";
            $tcio_SQLupdate .= "AND   cio_check_out_date = " . "'" . $coDate . " " .$coTime."'";

        //print_r($tcio_SQLupdate);
            if (mysqli_query($dbSelected, $tcio_SQLupdate)) {
                $returnMsg = "Check in of Asset <strong>" . $barcode . "</strong>";
                $returnMsg .= " was successful.";
                $returnMsg .= ".<br /><br />";
            } else {
                $errorMsg = "FAILED to add update CI data.<br />";
                $errorMsg .= mysqli_error($dbSelected) . "<br /><br />";
                $returnMsg = dataError($errorMsg);
            }
        }
    } // POST response
//    echo $returnMsg;
} //db SUCCESS
?>

<form class ="assetDetails" method="post" action="index.php?content=assetCheckInOut" >
    <div class="fieldSet">
        <fieldset>
            <legend>Asset Details</legend>

            <input type="hidden" name="update" value="<?php echo $update; ?>"/>
            <input type="hidden" name="insert" value="<?php echo $insert; ?>"/>
            <input type="hidden" name="assetType" value="<?php echo $assetType; ?>"/>
            <input type="hidden" name="make" value="<?php echo $make; ?>"/>
            <input type="hidden" name="model" value="<?php echo $model; ?>"/>
            <input type="hidden" name="name" value="<?php echo $name; ?>"/>
            <input type="hidden" name="coTime" value="<?php echo $coTime; ?>"/>

            <p>
                <label class="field" for="barcode">DPS Barcode</label>
                <input type="text" name="barcode" id="barcode" class="textboxr-300" readonly value="<?php echo str_pad($barcode, 10, "0", STR_PAD_LEFT);; ?>"/>
            </p>
            <table id="assetDetails">
                <thead>
                    <tr>
                        <th colspan="4">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="tblName">Type:</td>
                        <td class="tblValue"><?php echo $assetType; ?></td>
                        <td class="tblName">Make:</td>
                        <td class="tblValue"><?php echo $make; ?></td>
                    </tr>
                    <tr>
                        <td class="tblName">Model:</td>
                        <td class="tblValue"><?php echo $model; ?></td>
                        <td class="tblName">Name:</td>
                        <td class="tblValue"><?php echo $name; ?></td>
                    </tr>
                </tbody>
            </table>


        </fieldset>
        <?php  

        $test = new DateTime($coDate);
       ?>
        <div class="checkout">
            <fieldset>
                <legend>Check-Out Details</legend>
                <p>
                    <label class="field" for="coDate">Check-out Date</label>
                    <input type="date" name="coDate" id="coDate" class="textbox-300" value="<?php echo date_format($test,'Y-m-d'); ?>" <?php echo $readonly ?>/>
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
        <div class="checkin">
            <fieldset>
                <legend>Check-In Details</legend>
                <p>
                    <label class="field" for="ciDate">Check-in Date</label>
                    <input type="date" name="ciDate" id="ciDate" class="textbox-300" value="<?php echo $ciDate; ?>"/>
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
<?php echo $returnMsg; ?>
