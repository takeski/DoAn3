<?php		
	class General {
		private $db;
		
		function __construct($db) {
			$this->db = $db;
			
			$data["date"] = time();
			$this->db->SetTable("#_luottruycap");
			$this->db->Insert($data);
		}
		
		function GetMeta() {
			$this->db->SetTable("#_thongtin");
			$this->db->SetLimit("1");
			return reset($this->db->Select());
		}
		
		function GetMenu() {
			$this->db->SetTable("#_nhomsp");
			$this->db->SetWhere("parentid", "=", "0");
			$this->db->SetOrderBy("id");
			return $this->db->Select();
		}

		function SubMenu() {
			$this->db->SetTable("#_nhomsp");
			$this->db->SetWhere("parentid", "!=", "0");
			return $this->db->Select();
		}

		function GetNews() {
			$this->db->SetTable("#_baiviet");
			$this->db->SetWhere("loai", "=", "tintuc");
			return $this->db->Select();
		}

		function GetHelper() {
			$this->db->SetTable("#_baiviet");
			$this->db->SetWhere("loai", "=", "hotro");
			return $this->db->Select();
		}

		function GetChinhsach() {
			$this->db->SetTable("#_baiviet");
			$this->db->SetWhere("loai", "=", "chinhsach");
			return $this->db->Select();
		}

		function GetCompanyInfo() {
			$this->db->SetTable("#_thongtin");
			$this->db->SetLimit("1");
			return reset($this->db->Select());
		}
			
		function GetSocials() {
			$this->db->SetTable("#_mangxahoi");
			$this->db->SetWhere("anhien", "=", "1");
			return $this->db->Select();
		}
				
		function GetFavicon() {
			$this->db->SetTable("#_hinhanh");
			$this->db->SetWhere("loai", "=", "favicon");
			$this->db->SetWhere("anhien", "=", "1");
			return reset($this->db->Select());
		}
		
		function GetLogo() {
			//Get logo
			$this->db->SetTable("#_hinhanh");
			$this->db->SetWhere("loai", "=", "logo");
			$this->db->SetWhere("anhien", "=", "1");
			return reset($this->db->Select());
		}

		function GetCartQuantity($id) {
			$cart = array();
			if (isset($_SESSION["cart"])) {
				$cart = json_decode($_SESSION["cart"], true);
				if ($cart == null) {
					$cart = array();
				}
			}
			
			foreach ($cart as $c) {
				if ($c["idsanpham"] == $id) {
					return $c["quantity"];
				}
			}
			
			return 0;
		}
		
		function GetProductsInCart($lstId) {
			return $this->db->Query("
						select id, ten, duongdan, hinh, gia
						from #_sanpham
						where id in (" . $lstId . ")
					");
		}
		
	}
?>