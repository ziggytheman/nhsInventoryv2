<?php

//echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';


if (isset($_SESSION['errorMsg'])) {
    $errorMsg = $_SESSION['errorMsg'];
    $_SESSION['errorMsg'] = "";
    //print_r("Error " .$errorMsg);
} else {
    $errorMsg = "";
}

if (isset($_SESSION['statusMsg'])) {
    $statusMsg = $_SESSION['statusMsg'];
    $_SESSION['statusMsg'] = "";
} else {
    $statusMsg = "";
}

if (isset($_SESSION['returnMsg'])) {
    $returnMsg = $_SESSION['returnMsg'];
    $_SESSION['returnMsg'] = "";
} else {
    $returnMsg = "";
}

