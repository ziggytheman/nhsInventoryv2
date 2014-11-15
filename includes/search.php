<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include('includes/fn_insert_validations.php');

$errorMsg ="";
//$returnMsg = "Enter Barcode to search";
$returnMsg = "";
if ($dbSuccess) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //select barcode
        $barcode = clean_input($_POST["barcode"]);
        if (!empty($barcode)) { {  //   SQL:    Select from Asset table
                $tAsset_SQLselect = "Select * ";
                $tAsset_SQLselect .= "FROM nhi_asset ";
                $tAsset_SQLselect .= "WHERE ass_dps_barcode = $barcode ";

                $tAsset_SQLselect_Query = mysqli_query($dbSelected, $tAsset_SQLselect);
            }

            if (count(mysqli_fetch_assoc($tAsset_SQLselect_Query)) > 0) {
                //if found display edit screen

                header("Location: index.php?content=assetEdit&barcode=$barcode");
            } else {

                header("Location: index.php?content=assetAdd&barcode=$barcode");
            }
            // else display add screen
        } 
        else {
            $returnMsg = "Enter a Barcode to search";
        }
    }
    if (($_SERVER["REQUEST_METHOD"] == "GET") && (isset($_GET["returnMsg"]))) {
         $returnMsg = $_GET["returnMsg"];
        }
     $returnMsg .= " Enter a Barcode to search";
     
}
?>
<form method="post" action="index.php?content=assetSearch" >
    <div class="fieldSet">
        <fieldset>
            <legend>Barcode Search</legend>
            <input type="hidden" name="assetInserted" value="1"/>
            <p>
                <label class="field" for="barcode">DPS Barcode</label>
                <input type="text" name="barcode" id="barcode" class="textbox-300" autofocus/>
                <span class="error"><?php echo "$errorMsg"?></span>
            </p>
        </fieldset>
    </div>
    <input type="submit" value="Find">
</form>
<script>
	$("#pageTitle").text("Search");
</script>