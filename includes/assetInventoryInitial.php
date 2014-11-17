<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$errorMsg = "";
$returnMsg = "Enter Room Information";
include('includes/fn_insert_validations.php');
include('includes/fn_isRoomValid.php');
$room = $person = "";

if ($dbSuccess) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //$room = filter_input('INPUT_POST','room', FILTER_SANITIZE_SPECIAL_CHARS);
        $room = strtoupper(filter_input(INPUT_POST, 'room', FILTER_SANITIZE_SPECIAL_CHARS));
        if (strlen($room) > 0) {
            if (isRoomValid($dbSelected, $room)) {
                header("Location: index.php?content=assetInventory&room=$room");
            } else {
                $errorMsg = "Room not found";
            }
        } else {
            $errorMsg = "Enter a Room";
        }
    }
}
?>

<form method="post" action="index.php?content=assetInventoryInitial" >
    <fieldset>
        <legend>Search Criteria</legend>
        <div class="column1">
            <p>
                <label class="field" for="room">Room</label>
                <input type="text" name="room" id="room" class="textbox-150" value="<?php echo $room; ?>" style="<?php echo $coRoomError; ?>"/>
            </p>
        </div>
        <div class="column2">
            <p>
                <label class="field" for="person">Person</label>
                <input type="text" name="person" id="person" class="textbox-150" value="<?php echo $person; ?>" style="<?php echo $coPersonError; ?>"/>

            </p>
        </div>
    </fieldset>
    <input type="submit" value="Go">
</form>
<script>
    $("#pageTitle").text("Asset Inventory");
</script>
