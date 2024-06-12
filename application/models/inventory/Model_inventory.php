<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_inventory extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insert_trans_from_sales($salescode)
    {
        //kembalikan data lama dan hapus data lama
        $this->delete_trans_plus($salescode);

        $count_payment = $this->db->where("PaymentRef", $salescode)->get("TblSalesPayment")->num_rows();
        if ($count_payment > 0) {
            //update data baru
            $data_item_sales = $this->db->join("TblSales", "TblSales.SalesCode=TblSalesDetail.SalesDetailRef", "left")->where("SalesDetailRef", $salescode)->get("TblSalesDetail")->result();
            foreach ($data_item_sales as $row) {
                $datatrans = array(
                    "InvTransCode" => $salescode,
                    "InvTransDate" => $row->SalesDate,
                    "InvTransType" => "SL",
                    "MsWorkplaceId" => $row->MsWorkplaceId,
                    "InvTransQty" => $row->SalesDetailQty,
                    "MsItemId" => $row->MsItemId,
                    "MsVendorCode" => $row->MsVendorCode,
                );

                $this->db->insert("TblInvTrans", $datatrans);

                $data_stock = $this->db
                    ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblInvStock.MsVendorId", "left")
                    ->where("MsItemId", $row->MsItemId)
                    ->where("MsVendorCode", $row->MsVendorCode)
                    ->where("MsWorkplaceId", $row->MsWorkplaceId)
                    ->get("TblInvStock")->row();

                $this->db->update(
                    "TblInvStock",
                    array("InvStockQty" => ($data_stock->InvStockQty - $row->SalesDetailQty)),
                    array("InvStockId" =>  $data_stock->InvStockId)
                );
            }
        }
    }

    function insert_trans_from_grpo($grpocode)
    {
        //kembalikan data lama dan hapus data lama
        $this->delete_trans($grpocode);
        $select = $this->db->select("*,TblGRPO.MsVendorCode")
            ->join("TblGRPODetail","TblGRPODetail.GRPODetailRef=TblGRPO.GRPOCode")
            ->where("GRPOCode",$grpocode)->get("TblGRPO")->result();  

        foreach ($select as $row) {
            if($row->GRPODst != 0){ 
                //INSERT DATA TRANSAKSI INVENTORY
                $datatrans = array(
                    "MsProdukTransRef" => $grpocode,
                    "MsProdukTransDate" => $row->GRPODate,
                    "MsProdukTransType" => "GR",
                    "MsWorkplaceId" => $row->GRPODst,
                    "MsProdukTransQty" => $row->GRPODetailQty,
                    "MsProdukId" => $row->MsProdukId,
                    "MsProdukVarian" => $row->GRPODetailVarian,
                ); 
                $this->db->insert("TblMsProdukTrans", $datatrans); 

                //UPDATE DATA QTY STOCK INVENTORY
                $data_stock = $this->get_stock($row->GRPODetailVarian,$row->MsProdukId,$row->GRPODst);
                $this->db->update(
                    "TblMsProdukStock",
                    array("MsProdukStockQty" => ($data_stock->MsProdukStockQty + $row->GRPODetailQty)),
                    array("MsProdukStockId" =>  $data_stock->MsProdukStockId)
                );
            } 
            if($row->MsVendorCode == "WHO"){ // update stock warehouse
                //INSERT DATA TRANSAKSI INVENTORY MIN
                $datatrans = array(
                    "MsProdukTransRef" => $grpocode,
                    "MsProdukTransDate" => $row->GRPODate,
                    "MsProdukTransType" => "PO",
                    "MsWorkplaceId" => 2,
                    "MsProdukTransQty" => $row->GRPODetailQty,
                    "MsProdukId" => $row->MsProdukId,
                    "MsProdukVarian" => $row->GRPODetailVarian,
                ); 
                $this->db->insert("TblMsProdukTrans", $datatrans); 

                //UPDATE DATA QTY STOCK INVENTORY MIN
                $data_stock = $this->get_stock($row->GRPODetailVarian,$row->MsProdukId,2); 
                $this->db->update(
                    "TblMsProdukStock",
                    array("MsProdukStockQty" => ($data_stock->MsProdukStockQty - $row->GRPODetailQty)),
                    array("MsProdukStockId" =>  $data_stock->MsProdukStockId)
                );

                //INSERT DATA TRANSAKSI INVENTORY MIN
                $datatrans = array(
                    "MsProdukTransRef" => $grpocode,
                    "MsProdukTransDate" => $row->GRPODate,
                    "MsProdukTransType" => "BR",
                    "MsWorkplaceId" => 2,
                    "MsProdukTransQty" => $row->GRPODetailWasteQty,
                    "MsProdukId" => $row->MsProdukId,
                    "MsProdukVarian" => $row->GRPODetailVarian,
                ); 
                $this->db->insert("TblMsProdukTrans", $datatrans); 

                //UPDATE DATA QTY STOCK INVENTORY MIN
                $data_stock = $this->get_stock($row->GRPODetailVarian,$row->MsProdukId,2); 
                $this->db->update(
                    "TblMsProdukStock",
                    array("MsProdukStockQty" => ($data_stock->MsProdukStockQty - $row->GRPODetailWasteQty)),
                    array("MsProdukStockId" =>  $data_stock->MsProdukStockId)
                );
            } 
        } 
    }

    function insert_trans_from_to($tocode)
    {
        //kembalikan data lama dan hapus data lama 
        $this->delete_trans($tocode);
        $data_item = $this->db->join("TblInvTO", "TblInvTO.InvTOCode=TblInvTODetail.InvTODetailRef", "left")
            ->where("InvTODetailRef", $tocode)->get("TblInvTODetail")->result();
        foreach ($data_item as $row) {
             //INSERT DATA TRANSAKSI INVENTORY
             $datatrans = array(
                "MsProdukTransRef" => $tocode,
                "MsProdukTransDate" => $row->InvTODate,
                "MsProdukTransType" => "TO",
                "MsWorkplaceId" => $row->InvTOSrc,
                "MsProdukTransQty" => $row->InvTODetailQty,
                "MsProdukId" => $row->MsProdukId,
                "MsProdukVarian" => $row->InvTODetailVarian,
            ); 
            $this->db->insert("TblMsProdukTrans", $datatrans); 


            //UPDATE DATA QTY STOCK INVENTORY
            $data_stock = $this->get_stock($row->InvTODetailVarian,$row->MsProdukId,$row->InvTOSrc);
            $this->db->update(
                "TblMsProdukStock",
                array("MsProdukStockQty" => ($data_stock->MsProdukStockQty - $row->InvTODetailQty)),
                array("MsProdukStockId" =>  $data_stock->MsProdukStockId)
            );
  
        }
    }

    function insert_trans_from_ti($ticode)
    { 

        //kembalikan data lama dan hapus data lama 
        $this->delete_trans($ticode);
        $data_item = $this->db->join("TblInvTI", "TblInvTI.InvTICode=TblInvTIDetail.InvTIDetailRef", "left")
            ->where("InvTIDetailRef", $ticode)->get("TblInvTIDetail")->result();
        foreach ($data_item as $row) {
            //INSERT DATA TRANSAKSI INVENTORY
            $datatrans = array(
                "MsProdukTransRef" => $ticode,
                "MsProdukTransDate" => $row->InvTIDate,
                "MsProdukTransType" => "TI",
                "MsWorkplaceId" => $row->InvTIDst,
                "MsProdukTransQty" => $row->InvTIDetailQty,
                "MsProdukId" => $row->MsProdukId,
                "MsProdukVarian" => $row->InvTIDetailVarian,
            ); 
            $this->db->insert("TblMsProdukTrans", $datatrans); 


            //UPDATE DATA QTY STOCK INVENTORY
            $data_stock = $this->get_stock($row->InvTIDetailVarian,$row->MsProdukId,$row->InvTIDst);
            $this->db->update(
                "TblMsProdukStock",
                array("MsProdukStockQty" => ($data_stock->MsProdukStockQty + $row->InvTIDetailQty)),
                array("MsProdukStockId" =>  $data_stock->MsProdukStockId)
            );

        } 
    }

    function insert_trans_from_waste($grpocode)
    {
        //kembalikan data lama dan hapus data lama
        $this->delete_trans_plus($grpocode);

        $data_item = $this->db->join("TblInvWaste", "TblInvWaste.InvWasteCode=TblInvWasteDetail.InvWasteDetailRef", "left")
            ->where("InvWasteDetailRef", $grpocode)->get("TblInvWasteDetail")->result();
        foreach ($data_item as $row) {
            $datatrans = array(
                "InvTransCode" => $grpocode,
                "InvTransDate" => $row->InvWasteDate,
                "InvTransType" => "IW",
                "MsWorkplaceId" => $row->MsWorkplaceId,
                "InvTransQty" => $row->InvWasteDetailQty,
                "MsItemId" => $row->MsItemId,
                "MsVendorCode" => $row->MsVendorCode,
            );
            $this->db->insert("TblInvTrans", $datatrans);

            $data_stock = $this->db
                ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblInvStock.MsVendorId", "left")
                ->where("MsItemId", $row->MsItemId)
                ->where("MsVendorCode", $row->MsVendorCode)
                ->where("MsWorkplaceId", $row->MsWorkplaceId)
                ->get("TblInvStock")->row();
            $this->db->update(
                "TblInvStock",
                array("InvStockQty" => ($data_stock->InvStockQty - $row->InvWasteDetailQty)),
                array("InvStockId" =>  $data_stock->InvStockId)
            );
        }
    }

    function insert_trans_from_sample($grpocode)
    {
        //kembalikan data lama dan hapus data lama
        $this->delete_trans_plus($grpocode);

        $data_item = $this->db->join("TblInvSample", "TblInvSample.InvSampleCode=TblInvSampleDetail.InvSampleDetailRef", "left")
            ->where("InvSampleDetailRef", $grpocode)->get("TblInvSampleDetail")->result();
        foreach ($data_item as $row) {
            $datatrans = array(
                "InvTransCode" => $grpocode,
                "InvTransDate" => $row->InvSampleDate,
                "InvTransType" => "IS",
                "MsWorkplaceId" => $row->MsWorkplaceId,
                "InvTransQty" => $row->InvSampleDetailQty,
                "MsItemId" => $row->MsItemId,
                "MsVendorCode" => $row->MsVendorCode,
            );
            $this->db->insert("TblInvTrans", $datatrans);

            $data_stock = $this->db
                ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblInvStock.MsVendorId", "left")
                ->where("MsItemId", $row->MsItemId)
                ->where("MsVendorCode", $row->MsVendorCode)
                ->where("MsWorkplaceId", $row->MsWorkplaceId)
                ->get("TblInvStock")->row();
            $this->db->update(
                "TblInvStock",
                array("InvStockQty" => ($data_stock->InvStockQty - $row->InvSampleDetailQty)),
                array("InvStockId" =>  $data_stock->InvStockId)
            );
        }
    }

    function insert_trans_from_so($grpocode)
    {
        $data_item = $this->db->join("TblInvSO", "TblInvSO.InvSOCode=TblInvSODetail.InvSODetailRef", "left")
            ->where("InvSODetailRef", $grpocode)->get("TblInvSODetail")->result();
        foreach ($data_item as $row) {
            $datatrans = array(
                "InvTransCode" => $grpocode,
                "InvTransDate" => $row->InvSODate,
                "InvTransType" => "SO",
                "MsWorkplaceId" => $row->MsWorkplaceId,
                "InvTransQty" => $row->InvSODetailQtyAdj,
                "MsItemId" => $row->MsItemId,
                "MsVendorCode" => $row->MsVendorCode,
            );
            $this->db->insert("TblInvTrans", $datatrans);

            $data_stock = $this->db
                ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblInvStock.MsVendorId", "left")
                ->where("MsItemId", $row->MsItemId)
                ->where("MsVendorCode", $row->MsVendorCode)
                ->where("MsWorkplaceId", $row->MsWorkplaceId)
                ->get("TblInvStock")->row();
            $this->db->update(
                "TblInvStock",
                array("InvStockQty" => ($data_stock->InvStockQty + $row->InvSODetailQtyAdj)),
                array("InvStockId" =>  $data_stock->InvStockId)
            );
        }
    }


    
    function insert_trans_from_produksi_detail($produksicode)
    {
        //kembalikan data lama dan hapus data lama
        $this->delete_trans_plus($produksicode,"PM");
        $data_item = $this->db->select("*, TblProduksiDetail.MsItemId as iddetail,TblProduksiDetail.MsVendorCode as Vendordetail")
            ->join("TblProduksi", "TblProduksi.ProduksiCode=TblProduksiDetail.ProduksiDetailRef", "left")
            ->where("ProduksiDetailRef", $produksicode)->get("TblProduksiDetail")->result();
        foreach ($data_item as $row) {
            $datatrans = array(
                "InvTransCode" => $produksicode,
                "InvTransDate" => $row->ProduksiDateCetak,
                "InvTransType" => "PM",
                "MsWorkplaceId" => $row->MsWorkplaceId,
                "InvTransQty" => $row->ProduksiDetailQty,
                "MsItemId" => $row->iddetail,
                "MsVendorCode" => $row->Vendordetail,
            );

            $this->db->insert("TblInvTrans", $datatrans);

            $data_stock = $this->db
                ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblInvStock.MsVendorId", "left")
                ->where("MsItemId", $row->iddetail)
                ->where("MsVendorCode", $row->Vendordetail)
                ->where("MsWorkplaceId", $row->MsWorkplaceId)
                ->get("TblInvStock")->row();
            $this->db->update(
                "TblInvStock",
                array("InvStockQty" => ($data_stock->InvStockQty - $row->ProduksiDetailQty)),
                array("InvStockId" =>  $data_stock->InvStockId)
            );
        }
    }
    function insert_trans_from_produksi($produksicode)
    {
        //kembalikan data lama dan hapus data lama
        $this->delete_trans_min($produksicode,"PP");
        $data_item = $this->db->where("ProduksiCode", $produksicode)->get("TblProduksi")->row(); 
        $datatrans = array(
            "InvTransCode" => $produksicode,
            "InvTransDate" => $data_item->ProduksiDate,
            "InvTransType" => "PP",
            "MsWorkplaceId" => $data_item->MsWorkplaceId,
            "InvTransQty" => $data_item->ProduksiQty,
            "MsItemId" => $data_item->MsItemId,
            "MsVendorCode" => $data_item->MsVendorCode,
        );

        $this->db->insert("TblInvTrans", $datatrans);

        $data_stock = $this->db
            ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblInvStock.MsVendorId", "left")
            ->where("MsItemId", $data_item->MsItemId)
            ->where("MsVendorCode", $data_item->MsVendorCode)
            ->where("MsWorkplaceId", $data_item->MsWorkplaceId)
            ->get("TblInvStock")->row();
        $this->db->update(
            "TblInvStock",
            array("InvStockQty" => ($data_stock->InvStockQty + $data_item->ProduksiQty)),
            array("InvStockId" =>  $data_stock->InvStockId)
        ); 
    }

    function delete_trans_min($code,$type = null)
    {
        //kembalikan data lama
        $this->db->where("InvTransCode", $code);
        if($type != null) $this->db->where("InvTransType", $type);
        $dataold = $this->db->get("TblInvTrans")->result();
        foreach ($dataold as $row) {
            $data_stock = $this->db->join("TblMsVendor", "TblMsVendor.MsVendorId=TblInvStock.MsVendorId", "left")
                ->where("MsItemId", $row->MsItemId)
                ->where("MsVendorCode", $row->MsVendorCode)
                ->where("MsWorkplaceId", $row->MsWorkplaceId)
                ->get("TblInvStock")->row();
            $this->db->update(
                "TblInvStock",
                array("InvStockQty" => ($data_stock->InvStockQty - $row->InvTransQty)),
                array("MsItemId" => $row->MsItemId, "MsVendorId" => $data_stock->MsVendorId, "MsWorkplaceId" => $row->MsWorkplaceId)
            );
        }
        //hapus data lama
        $this->db->delete("TblInvTrans", array("InvTransCode" => $code));
    }
    function delete_trans_plus($code,$type = null)
    {
        //kembalikan data lama
        $this->db->where("InvTransCode", $code);
        if($type != null) $this->db->where("InvTransType", $type);
        $dataold = $this->db->get("TblInvTrans")->result();
        foreach ($dataold as $row) {
            $data_stock = $this->db->join("TblMsVendor", "TblMsVendor.MsVendorId=TblInvStock.MsVendorId", "left")
                ->where("MsItemId", $row->MsItemId)
                ->where("MsVendorCode", $row->MsVendorCode)
                ->where("MsWorkplaceId", $row->MsWorkplaceId)
                ->get("TblInvStock")->row();
            $this->db->update(
                "TblInvStock",
                array("InvStockQty" => ($data_stock->InvStockQty + $row->InvTransQty)),
                array("MsItemId" => $row->MsItemId, "MsVendorId" => $data_stock->MsVendorId, "MsWorkplaceId" => $row->MsWorkplaceId)
            );
        }
        //hapus data lama
        $this->db->delete("TblInvTrans", array("InvTransCode" => $code));
    }


    function delete_trans($code)
    {
        //kembalikan data lama
        /* CHEAT SHEET DST (jika delete kebalikan dari ini)
            GR(goods Receipt) = (+);
            BR(Barang Rusak) = (-);
            BS(Barang Sampel) = (-);
            TO(Transfer Out) = (-);
            TI(Transfer In) = (+);  
        */ 
        $dataold = $this->db->where("MsProdukTransRef", $code)->get("TblMsProdukTrans")->result();
        foreach ($dataold as $row) {
            $data_stock = $this->get_stock($row->MsProdukVarian,$row->MsProdukId,$row->MsWorkplaceId);
            

            switch ( $row->MsProdukTransType) {
                case "GR":
                case "TI":
                    $this->db->update(
                        "TblMsProdukStock",
                        array("MsProdukStockQty" => ($data_stock->MsProdukStockQty - $row->MsProdukTransQty)),
                        array("MsProdukStockId" =>  $data_stock->MsProdukStockId)
                    ); 
                    break;
                case "BR":
                case "BS":
                case "TO":
                    $this->db->update(
                        "TblMsProdukStock",
                        array("MsProdukStockQty" => ($data_stock->MsProdukStockQty + $row->MsProdukTransQty)),
                        array("MsProdukStockId" =>  $data_stock->MsProdukStockId)
                    );
                    break;
                default:
                   
            } 
            $this->db->delete("TblMsProdukTrans", array("MsProdukTransId" => $row->MsProdukTransId));
        }   
    } 
    function get_stock($varian,$produkid,$store){
        $this->db->where("MsProdukId",$produkid)->where("MsWorkplaceId",$store); 
        $datavarian = explode("|",$varian);
        for($i = 0; count($datavarian)>$i;$i++){
            $this->db->like(
                'REPLACE(lower(MsProdukVarian)," ","")',
                str_replace(" ","",strtolower($datavarian[$i]))
            );
        } 

        return $this->db->get("TblMsProdukStock")->row();
    }
}
