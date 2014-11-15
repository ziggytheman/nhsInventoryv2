<?php
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
$test = "2013-01-01";
?>
<form class ="assetDetails" method="post" action="index.php?next=check2.php" >
    <div class="checkout">
        <fieldset>
            <legend>Check-Out Details</legend>
            <div id="colA">
                <p>
                    <label class="field" for="coDate">Check-out Date</label>
                    <input type="date" name="coDate" id="coDate" class="textbox-150" value="<?php //echo date_format($test, 'Y-m-d');     ?>" <?php echo $readonly ?>/>
                </p>
                <p>
                    <label class="field" for="coName">Name</label>
                    <input type="text" name="coName" id="coName" class="textbox-150" value="<?php echo $coName; ?>"<?php echo $readonly ?>/>
                </p>  
                <p>
                    <label class="field" for="coTelephone">Telephone</label>
                    <input type="tel" name="coTelephone" id="coTelephone" class="textbox-150" value="<?php echo $coTelephone; ?>"<?php echo $readonly; ?>/>
                </p>

            </div>
            <div id="colB">

                <p>
                    <label class="field" for="coEmail">e-Mail</label>
                    <input type="email" name="coEmail" id="coEmail" class="textbox-150" value="<?php echo $coEmail; ?>"<?php echo $readonly; ?>/>
                </p>
                <p>
                    <label class="field" for="coRoom">Room</label>
                    <input type="text" name="coRoom" id="coRoom" class="textbox-150" value="<?php echo $coRoom; ?>"<?php echo $readonly; ?>/>
                </p>
                <p>
                    <label class="field" for="coNotes">Notes</label>
                    <textarea  name="coNotes" id="coNotes" class="textbox-300" <?php echo $readonly; ?>/><?php echo $coNotes; ?></textarea>
                </p>

            </div>
        </fieldset>
        <fieldset>
            <legend>Check-Out Details</legend>
            <table><table id="checkoutDetails">
                    <thead>
                        <tr>
                            <th class="tblNameA">Barcode</th>
                            <th class="tblNameA">Serial</th>
                            <th class="tblNameA">Available</th>
                            <th class="tblNameA">Type</th>
                            <th class="tblNameA">Make</th>
                            <th class="tblNameA">Model</th>
                            <th class="tblNameA">Name</th>
                            <th class="tblNameA">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="tblValueA"><input type="text" name="barcode1" id="barcode1" class="textbox-100"/></td>
                            <td class="tblValueA">serial number</td>
                            <td class="tblValueA">availablity</td>
                            <td class="tblValueA">type</td>
                            <td class="tblValueA">makes</td>
                            <td class="tblValueA">model</td>
                            <td class="tblValueA">Name</td>
                            <td class="tblValueA"><input type="radio" name=""remove" value="y"></td>
                        </tr>
                        <tr>
                            <td class="tblValueA"><input type="text" name="barcode1" id="barcode1" class="textbox-100"/></td>
                            <div id="txthint"></div>
                        </tr>
                    </tbody>
                </table> 

        </fieldset>
    </div>


    <input type="submit" value="Update">
</form>
<script>
    function getData(barcode) {
        var xmlhttp;
        if barcode = "" {
            document.getElementById("txtHInt").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("mICORSOFT.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementId("txtHint").innerHTML = xmlhttp.repsonseText;
            }
        }
        xmlhttp.open("Get", "getdata.php?barcode=" + barcode, true);
        xmlhttp.send;
    }
</script>
