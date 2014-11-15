<?php

$dbSelected = "";
if (!ini_get('date.timezone')) {
    date_default_timezone_set('America/Denver');
}

$dbSuccess = false;
$dbSelected = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);


if ($dbSelected) {
    $dbSuccess = true;
} else {
    echo "DB Selection FAILed <br/>";
    echo mysqli_error($dbSelected) . "<br/>";
    $returnMsg = mysqli_error($dbSelected);
}
?>
