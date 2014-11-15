<?php

{
      
    $SQL_SQLselect = 'Select CONCAT(emp_first_name, " " , emp_last_name) as name ';
    $SQL_SQLselect .= "FROM nhi_employee ";
    

    $SQLselect_Query = mysqli_query($dbSelected, $SQL_SQLselect);

 
	$employeeDropDown = "\n<datalist name=\"coName\" id=\"coName\" class=\"option-300\"> \n";
    $employeeDropDown .= " <option value=\"default\"> </option>\n";
    while ($row = mysqli_fetch_assoc($SQLselect_Query)) {
        
        foreach ($row as $idx => $r) {
           if($r == $coName){
               $selectedFlag = "selected";
           }  else {
               $selectedFlag = "";
           }
           $employeeDropDown .= "  <option $selectedFlag value=\"$r\">$r</option>\n";

        }
    }
	
    $employeeDropDown .= "</datalist> \n";  
    mysqli_free_result($SQLselect_Query);
}
?>