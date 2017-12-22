<?php
    require_once("libraries/dbhelper.php");
	require_once("controllers/general_controller.php");
	
    class Controller extends General {
        private $db;
        
        function __construct() {
            $this->db = new DBHelper();
			parent::__construct($this->db);
        }

        function Getslider() {
			$this->db->SetTable("#_sliders");
			$this->db->SetWhere("anhien", "=", "1");
			return $this->db->Select();
		}

        function GetProducthot() {
			$this->db->SetTable("#_sanpham");
			$this->db->SetWhere("noibat", "=", "1");
			$this->db->SetOrderBy("id desc");
			return $this->db->Select();
		}

        function GetVideo() {
			$this->db->SetTable("#_video");
			return $this->db->Select();
		}

        function GetIphone() {
			$this->db->SetTable("#_nhomsp");
            $this->db->SetWhere("parentid", "=", "1");
			return $this->db->Select();
		}

         function GetAndroid() {
			$this->db->SetTable("#_nhomsp");
            $this->db->SetWhere("parentid", "=", "2");
			return $this->db->Select();
		}

        function GetBannerleft() {
			$this->db->SetTable("#_quangcao");
            $this->db->SetWhere("loai", "=", "left");
			return reset($this->db->Select());
		}

        function GetBannerright() {
			$this->db->SetTable("#_quangcao");
            $this->db->SetWhere("loai", "=", "right");
			return reset($this->db->Select());
		}

		function GetProductIphone() {
			$this->db->SetTable("#_sanpham");
            $this->db->SetWhere("idnhasx", "=", "1");
			$this->db->SetWhere("anhien", "=", "1");
			$this->db->SetLimit("7");
			return $this->db->Select();
		}

		function GetProductAndroid() {
			$this->db->SetTable("#_sanpham");
            $this->db->SetWhere("idnhasx", "!=", "1");
			$this->db->SetWhere("anhien", "=", "1");
			$this->db->SetLimit("7");
			return $this->db->Select();
		}
    }
?>