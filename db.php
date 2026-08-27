<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "college_quiz";

try {

    $conn = mysqli_init();

    mysqli_options(
        $conn,
        MYSQLI_OPT_CONNECT_TIMEOUT,
        10
    );

    $conn->real_connect(
        $servername,
        $username,
        $password,
        $dbname
    );

    $conn->set_charset("utf8mb4");

} catch (mysqli_sql_exception $e) {

    http_response_code(503);

    die(
        "The quiz server is temporarily unavailable. " .
        "Please contact the organizers."
    );
}
?>