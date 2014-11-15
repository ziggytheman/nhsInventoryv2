<?php

$returnMsg = "Enter Barcode to search or select Barcode to edit";

if ($dbSuccess) {
    $list_SQLselect = "SELECT  ";
    $list_SQLselect .= "* ";
    $list_SQLselect .= "FROM ";
    $list_SQLselect .= "vAssets ";  //	<< table name

    include('includes/common_createTable.php');
}
?>
<script>
    $("#pageTitle").text("List");
</script>
