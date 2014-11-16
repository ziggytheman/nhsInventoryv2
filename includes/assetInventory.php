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
    $("#pageTitle").text("Asset Inventory");
</script>