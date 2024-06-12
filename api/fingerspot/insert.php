<?php

    date_default_timezone_set("Asia/Jakarta");
    $conn = mysqli_connect('localhost', 'u137848616_obi_server', 'SvrOmahBata13id','u137848616_obi_server');
    if (!$conn) {
        die("Koneksi Gagal: " . mysqli_connect_error());
        return;
    }
    $message = "insert data from request";
    $message1 = "";
    $data = $_POST; 
    for($i=0;$i < count($data);$i++){ 
        //set id employee
        switch(strlen($data[$i]["PIN"])) {
            case 1 :
                $empcode = "ID0000".$data[$i]["PIN"];
                break;
            case 2 :
                $empcode = "ID000".$data[$i]["PIN"];
                break;
            case 3 :
                $empcode = "ID00".$data[$i]["PIN"];
                break;
            case 4 :
                $empcode = "ID0".$data[$i]["PIN"];
                break;
            case 5 :
                $empcode = "ID".$data[$i]["PIN"];
                break;
            default:
                $empcode = "ID00000";
        }
        
        //set workplace absen
        $workplace = 1; 

        $sql = "SELECT * FROM TblAbsen WHERE AbsenDate = '".$data[$i]["Date"]."' and AbsenTime='".$data[$i]["Time"]."' and MsEmpCode='".$empcode."'"; 
        $result = $conn->query($sql); 
        if ($result->num_rows == 0) {

            $sql = "SELECT MsEmpName FROM TblMsEmployee WHERE MsEmpCode='".$empcode."'"; 
            $result = $conn->query($sql); 
            $emp = $result->fetch_assoc();

            $sql = "Insert into TblAbsen (AbsenDate, AbsenTime, MsEmpCode, MsEmpName,System,MsWorkplaceId) values 
            ('" .$data[$i]["Date"]. "','" .$data[$i]["Time"]. "','" .$empcode. "','" .$emp["MsEmpName"]. "',0,'" .$data[$i]["Workplace"]. "')";
            if ($conn->query($sql) === TRUE) { 
                $message1 .= $sql .  PHP_EOL ;
            }  
        }
    }
     
    
    $log  =
    "----------------------------------- LOG ACTIVITY ----------------------------------" . PHP_EOL .  
    "date: "  .  date('Y-m-j H:i:s') . PHP_EOL .
    "pesan: "  . $message . PHP_EOL .
    "result: " . $message1  .  PHP_EOL . PHP_EOL. PHP_EOL; 
    //Save string to log, use FILE_APPEND to append.
    echo json_encode($message1);
    if (!file_exists('./log')) {
        mkdir('./log', 0777, true);
    }
    file_put_contents('./log/log_' . date("j_n_Y") . '.log', $log, FILE_APPEND);

?>