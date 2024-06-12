<?php

header("Content-Type: application/json");

require_once('database.php');
require_once('function.php');  
$email = $_POST["email"]  ;
$pass = EncryptedPassword($_POST["password"] );

$sql = "SELECT * FROM TblMsEmployee as b 
            left join TblMsWorkplace as c on b.MsWorkplaceId=c.MsWorkplaceId
            left join TblMsEmployeePosition as d on d.MsEmpPositionId=b.MsEmpPositionId
            where MsEmpCode='" . $email . "' and MsEmpPass='" . $pass . "' and MsEmpIsActive='1'"; 
$result = $koneksi->query($sql);
if ($result->num_rows > 0) { 
    $emp = $result->fetch_assoc();
    $array = array(
        'status' => true,
        'message' => "Login berhasil...!",
        'data' =>  array(
            'MsEmpName' => $emp["MsEmpName"] ,
            'MsEmpCode' => $emp["MsEmpCode"] ,
            'MsEmpMode' => $emp["MsEmpMode"] , 
            'MsWorkplaceCode' => $emp["MsWorkplaceCode"] ,
            'MsEmpPositionName' => $emp["MsEmpPositionName"] 
        )
    );
}else{
    $array = array(
        'status'=> false,
        'message' => "Login gagal! periksa kembali user dan password anda...", 
    );
}


            
echo json_encode($array); 
