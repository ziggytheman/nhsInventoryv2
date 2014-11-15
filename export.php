<?php

include('htconfig/dbConfig.php');
include('includes/dbaccess.php');
$output = "";

$table = "nhi_asset";

$sql = mysqli_query($dbSelected, "SELECT * FROM $table");
$filename = "nhs_dump_" . date("Y-m-d H:i:s") . ".csv";

$indx = TRUE;

while ($row = mysqli_fetch_assoc($sql)) {
    if ($indx) {

        foreach ($row as $idx => $r) {
            $output .= '"' . strtoupper(str_replace("ass_", "", $idx)) . '",';
        }
        $indx = FALSE;
        $output .= "\n";
    }
    foreach ($row as $idx => $r) {
  /*      if($idx === 'ass_date_purchased') {
            $tempdate = $r;
        } else if($idx === 'ass_condition'){
            if($r !== "") {
                $output .='"' . $r . '",';
            } else {
                switch ($tempdate) {
                   case  
                }
            }
        } */
        $output .='"' . $r . '",';
    } 
    $output .= "\n";
}
header('Content-type: text/csv; charset=utf-8');
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header('Content-Disposition: attachment; filename=' . $filename);
echo $output;
exit;
?> 