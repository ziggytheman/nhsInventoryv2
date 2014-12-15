<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$errorMsg = "";
$returnMsg = "Enter Room Information";
//$_SESSION['errorMsg'] = "default";
//$_SESSION['statusMsg'] = "";
$errorMsg = "";
$statusMsg ="";

include('includes/fn_insert_validations.php');
include('includes/fn_isRoomValid.php');
include('includes/fn_createRoomDropDown.php');

$room = $person = $roomError = "";
$roomOption = createRoomDropDown($dbSelected);

if ($dbSuccess) {
    /*    if ($_SERVER["REQUEST_METHOD"] == "GET") {

      $room = strtoupper(filter_input(INPUT_GET, 'room', FILTER_SANITIZE_SPECIAL_CHARS));
      if (strlen($room) > 0) {
      if (isRoomValid($dbSelected, $room)) {
      header("Location: index.php?content=assetInventory&room=$room");
      } else {
      $_SESSION['errorMsg'] = "Room not found";
      }
      } else {
      $_SESSION['errorMsg'] = "Enter a Room2";
      }
      }
     */
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //$room = filter_input('INPUT_POST','room', FILTER_SANITIZE_SPECIAL_CHARS);
        $room = strtoupper(filter_input(INPUT_POST, 'room', FILTER_SANITIZE_SPECIAL_CHARS));
    //    print_r("Room -->" . $room . '</br>');

        if (strlen($room) > 0) {
            if (isRoomValid($dbSelected, $room)) {
                header("Location: index.php?content=assetInventory&room=$room");
            } else {
            //    $_SESSION['errorMsg'] = "Room not found";
                $errorMsg = "Room not found";
            }
        } else {
//            $_SESSION['errorMsg'] = "Enter a Room" . $_SESSION['debugx'];
//            print_r("Error Enter a Room Session value --> " . $_SESSION['errorMsg'] . '<--</br>');
//            $_SESSION['debugx'] ++;
            $errorMsg ="Enter a Room";
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
                <input list="rooms" name="room" id="room" class="textbox-150" autofocus/>
                <datalist id="rooms">
                    <?php echo $roomOption; ?>       
                </datalist>           
            </p>
        </div>
    </fieldset>
    <input type="submit" value="Go">
</form>
<script>
    $("#pageTitle").text("Asset Inventory");
</script>
