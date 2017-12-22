<?php
    require_once("libraries/dbhelper.php");
	require_once("controllers/general_controller.php");
	
    class Controller extends General {
        private $db;
        
        function __construct() {
            $this->db = new DBHelper();
			parent::__construct($this->db);
        }
		
		function GetInfo() {
			$this->db->SetTable("#_thongtin");
			return reset($this->db->Select());
		}
		
		function GetMangXaHoi() {
			$this->db->SetTable("#_mangxahoi");	
			$this->db->SetWhere("anhien", "=", 1);
			return $this->db->Select();
		}
    }
?>