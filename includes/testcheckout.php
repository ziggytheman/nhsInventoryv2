<?php
//include('includes/dbaccess.php');
include('includes/fn_insert_validations.php');
include('includes/fn_isCheckout.php');
include('includes/fn_doesExist.php');
include('includes/fn_getAssetInfo.php');
include('includes/fn_getCount.php');
$assetType = $make = $model = $name = $serialNo = $location = "";
$coDate = $coName = $coTelephone = $coEmail = $coRoom = $coNotes = $coTime = "";
$ciDate = $ciNotes = "";
$hasError = $rollBack = FALSE;
$returnMsg = "Enter check-out data; ";
$coDateError = $coNameError = $coTelephoneError = $coEmailError = $coRoomError = "";
$coDateErrorMsg = $coNameErrorMsg = $coTelephoneErrorMsg = $coEmailErrorMsg = $coRoomErrorMsg = "";
$styleError = "background-color:red;border-color:red";
$barcode = array_fill(0, 10, "");
$data = array_fill(0, 10, "");

if ($dbSuccess) {
		
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //select barcode
        if (isset($_GET["barcode"]) && strlen(clean_input($_GET["barcode"])>0)) {
            $barcode[0] = clean_input($_GET["barcode"]);
            $data[0] = getAssetInfo($dbSelected, $barcode[0]);
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // if(isset(filter_input(INPUT_POST,'barcode[]',FILTER_SANITIZE_SPECIAL_CHARS)))
        $barcode = ($_POST["barcode"]);
        $coDate = clean_input($_POST["coDate"]);
        $coName = clean_input($_POST["coName"]);
        $coTelephone = clean_input($_POST["coTelephone"]);
        $coEmail = clean_input($_POST["coEmail"]);
        $coRoom = clean_input($_POST["coRoom"]);
        $coNotes = clean_input($_POST["coNotes"]);

        //      print_r($barcode);
        //print_r($data);
        $hasError = FALSE;
        if (empty($coDate)) {
            $coDateError = $styleError;
            $coDateErrorMsg = " Enter Date";
            $hasError = TRUE;
        }
        if (strlen($coDateError) > 0) {
            $returnMsg .= $coDateErrorMsg . "; ";
        }

        if (empty($coName)) {
            $coNameError = $styleError;
            $coNameErrorMsg = " Enter Name";
            $hasError = TRUE;
        }
        if (strlen($coNameError) > 0) {
            $returnMsg .= $coNameErrorMsg . "; ";
        }
        //Process each barcode to make sure they exist and are available for checkout; set error condition if that is the case
        // echo "</br> count " . count($barcode) . " </br>";
        //remove duplicates
        $barcode = array_values(array_unique($barcode));
        for ($x = count($barcode); $x < 10; $x++) {
            array_push($barcode, "");
        }


        if (getCount($barcode) > 0) {
            for ($x = 0; $x < count($barcode); $x++) {

                if (strlen($barcode[$x]) > 0) {
                    $data[$x] = getAssetInfo($dbSelected, $barcode[$x]);
                    if (isCheckedOut($dbSelected, $barcode[$x]) ||
                            !doesExist($dbSelected, $barcode[$x])) {

                        // we have an error  
                        //echo "error in selection $barcode[$x]</br>";
                        $returnMsg .= "Check Details for error information; ";
                        $hasError = TRUE;
                    }
                }
            }
        } else {
            $returnMsg .= "Enter Details for check out; ";
            $hasError = TRUE;
        }
        //if no error then start processing each item one at a time
        //write a record for each item
        //if successful display message

        if (!$hasError) {
            //print_r(" Here Count= " . getCount($barcode));

            if (getCount($barcode) > 0) {

                //format common data
                $coTime = date("H:i:s");
                $tCio_SQLinsert = "INSERT INTO nhi_check_io (";
                $tCio_SQLinsert .= "cio_check_out_date, ";
                $tCio_SQLinsert .= "cio_name, ";
                $tCio_SQLinsert .= "cio_telephone, ";
                $tCio_SQLinsert .= "cio_email, ";
                $tCio_SQLinsert .= "cio_room, ";
                $tCio_SQLinsert .= "cio_check_out_notes ";
                $tCio_SQLinsert .= ") ";

                $tCio_SQLinsert .= "VALUES (";
                $tCio_SQLinsert .= "'" . $coDate . " " . $coTime . "', ";
                $tCio_SQLinsert .= "'" . $coName . "', ";
                $tCio_SQLinsert .= "'" . $coTelephone . "', ";
                $tCio_SQLinsert .= "'" . $coEmail . "', ";
                $tCio_SQLinsert .= "'" . $coRoom . "', ";
                $tCio_SQLinsert .= "'" . $coNotes . "' ";
                $tCio_SQLinsert .= ") ";

                //          print_r($tCio_SQLinsert);

                if (mysqli_query($dbSelected, $tCio_SQLinsert)) {

                    for ($x = 0; $x < count($barcode); $x++) {
                        if (strlen($barcode[$x]) > 0) {
                            //format and write each record

                            $tCiod_SQLinsert = "INSERT INTO nhi_check_io_details (";
                            $tCiod_SQLinsert .= "ciod_dps_barcode, ";
                            $tCiod_SQLinsert .= "ciod_check_out_date ";
                            $tCiod_SQLinsert .= ") ";

                            $tCiod_SQLinsert .= "VALUES (";
                            $tCiod_SQLinsert .= "'" . $barcode[$x] . "', ";
                            $tCiod_SQLinsert .= "'" . $coDate . " " . $coTime . "' ";
                            $tCiod_SQLinsert .= ") ";

                            // print_r($tCiod_SQLinsert);

                            if (mysqli_query($dbSelected, $tCiod_SQLinsert)) {
                                $returnMsg = "Check out ";
                                $returnMsg .= " was successful.";
                                $returnMsg .= ".<br />";
                            } else {
                                $errorMsg = "FAILED to add insert CO detail data.<br />";
                                $errorMsg .= mysqli_error($dbSelected) . "<br /><br />";
                                $returnMsg = dataError($errorMsg);
                                $rollBack = TRUE;
                            }
                        }
                    }
                } else {
                    $errorMsg = "FAILED to add insert CO data.<br />";
                    $errorMsg .= mysqli_error($dbSelected) . "<br /><br />";
                    $returnMsg = dataError($errorMsg);
                    $rollBack = TRUE;
                }


                //   print_r($data);
            }
        }
    }
    $coDate = date('Y-m-d');
	include('includes/employeeDropDown.php');
}
?>
<form method="post" action="index.php?content=assetTestCheckout" >
    <div class="fieldSet">
        <fieldset>
            <legend>Asset Check-Out Information</legend>
            <div class="column1">
                <p>
                    <label class="field" for="coDate">Check-out Date</label>
                    <input type="date" name="coDate" id="coDate" class="textbox-150" value="<?php echo $coDate; ?>" style="<?php echo $coDateError; ?>"/>

                </p>
                <p>
                    <label class="field" for="coName">Name</label>
					<input type="text" name="coName" id="coName" class="textbox-150" value="<?php echo $coName; ?>" style="<?php echo $coNameError; ?>"/>
				<!--	<input id="coName" name="coName" type="text" list="coName" class="textbox-150"  />
					<datalist id="coName">
						//<?php echo $employeeDropDown; ?>
					</datalist>
					-->
                    
				
                </p>
                <p>
                    <label class="field" for="coTelephone">Telephone</label>
                    <input type="tel" name="coTelephone" id="coTelephone" class="textbox-150" value="<?php echo $coTelephone; ?>" style="<?php echo $coTelephoneError; ?>"/>

                </p>
            </div>
            <div class="column2">
                <p>
                    <label class="field" for="coEmail">e-Mail</label>
                    <input type="email" name="coEmail" id="coEmail" class="textbox-150" value="<?php echo $coEmail; ?>" style="<?php echo $coEmailError; ?>"/>

                </p>
                <p>
                    <label class="field" for="coRoom">Room</label>
                    <input type="text" name="coRoom" id="coRoom" class="textbox-150" value="<?php echo $coRoom; ?>" style="<?php echo $coRoomError; ?>"/>

                </p>
                <p>
                    <label class="field" for="coNotes">Notes</label>
                    <textarea  name="coNotes" id="coNotes" class="textbox-150"><?php echo $coNotes; ?></textarea>
                </p>
            </div>
        </fieldset>
        <div class="fieldSet">
            <fieldset>
                <legend>Asset Check-Out Details</legend>
                <table id="checkDetails">
                    <thead>
                        <tr>
                            <th class="input-100">Barcode</th>
                            <th class="input-500">Details</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($x = 0; $x < count($barcode); $x++) {
                            echo "<tr class = 'row'>
                                <td class='checkDetailBarcode'>
                                    <input type='text' name='barcode[]' id='barcode' class='input-100' value='$barcode[$x]' "
                            . "onchange='showInfo(this.value, \"data$x\" )' </td>
                                <td class='input-500' id='data$x'>$data[$x]</td>
                            </tr>";
                        };
                        ?>

                    </tbody>
                </table>


            </fieldset>
        </div>
    </div>
    <input type="submit" value="Check Out">
</form>
<script>
    $("#pageTitle").text("Check-Out Test");
</script>
<script>
    function showInfo(str, id)
    {

        if (str === "")
        {
            document.getElementById(id).innerHTML = "";
            return;
        }

        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                document.getElementById(id).innerHTML = xmlhttp.responseText;
                document.getElementById(id).value = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "includes/getInfo.php?q=" + str, true);
        xmlhttp.send();

    }

</script>
