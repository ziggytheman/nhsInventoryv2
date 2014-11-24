<?php
include('includes/fn_insert_validations.php');
include('includes/fn_isCheckout.php');
include('includes/fn_doesExist.php');
include('includes/fn_getAssetInfo.php');
include('includes/fn_getCount.php');
include('includes/fn_ValidateDetails.php');
include('includes/fn_UpdateDetails.php');
include('includes/fn_isInventoryed.php');

$returnMsg = "Enter Room Details ";
$_SESSION["errorMsg"] = "";
$_SESSION["statusMsg"] = "";
$styleError = "background-color:red;border-color:red";
$barcode = array_fill(0, 10, "");
$details = array_fill(0, 10, "");

$room = "";
$timeFrame = "Fall-2014";
$hasError = false;

if ($dbSuccess) {

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $room = filter_input(INPUT_GET, 'room', FILTER_SANITIZE_SPECIAL_CHARS);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $room = filter_input(INPUT_POST, 'room', FILTER_SANITIZE_SPECIAL_CHARS);
        //  $barcodeTemp = filter_input(INPUT_POST, 'barcode', FILTER_SANITIZE_SPECIAL_CHARS);
        $barcodeTemp = ($_POST['barcode']);

        $barcode = array_values(array_unique($barcodeTemp));

        for ($x = count($barcode); $x < 10; $x++) {
            array_push($barcode, "");
        }
        if (getCount($barcode) > 0) {
            for ($x = 0; $x < count($barcode); $x++) {
                if (strlen($barcode[$x]) > 0) {
                    $details[$x] = getAssetInfo2($dbSelected, $barcode[$x]);
                    if (!doesExist($dbSelected, $barcode[$x]) or isInventoryed($dbSelected, $barcode[$x])) {
                        // we have an error  
                        $errorMsg .= "Check Details for error information; ";
                        $hasError = TRUE;
                    }
                }
            }
        }

        //$haserror = validateDetails($dbSelected, $barcode);
        if (!$hasError) {
            $hasError = updateDetails($dbSelected, $barcode, $room, $timeFrame);
                        if (!$hasError) {

                $_SESSION["statusMsg"] = " Update successful";
                header("Location: index.php?content=assetInventoryInitial");
            } else {
                $_SESSION["errorMsg"] = " Error ";
                $_SESSION["statusMsg"] = " Error ";
                echo " Error after Update";
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

                            echo "<tr class = 'row'>
                                <td class='checkDetailBarcode'>
                                    <input type='text' name='barcode[]' id='barcode' class='input-100' value='$barcode[$x]' "
                            . "onchange='showInfo(this.value, \"details$x\" )' />
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
    <input type="submit" value="Update">
    <input type="reset" value="Cancel">
</form>
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
