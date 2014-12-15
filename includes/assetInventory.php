<?php
include('includes/fn_insert_validations.php');
include('includes/fn_isCheckout.php');
include('includes/fn_doesExist.php');
include('includes/fn_getAssetInfo.php');
include('includes/fn_getCount.php');
include('includes/fn_ValidateDetails.php');
include('includes/fn_UpdateDetails.php');
include('includes/fn_isInventoryed.php');

$_SESSION['returnMsg'] = "Enter Room Details ";

//$_SESSION["errorMsg"] = "";
//$_SESSION["statusMsg"] = "";
$styleError = "background-color:red;border-color:red";
$barcode = array_fill(0, 10, "");
$details = array_fill(0, 10, "");
$totalRows = 0;
$done = "";
$checked = "";
$autofocus = "";
$rowX = 10;
$gotOne = false;

$room = "";
$timeFrame = "Fall-2014";
$hasError = false;

include('includes/common_message_handler.php');
if ($dbSuccess) {

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $room = filter_input(INPUT_GET, 'room', FILTER_SANITIZE_SPECIAL_CHARS);
        $errorMsg = "";
        $statusMsg = "";
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $room = filter_input(INPUT_POST, 'room', FILTER_SANITIZE_SPECIAL_CHARS);
        $done = filter_input(INPUT_POST, 'done', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($done === "yes") {
            $checked = "checked";
        } else {
            $checked = "";
        }

        //print_r("Done -->".$done.'</br>');
        //print_r("Checked -->".$checked.'</br>');
        //  $barcodeTemp = filter_input(INPUT_POST, 'barcode', FILTER_SANITIZE_SPECIAL_CHARS);
        $barcodeTemp = ($_POST['barcode']);

        $barcodeInitial = array_values(array_unique($barcodeTemp));

        $x = 0;
        $barcode = array();
        while ($x < count($barcodeInitial)) {
            if (strlen($barcodeInitial[$x]) > 0) {
                array_push($barcode, $barcodeInitial[$x]);
            }
            $x++;
        };

        for ($x = count($barcode); $x < 10; $x++) {
            array_push($barcode, "");
        }

        $rowX = count($barcode);
        if (getCount($barcode) > 0) {
            for ($x = 0; $x < count($barcode); $x++) {
                if (strlen($barcode[$x]) > 0) {
                    $gotOne = true;
                    $details[$x] = getAssetInfo2($dbSelected, $barcode[$x]);
                    if (!doesExist($dbSelected, $barcode[$x]) or isInventoryed($dbSelected, $barcode[$x])) {
                        // we have an error

                        if (!(strpos($errorMsg, 'Check Details for error information; ') > -1)) {
                            $errorMsg .= "Check Details for error information; ";
                        }

                        $hasError = TRUE;
                    }
                }
            }
        }

        //$haserror = validateDetails($dbSelected, $barcode);
        if(!$gotOne){
             $errorMsg .= " Please enter inventory data; ";
        }
        
        if ($done === 'yes' && $gotOne) {
            if (!$hasError) {
                $hasError = updateDetails($dbSelected, $barcode, $room, $timeFrame);
                if (!$hasError) {

                    $_SESSION["statusMsg"] = " Update successful";
                    $statusMsg = "Update sucessful";
                    header("Location: index.php?content=assetInventoryInitial");
                } else {
                    $_SESSION["errorMsg"] = " Error ";
                    $_SESSION["statusMsg"] = " Error ";
                    $errorMsg = "Update error";
                    $statusMsg = "Update Error";
                    echo " Error after Update";
                }
            }
        }
    }
    //print_r(get_defined_vars());
}
?>

<form method="post" action="index.php?content=assetInventory" >
    <div class="fieldSet">
        <fieldset>
            <legend>Search Criteria</legend>
            <div class="column1">
                <p>
                    <label class="field" for="room">Room</label>
                    <input type="text" name="room" id="room" class="textbox-150" readonly value="<?php echo $room; ?>"/>
                </p>
            </div>
            <div class="column2">
                <p>
                    <label class="field" for="room">Done</label>
                    <input type="checkbox" name="done" id="done" class="textbox-150" value='yes' <?php echo $checked; ?>/>
                </p>
            </div>
        </fieldset>
        <div class="fieldSet">
            <fieldset>
                <legend>Inventory Details</legend>
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
                            if (strlen($barcode[$x]) === 0) {
                                $autofocus = "autofocus";
                            } else {
                                $autofocus = "";
                            }

                            echo "<tr class = 'row'>
                                <td class='checkDetailBarcode'>
                                    <input type='text' name='barcode[]' id='barcode' class='input-100' value='$barcode[$x]' "
                            . "onchange='showInfo(this.value, \"details$x\" )' $autofocus/>
                                </td>
                                <td class='input-500' id='details$x'>$details[$x]</td>
                            </tr>";
                        }
                        ?>

                    </tbody>
                </table>


            </fieldset>
        </div>
    </div>
    <input type="submit" id="update" value="Update">
    <input type="reset" id="cancel" value="Cancel">
    <input type="button" id="addRow" value="Add"> 
</form>

<script>
    $("#addRow").click(function (event) {
        event.preventDefault();
        $rowX = $('.row').size();
        $("tbody tr:last").after("<tr class = 'row'> <td class='checkDetailBarcode'>" +
                "<input type='text' name='barcode[]' id='barcode' class='input-100' value=''" +
                "onchange='showInfo(this.value, \"details" + $rowX + "\" )' $autofocus/>" +
                "</td>" +
                "<td class='input-500' id='details" + $rowX + "'>" +
                "</td></tr>");
        '<?php array_push($barcode, ""); ?>';

    });
    $("#update").click(function (event) {


    });
</script>
<script>
    $("#pageTitle").text("Asset Inventory Details");
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
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
            {
                document.getElementById(id).innerHTML = xmlhttp.responseText;
                document.getElementById(id).value = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "includes/getInfo2.php?q=" + str, true);
        xmlhttp.send();

    }

</script>
