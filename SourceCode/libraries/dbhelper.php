<?php   
	require_once(dirname(__FILE__) . '/../config.php');
	
    class DBHelper {
        private $conn = null;
		
		private $table = "";
		private $where = "";
		private $orderBy = "";
		private $limit = "";
        
        function __construct() {
            $this->conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
			if (mysqli_connect_errno())
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			mysqli_set_charset($this->conn, "utf8");
        }
		
		private function ResetQuery() {
			$this->table = "";
			$this->where = "";
			$this->orderBy = "";
			$this->limit = "";
		}
        
        private function GetSecureString($str) {
            return mysqli_real_escape_string($this->conn, $str);
        }
        
        function Query($sql = "") {
			if($sql == "") {
				return null;
			}
			
			$sql = str_replace("#_", PREFIX, $sql);
			
            $queryResult = mysqli_query($this->conn, $sql);
			
			if ($queryResult != null) {
				if (is_object($queryResult)) {
					$lstResult = array();
					
					while ($row = mysqli_fetch_assoc($queryResult)) {
						array_push($lstResult, $row);
					}
					
					mysqli_free_result($queryResult);
					$this->ResetQuery();
					return $lstResult;
				}
				else {
					mysqli_free_result($queryResult);
					$this->ResetQuery();
					return true;
				}
			}
			else {
				echo "SQL Syntax Error (" . mysqli_errno($this->conn) . "): " . $sql;
				$this->ResetQuery();
				return null;
			}
        }
        
        function Select($str = "*") {
			$sql = "select " . $str;
			$sql .= " from " . $this->table;
			$sql .=  $this->where;
			$sql .=  $this->orderBy;
			$sql .=  $this->limit;
			return $this->Query($sql);
		}
		
		function Insert($data = array()) {
			if (count($data) == 0) {
				echo "Insert what?";
				return null;
			}
			else {					
				$num = 1;
				$countData = count($data);
				
				$keys = "";
				$values = "";
				
				foreach ($data as $key=>$value) {
					if ($num < $countData) {
						$keys .= $key . ", ";
						$values .= "'" . $this->GetSecureString($value) . "', ";
					}
					else {
						$keys .= $key;
						$values .= "'" . $this->GetSecureString($value) . "'";
						break;
					}
					
					++$num;
				}
				
				$sql = "insert into " . $this->table . " (" . $keys . ") values (" . $values . ")";					
				$this->Query($sql);
				return mysqli_insert_id($this->conn);
			}
		}
		
		function Update($data = array()) {
			if (count($data) == 0) {
				echo "Update what?";
				return null;
			}
			else {					
				$num = 1;
				$countData = count($data);
				
				$updateValues = "";
				
				foreach ($data as $key=>$value) {
					if ($num < $countData) {
						$updateValues .= $key . " = '" . $this->GetSecureString($value) . "', ";
					}
					else {
						$updateValues .= $key . " = '" . $this->GetSecureString($value) . "'";
						break;
					}
					
					++$num;
				}
				
				$sql = "update " . $this->table . " set " . $updateValues;
				$sql .= $this->where;
				return $this->Query($sql);
			}
		}
		
		function Delete() {
			$sql = "delete from " . $this->table;
			$sql .= $this->where;
			return $this->Query($sql);
		}
		
		function SetTable($str = "") {
			if ($str != "") {
				if ($this->table == "") {
					$this->table .= $str;
				}
				else {
					$this->table .= " join " . $str;
				}
			}
		}
		
		function JoinOn($str1, $str2) {
			if ($str1 != "" && $str2 != "") {
				if ($this->table != "") {
					$this->table .= " on " . $str1 . " = " . $str2;
				}
			}
		}
		
		function SetWhere($key = "", $operator = "", $value = "") {
			if ($key != "") {
				if ($this->where == "") {
					$this->where = " where " . $key . " " . $operator . " '" . $this->GetSecureString($value) . "'";
				}
				else {
					$this->where .= " and " . $key . " " . $operator . " '" . $this->GetSecureString($value) . "'";
				}
			}
		}
		
		function SetWhereOr($key = "", $operator = "", $value = "") {
			if ($key != "") {
				if ($this->where == "") {
					$this->where = " where " . $key . " " . $operator . " '" . $this->GetSecureString($value) . "'";
				}
				else {
					$this->where .= " or " . $key . " " . $operator . " '" . $this->GetSecureString($value) . "'";
				}
			}
		}
		
		function SetOrderBy($str = "") {
			if ($str != "") {
				$this->orderBy = " order by " . $str;
			}
		}
		
		function SetLimit($str = "") {
			if ($str != "") {
				$this->limit = " limit " . $str;
			}
		}
        
        function CloseConnection() {
            mysqli_close($this->conn);
        }
    }
?>