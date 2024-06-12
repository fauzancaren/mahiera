<?php
    require_once('koneksi.php');
    if($_POST){
        $sql = "Insert into TblAbsen (AbsenDate, AbsenTime, MsEmpCode, MsEmpName,System,MsWorkplaceId) values 
                ('" .$_POST['AbsenDate']. "','" .$_POST['AbsenTime']. "','" .$_POST['MsEmpCode']. "','" .$_POST['MsEmpName']. "',0,'" .$_POST['MsWorkplaceId']. "')";
        if ($koneksi->query($sql) === TRUE) {
            echo "============= Insert success";
        }
    }
?>