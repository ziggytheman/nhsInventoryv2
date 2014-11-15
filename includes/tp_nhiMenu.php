<?php

/* 		INCLUDE FILE:   tp_nhiMenu.php
 *
 * 		folder:			includes/
 *
 * 		used in:        index.php
 *
 * 		version:    	0901   date: 2010-07-01
 *
 * 		purpose:		MENU for the TEMPLATE version of alpha CRM
 *
 * 	===========================================================================
 */
echo '<li id="active"><a href="#">Home</a></li>' ;

if (isset($accessLevel) AND $accessLevel >= 21) {
    echo '<li><a href="index.php?content=assetSearch">Search</a></li>';
    echo '<li><a href="index.php?content=assetList">List</a></li>';
    echo '<li><a href="index.php?content=assetAdd">Add</a></li>';
    echo '<li><a href="index.php?content=assetMaintenance">Maintenance</a></li>';
    echo '<li><a href="index.php?content=assetMaintenanceHistory">Maintenance History</a></li>';
    echo '<li><a href="index.php?content=assetCheckIn">Check-In</a></li>';
    echo '<li><a href="index.php?content=assetCheckOut">Check-Out</a></li>';
    echo '<li><a href="index.php?content=assetCheckHistory">Check History</a></li>';
    echo '<li id="active"><a href="#">File System</a></li>';
    echo '<li><a href="export.php">Export</a></li>';
 //   echo '<li><a href="index.php?content=assetTestCheckout">Test Checkout</a></li>';
}

echo '<li><a href="index.php?status=logout">Logout</a></li>';
?>