<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$errorMsg = "";
include('includes/fn_insert_validations.php');

if ($dbSuccess) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //select barcode
        $barcode = clean_input($_POST["barcode"]);
    }
      if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //select barcode
        if(isset($_GET["barcode"]))
         $barcode = clean_input($_GET["barcode"]);
    }
        if (!empty($barcode)) { {  //   SQL:    Select from Asset table
                $tAsset_SQLselect = "Select * ";
                $tAsset_SQLselect .= "FROM nhi_asset ";
                $tAsset_SQLselect .= "WHERE ass_dps_barcode = $barcode ";

                $tAsset_SQLselect_Query = mysqli_query($dbSelected, $tAsset_SQLselect);
            }

            if (count(mysqli_fetch_assoc($tAsset_SQLselect_Query)) > 0) {
                //if found display edit screen
                $tCIO_SQLselect = "Select * ";
                $tCIO_SQLselect .= "FROM nhi_check_io ";
                $tCIO_SQLselect .= "WHERE cio_dps_barcode = $barcode ";
                $tCIO_SQLselect .= "AND cio_check_out_date > 0 ";
                $tCIO_SQLselect .= "AND cio_check_in_date = 0 ";

                $tCIO_SQLselect_Query = mysqli_query($dbSelected, $tCIO_SQLselect);
                if ($row = mysqli_fetch_assoc($tCIO_SQLselect_Query)) {
                    $returnMsg = "Asset $barcode already checked out";
                } else {
                    header("Location: /index.php?content=assetCheckOutProcess&barcode=$barcode");
                }
            }else{
                $returnMsg = "Item not found";
            }
                
        } else {
            $returnMsg = "Enter a barcode to search";
        }
    }

?>
<form method="post" action="index.php?content=assetCheckOut" >
    <div class="fieldSet">
        <fieldset>
            <legend>Asset Check-Out</legend>
            <input type="hidden" name="assetInserted" value="1"/>
            <p>
                <label class="field" for="barcode">DPS Barcode</label>
                <input type="text" name="barcode" id="barcode" class="textbox-300" autofocus />
                <span class="error"><?php echo "$errorMsg" ?></span>
            </p>
        </fieldset>
    </div>
    <input type="submit" value="Find">
</form>
<script>
    $("#pageTitle").text("Check-Out");
</script>
