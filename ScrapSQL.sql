/*
create view  vInventory as select dtl_barcode as 'Barcode',
ass_make as 'Make',
ass_model as 'Model',
dtl_room as 'Location',
UCASE(dtl_timeframe) as 'Inventory Time' 
from nhi_inventory_details, nhi_asset where dtl_barcode = ass_dps_barcode;
*/

drop function getLocation;
Delimiter ;;
Create function getLocation(barcode decimal(10,0))
returns varchar(10)
Begin
    declare loc varchar(10);
    declare timeframe varchar(20);
    set timeframe = (select cfg_value from nhi_configuration where cfg_key_value = 'inventory_time');
    set loc = (select concat(dtl_room,"*") from nhi_inventory_details where dtl_barcode = barcode and dtl_timeframe = timeframe);
    if loc is NULL then
        set loc = (select ass_location from nhi_asset where ass_dps_barcode = barcode);
        end if;
    return loc;
end ;;
DELIMITER ;

Begin
    declare loc varchar(10);
    declare timeframe varchar(20);
    set timeframe = (select cfg_value from nhi_configuration where cfg_key_value = 'inventory_time');
    set loc = (select dtl_room from nhi_inventory_details where dtl_barcode = barcode and dtl_timeframe = timeframe);
    if loc is NULL then
        set loc = (select ass_location from nhi_asset where ass_dps_barcode = barcode);
        end if;
    return loc;
end

Begin
    declare loc varchar(10);
    declare timeframe varchar(20);
    set timeframe = (select cfg_value from nhi_configuration where cfg_key_value = 'inventory_time');
    set loc = (select concat(dtl_room,"*") from nhi_inventory_details where dtl_barcode = barcode and dtl_timeframe = timeframe);
    if loc is NULL then
        set loc = (select ass_location from nhi_asset where ass_dps_barcode = barcode);
        end if;
    return loc;
end
