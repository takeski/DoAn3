<?php
    require_once("libraries/dbhelper.php");
	require_once("controllers/general_controller.php");
	
    class Controller extends General {
        private $db;
        
        function __construct() {
            $this->db = new DBHelper();
			parent::__construct($this->db);
        }

        function GetCurrentProductQuantity($id){
			$this->db->SetTable("#_khohang");
			$this->db->SetWhere("idsanpham", "=", $id);
			$this->db->SetWhere("trangthai", "=", 1);
			$quantity = reset($this->db->Select("count(idsanpham) as totalquantity"))["totalquantity"];
			return $quantity == null ? 0 : $quantity;
		}
    }
?>