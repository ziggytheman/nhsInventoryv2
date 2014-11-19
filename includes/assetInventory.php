<?php
include('includes/fn_insert_validations.php');
include('includes/fn_isCheckout.php');
include('includes/fn_doesExist.php');
include('includes/fn_getAssetInfo.php');
include('includes/fn_getCount.php');
$returnMsg = "Enter Room ";

$styleError = "background-color:red;border-color:red";
$barcode = array_fill(0, 10, "");
$details = array_fill(0, 10, "");
$remove = array_fill(0, 10, "");
$confirm = array_fill(0, 10, "");
$room = $person = "";

if ($dbSuccess) {

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $room = filter_input(INPUT_GET, 'room', FILTER_SANITIZE_SPECIAL_CHARS);

        // if (isset($_GET["room"]) && strlen(clean_input($_GET["room"]) > 0))
        {
            $room = filter_input(INPUT_GET, 'room', FILTER_SANITIZE_SPECIAL_CHARS);
            //  $data[0] = getAssetInfo($dbSelected, $barcode[0]);
            //populate data based on what is already their
            //get items in room
            $SQLselect = "Select * ";
            $SQLselect .= "FROM vassetsbyroom ";
            $SQLselect .= "WHERE Location = '$room' ";

            $SQLselect_Query = mysqli_query($dbSelected, $SQLselect);

            $rowCount = 0;
            while ($row = mysqli_fetch_assoc($SQLselect_Query)) {
                foreach ($row as $idx => $r) {
                    if ($idx === "Barcode") {
                        $r = str_pad($r, 10, "0", STR_PAD_LEFT);
                        $barcode[$rowCount] = $r;
                    } elseif ($idx === "Details") {
                        $details[$rowCount] = $r;
                    }
                }
                $rowCount++;
            }
        }
    }
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // if(isset(filter_input(INPUT_POST,'barcode[]',FILTER_SANITIZE_SPECIAL_CHARS)))
        $room = filter_input(INPUT_POST, 'room', FILTER_SANITIZE_SPECIAL_CHARS);
        $barcode = filter_input(INPUT_POST, 'barcode', FILTER_SANITIZE_SPECIAL_CHARS);
        $details = filter_input(INPUT_POST, 'details', FILTER_SANITIZE_SPECIAL_CHARS);
        $confirm = filter_input(INPUT_POST, 'confirm', FILTER_SANITIZE_SPECIAL_CHARS);
        $checked = filter_input(INPUT_POST, 'checked', FILTER_SANITIZE_SPECIAL_CHARS);
echo " here ";
        print_r($barcode);
        print_r($details);
        print_r($confirm);
        print_r($checked);


        $hasError = FALSE;
    }
}
?>

<form method="post" action="index.php?content=assetInventory" >
    <div class="fieldSet">
        <fieldset>
            <legend>Search Criteria</legend>
            <div class="column1">
                <p>
                    <label class="field" for="room">Room</label>
                    <input type="text" name="room" id="room" class="textbox-150" value="<?php echo $room; ?>" style="<?php echo $coRoomError; ?>"/>
                </p>
            </div>
            <!--       <div class="column2">
                       <p>
                           <label class="field" for="person">Person</label>
                           <input type="text" name="person" id="person" class="textbox-150" value="<?php echo $person; ?>" style="<?php echo $coPersonError; ?>"/>
       
                       </p>
                   </div>
            -->
        </fieldset>
        <div class="fieldSet">
            <fieldset>
                <legend>Inventory Details</legend>
                <table id="checkDetails">
                    <thead>
                        <tr>
                            <th class="input-100">Barcode</th>
                            <th class="input-500">Details</th>
                            <th class="input-100">Confirm</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($x = 0; $x < count($barcode); $x++) {
                            $checked[$x] = "no";
                            if (strlen($barcode[$x]) > 0) {
                                $checked[$x] = "checked";
                            }
                            echo "<tr class = 'row'>
                                <td class='checkDetailBarcode'>
                                    <input type='text' name='barcode[]' id='barcode' class='input-100' value='$barcode[$x]' "
                            . "onchange='showInfo(this.value, \"details$x\" )' />
                                </td>
                                <td class='input-500' id='details$x'>$details[$x]</td>
                                <td class='input-100'>
                                   <input type='radio' name='confirm$x' id='confirm$x'  value='yes' $checked[$x]>Yes
                                   <input type='radio' name='confirm$x' id='confirm$x'  value='no'>No                       
                            
                                </td>
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
    $("#pageTitle").text("Asset Inventory");
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
