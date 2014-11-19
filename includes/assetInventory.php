<?php
include('includes/fn_insert_validations.php');
include('includes/fn_isCheckout.php');
include('includes/fn_doesExist.php');
include('includes/fn_getAssetInfo.php');
include('includes/fn_getCount.php');
$returnMsg = "Enter Room ";

$styleError = "background-color:red;border-color:red";
$barcode = array_fill(0, 10, "");
$data = array_fill(0, 10, "");
$remove = array_fill(0, 10, "");
$room = $person = ""; 

if ($dbSuccess) {

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        //select barcode
       if (isset($_GET["room"]) && strlen(clean_input($_GET["room"]) > 0)) {
            $room = clean_input($_GET["room"]);
          //  $data[0] = getAssetInfo($dbSelected, $barcode[0]);
            //populate data based on what is already their
      
          }
      
      
    }
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // if(isset(filter_input(INPUT_POST,'barcode[]',FILTER_SANITIZE_SPECIAL_CHARS)))
        $room = filter_input(input_post,'room',FILTER_SANITIZE_SPECIAL_CHARS);
        $remove = filter_input(input_post,'remove',FILTER_SANITIZE_SPECIAL_CHARS);
       

        print_r($room);
        print_r($barcode);
        print_r($remove);
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
                            <th class="input-100">Remove</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($x = 0; $x < count($barcode); $x++) {
                            echo "<tr class = 'row'>
                                <td class='checkDetailBarcode'>
                                    <input type='text' name='barcode[]' id='barcode' class='input-100' value='$barcode[$x]' "
                            . "onchange='showInfo(this.value, \"data$x\" )' />
                                </td>
                                <td class='input-500' id='data$x'>$data[$x]</td>
                                <td class='input-100'>
                                   <input type='checkbox' name='remove[]' id='remove' class='input-100' value='$remove[$x]' />
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