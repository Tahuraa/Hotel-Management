<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_OFF);

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'manage';

$con = mysqli_connect($servername,$username,$password, $dbname);



if (mysqli_connect_errno()) {

    die('blocked '. mysqli_connect_error());}

// else {
//     echo 'succesful connection <br>';
// }

?>