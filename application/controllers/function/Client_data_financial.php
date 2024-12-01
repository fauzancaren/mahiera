<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_data_financial extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      $this->load->helper('directory');
      $this->load->library('image_lib');
      date_default_timezone_set('Asia/Jakarta');
   }

   function get_data_approve()
   {
      $toko = $this->input->post("tb_status");
      $search = $this->input->post("tb_search");
      if ($toko != "-") $this->db->like("MsWorkplaceId", $toko);
      $this->db->join('TblSales', 'TblSales.SalesCode = TblSalesPayment.PaymentRef');
      $this->db->join('TblMsCustomer', 'TblSales.MsCustomerId=TblMsCustomer.MsCustomerId');
      $this->db->join('TblMsMethod', 'TblMsMethod.MsMethodId=TblSalesPayment.MsMethodId');

      $this->db->where("PaymentApprove", 0);
      $this->db->group_start();
      $this->db->like("SalesCode", $search)->or_like("MsCustomerName", $search)->or_like("MsCustomerCompany", $search)->or_like("MsCustomerCode", $search)->or_like("PaymentTotal", $search);
      $this->db->group_end();
      $master = $this->db->get("TblSalesPayment")->result();
      $html = "";
      $no = 0;
      foreach ($master as $row) {

         $sales_telp = (($row->MsCustomerTelp2 == "" || $row->MsCustomerTelp2 == "-") ? $row->MsCustomerTelp1 : $row->MsCustomerTelp1 . " / " . $row->MsCustomerTelp2);
         $html .= '<div class="row datatable-header"> 
                     <div class="col-md-5 col-sm-12 p-1 g-1">
                        <div class="row"> 
                           <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                 <img src="' . base_url("asset/image/logo/logo-") . $row->SalesHeader . '-200.png" class="rounded" width="40">
                           </div>      
                           <div class="col pe-0">
                                 <span class="fw-bold text-orange" style="font-size:11px;">' . $row->SalesCode . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                 <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                           </div>      
                           <div class="col pe-0">
                                 <span class="text-dark text-uppercase" style="font-size:12px;">' . $this->model_app->get_customer_name($row->MsCustomerId) . '</span>
                           </div>
                        </div>
                        <div class="row">
                              <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                    <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                              </div>      
                              <div class="col pe-0">
                                    <span class="text-dark text-uppercase" style="font-size:12px;">' . $sales_telp . '</span>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                    <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                              </div>      
                              <div class="col pe-0">
                                    <span class="text-dark" style="font-size:12px;">' . $row->MsCustomerAddress . '</span>
                              </div>
                        </div>
                     </div>
                     <div class="col-md-5 col-sm-12 p-1 g-1">
                        <div class="row mb-1 align-items-center">
                           <div class="label-border-right">
                              <span class="label-dialog">Payment</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Tanggal</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  date_format(date_create($row->PaymentDate), "d F Y") . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Metode</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  $row->MsMethodName . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Atas Nama</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  $row->PaymentCardName . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Total</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  number_format($row->PaymentTotal) . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Bukti</span>
                           </div>      
                           <div class="col pe-0">
                              <button type="button" class="btn btn-transparent btn-sm" aria-expanded="false" onclick="payment_view(' . $row->SalesId . ',\'' . $row->PaymentImage . '\')" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                    <i class="fas fa-eye"></i>  
                                    <span class="fw-bold">
                                    &nbsp;Lihat
                                    </span>
                              </button>
                           </div>
                           </div>
                     </div>
                     <div class="col-md-2 col-sm-12 p-1 g-1 align-items-center">
                        <button type="button" class="btn btn-outline-success btn-sm mx-1" onclick="approve_click(' . $row->PaymentId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                           <i class="fas fa-share-square"></i>  
                           <span class="fw-bold">
                           &nbsp;Approve
                           </span>
                        </button>
                     </div>
                  </div>';
      }
      if ($html == "") {
         $html = '<img src="' .  base_url("asset/image/mgs-erp/iconnotfound.png")  . '" class="rounded mx-auto d-block" width="300px">';
      }
      echo $html;
   }
   public function data_financial_approve($id)
   {
      $this->db->update('TblSalesPayment', array("PaymentApprove" => 1), array("PaymentId" => $id));
      echo ($this->db->affected_rows() != 1 ? false : true);

      $payment = $this->db->where("PaymentId", $id)->get("TblSalesPayment")->row();
      $result = $this->db->where("SalesCode", $payment->PaymentRef)->get("TblSales")->row();

      $this->db->insert("TblFinancial", array(
         "FinancialDate" => $payment->PaymentDate,
         "FinancialCategory" => '32',
         "FinancialType" => '1',
         "FinancialDescription" => "(auto) Dana Masuk Dari Customer " . $this->model_app->get_customer_name($result->MsCustomerId)  . " Sales no. " . $result->SalesCode,
         "FinancialTotal" => $payment->PaymentTotal,
         "MsWorkplaceId" => $result->MsWorkplaceId,
         "IsDelete" => "0",
         "FinancialRef" => $result->SalesCode,
         "FinancialRef2" => $id,
      ));
      $this->db->insert("TblFinancial", array(
         "FinancialDate" =>  $payment->PaymentDate,
         "FinancialCategory" => '33',
         "FinancialType" => '0',
         "FinancialDescription" => "(auto) Dana Masuk Dari Customer " . $this->model_app->get_customer_name($result->MsCustomerId)  . " Sales no. " . $result->SalesCode,
         "FinancialTotal" => $payment->PaymentTotal,
         "MsWorkplaceId" => $result->MsWorkplaceId,
         "IsDelete" => "0",
         "FinancialRef" => $result->SalesCode,
         "FinancialRef2" => $id,
      ));

      $datasales = $this->db->where("SalesCode", $payment->PaymentRef)->get("TblSales")->row();

      // ============================================== INSERT NOTIF
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $payment->PaymentRef,
            "SalesLogDesc" => "<b>Pembayaran</b> telah <b><span style='color:BLUE'>DIAPPROVE</span></b> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b>"
         )
      );
      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Pembayaran Berhasil diapprove <i class='ps-1 text-success fas fa-check'></i>",
         "NotifDesc" => "Pembayaran sudah diapprove oleh <b>" . $this->session->userdata("MsEmpName") . "</b> dengan No. Sales <b>" . $datasales->SalesCode . "</b> atas nama <b>" . $payment->PaymentCardName . "</b>" . " sebesar <b>Rp. " . number_format($payment->PaymentTotal) . "</b>",
         "NotifType" => "SALES",
         "NotifRef" => $datasales->SalesCode,
         "NotifRefDate" => $datasales->SalesDate,
         "MsWorkplaceId" => $datasales->MsWorkplaceId,
      );
      $this->model_app->insert_notif($datanotif);

      exit;
   }

   public function get_data_category()
   {
      $search = isset($_REQUEST['q']) ? $_REQUEST['q'] : NULL;
      $list = array();
      $key = 0;

      $query = $this->db->where("FinanceCatParent", 0)->get("TblFinanceCategory")->result();
      foreach ($query as $row) {
         $list[$key]['id'] = $row->FinanceCatId;
         $list[$key]['text'] = $row->FinanceCatName;
         $query1 = $this->db->where("FinanceCatParent", $row->FinanceCatId)->like("FinanceCatName", $search)->get("TblFinanceCategory")->result();
         $child = array();
         foreach ($query1 as $row1) {
            $data = array(
               "id" => $row1->FinanceCatId,
               "text" => $row->FinanceCatName . ' - ' . $row1->FinanceCatName,
            );
            $child[] = $data;
         }
         $list[$key]['children'] = $child;
         $key++;
      }
      echo json_encode($list);
      exit;
   }
   public function data_petty_cash()
   {
      $result = $this->db->get("TblFinanceCategory")->result();
      foreach ($result as $row) {
         $sub_data["id"] = $row->FinanceCatId;
         $sub_data["name"] = $row->FinanceCatName;
         $sub_data["type"] =  $row->FinanceCatType;
         $sub_data["parent_id"] =  $row->FinanceCatParent;
         $data[] = $sub_data;
      }
      foreach ($data as $key => &$value) {
         $output[$value["id"]] = &$value;
      }
      foreach ($data as $key => &$value) {
         if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
            $output[$value["parent_id"]]["nodes"][] = &$value;
         }
      }
      foreach ($data as $key => &$value) {
         if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
            unset($data[$key]);
         }
      }
      return $data;
   }
   public function data_petty_cash_kategory()
   {
      $datestart = $this->input->post("datestart");
      $dateend = $this->input->post("dateend");
      $store = $this->input->post("store");
      $data = $this->data_petty_cash();

      $data_list = "";
      $total_out = 0;
      $total_in = 0;
      $first = true;
      foreach ($data as $key) {
         $totalout = $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
            ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
            ->where("a.FinanceCatId", $key["id"])
            ->where("c.isDelete", 0)
            ->where("FinancialType", 0)
            ->where("FinancialDate >=", $datestart)
            ->where("FinancialDate <=", $dateend)
            ->like("MsWorkplaceId", $store)
            ->select_sum("c.FinancialTotal")
            ->get("TblFinanceCategory AS a")->row();

         $totalin = $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
            ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
            ->where("a.FinanceCatId", $key["id"])
            ->where("c.isDelete", 0)
            ->where("FinancialType", 1)
            ->where("FinancialDate >=", $datestart)
            ->where("FinancialDate <=", $dateend)
            ->like("MsWorkplaceId", $store)
            ->select_sum("c.FinancialTotal")
            ->get("TblFinanceCategory AS a")->row();

         $data_list .= '<div class="accordion-item ">
                  <a class="row align-items-center text-decoration-none me-2 collapsed ' . ($first == true ? "active" : "") . '" data-bs-toggle="collapse" data-bs-target="#fin-' . $key["id"] . '" aria-expanded="false" aria-controls="fin-' . $key["id"] . '" data-id="' . $key["id"] . '">
                     <div class="col">
                        <span>' . $key["name"] . '  <span class="fw-bold">(' . $this->total_petty_cash_category($key["id"], $store, $dateend) . ')</span></span>
                     </div>
                     <div class="col-auto px-1 text-end" style="width:7rem">
                        <span class="fw-bold">' . number_format((int)$totalin->FinancialTotal, 0) . '</span>
                     </div>
                     <div class="col-auto px-0 text-end" style="width:7rem">
                        <span class="fw-bold">' . number_format((int)$totalout->FinancialTotal, 0) . '</span>
                     </div>
                  </a>
               </div>
               <div id="fin-' . $key["id"] . '" class="accordion-item-sub accordion-collapse collapse" aria-labelledby="fin-' . $key["id"] . '" data-bs-parent="#menu-side">';
         $first = false;

         $total_out += $totalout->FinancialTotal;
         $total_in += $totalin->FinancialTotal;

         foreach ($key["nodes"] as $row) {
            $totalout = $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
               ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
               ->where("c.FinancialCategory", $row["id"])
               ->where("c.isDelete", 0)
               ->where("FinancialType", 0)
               ->where("FinancialDate >=", $datestart)
               ->where("FinancialDate <=", $dateend)
               ->like("MsWorkplaceId", $store)
               ->select_sum("c.FinancialTotal")
               ->get("TblFinanceCategory AS a")->row();

            $totalin = $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
               ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
               ->where("c.FinancialCategory", $row["id"])
               ->where("c.isDelete", 0)
               ->where("FinancialType", 1)
               ->where("FinancialDate >=", $datestart)
               ->where("FinancialDate <=", $dateend)
               ->like("MsWorkplaceId", $store)
               ->select_sum("c.FinancialTotal")
               ->get("TblFinanceCategory AS a")->row();

            $data_list .= '<a class="row align-items-center text-decoration-none me-2"  data-id="' . $row["id"] . '">
                     <div class="col">
                        <span>' . $row["name"] . '</span>
                     </div>
                     <div class="col-auto px-1 text-end" style="width:7rem">
                        <span class="fw-bold">' . number_format((int)$totalin->FinancialTotal, 0) . '</span>
                     </div>
                     <div class="col-auto px-0 text-end" style="width:7rem">
                        <span class="fw-bold">' . number_format((int)$totalout->FinancialTotal, 0) . '</span>
                     </div>
                  </a>';
         }
         $data_list .= '</div>';
      }
      $tataloldin = $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
         ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
         ->where("c.isDelete", 0)
         ->where("FinancialType", 1)
         ->where("FinancialDate <", $datestart)
         ->like("MsWorkplaceId", $store)
         ->select_sum("c.FinancialTotal")
         ->get("TblFinanceCategory AS a")->row();
      $tataloldout = $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
         ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
         ->where("c.isDelete", 0)
         ->where("FinancialType", 0)
         ->where("FinancialDate <", $datestart)
         ->like("MsWorkplaceId", $store)
         ->select_sum("c.FinancialTotal")
         ->get("TblFinanceCategory AS a")->row();


      $data = array(
         "list" => $data_list,
         "totalin" => number_format($total_in),
         "totalout" => number_format($total_out),
         "saldoawal" => number_format($tataloldin->FinancialTotal - $tataloldout->FinancialTotal),
         "perubahan" => number_format($total_in - $total_out),
         "sisa" => number_format(($tataloldin->FinancialTotal - $tataloldout->FinancialTotal) + ($total_in - $total_out)),

      );
      echo json_encode($data);
      exit;
   }
   public function total_petty_cash_category($category, $store, $dateend)
   {
      $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
         ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
         ->where("a.FinanceCatId", $category)
         ->where("c.isDelete", 0)
         ->where("FinancialType", 0)
         ->where("FinancialDate <=", $dateend);
      if (isset($store)) $this->db->like("MsWorkplaceId", $store);
      $totalout_sebelumnya =  $this->db->select_sum("c.FinancialTotal")->get("TblFinanceCategory AS a")->row();
      $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
         ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
         ->where("a.FinanceCatId", $category)
         ->where("c.isDelete", 0)
         ->where("FinancialType", 1)
         ->where("FinancialDate <=", $dateend);
      if (isset($store)) $this->db->like("MsWorkplaceId", $store);
      $totalin_sebelumnya =  $this->db->select_sum("c.FinancialTotal")->get("TblFinanceCategory AS a")->row();

      return number_format($totalin_sebelumnya->FinancialTotal - $totalout_sebelumnya->FinancialTotal);
   }
   public function data_petty_cash_table()
   {
      $datestart = $this->input->post("datestart");
      $dateend = $this->input->post("dateend");
      $store = $this->input->post("store");
      $id = $this->input->post("id");
      $search = $this->input->post("search");

      if ($store != "") {
         $storename = $this->model_app->get_single_data("MsWorkplaceCode", "TblMsWorkplace", array("MsWorkplaceId" => $store));
      } else {
         $storename = "Semua Toko";
      }

      $dataid = $this->db->where("FinanceCatId", $id)->get("TblFinanceCategory")->row();
      $datacategory = array();
      if ($dataid->FinanceCatParent == 0) {
         $header = '
                     <div class="d-block">
                        <span class="detail">Data toko : ' . $storename . '</span>
                        <span class="header-end">Periode ' . date_format(date_create($datestart), "d F Y") . ' - ' . date_format(date_create($dateend), "d F Y") . '1</span>
                     </div>
                     <div class="d-block">
                        <span class="header">' . $dataid->FinanceCatName . ' </span>
                     </div>';
         $datacategory = $this->db->where("FinanceCatParent", $dataid->FinanceCatId)->get("TblFinanceCategory")->result();
      } else {
         $data = $this->db->where("FinanceCatId", $dataid->FinanceCatParent)->get("TblFinanceCategory")->row();
         $header = '
                     <div class="d-block">
                        <span class="detail">Data toko : ' . $storename . '</span>
                        <span class="header-end">Periode ' . date_format(date_create($datestart), "d F Y") . ' - ' . date_format(date_create($dateend), "d F Y") . '1</span>
                     </div>
                     <div class="d-block">
                        <span class="header">' . $data->FinanceCatName . ' </span>
                     </div>';
         $datacategory = array($dataid);
      }
      $content = "";
      foreach ($datacategory as $row) {
         $data = $this->db
            ->join("TblFinanceCategory", "TblFinancial.FinancialCategory=TblFinanceCategory.FinanceCatId")
            ->where("FinancialCategory", $row->FinanceCatId)
            ->where("isDelete", 0)
            ->where("FinancialDate >=", $datestart)
            ->where("FinancialDate <=", $dateend)
            ->like("MsWorkplaceId", $store)
            ->order_by("")
            ->get("TblFinancial")->result();
         $detail_item = "";
         $no = 0;
         foreach ($data as $rows) {
            if ($search == "") {
               $desc = true;
               $category  = true;
            } else {
               $desc = strpos(strtolower($rows->FinancialDescription), strtolower($search));
               $category = strpos(strtolower($rows->FinanceCatName), strtolower($search));
            }
            if ($desc || $category) {
               $no++;
               $detail_item .= '<tr>
                              <th scope="row">' . $no . '</th>
                              <td>' . $rows->FinancialDescription . '</td>
                              <td>' . $rows->FinancialDate . '</td>
                              <td align="right">' . number_format($rows->FinancialTotal) . '</td>
                              <td>
                                 <div class="d-flex flex-row">
                                    <a onclick="view_click(' . $rows->FinancialId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                                    <a onclick="edit_click(' . $rows->FinancialId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                                    <a onclick="delete_click(' . $rows->FinancialId . ')" class="me-2 text-danger pointer" title="Delete Data"><i class="fas fa-trash-alt"></i></a>
                                 </div>
                              </td>
                           </tr>';
            }
         }
         if ($detail_item == "") {
            $detail_item = '<tr>
                              <td colspan="5">Tidak Ada Data</td>
                           </tr>';
         }
         $content .= '
                     <div class="d-block detail ms-2 bg-light">' . $row->FinanceCatName . '</div>
                     <table class="table ms-2">
                        <thead>
                           <tr>
                              <th scope="col">#</th>
                              <th scope="col">Keterangan</th>
                              <th scope="col">Tanggal</th>
                              <th scope="col">Total</th>
                              <th scope="col"><i class="fas fa-cog"></i></th>
                           </tr>
                        </thead>
                        <tbody>
                           ' . $detail_item . '
                        </tbody>
                     </table>';
      }
      echo JSON_ENCODE(array(
         "header" => $header,
         "datacategory" => $content,
      ));
   }

   public function data_petty_cash_add()
   {
      $data = array(
         "FinancialDate" => $this->input->post("FinancialDate"),
         "FinancialCategory" => $this->input->post("FinancialCategory"),
         "FinancialDescription" => $this->input->post("FinancialDesc"),
         "FinancialTotal" => $this->input->post("FinancialTotal"),
         "MsWorkplaceId" => $this->input->post("MsWorkplaceId"),
         "FinancialPath" => $this->input->post("FinancialPath"),
         "FinancialType" => $this->model_app->get_single_data("FinanceCatType", "TblFinanceCategory", array("FinanceCatId" => $this->input->post("FinancialCategory"))),
      );
      $this->db->insert('TblFinancial', $data);
      echo ($this->db->affected_rows() != 1) ? false : true;
      exit();
   }
   public function data_petty_cash_edit($id)
   {
      $data = array(
         "FinancialDate" => $this->input->post("FinancialDate"),
         "FinancialCategory" => $this->input->post("FinancialCategory"),
         "FinancialDescription" => $this->input->post("FinancialDesc"),
         "FinancialTotal" => $this->input->post("FinancialTotal"),
         "MsWorkplaceId" => $this->input->post("MsWorkplaceId"),
         "FinancialPath" => $this->input->post("FinancialPath"),
         "FinancialType" => $this->model_app->get_single_data("FinanceCatType", "TblFinanceCategory", array("FinanceCatId" => $this->input->post("FinancialCategory"))),
      );
      $this->db->update('TblFinancial', $data, array("FinancialId" => $id));
      echo ($this->db->affected_rows() != 1) ? false : true;
      $dirPath = 'asset/image/file/financial/' . $this->input->post("FinancialPath");
      if (is_dir($dirPath)) {
         $objects = scandir($dirPath);
         foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
               unlink($dirPath . DIRECTORY_SEPARATOR . $object);
            }
         }
         reset($objects);
         rmdir($dirPath);
      }

      exit();
   }
   public function data_petty_cash_delete($id)
   {
      $this->db->update('TblFinancial', array("isDelete" => 1), array("FinancialId" => $id));
      echo ($this->db->affected_rows() != 1) ? false : true;
      exit();
   }


   public function data_image_url($id)
   {
      $map = directory_map('./asset/image/file/financial/' . $id, FALSE, TRUE);
      asort($map);
      $arr_file = array();
      foreach ($map as $row) {
         $data = array(
            "filename" => $row,
            "size" => filesize("./asset/image/file/financial/" . $id . "/" . $row),
            "filetype" => filetype("./asset/image/file/financial/" . $id . "/" . $row),
            "dataURL" => base_url("asset/image/file/financial/") . $id . "/" . $row,
         );
         $arr_file[] = $data;
      }
      echo json_encode($arr_file);
   }
   public function upload_file($folder)
   {
      if (!empty($_FILES['file']['name'])) {
         if (!file_exists('asset/image/file/financial/')) {
            mkdir("asset/image/file/financial", 0777);
         }
         if (!file_exists('asset/image/file/financial/' . $folder . '/')) {
            mkdir("asset/image/file/financial/" . $folder, 0777);
         }
         // Set preference
         $config['upload_path'] = 'asset/image/file/financial/' . $folder;
         $config['allowed_types'] = '*';
         $config['max_size'] = '100000'; // max_size in kb
         $config['file_name'] = $_FILES['file']['name'];

         //Load upload library
         $this->load->library('upload', $config);
         // File upload
         if ($this->upload->do_upload('file')) {
            // Get data about the file
            $uploadData = $this->upload->data();
            echo $uploadData;
            exit;
         }
      }
   }



   public function get_card_pihutang($id){
      $this->db->where("SalesStatusPayment", 1);
      $datestart = $this->input->post("tanggalstart");
      $dateend = $this->input->post("tanggalend");
      $datechecked = $this->input->post("tanggalchecked");

      if($datechecked == "true"){
         $this->db->where("SalesDate >=", $datestart);
         $this->db->where("SalesDate <=", $dateend);
      }

      if($id > 0) $this->db->where("MsWorkplaceId", $id);
      $datasales = $this->db->get("TblSales")->result();
      $array = []; 
      foreach($datasales as $row){
         $arr_sales = array("SalesCode"=>$row->SalesCode,"SalesGrandTotal"=>$row->SalesGrandTotal);

         /* get payment */
         $datapayment = $this->db->where("PaymentRef",$row->SalesCode)->get("TblSalesPayment")->result();
         $arr_pay_sales = []; 
         $pay_total = 0;
         foreach($datapayment as $row_payment){
            $arr_pay_sales[] = array(
               "PaymentType"=> $row_payment->PaymentType,
               "PaymentDate"=> $row_payment->PaymentDate,
               "PaymentTotal"=> $row_payment->PaymentTotal, 
            );
            $pay_total += $row_payment->PaymentTotal;
         }

         /* get item sales */
         $dataitem = $this->db->where("SalesDetailRef",$row->SalesCode)->get("TblSalesDetail")->result();
         $arr_item_sales = []; 
         $status_pengiriman = true;
         foreach($dataitem as $row_item){
            /* get data Delivery by Item */
            $datadelivery = $this->db
               ->join("TblDeliveryDetail","TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
               ->where("DeliveryRef",$row->SalesCode)
               ->Where("MsItemId",$row_item->MsItemId)
               ->Where("MsVendorCode",$row_item->MsVendorCode)
               ->where("DeliveryDate < ",date("Y-m-d"))
               ->get("TblDelivery")->result();
            $arr_item_delivery = []; 
            $DeliveryQty = 0;
            foreach($datadelivery as $row_delivery){ 
               $arr_item_delivery[] = array(
                  "DeliveryCode"=> $row_delivery->DeliveryCode,
                  "DeliveryDate"=> $row_delivery->DeliveryDate,
                  "MsItemId"=> $row_delivery->MsItemId,
                  "MsVendorCode"=> $row_delivery->MsVendorCode,
                  "Qty"=> $row_delivery->DeliveryDetailQty,
               );
               
               $DeliveryQty += $row_delivery->DeliveryDetailQty;
            }
            $arr_item_sales[] = array(
               "MsItemId"=> $row_item->MsItemId,
               "MsVendorCode"=> $row_item->MsVendorCode,
               "Qty"=> $DeliveryQty, 
               "QtyDelivery"=> $row_item->SalesDetailQty, 
               "Delivery"=> $arr_item_delivery,
            ); 
            if($DeliveryQty < $row_item->SalesDetailQty) $status_pengiriman = false;
         }
         
         $arr_sales["PaymentTotal"] = $pay_total;
         $arr_sales["PaymentSisa"] = $row->SalesGrandTotal -$pay_total;
         $arr_sales["PaymentDetail"] = $arr_pay_sales; 
         $arr_sales["DeliveryStatus"] = $status_pengiriman;
         $arr_sales["Item"] = $arr_item_sales;
         $array[] = $arr_sales;
      } 
      $data_selesai = array_filter($array,function($data){return $data["DeliveryStatus"] == true;});
      $data_progress = array_filter($array,function($data){return $data["DeliveryStatus"] == false;});
      header('Content-type: application/json'); 
      echo json_encode( array(
         "totaltrans"=> count($array),
         "totalpayment"=> array_sum(array_column($array,'PaymentSisa')),
         "hutangtrans"=> count($data_selesai), 
         "hutangpayment"=> array_sum(array_column($data_selesai,'PaymentSisa')),
         "progresstrans"=> count($data_progress),
         "progresspayment"=> array_sum(array_column($data_progress,'PaymentSisa')), 
      ));
   }
   public function get_list_pihutang(){
      $status = $this->input->post("status");
      $store = $this->input->post("store");
      $search = $this->input->post("search");
      $datestart = $this->input->post("tanggalstart");
      $dateend = $this->input->post("tanggalend");
      $datechecked = $this->input->post("tanggalchecked");

      
      $this->db->join("TblMsCustomer","TblMsCustomer.MsCustomerId=TblSales.MsCustomerId");
      $this->db->join("TblMsEmployee","TblMsEmployee.MsEmpId=TblSales.MsEmpId");
      $this->db->join("TblMsWorkplace","TblMsWorkplace.MsWorkplaceId=TblSales.MsWorkplaceId");
      $this->db->where("SalesStatusPayment", 1);
      if($store > 0) $this->db->where("TblSales.MsWorkplaceId", $store); 
      if($datechecked == "true"){
         $this->db->where("SalesDate >=", $datestart);
         $this->db->where("SalesDate <=", $dateend);
      }
      $datasales = $this->db->get("TblSales")->result();
      $array = []; 
      $no = 0;
      $content = "";
      foreach($datasales as $row){
         $arr_sales = array("SalesCode"=>$row->SalesCode,"SalesGrandTotal"=>$row->SalesGrandTotal);




         /* get payment */
         $datapayment = $this->db->join("TblMsMethod","TblMsMethod.MsMethodId=TblSalesPayment.MsMethodId")->where("PaymentRef",$row->SalesCode)->get("TblSalesPayment")->result(); 
         $pay_total = 0;
         $pay_content = '<table class="table table-sm">
         <thead>
            <tr>
               <th scope="col">#</th>
               <th scope="col">Metode Pembayaran</th>
               <th scope="col">Nama</th>
               <th scope="col">Tanggal</th>
               <th scope="col">Total</th> 
            </tr>
         </thead>';
         $no = 0;
         foreach($datapayment as $row_payment) {
            $no++;
            $pay_content .= '
            <tr>
               <th scope="row">'.$no.'</th> 
               <td>'.$row_payment->MsMethodCode.' - '.$row_payment->MsMethodName.'</td>
               <td>'.$row_payment->PaymentCardName.'</td>
               <td>'.$row_payment->PaymentDate.'</td>
               <td class="text-end">'.number_format($row_payment->PaymentTotal,0).'</td>
            </tr>
            ';
            $pay_total += $row_payment->PaymentTotal; 
         } 
         $pay_content .= '</tbody></table>';




         /* get item sales */
         $dataitem = $this->db->join("TblMsItem","TblMsItem.MsItemId=TblSalesDetail.MsItemId")->where("SalesDetailRef",$row->SalesCode)->get("TblSalesDetail")->result(); 
         $status_pengiriman = true;
         $item_content = '<table class="table table-sm">
         <thead>
            <tr>
               <th scope="col">#</th>
               <th scope="col">Nama Barang</th>
               <th scope="col">Vendor</th>
               <th scope="col">Ukuran</th>
               <th scope="col">Qty Sales</th>
               <th scope="col">Sudah kirim</th>
               <th scope="col">Sisa kirim</th>
            </tr>
         </thead>';
         $no = 0;
         foreach($dataitem as $row_item){
            $no++;
            /* get data Delivery by Item */
            $datadelivery = $this->db
               ->join("TblDeliveryDetail","TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
               ->where("DeliveryRef",$row->SalesCode)
               ->Where("MsItemId",$row_item->MsItemId)
               ->Where("MsVendorCode",$row_item->MsVendorCode)
               ->where("DeliveryDate < ",date("Y-m-d"))
               ->get("TblDelivery")->result();
           
            $DeliveryQty = 0;
            foreach($datadelivery as $row_delivery){
               $DeliveryQty += $row_delivery->DeliveryDetailQty; 
            }
            if($DeliveryQty < $row_item->SalesDetailQty) $status_pengiriman = false;
            $item_content .= '
               <tr class="'.(($row_item->SalesDetailQty - $DeliveryQty) > 0 ? "bg-danger bg-opacity-10" : "").'">
                 <th scope="row">'.$no.'</th>
                 <td>'.$row_item->MsItemCode.' - '.$row_item->MsItemName.'</td>
                 <td>'.$row_item->MsVendorCode.'</td>
                 <td>'.$row_item->MsItemSize.'</td>
                 <td>'.number_format($row_item->SalesDetailQty,0)." ".$row_item->MsItemUoM.'</td>
                 <td>'.number_format($DeliveryQty,0)." ".$row_item->MsItemUoM.'</td>
                 <td>'.number_format($row_item->SalesDetailQty - $DeliveryQty,0)." ".$row_item->MsItemUoM.'</td>
               </tr>
            ';
            
         } 
         $item_content .= '</tbody></table>';
         // Cek Status Transaksi Filter 
         if($status== 1 && $status_pengiriman != false) continue; 
         if($status== 2 && $status_pengiriman != true) continue; 
         if(strlen($search) > 0){
            $return = false; 
            if(strpos($pay_total,$search) !== false) $return = true;
            if(strpos($row->SalesGrandTotal,$search)!== false) $return = true;
            if(strpos(($row->SalesGrandTotal -$pay_total),$search)!== false) $return = true;
            if(strpos(strtolower($row->MsCustomerName),strtolower($search))!== false) $return = true;
            if(strpos(strtolower($row->MsCustomerCompany),strtolower($search))!== false) $return = true;
            if(strpos(strtolower($row->SalesCode),strtolower($search))!== false) $return = true;
            if(strpos(strtolower($row->MsCustomerTelp1),strtolower($search))!== false) $return = true;
            if(strpos(strtolower($row->MsCustomerTelp2),strtolower($search))!== false) $return = true;
            if(strpos(strtolower($row->MsCustomerAddress),strtolower($search))!== false) $return = true;
            if(strpos(strtolower($row->MsEmpName),strtolower($search))!== false) $return = true;
            if(strpos(strtolower(date_format(date_create($row->SalesDate),"d F Y")),strtolower($search))!== false) $return = true;
            if(strpos(strtolower(date_format(date_create($row->SalesDate),"Y-m-d")),strtolower($search))!== false) $return = true;
            if($return===false) continue;
         } 
         $no++;
         if(!$status_pengiriman){
            $d_status= '
               <div class="text-center text-primary bg-primary bg-opacity-10 p-2">
                  <div class="fw-bold  d-inline" style="font-size:1.5rem">PROGRESS</div><br>
                  <div class="d-inline" style="font-size:0.7rem">(Sedang Berjalan)</div>
               </div>';
         }else{
            $d_status= '
               <div class="text-center text-orange bg-warning bg-opacity-10 p-2">
                  <div class="fw-bold  d-inline" style="font-size:1.5rem">SELESAI</div><br>
                  <div class="d-inline" style="font-size:0.7rem">(Transaksi Selesai)</div>
               </div>';
         }
         $content .= '<div class="row datatable-header mb-2" style="font-size:0.75rem">  
                  <div class="col-md-2 col-sm-12 p-1 g-1 border-end text-center">
                     <img src="' . base_url("asset/image/logo/logo-").$row->SalesHeader.'-200.png" class="rounded" width="100">
                   '.$d_status.'
                  </div> 
                  <div class="col-md-10 col-sm-12">
                     <div class="row">
                        <div class="col-md-4 col-sm-8 p-3 g-1 ">
                           <div class="row mb-1 align-items-center">
                              <div class="label-border-right">
                                 <span class="label-dialog">Transaksi</span>
                              </div>
                           </div>
                           <div class="row"> 
                              <div class="col-auto pe-0" style="min-width:5rem;">
                                 <span class="fw-bold text-secondary">No. INV</span>
                              </div>      
                              <div class="col pe-0">
                                    <span class="fw-bold text-dark">'.$row->SalesCode.'</span>
                              </div>
                           </div>  
                           <div class="row"> 
                              <div class="col-auto pe-0" style="min-width:5rem;">
                                 <span class="fw-bold text-secondary">Tanggal</span>
                              </div>      
                              <div class="col pe-0">
                                    <span class="fw-bold text-dark">'.date_format(date_create($row->SalesDate),"d F Y").'</span>
                              </div>
                           </div> 
                           <div class="row"> 
                              <div class="col-auto pe-0" style="min-width:5rem;">
                                 <span class="fw-bold text-secondary">Toko</span>
                              </div>      
                              <div class="col pe-0">
                                    <span class="fw-bold text-dark">'.$row->MsWorkplaceCode.'</span>
                              </div>
                           </div> 
                           <div class="row"> 
                              <div class="col-auto pe-0" style="min-width:5rem;">
                                 <span class="fw-bold text-secondary">Admin</span>
                              </div>      
                              <div class="col pe-0">
                                    <span class="fw-bold text-dark">'.$row->MsEmpName.'</span>
                              </div>
                           </div> 
                        </div>
                        <div class="col-md-5 col-sm-12 p-3 g-1">
                           <div class="row mb-1 align-items-center">
                              <div class="label-border-right">
                                 <span class="label-dialog">Customer</span>
                              </div>
                           </div>
                           <div class="row"> 
                              <div class="col-auto pe-0" style="min-width:5rem;">
                                 <span class="fw-bold text-secondary">Nama</span>
                              </div>      
                              <div class="col pe-0">
                                    <span class="fw-bold text-dark">'.$this->model_app->get_customer_name($row->MsCustomerId).'</span>
                              </div>
                           </div> 
                           <div class="row"> 
                              <div class="col-auto pe-0" style="min-width:5rem;">
                                 <span class="fw-bold text-secondary">Telp.</span>
                              </div>      
                              <div class="col pe-0">
                                    <span class="fw-bold text-dark">'.$this->model_app->get_customer_telp($row->MsCustomerId).'</span>
                              </div>
                           </div> 
                           <div class="row"> 
                              <div class="col-auto pe-0" style="min-width:5rem;">
                                 <span class="fw-bold text-secondary">Alamat.</span>
                              </div>      
                              <div class="col pe-0">
                                    <span class="fw-bold text-dark">'.$row->MsCustomerAddress.'</span>
                              </div>
                           </div> 
                        </div>  
                        <div class="col-md-3 col-sm-8 p-3 g-1 "> 
                           <div class="row"> 
                              <div class="col-auto pe-0" style="min-width:5rem;">
                                 <span class="fw-bold text-secondary">Total</span>
                              </div>      
                              <div class="col pe-0 text-end">
                                    <span class="fw-bold text-primary" style="font-size:1rem">'.number_format($row->SalesGrandTotal,0).'</span>
                              </div>
                           </div> 
                           <div class="row"> 
                              <div class="col-auto pe-0" style="min-width:5rem;">
                                 <span class="fw-bold text-secondary">Sudah Bayar</span>
                              </div>      
                              <div class="col pe-0 text-end">
                                    <span class="fw-bold text-primary" style="font-size:1rem">'.number_format($pay_total,0).'</span>
                              </div>
                           </div> 
                           <div class="row"> 
                              <div class="col-auto pe-0" style="min-width:5rem;">
                                 <span class="fw-bold text-secondary">Sisa Bayar</span>
                              </div>      
                              <div class="col pe-0 text-end">
                                    <span class="fw-bold '.(!$status_pengiriman ? "text-primary":"text-danger").'" style="font-size:1rem">'.number_format($row->SalesGrandTotal - $pay_total,0).'</span>
                              </div>
                           </div> 
                        </div>
                        <div class="col-12 border-top p-2 px-4">
                           <div class="row mb-1 align-items-center ">
                              <a class="toggle text-decoration-none p-2 bg-secondary bg-opacity-10 collapsed" data-bs-toggle="collapse" href="#payment-'.$row->SalesId.'" role="button" aria-expanded="false" aria-controls="payment-'.$row->SalesId.'">
                                 <i class="fas fa-chevron-right"></i> <span class="label-dialog fw-bold ps-2">lihat Detail Pembayaran</span>
                              </a>
                              <div class="collapse" id="payment-'.$row->SalesId.'">
                                 <div class="d-block p-2 table-responsive"> '.$pay_content.' </div>
                              </div>
                           </div>
                           <div class="row mb-1 align-items-center ">
                              <a class="toggle text-decoration-none p-2 bg-secondary bg-opacity-10 collapsed" data-bs-toggle="collapse" href="#detail-'.$row->SalesId.'" role="button" aria-expanded="false" aria-controls="detail-'.$row->SalesId.'">
                                 <i class="fas fa-chevron-right"></i> <span class="label-dialog fw-bold  ps-2">lihat Detail Barang</span>
                              </a>
                              <div class="collapse" id="detail-'.$row->SalesId.'">
                                 <div class="d-block p-2 table-responsive">'.$item_content.' </div>
                              </div>
                           </div>
                        </div> 
                     </div>
                  </div>
               </div>';
      } 
      if($content==""){
         $content = '<div class="row text-center" style="font-size:0.75rem"> 
            <div class="d-inline-block">
               <img src="'.base_url("asset/image/mgs-erp/iconnotfound.png").'" width="300px">
            </div>
         </div>';
      }
      echo $content;
   }
}
