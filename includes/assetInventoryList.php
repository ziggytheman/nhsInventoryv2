<?php

$returnMsg = "Enter data to search";

if ($dbSuccess) {
    $list_SQLselect = "SELECT  ";
    $list_SQLselect .= "* ";
    $list_SQLselect .= "FROM ";
    $list_SQLselect .= "vInventory ";  //	<< table name

    include('includes/common_createTable.php');
}
?>
<script>
    $("#pageTitle").text("Inventory List");
</script>

    