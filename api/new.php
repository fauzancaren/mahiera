<?php
    require_once('koneksi.php');
    if($_POST){
        $sql = "Insert into TblCardDetect (Card, Store) values
                ('" .$_POST['Card']. "','" .$_POST['Store']. "')";
        if ($koneksi->query($sql) === TRUE) {
            echo "============= Insert success";
        }
    }
?>