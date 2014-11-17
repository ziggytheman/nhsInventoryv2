<?php
/* 	File:			index.php
 *
 * 	Folder:		root (htdocs)	
 * 	By:			ARH
 * 	Date:		2014-1-5
 *
 * 	This script is the HOMEPAGE for NHI
 *
 *
 * ============================================================
 */
//	Secure Connection Script
include('htconfig/dbConfig.php');
include('includes/dbaccess.php');
//	END	Secure Connection Script


if ($dbSuccess) {
    include_once('includes/fn_authorise.php');
    //   include_once('includes/fn_strings.php');
    //   include_once('includes/fn_formatting.php');
    //  include_once('includes/fn_eMailLog.php');

    $menuFile = '';
    $contentFile = '';
    $contentMsg = '';

    //$loginAuthorised = ($_COOKIE["loginAuthorised"] == "loginAuthorised");
    $loginAuthorised = filter_input(INPUT_COOKIE, 'loginAuthorised', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($loginAuthorised) {

        $accessLevel = filter_input(INPUT_COOKIE, 'accessLevel', FILTER_SANITIZE_SPECIAL_CHARS);
        $userID = filter_input(INPUT_COOKIE, 'userID', FILTER_SANITIZE_SPECIAL_CHARS);
        $status = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($status) AND ( $status == "logout")) {
            setcookie("loginAuthorised", "", time() - 7200, "/");
            header("Location: index.php");
        } else {

            //		This is where we manage CONTENT for LOGGED-IN users
            $menuFile = 'includes/tp_nhiMenu.php';

            $contentCode = filter_input(INPUT_GET, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

            //  DO SOMETHING depending on the $contentCode.  
            //		update code:   0905 Content management 
            switch ($contentCode) {
                case "assetSearch":
                    $contentFile = "includes/search.php";
                    break;
                case "assetList":
                    $contentFile = "includes/list.php";
                    break;
                case "assetAdd":
                    $contentFile = "includes/add.php";
                    break;
                case "assetInventory":
                    $contentFile = "includes/assetInventory.php";
                    break;
                case "assetInventoryInitial":
                    $contentFile = "includes/assetInventoryInitial.php";
                    break;
                case "assetMaintenanceHistory":
                    $contentFile = "includes/mainhistory.php";
                    break;
                case "assetMaintenanceInsert":
                    $contentFile = "includes/maininsert.php";
                    break;
                case "assetCheckIn":
                    $contentFile = "includes/check-in.php";
                    break;
                case "assetCheckOut":
                    // $contentFile = "includes/check-out.php";
                    $contentFile = "includes/testcheckout.php";
                    break;
                case "assetCheckInOut":
                    $contentFile = "includes/checkinout.php";
                    break;
                case "assetCheckHistory":
                    $contentFile = "includes/checkhistory.php";
                    break;
                case "assetCheckInProcess":
                    $contentFile = "includes/check-inprocess.php";
                    break;
                case "assetCheckOutProcess":
                    $contentFile = "includes/check-outprocess.php";
                    break;
                case "assetMaintenance":
                    $contentFile = "includes/maintenance.php";
                    break;
                case "assetEdit":
                    $contentFile = "includes/edit.php";
                    break;
                case "assetTestCheckout":
                    $contentFile = "includes/testcheckout.php";
                    break;
                case "assetTestCheckin":
                    $contentFile = "includes/testcheckin.php";
                    break;
                default:
                    $contentFile = "includes/list.php";
                    break;
            }
        }
    } else {

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

        if (userAuthorised($username, $password, $dbSelected)) {
            header("Location: index.php");
        } else {
            $contentFile = 'includes/tp_loginForm.php';
        }
    }
} else {
    $contentMsg = 'No database connection.';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="UTF-8">
        <title>NHI</title>
        <link rel="stylesheet" type="text/css" href="css/reset.css" > 
        <link rel="stylesheet" type="text/css" href="css/nhi.css" > 

        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" 
              href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">

        <!-- jQuery -->
        <script type="text/javascript" charset="utf-8" 
        src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>

        <!-- DataTables -->
        <script type="text/javascript" charset="utf-8" 
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="js/nhi.js"></script>
    </head>
    <body>

    <header>
        <h1 id="pageHeader">Inventory</h1>
        <h2 id="pageTitle"></h2>
        <div id="message">
            <p><span id="returnMsg"></span></p>
        </div>

    </header> 
    <div class="lhs_menu">

        <ul>
            <?php
            if (file_exists($menuFile)) {
                include($menuFile);
            }
            ?>
        </ul>
    </div>
    <div id="main_area">
        <?php
        if (file_exists($contentFile)) {
            include($contentFile);
        }

        if (!empty($contentMsg)) {
            echo $contentMsg;
        }
        ?>
    </div><!-- end contentColumn -->



    <footer>
        <div id="message">
            <p><span id="errorMsg"></span></p>
        </div>
    </footer><!-- end footer -->

</body>
</html>
<script>
    $(document).ready(function () {
        document.getElementById('returnMsg').innerHTML = "<?php echo $returnMsg; ?>";
        document.getElementById('errorMsg').innerHTML = "<?php echo $errorMsg; ?>";
    });
</script>
