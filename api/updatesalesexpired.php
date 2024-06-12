<?php
require_once('koneksi.php');
$date = date('Y-m-d', strtotime('-2 months'));
$sql = "Update TblSales set SalesStatusPayment=3 where SalesDate <= '" . $date . "' and SalesStatusPayment = 0";
$koneksi->query($sql);
