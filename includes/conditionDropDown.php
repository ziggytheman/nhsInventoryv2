<?php

{ //create condition value dropdown values
    $tCondition_SQLselect = "SELECT ";
    $tCondition_SQLselect .= "con_value ";
    $tCondition_SQLselect .= "FROM ";
    $tCondition_SQLselect .= "nhi_condition "; 
    $tCondition_SQLselect .= "order by con_value "; 


    $tCondition_SQLselect_Query = mysqli_query($dbSelected, $tCondition_SQLselect);

    $conditionDropDown = "\n<select name=\"condition\" id=\"condition\" class=\"option-300\"> \n";
    $conditionDropDown .= " <option value=\"default\"> </option>\n";
    while ($row = mysqli_fetch_assoc($tCondition_SQLselect_Query)) {
        
        foreach ($row as $idx => $r) {
           if($r == $condition){
               $selectedFlag = "selected";
           }  else {
               $selectedFlag = "";
           }
           $conditionDropDown .= "  <option $selectedFlag value=\"$r\">$r</option>\n";

        }
    }
    $conditionDropDown .= "</select> \n";  
    mysqli_free_result($tCondition_SQLselect_Query);
}
?>

