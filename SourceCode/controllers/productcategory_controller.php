<?php
    require_once("libraries/dbhelper.php");
	require_once("controllers/general_controller.php");
	
    class Controller extends General {
        private $db;
        
        function __construct() {
            $this->db = new DBHelper();
			parent::__construct($this->db);
        }

        function GetMenu() {
			$this->db->SetTable("#_nhomsp");
			$this->db->SetWhere("parentid", "=", "0");
			return $this->db->Select();
		}
    }
?>