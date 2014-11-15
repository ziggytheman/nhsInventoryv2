$(document).ready(function() {
    $('#list').dataTable(
            {"bAutoWidth": false}
        );
$('div.dataTables_filter input').focus();
});

/**
 * File: js/showhide.js
 * Author: design1online.com, LLC
 * Purpose: toggle the visibility of fields depending on the value of another field
 **/
$(document).ready(function() {
    toggleFields(); //call this first so we start out with the 
    //correct visibility depending on the selected form values
    //this will call our toggleFields function every time the 
    //selection value of our underAge field changes
    $("#location").change(function() {
        toggleFields();
        $("#otherLocation").focus();
    });

});

//this toggles the visibility of our parent permission fields depending on the 
//current selected value of the underAge field
function toggleFields()
{
    if ($("#location").val() === 'Other')
        $("#otherLocation").show();
    else
        $("#otherLocation").hide();
}


