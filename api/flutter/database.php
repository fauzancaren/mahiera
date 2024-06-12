<?php    
    $koneksi = new mysqli('localhost', 'u137848616_obi_server', 'SvrOmahBata13','u137848616_obi_server');
    if ($koneksi->connect_error) {
        die("Koneksi Gagal: " . $koneksi->connect_error);
    }
?>
