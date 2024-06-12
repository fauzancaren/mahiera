<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_app');
        $this->load->helper('cookie'); 
    }
    public function test(){
       if (!empty($_SERVER["HTTP_CLIENT_IP"])){
        $ip = $_SERVER["HTTP_CLIENT_IP"];
        }elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))  {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }else{
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        echo "<center>
                <h2>YOUR IP ADDRESS is ".$ip." </h2>
            </center>";
        $host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        echo "<center>
                <p>YOUR HostName is ".$host." </p>
            </center>";  
    }
    public function index()
    {
        $row = $this->model_app->login(get_cookie('username'), $this->model_app->DecryptedPassword(get_cookie('password')));
        if ($row) { 
            $sess_array = array(
                'MsEmpId' => $row->MsEmpId,
                'MsEmpCode' => $row->MsEmpCode,
                'MsEmpName' => $row->MsEmpName,
                'MsEmpPositionName' => $row->MsEmpPositionName,
                'MsEmpPositionId' => $row->MsEmpPositionId,
                'MsWorkplaceCode' => $row->MsWorkplaceCode,
                'MsEmpPass' => $row->MsEmpPass,
                'MsWorkplaceId' => $row->MsWorkplaceId,
                'MsEmpWhatsapp' => $row->MsEmpWhatsapp,
                'MsEmpEmail' => $row->MsEmpEmail,
                'MsEmpImage' => $this->model_app->get_base_64_by_id($row->MsEmpCode),
                'menu_mode' => '-',
                'menu_active' => 'menu-dashboard',
                'menu_id' => '1',
                'login_status' => true,
                'login_mode' => $row->MsEmpMode,
                'login_uuid' => (empty(get_cookie('uuid')) ? $this->model_app->guidv4() : get_cookie('uuid')),

            ); 
            set_cookie('username', $row->MsEmpCode, '3600');
            set_cookie('password', $this->model_app->EncryptedPassword(str_replace("'", "''", $pass)), '3600');
            set_cookie('uuid', $uuid, '3600'); 
            set_cookie('auth', false, '3600'); 
            $this->session->set_userdata($sess_array);
            redirect('client', 'refresh'); 
        } else { 
            $this->load->view('template/login'); 
        }
    } 
    public function check()
    {
        $username = $this->input->post('MsEmpCode');
        $pass = $this->input->post('MsEmpPass');
        $uuid = $this->model_app->guidv4();
        $check_user = $this->model_app->check_user($username);
        if ($check_user) {
            $row = $this->model_app->login($username, $pass);
            if ($row) { 
                $sess_array = array(
                    'MsEmpId' => $row->MsEmpId,
                    'MsEmpCode' => $row->MsEmpCode,
                    'MsEmpName' => $row->MsEmpName,
                    'MsEmpPositionName' => $row->MsEmpPositionName,
                    'MsEmpPositionId' => $row->MsEmpPositionId,
                    'MsWorkplaceCode' => $row->MsWorkplaceCode,
                    'MsEmpPass' => $row->MsEmpPass,
                    'MsWorkplaceId' => $row->MsWorkplaceId,
                    'MsEmpWhatsapp' => $row->MsEmpWhatsapp,
                    'MsEmpEmail' => $row->MsEmpEmail,
                    'MsEmpImage' => $this->model_app->get_base_64_by_id($row->MsEmpCode),
                    'menu_mode' => '-',
                    'menu_active' => 'menu-dashboard',
                    'menu_id' => '1',
                    'login_status' => true,
                    'login_mode' => $row->MsEmpMode,
                    'login_uuid' => $uuid,
                    'login_auth' => true,
                );
                $this->session->set_userdata($sess_array);

                $json = array(
                    "status" => "Success",
                    "username" => "",
                    "password" => ""
                );
                
                set_cookie('username', $row->MsEmpCode, '3600');
                set_cookie('password', $this->model_app->EncryptedPassword(str_replace("'", "''", $pass)), '3600');
                set_cookie('uuid', $uuid, '3600'); 
                set_cookie('auth', false, '3600'); 
            } else {
                $json = array(
                    "status" => "failed",
                    "username" => "",
                    "password" => "Password tidak cocok"
                );
            }
        } else {
            $json = array(
                "status" => "failed",
                "username" => "User belum terdaftar atau tidak aktif",
                "password" => ""
            );
        }

        header('Content-type: application/json');
        echo json_encode($json);
    } 
    function logout()
    { 
        delete_cookie('username');
        delete_cookie('password');
        delete_cookie('uuid');
        delete_cookie('auth');

        $this->session->unset_userdata('MsEmpId');
        $this->session->unset_userdata('MsEmpCode');
        $this->session->unset_userdata('MsEmpName');
        $this->session->unset_userdata('MsEmpPositionName');
        $this->session->unset_userdata('MsEmpPositionId');
        $this->session->unset_userdata('MsWorkplaceCode');
        $this->session->unset_userdata('MsEmpPass');
        $this->session->unset_userdata('MsEmpWhatsapp');
        $this->session->unset_userdata('MsEmpEmail');
        $this->session->unset_userdata('MsWorkplaceId');
        $this->session->unset_userdata('MsEmpImage');
        $this->session->unset_userdata('login_status');
        $this->session->unset_userdata('login_mode');
        $this->session->unset_userdata('login_uuid');
        $this->session->set_flashdata('notif', '<p class="alert alert-success"><font FACE="calibri" Size="3px" color="RED"> Logout berhasil, Terima kasih telah menggunakan aplikasi ini...!!!</font></p>');
        redirect('login', 'refresh');
    }
    function bypass($uuid,$code){
        $login_uuid = $this->session->userdata("login_uuid");
        $user = $this->session->userdata("MsEmpId");
        if(!$login_uuid) redirect('login', 'refresh');  
        $old = $this->db
        ->where("SysVerifikasiUUID",$login_uuid)
        ->where("SysVerifikasiUser",$user)
        ->where("SysVerifikasiType",1)
        ->where("SysVerifikasiCode",$code)
        ->where("SysVerifikasiDate >", date_format(date_create(),"Y-m-d H:i:s"))->get("TblSysVerifikasi");
        if($old->num_rows() > 0){ 
            delete_cookie('auth');
            set_cookie('auth', true, '3600');   
            $this->session->set_userdata('login_auth',true);
            redirect('client', 'refresh');  
        }else{
            redirect('login', 'refresh');  
        }
    }

    function login_google(){
        // Redirect to profile page if the user already logged in 
        // Fill CLIENT ID, CLIENT SECRET ID, REDIRECT URI from Google Developer Console
        $client_id = '57741008501-7lupg3ae0o49kc1416dri88tu87rdfar.apps.googleusercontent.com';
        $client_secret = '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';
        $redirect_uri = base_url('login/profile');

        $google_client = new Google_Client();
        $google_client->setClientId($client_id); //masukkan ClientID anda 
        $google_client->setClientSecret($client_secret); //masukkan Client Secret Key anda
        $google_client->setRedirectUri($redirect_uri); //Masukkan Redirect Uri anda
        $google_client->addScope('email');
        $google_client->addScope('profile');

        if(isset($_GET["code"]))
        {
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
            if(!isset($token["error"]))
            {
            $google_client->setAccessToken($token['access_token']);
            $this->session->set_userdata('access_token', $token['access_token']);
            $google_service = new Google_Service_Oauth2($google_client);
            $data = $google_service->userinfo->get();
            $current_datetime = date('Y-m-d H:i:s');
                $user_data = array(
                    'first_name' => $data['given_name'],
                    'last_name'  => $data['family_name'],
                    'email_address' => $data['email'],
                    'profile_picture'=> $data['picture'],
                    'updated_at' => $current_datetime
                );
                $this->session->set_userdata('user_data', $data);
            }									
        }
        $login_button = '';
        if(!$this->session->userdata('access_token'))
        {
            
            $login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="https://1.bp.blogspot.com/-gvncBD5VwqU/YEnYxS5Ht7I/AAAAAAAAAXU/fsSRah1rL9s3MXM1xv8V471cVOsQRJQlQCLcBGAsYHQ/s320/google_logo.png" /></a>';
            $data['login_button'] = $login_button;
            $this->load->view('google_login', $data);
        }
        else
        {
            // uncomentar kode dibawah untuk melihat data session email
            // echo json_encode($this->session->userdata('access_token')); 
            // echo json_encode($this->session->userdata('user_data'));
            echo "Login success";
        }
    } 
    
    public function profile(){ 
       // Redirect to profile page if the user already logged in 
        // Fill CLIENT ID, CLIENT SECRET ID, REDIRECT URI from Google Developer Console
        $client_id = '57741008501-7lupg3ae0o49kc1416dri88tu87rdfar.apps.googleusercontent.com';
        $client_secret = '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';
        $redirect_uri = base_url('login/profile');

        $google_client = new Google_Client();
        $google_client->setClientId($client_id); //masukkan ClientID anda 
        $google_client->setClientSecret($client_secret); //masukkan Client Secret Key anda
        $google_client->setRedirectUri($redirect_uri); //Masukkan Redirect Uri anda
        $google_client->addScope('email');
        $google_client->addScope('profile');

        if(isset($_GET["code"]))
        {
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
            if(!isset($token["error"]))
            {
            $google_client->setAccessToken($token['access_token']);
            $this->session->set_userdata('access_token', $token['access_token']);
            $google_service = new Google_Service_Oauth2($google_client);
            $data = $google_service->userinfo->get();
            $current_datetime = date('Y-m-d H:i:s');
                $user_data = array(
                    'first_name' => $data['given_name'],
                    'last_name'  => $data['family_name'],
                    'email_address' => $data['email'],
                    'profile_picture'=> $data['picture'],
                    'updated_at' => $current_datetime
                );
                $this->session->set_userdata('user_data', $data);
            }									
        }
        $login_button = '';
        if(!$this->session->userdata('access_token'))
        {
            
            $login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="https://1.bp.blogspot.com/-gvncBD5VwqU/YEnYxS5Ht7I/AAAAAAAAAXU/fsSRah1rL9s3MXM1xv8V471cVOsQRJQlQCLcBGAsYHQ/s320/google_logo.png" /></a>';
            $data['login_button'] = $login_button;
            $this->load->view('google_login', $data);
        }
        else
        {
            // uncomentar kode dibawah untuk melihat data session email
            // echo json_encode($this->session->userdata('access_token')); 
            // echo json_encode($this->session->userdata('user_data'));
            echo "Login success";
        }
        
    } 
    
    public function logout_google(){ 
        $this->session->unset_userdata('access_token');

        $this->session->unset_userdata('user_data');
        echo "Logout berhasil";
    } 


    function test_generate(){
        echo $this->model_app->EncryptedPassword("0001");
    }
}
