<?php
    // convert in https://tableconvert.com/excel-to-json
    $string = '[["C2697842931D1B38","3","ERWIN BRACHM","2022-07-28","10:47","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","26","SUHANDA","2022-07-28","08:39","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","45","HARIS SUPRIA","2022-07-28","08:35","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","31","PUJI YANTO","2022-07-28","08:16","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","18","AGUNG MULYAD","2022-07-28","07:58","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","15","GUNAWAN","2022-07-28","07:57","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","12","YUSUP","2022-07-28","07:57","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","40","REDY PRIANTO","2022-07-28","07:55","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","29","MOCH AMIRUDI","2022-07-28","07:55","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","14","ANDRY","2022-07-28","07:53","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","42","MUHAMMAD ICH","2022-07-28","07:51","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","10","SYARIFUDIN","2022-07-28","07:50","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","16","SEPTIAN ADE","2022-07-28","07:48","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","25","ARIEF BUDIAR","2022-07-28","07:48","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","27","KAFI ABDUL H","2022-07-28","07:00","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","7","IRWAN SETIAW","2022-07-27","18:39","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","18","AGUNG MULYAD","2022-07-27","18:22","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","31","PUJI YANTO","2022-07-27","18:09","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","16","SEPTIAN ADE","2022-07-27","18:07","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","26","SUHANDA","2022-07-27","17:48","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","14","ANDRY","2022-07-27","17:46","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","12","YUSUP","2022-07-27","17:39","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","40","REDY PRIANTO","2022-07-27","17:33","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","42","MUHAMMAD ICH","2022-07-27","17:23","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","35","BABAI JUBAED","2022-07-27","17:06","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","29","MOCH AMIRUDI","2022-07-27","17:06","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","45","HARIS SUPRIA","2022-07-27","16:15","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","7","IRWAN SETIAW","2022-07-27","12:28","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","26","SUHANDA","2022-07-27","08:47","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","3","ERWIN BRACHM","2022-07-27","08:41","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","45","HARIS SUPRIA","2022-07-27","08:33","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","35","BABAI JUBAED","2022-07-27","08:03","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","18","AGUNG MULYAD","2022-07-27","08:01","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","14","ANDRY","2022-07-27","07:58","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","31","PUJI YANTO","2022-07-27","07:57","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","40","REDY PRIANTO","2022-07-27","07:56","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","29","MOCH AMIRUDI","2022-07-27","07:55","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","12","YUSUP","2022-07-27","07:54","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","10","SYARIFUDIN","2022-07-27","07:53","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","42","MUHAMMAD ICH","2022-07-27","07:51","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","25","ARIEF BUDIAR","2022-07-27","07:47","Sidik Jari","Scan Masuk",""],["C2697842931D1B38","16","SEPTIAN ADE","2022-07-27","07:23","Sidik Jari","Scan Masuk",""]]';
    $data = JSON_DECODE($string); 
    $conn = mysqli_connect('localhost', 'u137848616_obi_server', 'SvrOmahBata13id','u137848616_obi_server');
    if (!$conn) {
        die("Koneksi Gagal: " . mysqli_connect_error());
        return;
    }

    $message = "Berhasil Mengambil data";
    $message1 = "";
    for($i=0;$i < count($data);$i++){ 
        switch(strlen($data[$i][1])) {
            case 1 :
                $empcode = "ID0000".$data[$i][1];
                break;
            case 2 :
                $empcode = "ID000".$data[$i][1];
                break;
            case 3 :
                $empcode = "ID00".$data[$i][1];
                break;
            case 4 :
                $empcode = "ID0".$data[$i][1];
                break;
            case 5 :
                $empcode = "ID".$data[$i][1];
                break;
            default:
                $empcode = "ID00000";
        }    
        switch( $data[$i][0]) {
            case "C2697842931D1B38" :
                $workplace = 2; 
                break;
            default:
                $workplace = 0;
        }   


        $sql = "SELECT * FROM TblAbsen WHERE AbsenDate = '".$data[$i][3]."' and AbsenTime='".$data[$i][4]."' and MsEmpCode='$empcode'"; 
        $result = $conn->query($sql); 
        if ($result->num_rows == 0) {
    
            $sql = "SELECT MsEmpName FROM TblMsEmployee WHERE MsEmpCode='$empcode' "; 
            $result = $conn->query($sql); 
            $emp = $result->fetch_assoc();
    
            $sql = "Insert into TblAbsen (AbsenDate, AbsenTime, MsEmpCode, MsEmpName,System,MsWorkplaceId) values 
            ('" .$data[$i][3]. "','" .$data[$i][4]. "','" .$empcode. "','" .$emp["MsEmpName"]. "',0,'" .$workplace. "')";
            if ($conn->query($sql) === TRUE) { 
                $message1 .= $sql .  PHP_EOL ;
            }  
        }

    }

    $log  =
    "----------------------------------- LOG ACTIVITY ----------------------------------" . PHP_EOL .  
    "date: "  .  date('Y-m-d h:m:s') . PHP_EOL .
    "pesan: "  . $message . PHP_EOL .
    "result: " . $message1 .  PHP_EOL . PHP_EOL. PHP_EOL; 
    //Save string to log, use FILE_APPEND to append.

    if (!file_exists('./log')) {
        mkdir('./log', 0777, true);
    }
    file_put_contents('./log/log_' . date("j_n_Y") . '.log', $log, FILE_APPEND);
