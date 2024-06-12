<?php
    require_once('koneksi.php');
    $query = "SELECT * FROM TblMsEmployee";
    $result = $koneksi->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        echo $row["MsEmpCode"].";".$row["MsEmpName"].";".$row["MsEmpCard"]."\r" ;
        }
    }else {
      echo "tidak ada data";
    }
?>