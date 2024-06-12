<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_data_chat extends CI_Controller
{
    function __construct()
    {
        parent::__construct(); 
        $this->load->model('model_app');
    }
    function send_chat(){
        $data = $this->input->post("data");   
        $this->db->insert("TblChat",$data);
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit; 
    }

    function get_list_chat(){
        $code = $this->input->post("code");   
        $search = $this->input->post("search");   
        $query = $this->db  
        ->query("SELECT * from (
            SELECT ChatId,ChatFrom,ChatTo,ChatText,ChatDate,ChatRead,'FROM' FROM TblChat WHERE ChatFrom='".$code."'
            UNION ALL
            SELECT ChatId,ChatTo,ChatFrom,ChatText,ChatDate,ChatRead,'TO' FROM TblChat WHERE ChatTO='".$code."'
        ) a  ORDER BY a.ChatTo DESC, a.ChatDate DESC ")->result();
        $data = [];
        $userlast="";
        foreach($query as $row){ 
            $now = date_create($row->ChatDate);
            $now->modify('+7 hours'); 
            
            if($userlast != $row->ChatTo){
                $userlast = $row->ChatTo;  
                $data[] = array(
                    "userimage"=>$this->model_app->get_base_64_by_id($row->ChatTo),
                    "nama"=>$this->model_app->get_single_data("MsEmpName","TblMsEmployee",array("MsEmpCode"=>$row->ChatTo)),
                    "code"=>$row->ChatTo,
                    "ChatId"=>$row->ChatId,
                    "ChatFrom"=>$row->ChatTo,
                    "ChatTo"=>$row->ChatFrom,
                    "ChatText"=>$row->ChatText,
                    "ChatDate"=>date_format($now, "Y-m-d H:i:s") ,
                    "ChatRead"=>$row->ChatRead, 
                    "ChatType"=>$row->FROM, 
                ); 
            }
        }
        usort($data, function($a, $b)
        {
            return $a["ChatDate"] < $b["ChatDate"];
        });
        echo JSON_ENCODE($data);
        exit; 
    }
    function get_chat(){
        $data = $this->input->post("data");   
        $query = $this->db
        ->group_start()->where("ChatFrom",$data["ChatFrom"])->where("ChatTo",$data["ChatTo"])->group_end()
        ->or_group_start()->where("ChatFrom",$data["ChatTo"])->where("ChatTo",$data["ChatFrom"])->group_end()
        ->get("TblChat")->result();
        echo JSON_ENCODE( $query);
        exit; 
    }
    function get_new_chat(){
        $data = $this->input->post("data");   
        $query = $this->db
        ->group_start()->where("ChatFrom",$data["ChatFrom"])->where("ChatTo",$data["ChatTo"])->where("ChatDate >",$data["ChatDate"])->group_end()
        ->or_group_start()->where("ChatFrom",$data["ChatTo"])->where("ChatTo",$data["ChatFrom"])->where("ChatDate >",$data["ChatDate"])->group_end() 
        ->get("TblChat")->result();
        echo JSON_ENCODE( $query);
        exit; 
    }
}