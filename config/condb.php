<?php

$con = mysqli_connect(
    "localhost",
    "root",
    "",
    "farm"
);

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8mb4");

date_default_timezone_set('Asia/Bangkok');