<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$barcode = intval($_GET['barcode']);
$availabilty = "";
include('htconfig/dbaccess.php');
if (!$dbSelected) {
    die('could not connect: ' . mysqli_error($dbSelected));
}
include('includes/common_assetTable_sql.php');
if (mysqli_query($dbSelected, $tAsset_SQLselect)) {
    echo '<tr>
            <td class="tblValueA">'.$serialno.'</td>
            <td class="tblValueA">'.$availablity.'</td>
            <td class="tblValueA">'.$type.'</td>
            <td class="tblValueA">'.$make.'</td>
            <td class="tblValueA">'.$model.'</td>
            <td class="tblValueA">'.$name.'</td>
            <td class="tblValueA"><input type="radio" name=""remove" value="y"></td>
         </tr>';
}