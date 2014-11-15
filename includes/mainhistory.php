<?php
$returnMsg = "Enter bar code or select barcode";

if ($dbSuccess) {
    $list_SQLselect = "SELECT  ";
    $list_SQLselect .= "* ";
    $list_SQLselect .= "FROM ";
    $list_SQLselect .= "vMainhist ";  //	<< table name

    include('includes/common_createTable.php');
   
}
?>
<script>
    $("#pageTitle").text("Maintenance History");
</script>
