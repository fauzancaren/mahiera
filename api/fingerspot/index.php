<?php 
    $conn = mysqli_connect('localhost', 'u137848616_obi_server', 'SvrOmahBata13id','u137848616_obi_server');
    if (!$conn) {
        die("Koneksi Gagal: " . mysqli_connect_error());
        return;
    }

    date_default_timezone_set("Asia/Jakarta");
    /* -------------------     PARAMETER FINGERSPOT -------------*/
    /* lihat data di fingerspot.io atau di http://fingerspot.io/download/Quick_Guide_API_SDK_Fingerspot.iO.pdf */
    $cloudid = 'C2697842931D1B38'; 
    $nowdate = date('Y-m-d');//"2022-07-12";//date('Y-m-d');
    $lastdate = strtotime ( '-1 day' , strtotime ( $nowdate ) ) ;
    $lastdate = date ( 'Y-m-d' , $lastdate );
    $lastdate1 = strtotime ( '-2 day' , strtotime ( $nowdate ) ) ;
    $lastdate1 = date ( 'Y-m-d' , $lastdate1 );

    $format_date = 6;
    $property = 'date_time';
    $direction = 'asc';
    $export_type = 'json';
    $current = date('Ymdhms');
    $auth = md5($cloudid.$nowdate.$current.'Y00BCI2EGB2110MK');
    $authlast = md5($cloudid.$lastdate.$current.'Y00BCI2EGB2110MK');
    $authlast1 = md5($cloudid.$lastdate1.$current.'Y00BCI2EGB2110MK');
    $data_url = "http://api.fingerspot.io/api/download/attendance_log/{$cloudid}/{$nowdate}/{$format_date}/{$property}/{$direction}/{$export_type}/{$auth}/{$current}";
    $data_url_last = "http://api.fingerspot.io/api/download/attendance_log/{$cloudid}/{$lastdate}/{$format_date}/{$property}/{$direction}/{$export_type}/{$authlast}/{$current}";
    $data_url_last_1 = "http://api.fingerspot.io/api/download/attendance_log/{$cloudid}/{$lastdate1}/{$format_date}/{$property}/{$direction}/{$export_type}/{$authlast1}/{$current}";
     
    /* -----------------------------------------------------------*/
    // get data now
    $curl = curl_init($data_url);
    curl_setopt($curl, CURLOPT_URL, $data_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    $headers = array( 
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "Accept-Encoding: gzip, deflate",
        "Accept-Language: id-ID,id;q=0.9,en;q=0.8",
        "Cache-Control: no-cache",
        "Connection: keep-alive", 
        "Cookie: _ga=GA1.2.188722438.1656736013; _gid=GA1.2.1495122764.1657682350",
        "Host: api.fingerspot.io",
        "Pragma: no-cache",
        "Upgrade-Insecure-Requests: 1",
        "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    $obj = JSON_DECODE($resp); 
    
    if(!$obj->success){

        $message = "Gagal Mengambil data";
        $message1 = "";
        switch($obj->msg) {
            case "IO_API_ERR_0" :
                $message1 = "Akses API tidak tersedia antara pukul 06.00 s/d 08.59 WIB dan 14.00 s/d 15.59 WIB";
                break;
            case "IO_API_ERR_1" :
                $message1 = "Mesin tidak ditemukan";
                break;
            case "IO_API_ERR_2" :
                $message1 = "Akun tidak ditemukan";
                break;
            case "IO_API_ERR_3" :
                $message1 = "Parameter {auth} tidak sesuai";
                break;
            case "IO_API_ERR_4" :
                $message1 = "Akun melebihi DUE DATE";
                break;
            case "IO_API_ERR_5" :
                $message1 = "Mesin belum berlangganan API SDK";
                break;
            case "IO_API_ERR_6" :
                $message1 = "Belum berlangganan AddOn API SDK scan GPS";
                break;
            case "IO_API_ERR_7" :
                $message1 = "Sudah mencapai limit 100 kali request API per hari";
                break;
            default:
                $message1 = "tdak ada keterangan";
        } 
    }else{ 
        $message = "Berhasil Mengambil data";
        $message1 = "";
        foreach($obj->data as $row){
 
            $date = explode(" ", $row->{'Date Time'});
            switch(strlen($row->PIN)) {
                case 1 :
                    $empcode = "ID0000".$row->PIN;
                    break;
                case 2 :
                    $empcode = "ID000".$row->PIN;
                    break;
                case 3 :
                    $empcode = "ID00".$row->PIN;
                    break;
                case 4 :
                    $empcode = "ID0".$row->PIN;
                    break;
                case 5 :
                    $empcode = "ID".$row->PIN;
                    break;
                default:
                    $empcode = "ID00000";
            }    
            switch( $row->{'Cloud ID'}) {
                case "C2697842931D1B38" :
                    $workplace = 2; 
                    break;
                default:
                    $workplace = 0;
            }   


            $sql = "SELECT * FROM TblAbsen WHERE AbsenDate = '$date[0]' and AbsenTime='$date[1]' and MsEmpCode='$empcode'"; 
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
        
                $sql = "SELECT MsEmpName FROM TblMsEmployee WHERE MsEmpCode='$empcode' "; 
                $result = $conn->query($sql); 
                $emp = $result->fetch_assoc();
        
                $sql = "Insert into TblAbsen (AbsenDate, AbsenTime, MsEmpCode, MsEmpName,System,MsWorkplaceId) values 
                ('" .$date[0]. "','" .$date[1]. "','" .$empcode. "','" .$emp["MsEmpName"]. "',0,'" .$workplace. "')";
                if ($conn->query($sql) === TRUE) { 
                    $message1 .= $sql .  PHP_EOL ;
                }  
            }

           
        } 
        if(strlen($message1)==0) $message1 = "tidak ada data yang ditambahkan";
       
    }; 

    $log  =
    "----------------------------------- LOG ACTIVITY ----------------------------------" . PHP_EOL .  
    "date: "  .  date('Y-m-j H:i:s') . PHP_EOL .
    "datedata: "  . $nowdate . PHP_EOL .
    "pesan: "  . $message . PHP_EOL .
    "result: " . $message1 .  PHP_EOL . PHP_EOL. PHP_EOL; 
    //Save string to log, use FILE_APPEND to append.

    if (!file_exists('./log')) {
        mkdir('./log', 0777, true);
    }
    file_put_contents('./log/log_' . date("j_n_Y") . '.log', $log, FILE_APPEND);
    echo $log;
   /* -----------------------------------------------------------*/ 




    /* -----------------------------------------------------------*/
    // get data -1 day
    sleep(10);
    $curl = curl_init($data_url_last);
    curl_setopt($curl, CURLOPT_URL, $data_url_last);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    $headers = array( 
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "Accept-Encoding: gzip, deflate",
        "Accept-Language: id-ID,id;q=0.9,en;q=0.8",
        "Cache-Control: no-cache",
        "Connection: keep-alive",
        "Cookie: _ga=GA1.2.188722438.1656736013; _gid=GA1.2.1495122764.1657682350",
        "Host: api.fingerspot.io",
        "Pragma: no-cache",
        "Upgrade-Insecure-Requests: 1",
        "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    $obj = JSON_DECODE($resp);  
    if(!$obj->success){

        $message = "Gagal Mengambil data";
        $message1 = "";
        switch($obj->msg) {
            case "IO_API_ERR_1" :
                $message1 = "Mesin tidak ditemukan";
                break;
            case "IO_API_ERR_2" :
                $message1 = "Akun tidak ditemukan";
                break;
            case "IO_API_ERR_3" :
                $message1 = "Parameter {auth} tidak sesuai";
                break;
            case "IO_API_ERR_4" :
                $message1 = "Akun melebihi DUE DATE";
                break;
            case "IO_API_ERR_5" :
                $message1 = "Mesin belum berlangganan API SDK";
                break;
            case "IO_API_ERR_6" :
                $message1 = "Belum berlangganan AddOn API SDK scan GPS";
                break;
            default:
            $message1 = "tdak ada keterangan";
        } 
    }else{ 
        $message = "Berhasil Mengambil data";
        $message1 = "";
        foreach($obj->data as $row){

            $date = explode(" ", $row->{'Date Time'});
            switch(strlen($row->PIN)) {
                case 1 :
                    $empcode = "ID0000".$row->PIN;
                    break;
                case 2 :
                    $empcode = "ID000".$row->PIN;
                    break;
                case 3 :
                    $empcode = "ID00".$row->PIN;
                    break;
                case 4 :
                    $empcode = "ID0".$row->PIN;
                    break;
                case 5 :
                    $empcode = "ID".$row->PIN;
                    break;
                default:
                    $empcode = "ID00000";
            }    
            switch( $row->{'Cloud ID'}) {
                case "C2697842931D1B38" :
                    $workplace = 2; 
                    break;
                default:
                    $workplace = 0;
            }   


            $sql = "SELECT * FROM TblAbsen WHERE AbsenDate = '$date[0]' and AbsenTime='$date[1]' and MsEmpCode='$empcode'"; 
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
        
                $sql = "SELECT MsEmpName FROM TblMsEmployee WHERE MsEmpCode='$empcode' "; 
                $result = $conn->query($sql); 
                $emp = $result->fetch_assoc();
        
                $sql = "Insert into TblAbsen (AbsenDate, AbsenTime, MsEmpCode, MsEmpName,System,MsWorkplaceId) values 
                ('" .$date[0]. "','" .$date[1]. "','" .$empcode. "','" .$emp["MsEmpName"]. "',0,'" .$workplace. "')";
                if ($conn->query($sql) === TRUE) { 
                    $message1 .= $sql .  PHP_EOL ;
                }  
            }

            
        } 
        if(strlen($message1)==0) $message1 = "tidak ada data yang ditambahkan";
        
    }; 

    $log  =
    "----------------------------------- LOG ACTIVITY ----------------------------------" . PHP_EOL .  
    "date: "  .  date('Y-m-j H:i:s') . PHP_EOL .
    "datedata: "  . $lastdate . PHP_EOL .
    "pesan: "  . $message . PHP_EOL .
    "result: " . $message1 .  PHP_EOL . PHP_EOL. PHP_EOL; 
    //Save string to log, use FILE_APPEND to append.

    if (!file_exists('./log')) {
        mkdir('./log', 0777, true);
    }
    file_put_contents('./log/log_' . date("j_n_Y") . '.log', $log, FILE_APPEND); 
    echo $log; 
   /* -----------------------------------------------------------*/ 




    /* -----------------------------------------------------------*/
    // get data -2 day
    sleep(10);
    $curl = curl_init($data_url_last_1);
    curl_setopt($curl, CURLOPT_URL, $data_url_last_1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    $headers = array( 
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "Accept-Encoding: gzip, deflate",
        "Accept-Language: id-ID,id;q=0.9,en;q=0.8",
        "Cache-Control: no-cache",
        "Connection: keep-alive",
        "Cookie: _ga=GA1.2.188722438.1656736013; _gid=GA1.2.1495122764.1657682350",
        "Host: api.fingerspot.io",
        "Pragma: no-cache",
        "Upgrade-Insecure-Requests: 1",
        "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    $obj = JSON_DECODE($resp);  
    if(!$obj->success){

        $message = "Gagal Mengambil data";
        $message1 = "";
        switch($obj->msg) {
            case "IO_API_ERR_1" :
                $message1 = "Mesin tidak ditemukan";
                break;
            case "IO_API_ERR_2" :
                $message1 = "Akun tidak ditemukan";
                break;
            case "IO_API_ERR_3" :
                $message1 = "Parameter {auth} tidak sesuai";
                break;
            case "IO_API_ERR_4" :
                $message1 = "Akun melebihi DUE DATE";
                break;
            case "IO_API_ERR_5" :
                $message1 = "Mesin belum berlangganan API SDK";
                break;
            case "IO_API_ERR_6" :
                $message1 = "Belum berlangganan AddOn API SDK scan GPS";
                break;
            default:
            $message1 = "tdak ada keterangan";
        } 
    }else{ 
        $message = "Berhasil Mengambil data";
        $message1 = "";
        foreach($obj->data as $row){

            $date = explode(" ", $row->{'Date Time'});
            switch(strlen($row->PIN)) {
                case 1 :
                    $empcode = "ID0000".$row->PIN;
                    break;
                case 2 :
                    $empcode = "ID000".$row->PIN;
                    break;
                case 3 :
                    $empcode = "ID00".$row->PIN;
                    break;
                case 4 :
                    $empcode = "ID0".$row->PIN;
                    break;
                case 5 :
                    $empcode = "ID".$row->PIN;
                    break;
                default:
                    $empcode = "ID00000";
            }    
            switch( $row->{'Cloud ID'}) {
                case "C2697842931D1B38" :
                    $workplace = 2; 
                    break;
                default:
                    $workplace = 0;
            }   


            $sql = "SELECT * FROM TblAbsen WHERE AbsenDate = '$date[0]' and AbsenTime='$date[1]' and MsEmpCode='$empcode'"; 
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
        
                $sql = "SELECT MsEmpName FROM TblMsEmployee WHERE MsEmpCode='$empcode' "; 
                $result = $conn->query($sql); 
                $emp = $result->fetch_assoc();
        
                $sql = "Insert into TblAbsen (AbsenDate, AbsenTime, MsEmpCode, MsEmpName,System,MsWorkplaceId) values 
                ('" .$date[0]. "','" .$date[1]. "','" .$empcode. "','" .$emp["MsEmpName"]. "',0,'" .$workplace. "')";
                if ($conn->query($sql) === TRUE) { 
                    $message1 .= $sql .  PHP_EOL ;
                }  
            }

            
        } 
        if(strlen($message1)==0) $message1 = "tidak ada data yang ditambahkan";
        
    }; 

    $log  =
    "----------------------------------- LOG ACTIVITY ----------------------------------" . PHP_EOL .  
    "date: "  .  date('Y-m-j H:i:s') . PHP_EOL .
    "datedata: "  . $lastdate1 . PHP_EOL .
    "pesan: "  . $message . PHP_EOL .
    "result: " . $message1 .  PHP_EOL . PHP_EOL. PHP_EOL; 
    //Save string to log, use FILE_APPEND to append.

    if (!file_exists('./log')) {
        mkdir('./log', 0777, true);
    }
    file_put_contents('./log/log_' . date("j_n_Y") . '.log', $log, FILE_APPEND);
    echo $log;
