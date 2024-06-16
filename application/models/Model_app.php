<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by Fauzan Caren.
 * User: OBI-WEB
 * Ver: v5.0.0
 * Date: 05/19/2021
 * To change this template use File | Settings | File Templates.
 */

class Model_app extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function login($username, $password)
	{
		$user = $username;
		$pass = $this->EncryptedPassword($password);
		$query = $this->db->query("SELECT * FROM TblMsEmployee as b 
                                   left join TblMsWorkplace as c on b.MsWorkplaceId=c.MsWorkplaceId
                                   left join TblMsEmployeePosition as d on d.MsEmpPositionId=b.MsEmpPositionId
                                   where MsEmpCode='" . $user . "' and MsEmpPass='" . $pass . "' and MsEmpIsActive='1'");
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}
	function check_user($username)
	{
		$user = $username ;
		$query = $this->db->query("SELECT * FROM TblMsEmployee where MsEmpCode='" . $username . "'");
		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	/*
	|
	|	FUNCTION UNTUK NEXT CODE TABLE
	|
	*/
	function get_store($id)
	{
		if ($id == 1) {
			return "OMAHBATA";
		} else if ($id == 2) {
			return "WAREHOUSE";
		} else if ($id == 3) {
			return "TOKO ROSTER BSD";
		} else if ($id == 4) {
			return "PABRIK ROSTER BOGOR";
		} else if ($id == 5) {
			return "GLOCANA";
		} else if ($id == 6) {
			return "OMAHBATA STUDIO";
		} else if ($id == 7) {
			return "CONBLOCINDO";
		}
	}
	function get_next_id_employee()
	{
		$query = $this->db->query("SELECT CAST((ifnull(MAX(SUBSTRING(MsEmpCode, 3, 5)),0) + 1) AS SIGNED) as max FROM TblMsEmployee")->result();
		foreach ($query as $rows) {
			$id = $rows->max;
			switch (strlen($id)) {
				case 1:
					$nextid = "ID0000" . $id;
					return $nextid;
				case 2:
					$nextid = "ID000" . $id;
					return $nextid;
				case 3:
					$nextid = "ID00" . $id;
					return $nextid;
				case 4:
					$nextid = "ID0" . $id;
					return $nextid;
				case 5:
					$nextid = "ID" . $id;
					return $nextid;
				default:
					$nextid = "ID00000";
					return $nextid;
			}
		}
	}

	function get_next_id_staff()
	{
		$query = $this->db->query("SELECT CAST((ifnull(MAX(SUBSTRING(StaffCode, 3, 5)),0) + 1) AS SIGNED) as max FROM TblMsStaff")->result();
		foreach ($query as $rows) {
			$id = $rows->max;
			switch (strlen($id)) {
				case 1:
					$nextid = "SC0000" . $id;
					return $nextid;
				case 2:
					$nextid = "SC000" . $id;
					return $nextid;
				case 3:
					$nextid = "SC00" . $id;
					return $nextid;
				case 4:
					$nextid = "SC0" . $id;
					return $nextid;
				case 5:
					$nextid = "SC" . $id;
					return $nextid;
				default:
					$nextid = "SC00000";
					return $nextid;
			}
		}
	}

	function get_next_id_item_master($code)
	{
		$query = $this->db->query("SELECT CAST((ifnull(MAX(SUBSTRING(MsItemCode, -4, 4)),0) + 1) AS SIGNED) as max FROM TblMsItem where MsItemCatId='" . $code['MsItemCatId'] . "'")->result();
		foreach ($query as $rows) {
			$id = $rows->max;
			switch (strlen($id)) {
				case 1:
					$nextid = $code['MsItemCatCode'] . "000" . $id;
					return $nextid;
				case 2:
					$nextid = $code['MsItemCatCode'] . "00" . $id;
					return $nextid;
				case 3:
					$nextid = $code['MsItemCatCode'] . "0" . $id;
					return $nextid;
				case 4:
					$nextid = $code['MsItemCatCode'] . "" . $id;
					return $nextid;
				default:
					$nextid = $code['MsItemCatCode'] . "0000";
					return $nextid;
			}
		}
	}

	function get_next_id_item($code)
	{
		$query = $this->db->query("SELECT CAST((ifnull(MAX(SUBSTRING(MsProdukCode, -4, 4)),0) + 1) AS SIGNED) as max FROM TblMsProduk where MsProdukCatId='" . $code['MsProdukCatId'] . "'")->result();
		foreach ($query as $rows) {
			$id = $rows->max;
			switch (strlen($id)) {
				case 1:
					$nextid = $code['MsProdukCatCode'] . "000" . $id;
					return $nextid;
				case 2:
					$nextid = $code['MsProdukCatCode'] . "00" . $id;
					return $nextid;
				case 3:
					$nextid = $code['MsProdukCatCode'] . "0" . $id;
					return $nextid;
				case 4:
					$nextid = $code['MsProdukCatCode'] . "" . $id;
					return $nextid;
				default:
					$nextid = $code['MsProdukCatCode'] . "0000";
					return $nextid;
			}
		}
	}

	function get_next_id_customer()
	{
		$id = $this->session->userdata('MsEmpId');
		$query = $this->db->query("SELECT ifnull(MAX(CAST(SUBSTRING(MsCustomerCode,5,5) AS UNSIGNED)),0) AS nextcode FROM TblMsCustomer WHERE CAST(SUBSTRING(MsCustomerCode,1,2) AS UNSIGNED) = '" . $id . "'")->result();
		if (strlen($id) == 1) {
			$id = "0" . $id;
		}
		foreach ($query as $rows) {
			$nextcode = $rows->nextcode;
			$nextcode++;
			switch (strlen($nextcode)) {
				case 1:
					$nextid = $id . "CS0000" . $nextcode;
					return $nextid;
				case 2:
					$nextid = $id . "CS000" . $nextcode;
					return $nextid;
				case 3:
					$nextid = $id . "CS00" . $nextcode;
					return $nextid;
				case 4:
					$nextid = $id . "CS0" . $nextcode;
					return $nextid;
				case 5:
					$nextid = $id . "CS" . $nextcode;
					return $nextid;
				default:
					$nextid = $rows->MsItemCatCode . "0000";
					return $nextid;
			}
		}
	}

	function get_next_quotation($StrWorkplaceCode, $StrMonth, $StrYear, $StrEmp)
	{
		$StoreCode = $StrWorkplaceCode;
		$EmpId = $StrEmp;
		if (strlen($StrWorkplaceCode) == 1) {
			$StoreCode = "0" . $StrWorkplaceCode;
		}
		if (strlen($StrEmp) == 1) {
			$EmpId = "0" . $StrEmp;
		}
		$regexcode = "QUO/" . $StoreCode . "/";
		$romawi = $this->Romawi_date($StrMonth, $StrYear);

		$query = $this->db->query("SELECT ifnull(max(SUBSTR(QuoCode,8,4)),0) as max FROM TblQuotation where MONTH(QuoDate2)='" . $StrMonth . "' and SUBSTR(QuoCode,5,2)='" . $StoreCode . "' and
				YEAR(QuoDate2)='" . $StrYear . "' and SUBSTR(QuoCode,13,2) = '" . $EmpId . "'")->result();
		if ($query) {
			foreach ($query as $rows) {
				$nextcode = $rows->max;
				$NextKd = intval($nextcode) + 1;
				switch (strlen($NextKd)) {
					case 1:
						$NextKd = "000" . $NextKd;
						break;
					case 2:
						$NextKd = "00" . $NextKd;
						break;
					case 3:
						$NextKd = "0" . $NextKd;
						break;
					default:
						$NextKd = $NextKd;
						break;
				}

				return $regexcode . $NextKd . "/" . $EmpId . $romawi;
			}
		} else {
			return $regexcode . "0000/" . $EmpId . $romawi;
		}
	}
	function get_next_sales($StrWorkplaceCode, $StrMonth, $StrYear, $StrEmp)
	{
		$StoreCode = $StrWorkplaceCode;
		$EmpId = $StrEmp;
		if (strlen($StrWorkplaceCode) == 1) {
			$StoreCode = "0" . $StrWorkplaceCode;
		}
		if (strlen($StrEmp) == 1) {
			$EmpId = "0" . $StrEmp;
		}
		$regexcode = "SALES/" . $StoreCode . "/";
		$romawi = $this->Romawi_date($StrMonth, $StrYear);

		$query = $this->db->query("SELECT ifnull(max(SUBSTR(SalesCode,10,4)),0) as max FROM TblSales where MONTH(SalesDate2)='" . $StrMonth . "' and SUBSTR(SalesCode,7,2)='" . $StoreCode . "' and
				YEAR(SalesDate2)='" . $StrYear . "' and SUBSTR(SalesCode,15,2) = '" . $EmpId . "'")->result();
		if ($query) {
			foreach ($query as $rows) {
				$nextcode = $rows->max;
				$NextKd = intval($nextcode) + 1;
				switch (strlen($NextKd)) {
					case 1:
						$NextKd = "000" . $NextKd;
						break;
					case 2:
						$NextKd = "00" . $NextKd;
						break;
					case 3:
						$NextKd = "0" . $NextKd;
						break;
					default:
						$NextKd = $NextKd;
						break;
				}

				return $regexcode . $NextKd . "/" . $EmpId . $romawi;
			}
		} else {
			return $regexcode . "0000/" . $EmpId . $romawi;
		}
	}
	function get_next_delivery($StrWorkplaceCode, $StrMonth, $StrYear, $StrEmp)
	{
		$StoreCode = $StrWorkplaceCode;
		$EmpId = $StrEmp;
		if (strlen($StrWorkplaceCode) == 1) {
			$StoreCode = "0" . $StrWorkplaceCode;
		}
		if (strlen($StrEmp) == 1) {
			$EmpId = "0" . $StrEmp;
		}
		$regexcode = "ALY/XIII/" . $StoreCode . "/DO-";
		$romawi = $this->Romawi_date($StrMonth, $StrYear);

		$query = $this->db->query("SELECT ifnull(max(SUBSTR(DeliveryCode,16,4)),0) as max FROM TblDelivery where MONTH(DeliveryDate2)='" . $StrMonth . "' and
				YEAR(DeliveryDate2)='" . $StrYear . "' and SUBSTR(DeliveryCode,21,2) = '" . $EmpId . "'")->result();
		if ($query) {
			foreach ($query as $rows) {
				$nextcode = $rows->max;
				$NextKd = intval($nextcode) + 1;
				switch (strlen($NextKd)) {
					case 1:
						$NextKd = "000" . $NextKd;
						break;
					case 2:
						$NextKd = "00" . $NextKd;
						break;
					case 3:
						$NextKd = "0" . $NextKd;
						break;
					default:
						$NextKd = $NextKd;
						break;
				}

				return $regexcode . $NextKd . "/" . $EmpId . $romawi;
			}
		} else {
			return $regexcode . "0000/" . $EmpId . $romawi;
		}
	}
	function get_next_po($StrWorkplaceCode, $StrMonth, $StrYear, $StrEmp)
	{
		$StoreCode = $StrWorkplaceCode;
		$EmpId = $StrEmp;
		if (strlen($StrWorkplaceCode) == 1) {
			$StoreCode = "0" . $StrWorkplaceCode;
		}
		if (strlen($StrEmp) == 1) {
			$EmpId = "0" . $StrEmp;
		}
		$regexcode = "ALY/XIII/" . $StoreCode . "/PO-";
		$romawi = $this->Romawi_date($StrMonth, $StrYear);

		$query = $this->db->query("SELECT ifnull(max(SUBSTR(POCode,16,4)),0) as max FROM TblPO where MONTH(PODate2)='" . $StrMonth . "' and
				YEAR(PODate2)='" . $StrYear . "' and SUBSTR(POCode,21,2) = '" . $EmpId . "'")->result();
		if ($query) {
			foreach ($query as $rows) {
				$nextcode = $rows->max;
				$NextKd = intval($nextcode) + 1;
				switch (strlen($NextKd)) {
					case 1:
						$NextKd = "000" . $NextKd;
						break;
					case 2:
						$NextKd = "00" . $NextKd;
						break;
					case 3:
						$NextKd = "0" . $NextKd;
						break;
					default:
						$NextKd = $NextKd;
						break;
				}

				return $regexcode . $NextKd . "/" . $EmpId . $romawi;
			}
		} else {
			return $regexcode . "0000/" . $EmpId . $romawi;
		}
	}
	function get_next_grpo($StrWorkplaceCode, $StrMonth, $StrYear, $StrEmp)
	{
		$StoreCode = $StrWorkplaceCode;
		$EmpId = $StrEmp;
		if (strlen($StrWorkplaceCode) == 1) {
			$StoreCode = "0" . $StrWorkplaceCode;
		}
		if (strlen($StrEmp) == 1) {
			$EmpId = "0" . $StrEmp;
		}
		$regexcode = "ALY/XIII/" . $StoreCode . "/GR-";
		$romawi = $this->Romawi_date($StrMonth, $StrYear);

		$query = $this->db->query("SELECT ifnull(max(SUBSTR(GRPOCode,16,4)),0) as max FROM TblGRPO where MONTH(GRPODate2)='" . $StrMonth . "' and
				YEAR(GRPODate2)='" . $StrYear . "' and SUBSTR(GRPOCode,21,2) = '" . $EmpId . "'")->result();
		if ($query) {
			foreach ($query as $rows) {
				$nextcode = $rows->max;
				$NextKd = intval($nextcode) + 1;
				switch (strlen($NextKd)) {
					case 1:
						$NextKd = "000" . $NextKd;
						break;
					case 2:
						$NextKd = "00" . $NextKd;
						break;
					case 3:
						$NextKd = "0" . $NextKd;
						break;
					default:
						$NextKd = $NextKd;
						break;
				}

				return $regexcode . $NextKd . "/" . $EmpId . $romawi;
			}
		} else {
			return $regexcode . "0000/" . $EmpId . $romawi;
		}
	}
	function get_next_to($StrWorkplaceCode, $StrMonth, $StrYear, $StrEmp)
	{
		$StoreCode = $StrWorkplaceCode;
		$EmpId = $StrEmp;
		if (strlen($StrWorkplaceCode) == 1) {
			$StoreCode = "0" . $StrWorkplaceCode;
		}
		if (strlen($StrEmp) == 1) {
			$EmpId = "0" . $StrEmp;
		}
		$regexcode = "ALY/XIII/" . $StoreCode . "/TO-";
		$romawi = $this->Romawi_date($StrMonth, $StrYear);

		$query = $this->db->query("SELECT ifnull(max(SUBSTR(InvTOCode,16,4)),0) as max FROM TblInvTO where MONTH(InvTODate2)='" . $StrMonth . "' and
				YEAR(InvTODate2)='" . $StrYear . "' and SUBSTR(InvTOCode,21,2) = '" . $EmpId . "'")->result();
		if ($query) {
			foreach ($query as $rows) {
				$nextcode = $rows->max;
				$NextKd = intval($nextcode) + 1;
				switch (strlen($NextKd)) {
					case 1:
						$NextKd = "000" . $NextKd;
						break;
					case 2:
						$NextKd = "00" . $NextKd;
						break;
					case 3:
						$NextKd = "0" . $NextKd;
						break;
					default:
						$NextKd = $NextKd;
						break;
				}

				return $regexcode . $NextKd . "/" . $EmpId . $romawi;
			}
		} else {
			return $regexcode . "0000/" . $EmpId . $romawi;
		}
	}
	function get_next_ti($StrWorkplaceCode, $StrMonth, $StrYear, $StrEmp)
	{
		$StoreCode = $StrWorkplaceCode;
		$EmpId = $StrEmp;
		if (strlen($StrWorkplaceCode) == 1) {
			$StoreCode = "0" . $StrWorkplaceCode;
		}
		if (strlen($StrEmp) == 1) {
			$EmpId = "0" . $StrEmp;
		}
		$regexcode = "ALY/XIII/" . $StoreCode . "/TI-";
		$romawi = $this->Romawi_date($StrMonth, $StrYear);

		$query = $this->db->query("SELECT ifnull(max(SUBSTR(InvTICode,16,4)),0) as max FROM TblInvTI where MONTH(InvTIDate2)='" . $StrMonth . "' and
				YEAR(InvTIDate2)='" . $StrYear . "' and SUBSTR(InvTICode,21,2) = '" . $EmpId . "'")->result();
		if ($query) {
			foreach ($query as $rows) {
				$nextcode = $rows->max;
				$NextKd = intval($nextcode) + 1;
				switch (strlen($NextKd)) {
					case 1:
						$NextKd = "000" . $NextKd;
						break;
					case 2:
						$NextKd = "00" . $NextKd;
						break;
					case 3:
						$NextKd = "0" . $NextKd;
						break;
					default:
						$NextKd = $NextKd;
						break;
				}

				return $regexcode . $NextKd . "/" . $EmpId . $romawi;
			}
		} else {
			return $regexcode . "0000/" . $EmpId . $romawi;
		}
	}
	function get_next_iw($StrWorkplaceCode, $StrMonth, $StrYear, $StrEmp)
	{
		$StoreCode = $StrWorkplaceCode;
		$EmpId = $StrEmp;
		if (strlen($StrWorkplaceCode) == 1) {
			$StoreCode = "0" . $StrWorkplaceCode;
		}
		if (strlen($StrEmp) == 1) {
			$EmpId = "0" . $StrEmp;
		}
		$regexcode = "ALY/XIII/" . $StoreCode . "/IW-";
		$romawi = $this->Romawi_date($StrMonth, $StrYear);

		$query = $this->db->query("SELECT ifnull(max(SUBSTR(InvWasteCode,16,4)),0) as max FROM TblInvWaste where MONTH(InvWasteDate2)='" . $StrMonth . "' and
				YEAR(InvWasteDate2)='" . $StrYear . "' and SUBSTR(InvWasteCode,21,2) = '" . $EmpId . "'")->result();
		if ($query) {
			foreach ($query as $rows) {
				$nextcode = $rows->max;
				$NextKd = intval($nextcode) + 1;
				switch (strlen($NextKd)) {
					case 1:
						$NextKd = "000" . $NextKd;
						break;
					case 2:
						$NextKd = "00" . $NextKd;
						break;
					case 3:
						$NextKd = "0" . $NextKd;
						break;
					default:
						$NextKd = $NextKd;
						break;
				}

				return $regexcode . $NextKd . "/" . $EmpId . $romawi;
			}
		} else {
			return $regexcode . "0000/" . $EmpId . $romawi;
		}
	}
	function get_next_is($StrWorkplaceCode, $StrMonth, $StrYear, $StrEmp)
	{
		$StoreCode = $StrWorkplaceCode;
		$EmpId = $StrEmp;
		if (strlen($StrWorkplaceCode) == 1) {
			$StoreCode = "0" . $StrWorkplaceCode;
		}
		if (strlen($StrEmp) == 1) {
			$EmpId = "0" . $StrEmp;
		}
		$regexcode = "ALY/XIII/" . $StoreCode . "/IS-";
		$romawi = $this->Romawi_date($StrMonth, $StrYear);

		$query = $this->db->query("SELECT ifnull(max(SUBSTR(InvSampleCode,16,4)),0) as max FROM TblInvSample where MONTH(InvSampleDate2)='" . $StrMonth . "' and
				YEAR(InvSampleDate2)='" . $StrYear . "' and SUBSTR(InvSampleCode,21,2) = '" . $EmpId . "'")->result();
		if ($query) {
			foreach ($query as $rows) {
				$nextcode = $rows->max;
				$NextKd = intval($nextcode) + 1;
				switch (strlen($NextKd)) {
					case 1:
						$NextKd = "000" . $NextKd;
						break;
					case 2:
						$NextKd = "00" . $NextKd;
						break;
					case 3:
						$NextKd = "0" . $NextKd;
						break;
					default:
						$NextKd = $NextKd;
						break;
				}

				return $regexcode . $NextKd . "/" . $EmpId . $romawi;
			}
		} else {
			return $regexcode . "0000/" . $EmpId . $romawi;
		}
	}

	function get_next_so($StrWorkplaceCode, $StrMonth, $StrYear, $StrEmp)
	{
		$StoreCode = $StrWorkplaceCode;
		$EmpId = $StrEmp;
		if (strlen($StrWorkplaceCode) == 1) {
			$StoreCode = "0" . $StrWorkplaceCode;
		}
		if (strlen($StrEmp) == 1) {
			$EmpId = "0" . $StrEmp;
		}
		$regexcode = "ALY/XIII/" . $StoreCode . "/SO-";
		$romawi = $this->Romawi_date($StrMonth, $StrYear);

		$query = $this->db->query("SELECT ifnull(max(SUBSTR(InvSOCode,16,4)),0) as max FROM TblInvSO where MONTH(InvSODate)='" . $StrMonth . "' and
				YEAR(InvSODate)='" . $StrYear . "' and SUBSTR(InvSOCode,21,2) = '" . $EmpId . "'")->result();
		if ($query) {
			foreach ($query as $rows) {
				$nextcode = $rows->max;
				$NextKd = intval($nextcode) + 1;
				switch (strlen($NextKd)) {
					case 1:
						$NextKd = "000" . $NextKd;
						break;
					case 2:
						$NextKd = "00" . $NextKd;
						break;
					case 3:
						$NextKd = "0" . $NextKd;
						break;
					default:
						$NextKd = $NextKd;
						break;
				}

				return $regexcode . $NextKd . "/" . $EmpId . $romawi;
			}
		} else {
			return $regexcode . "0000/" . $EmpId . $romawi;
		}
	}
	function get_next_pd($StrWorkplaceCode, $StrMonth, $StrYear, $StrEmp)
	{
		$StoreCode = $StrWorkplaceCode;
		$EmpId = $StrEmp;
		if (strlen($StrWorkplaceCode) == 1) {
			$StoreCode = "0" . $StrWorkplaceCode;
		}
		if (strlen($StrEmp) == 1) {
			$EmpId = "0" . $StrEmp;
		}
		$regexcode = "ALY/XIII/" . $StoreCode . "/PD-";
		$romawi = $this->Romawi_date($StrMonth, $StrYear);

		$query = $this->db->query("SELECT ifnull(max(SUBSTR(ProduksiCode,16,4)),0) as max FROM TblProduksi where MONTH(ProduksiDate)='" . $StrMonth . "' and
				YEAR(ProduksiDate)='" . $StrYear . "' and SUBSTR(ProduksiCode,21,2) = '" . $EmpId . "'")->result();
		if ($query) {
			foreach ($query as $rows) {
				$nextcode = $rows->max;
				$NextKd = intval($nextcode) + 1;
				switch (strlen($NextKd)) {
					case 1:
						$NextKd = "000" . $NextKd;
						break;
					case 2:
						$NextKd = "00" . $NextKd;
						break;
					case 3:
						$NextKd = "0" . $NextKd;
						break;
					default:
						$NextKd = $NextKd;
						break;
				}

				return $regexcode . $NextKd . "/" . $EmpId . $romawi;
			}
		} else {
			return $regexcode . "0000/" . $EmpId . $romawi;
		}
	}
	function get_single_data($select, $tabel, $where)
	{
		$this->db->select($select);
		$this->db->where($where);
		$query = $this->db->get($tabel)->result();
		foreach ($query as $key => $value) {
			if ($key == $select) {
				return  $value->{$select};
			}
		}
	}
	function get_customer_name_by_array($array)
	{
		if ($array) {
			if ($array["MsCustomerCompany"] == "-") {
				return $array["MsCustomerName"];
			} else if ($array["MsCustomerName"] == "-") {
				return $array["MsCustomerCompany"];
			} else {
				return $array["MsCustomerName"] . " (" . $array["MsCustomerCompany"] . ")";
			}
		}
	}
	function get_customer_telp_by_array($array)
	{
		if ($array) {
			if ($array["MsCustomerTelp2"] == "-" || $array["MsCustomerTelp2"] == "") {
				return $array["MsCustomerTelp1"];
			} else {
				return $array["MsCustomerTelp1"] . " / " . $array["MsCustomerTelp2"] . "";
			}
		}
	}
	function get_customer_name($id)
	{
		$data = $this->db
			->query('SELECT 
							case  
							WHEN MsCustomerCompany="-" THEN MsCustomerName 
							WHEN MsCustomerName="-" THEN MsCustomerCompany 
							ELSE concat(MsCustomerName," (",MsCustomerCompany,")") END AS customer  
						FROM TblMsCustomer where MsCustomerId="' . $id . '"')
			->row();
		if ($data) {
			return $data->customer;
		} else {
			return $id;
		}
	}
	function get_customer_telp($id)
	{
		$data = $this->db
			->query('SELECT 
							case  
							WHEN MsCustomerTelp2="-" or MsCustomerTelp2="" THEN MsCustomerTelp1  
							ELSE concat(MsCustomerTelp1," / ",MsCustomerTelp2) END AS customer  
						FROM TblMsCustomer where MsCustomerId="' . $id . '"')
			->row();
		if ($data) {
			return $data->customer;
		} else {
			return $id;
		}
	}
	function get_numberphone_valid($no)
	{
		$no = str_replace(" ", "", $no);
		if (substr($no, 0, 1) == "0") {
			return "62" . substr($no, 1);
		} else if (substr($no, 0, 1) == "+") {
			return $no;
		}
	}
	/*
	|
	|	FUNCTION UNTUK PROSES IMAGE
	|
	*/
	function get_base_64_by_id($id)
	{
		$configfile = getcwd() . "/asset/image/"; //untuk server
		//$configfile = "/obi-update/asset/image/"; //untuk lokal
		try {
			if (file_exists($configfile . 'employee/' . $id . '.png')) {
				$path = $configfile . 'employee/' . $id . '.png';
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
				return $base64;
			} else {
				$path = $configfile . 'mgs-erp/user.png';
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
				return $base64;
			}
		} catch (Exception $e) {
			$path = $configfile . 'kosong.png';
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data = file_get_contents($path);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			return $base64;
		}
	}

	function base_64_to_image($data, $code)
	{
		$image_array_1 = explode(";", $data);
		$image_array_2 = explode(",", $image_array_1[1]);
		$data = base64_decode($image_array_2[1]);
		$imageName = getcwd() . '/asset/image/employee/' . $code . '.png'; //untuk server
		//$imageName = 'omahbata/asset/image/employee/' . $code . '.png'; //untuk lokal
		file_put_contents(FCPATH . $imageName, $data);
	}
	function move_file($filename, $index)
	{
		if (!file_exists('asset/image/payment/' . $index . '/')) {
			mkdir("asset/image/payment/" . $index, 0777);
		}
		$location = 'temp/' . $filename; //untuk lokal
		$location1 = 'asset/image/payment/' . $index . '/' . $filename; //untuk lokal
		rename(FCPATH . $location, FCPATH . $location1);
	}
	function upload_file($data, $filename)
	{
		$data = substr($data, strpos($data, ",") + 1);
		$decodedData = base64_decode($data);
		//$location = 'temp/' . $filename; //untuk server
		$location = 'temp/' . $filename; //untuk lokal
		file_put_contents(FCPATH . $location, $decodedData);
	}
	function remove_file($filename)
	{
		$location = 'temp/' . $filename; //untuk lokal
		unlink(FCPATH . $location);
	}
	function remove_old_file($filename, $id)
	{
		$location = 'asset/image/payment/' . $id . '/' . $filename; //untuk lokal
		unlink(FCPATH . $location);
	}

	/*
	|
	|	FUNCTION UNTUK ENCRIPT DAN DESCRIPT
	|
	*/
	function EncryptedPassword($pass)
	{
		$str1 = " ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890?!@#$%^&*()_+|;:,'.-`~";
		$str2 = "?!@#$%^&*()_+|;:,'.-`~1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";
		$DecryptedText = "";
		for ($x = 1; $x <= strlen($pass); $x++) {

			$ori = substr($pass, $x - 1, 1);
			$lngPos  = strpos($str1, $ori);
			$DecryptedChr = substr($str2, $lngPos, 1);

			//echo substr($pass, $x, 1)."<br>";
			if ($lngPos > 0) {
				$DecryptedText = $DecryptedText . $DecryptedChr;
			} else {
				$DecryptedText = substr($pass, $x, 1);
			}
		}
		return $DecryptedText;
	}
	function DecryptedPassword($pass)
	{
		$str2 = " ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890?!@#$%^&*()_+|;:,'.-`~";
		$str1 = "?!@#$%^&*()_+|;:,'.-`~1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";
		$DecryptedText = "";
		for ($x = 1; $x <= strlen((string)$pass); $x++) {

			$ori = substr($pass, $x - 1, 1);
			$lngPos  = strpos($str1, $ori);
			$DecryptedChr = substr($str2, $lngPos, 1);

			//echo substr($pass, $x, 1)."<br>";
			if ($lngPos > 0) {
				$DecryptedText = $DecryptedText . $DecryptedChr;
			} else {
				$DecryptedText = substr($pass, $x, 1);
			}
		}
		return $DecryptedText;
	}


	function convert_date_dd_mm_yyyy($data)
	{
		$date = explode("/", $data);
		return $date[2] . '-' . $date[1] . '-' . $date[0];
	}


	function Romawi_date($StrMonth, $StrYear)
	{
		$str = "/";
		switch ($StrMonth) {
			case "01":
				$str = "/I/" . $StrYear;
				break;
			case "02":
				$str = "/II/" . $StrYear;
				break;
			case "03":
				$str = "/III/" . $StrYear;
				break;
			case "04":
				$str = "/IV/" . $StrYear;
				break;
			case "05":
				$str = "/V/" . $StrYear;
				break;
			case "06":
				$str = "/VI/" . $StrYear;
				break;
			case "07":
				$str = "/VII/" . $StrYear;
				break;
			case "08":
				$str = "/VIII/" . $StrYear;
				break;
			case "09":
				$str = "/IX/" . $StrYear;
				break;
			case "10":
				$str = "/X/" . $StrYear;
				break;
			case "11":
				$str = "/XI/" . $StrYear;
				break;
			case "12":
				$str = "/XII/" . $StrYear;
				break;
		}

		return $str;
	}
	/*
	|
	|	FUNCTION STOCK
	|
	*/
	function create_stock($id, $vendor)
	{
		$query = $this->db->query("insert into TblInvStock (MsItemId,MsVendorId,MsWorkplaceId,InvStockQty,InvStockLastUpdate) select '" . $id . "',(Select MsVendorId from TblMsVendor where MsVendorCode
									= '" . $vendor . "') as MsVendorId,MsworkplaceId,0,CURRENT_TIMESTAMP from TblMsWorkplace");
		return $query;
	}
	function delete_stock($id, $vendor)
	{
		$query = $this->db->query("Delete From TblInvStock where MsItemId='" . $id . "' and MsVendorId=(Select MsVendorId from TblMsVendor where MsVendorCode = '" . $vendor . "')");
		return $query;
	}



	function tanggalMerah($value, $array)
	{

		//check tanggal merah berdasarkan libur nasional
		if (isset($array[$value])) {
			if (date("D", strtotime($value)) === "Sun") {
				$arr = array("RED", $this->hari_ini(date("D", strtotime($value))) . "\n(" . $array[$value]["summary"][0] . ")", "1", "#f2f2f2");
				return $arr;
			} else {
				$arr = array("RED", $this->hari_ini(date("D", strtotime($value))) . "\n(" . $array[$value]["summary"][0] . ")", "0", "#f2f2f2");
				return $arr;
			}
		}
		//check tanggal merah berdasarkan hari minggu
		elseif (date("D", strtotime($value)) === "Sun") {
			$arr = array("RED", $this->hari_ini(date("D", strtotime($value))), "1", "#f2f2f2");
			return $arr;
			//bukan tanggal merah
		} else {
			$arr = array("Black", $this->hari_ini(date("D", strtotime($value))), "2", "#FFFFFF");
			return $arr;
		}
	}

	function hari_ini($hari)
	{
		switch ($hari) {
			case 'Sun':
				$hari_ini = "Minggu";
				break;

			case 'Mon':
				$hari_ini = "Senin";
				break;

			case 'Tue':
				$hari_ini = "Selasa";
				break;

			case 'Wed':
				$hari_ini = "Rabu";
				break;

			case 'Thu':
				$hari_ini = "Kamis";
				break;

			case 'Fri':
				$hari_ini = "Jumat";
				break;

			case 'Sat':
				$hari_ini = "Sabtu";
				break;

			default:
				$hari_ini = "Tidak di ketahui";
				break;
		}

		return $hari_ini;
	}


	// =============================================  FUNCTION INSERT NOTIF

	function insert_notif($data)
	{
		$emp = $this->db->group_start()->where("MsWorkplaceId", $data["MsWorkplaceId"])->where("MsEmpMode", "Admin Toko")->group_end()->or_where("MsEmpMode", "Superuser")->get("TblMsEmployee")->result();
		$user = array();
		foreach ($emp as $row) {
			$datainsert = $data;
			$datainsert += ["MsEmpId" => $row->MsEmpId];
			$this->db->insert("TblNotification", $datainsert);
			array_push($user, $row->MsEmpId);
		}
		$data += ["employee" => $user];
		// $this->send_pusher_notif($data);
	}

	function insert_notif_approve($data)
	{
		$emp = $this->db->where_in("MsEmpMode", array("Superuser", "Finance"))->get("TblMsEmployee")->result();
		$user = array();
		foreach ($emp as $row) {
			$datainsert = $data;
			$datainsert += ["MsEmpId" => $row->MsEmpId];
			$this->db->insert("TblNotification", $datainsert);
			array_push($user, $row->MsEmpId);
		}
		$data += ["employee" => $user];
		// $this->send_pusher_notif($data);
	}
	function insert_notif_approve_superuser($data)
	{
		$emp = $this->db->where("MsEmpMode", "Superuser")->get("TblMsEmployee")->result();
		$user = array();
		foreach ($emp as $row) {
			$datainsert = $data;
			$datainsert += ["MsEmpId" => $row->MsEmpId];
			$this->db->insert("TblNotification", $datainsert);
			array_push($user, $row->MsEmpId);
		}
		$data += ["employee" => $user];
		// $this->send_pusher_notif($data);
	}

	function send_pusher_notif($data)
	{
		$url="https://omahbata.ddns.net:5000/send";
		$datas=array("data"=>$data);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, JSON_ENCODE($datas));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($curl);
		curl_close($curl);
		echo $response;  
	}

	function exchange_code_country($id)
	{
		$country = array(
			"-1" => "Select Country",
			"AF" => "Afghanistan",
			"AL" => "Albania",
			"DZ" => "Algeria",
			"AS" => "American Samoa",
			"AD" => "Andorra",
			"AO" => "Angola",
			"AI" => "Anguilla",
			"AQ" => "Antarctica",
			"AG" => "Antigua and Barbuda",
			"AR" => "Argentina",
			"AM" => "Armenia",
			"AW" => "Aruba",
			"AU" => "Australia",
			"AT" => "Austria",
			"AZ" => "Azerbaijan",
			"BS" => "Bahamas",
			"BH" => "Bahrain",
			"BD" => "Bangladesh",
			"BB" => "Barbados",
			"BY" => "Belarus",
			"BE" => "Belgium",
			"BZ" => "Belize",
			"BJ" => "Benin",
			"BM" => "Bermuda",
			"BT" => "Bhutan",
			"BO" => "Bolivia",
			"BA" => "Bosnia and Herzegowina",
			"BW" => "Botswana",
			"BV" => "Bouvet Island",
			"BR" => "Brazil",
			"IO" => "British Indian Ocean Territory",
			"BN" => "Brunei Darussalam",
			"BG" => "Bulgaria",
			"BF" => "Burkina Faso",
			"BI" => "Burundi",
			"KH" => "Cambodia",
			"CM" => "Cameroon",
			"CA" => "Canada",
			"CV" => "Cape Verde",
			"KY" => "Cayman Islands",
			"CF" => "Central African Republic",
			"TD" => "Chad",
			"CL" => "Chile",
			"CN" => "China",
			"CX" => "Christmas Island",
			"CC" => "Cocos (Keeling) Islands",
			"CO" => "Colombia",
			"KM" => "Comoros",
			"CG" => "Congo",
			"CK" => "Cook Islands",
			"CR" => "Costa Rica",
			"CI" => "Cote D'Ivoire",
			"HR" => "Croatia",
			"CU" => "Cuba",
			"CY" => "Cyprus",
			"CZ" => "Czech Republic",
			"DK" => "Denmark",
			"DJ" => "Djibouti",
			"DM" => "Dominica",
			"DO" => "Dominican Republic",
			"TL" => "East Timor",
			"EC" => "Ecuador",
			"EG" => "Egypt",
			"SV" => "El Salvador",
			"GQ" => "Equatorial Guinea",
			"ER" => "Eritrea",
			"EE" => "Estonia",
			"ET" => "Ethiopia",
			"FK" => "Falkland Islands (Malvinas)",
			"FO" => "Faroe Islands",
			"FJ" => "Fiji",
			"FI" => "Finland",
			"FR" => "France",
			"FX" => "France, Metropolitan",
			"GF" => "French Guiana",
			"PF" => "French Polynesia",
			"TF" => "French Southern Territories",
			"GA" => "Gabon",
			"GM" => "Gambia",
			"GE" => "Georgia",
			"DE" => "Germany",
			"GH" => "Ghana",
			"GI" => "Gibraltar",
			"GR" => "Greece",
			"GL" => "Greenland",
			"GD" => "Grenada",
			"GP" => "Guadeloupe",
			"GU" => "Guam",
			"GT" => "Guatemala",
			"GN" => "Guinea",
			"GW" => "Guinea-bissau",
			"GY" => "Guyana",
			"HT" => "Haiti",
			"HM" => "Heard and Mc Donald Islands",
			"HN" => "Honduras",
			"HK" => "Hong Kong",
			"HU" => "Hungary",
			"IS" => "Iceland",
			"IN" => "India",
			"ID" => "Indonesia",
			"IR" => "Iran (Islamic Republic of)",
			"IQ" => "Iraq",
			"IE" => "Ireland",
			"IL" => "Israel",
			"IT" => "Italy",
			"JM" => "Jamaica",
			"JP" => "Japan",
			"JO" => "Jordan",
			"KZ" => "Kazakhstan",
			"KE" => "Kenya",
			"KI" => "Kiribati",
			"KP" => "Korea, Democratic People's Republic of",
			"KR" => "Korea, Republic of",
			"KW" => "Kuwait",
			"KG" => "Kyrgyzstan",
			"LA" => "Lao People's Democratic Republic",
			"LV" => "Latvia",
			"LB" => "Lebanon",
			"LS" => "Lesotho",
			"LR" => "Liberia",
			"LY" => "Libyan Arab Jamahiriya",
			"LI" => "Liechtenstein",
			"LT" => "Lithuania",
			"LU" => "Luxembourg",
			"MO" => "Macau",
			"MK" => "Macedonia, The Former Yugoslav Republic of",
			"MG" => "Madagascar",
			"MW" => "Malawi",
			"MY" => "Malaysia",
			"MV" => "Maldives",
			"ML" => "Mali",
			"MT" => "Malta",
			"MH" => "Marshall Islands",
			"MQ" => "Martinique",
			"MR" => "Mauritania",
			"MU" => "Mauritius",
			"YT" => "Mayotte",
			"MX" => "Mexico",
			"FM" => "Micronesia, Federated States of",
			"MD" => "Moldova, Republic of",
			"MC" => "Monaco",
			"MN" => "Mongolia",
			"MS" => "Montserrat",
			"MA" => "Morocco",
			"MZ" => "Mozambique",
			"MM" => "Myanmar",
			"NA" => "Namibia",
			"NR" => "Nauru",
			"NP" => "Nepal",
			"NL" => "Netherlands",
			"AN" => "Netherlands Antilles",
			"NC" => "New Caledonia",
			"NZ" => "New Zealand",
			"NI" => "Nicaragua",
			"NE" => "Niger",
			"NG" => "Nigeria",
			"NU" => "Niue",
			"NF" => "Norfolk Island",
			"MP" => "Northern Mariana Islands",
			"NO" => "Norway",
			"OM" => "Oman",
			"PK" => "Pakistan",
			"PW" => "Palau",
			"PA" => "Panama",
			"PG" => "Papua New Guinea",
			"PY" => "Paraguay",
			"PE" => "Peru",
			"PH" => "Philippines",
			"PN" => "Pitcairn",
			"PL" => "Poland",
			"PT" => "Portugal",
			"PR" => "Puerto Rico",
			"QA" => "Qatar",
			"RE" => "Reunion",
			"RO" => "Romania",
			"RU" => "Russian Federation",
			"RW" => "Rwanda",
			"KN" => "Saint Kitts and Nevis",
			"LC" => "Saint Lucia",
			"VC" => "Saint Vincent and the Grenadines",
			"WS" => "Samoa",
			"SM" => "San Marino",
			"ST" => "Sao Tome and Principe",
			"SA" => "Saudi Arabia",
			"SN" => "Senegal",
			"SC" => "Seychelles",
			"SL" => "Sierra Leone",
			"SG" => "Singapore",
			"SK" => "Slovakia (Slovak Republic)",
			"SI" => "Slovenia",
			"SB" => "Solomon Islands",
			"SO" => "Somalia",
			"ZA" => "South Africa",
			"GS" => "South Georgia and the South Sandwich Islands",
			"ES" => "Spain",
			"LK" => "Sri Lanka",
			"SH" => "St. Helena",
			"PM" => "St. Pierre and Miquelon",
			"SD" => "Sudan",
			"SR" => "Suriname",
			"SJ" => "Svalbard and Jan Mayen Islands",
			"SZ" => "Swaziland",
			"SE" => "Sweden",
			"CH" => "Switzerland",
			"SY" => "Syrian Arab Republic",
			"TW" => "Taiwan",
			"TJ" => "Tajikistan",
			"TZ" => "Tanzania, United Republic of",
			"TH" => "Thailand",
			"TG" => "Togo",
			"TK" => "Tokelau",
			"TO" => "Tonga",
			"TT" => "Trinidad and Tobago",
			"TN" => "Tunisia",
			"TR" => "Turkey",
			"TM" => "Turkmenistan",
			"TC" => "Turks and Caicos Islands",
			"TV" => "Tuvalu",
			"UG" => "Uganda",
			"UA" => "Ukraine",
			"AE" => "United Arab Emirates",
			"GB" => "United Kingdom",
			"US" => "United States",
			"UM" => "United States Minor Outlying Islands",
			"UY" => "Uruguay",
			"UZ" => "Uzbekistan",
			"VU" => "Vanuatu",
			"VA" => "Vatican City State (Holy See)",
			"VE" => "Venezuela",
			"VN" => "Viet Nam",
			"VG" => "Virgin Islands (British)",
			"VI" => "Virgin Islands (U.S.)",
			"WF" => "Wallis and Futuna Islands",
			"EH" => "Western Sahara",
			"YE" => "Yemen",
			"RS" => "Serbia",
			"CD" => "The Democratic Republic of Congo",
			"ZM" => "Zambia",
			"ZW" => "Zimbabwe",
			"JE" => "Jersey",
			"BL" => "St. Barthelemy",
			"XU" => "St. Eustatius",
			"XC" => "Canary Islands",
			"ME" => "Montenegro"
		);
		foreach ($country as $x => $val) {
			if ($x == $id) return $val;
		}
	}

	function guidv4($data = null) {
		// Generate 16 bytes (128 bits) of random data or use the data passed into the function.
		$data = $data ?? random_bytes(16);
		assert(strlen($data) == 16);
	
		// Set version to 0100
		$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
		// Set bits 6-7 to 10
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80);
	
		// Output the 36 character UUID.
		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}
	
	public function convert_image_url_to_base64($url)
	{
	   $arrContextOptions=array(
		  "ssl"=>array(
			  "verify_peer"=>false,
			  "verify_peer_name"=>false,
		  ),
	   );  
  
	   $data = file_get_contents($url, false, stream_context_create($arrContextOptions));
	   return 'data:image/png;base64,' . base64_encode($data); 
	}
}
