<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>NHI</title>
        <link rel="stylesheet" type="text/css" href="css/reset.css" /> 
        <link rel="stylesheet" type="text/css" href="css/nhi.css" /> 

        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" 
              href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">

        <!-- jQuery -->
        <script type="text/javascript" charset="utf-8" 
        src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>

        <!-- DataTables -->
        <script type="text/javascript" charset="utf-8" 
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
        <script src="js/nhi.js"></script>

    </head>
    <body>
        <header>
            <h1 id="pageHeader">Inventory</h1>
            <h2 id="pageTitle"></h2>
            <div id="message">
                <p><span id="returnMsg"></span></p>
            </div>
        </header> <!--topheader -->
        <div class="lhs_menu">
            <ul>
                <li id="active"><a href="#">Home</a></li>
                <li> <a href="index.php?next=search.php">Search</a> </li>
                <li> <a href="index.php?next=list.php">List</a> </li>
                <li> <a href="index.php?next=add.php">Add</a> </li>
                <li> <a href="index.php?next=maintenance.php">Maintenance</a> </li>
                <li> <a href="index.php?next=mainhistory.php">Maintenance History</a> </li>

                <li> <a href="index.php?next=check-in.php">Check-In</a> </li>
                <li> <a href="index.php?next=check-out.php">Check-Out</a> </li>
                <li> <a href="index.php?next=checkhistory.php">Check History</a> </li>
                <li id="active"><a href="#">File System</a></li>
                <li> <a href="export.php">Export</a> </li>
                <li> <a href="backup.php">Backup</a> </li>
                <li> <a href="index.php?next=testcheckout.php">Check Out Test</a> </li>
            </ul>
        </div> <!--lhs_menu -->

        <div id="main_area">


            <?php
            $returnMsg = "";
            include('htconfig/dbConfig.php');
            include('includes/dbaccess.php');
            
            if (isset($_GET["next"])) {
                $location = "includes/" . $_GET["next"];
            } else {
                $location = "includes/list.php";
            }


            include($location);
            unset($GLOBALS['next']);
            ?>
        </div> <!--main_area -->
        <footer>
            <!-- <p><span class="returnMsg"><?php echo $returnMsg; ?></span></p> -->
        </footer>
    </body>

</html>
<script>
    $(document).ready(function() {

        document.getElementById('returnMsg').innerHTML = "<?php echo $returnMsg; ?>";

    });
</script>
