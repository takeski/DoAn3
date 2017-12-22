<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
		include "libraries/dbhelper.php"; 
		$query = new DBHelper();
		if ($_POST["act"] == "login") {
            $query->SetTable("#_taikhoan");
            $query->SetWhere("tentaikhoan", "=", $_POST["username"]);
            $query->SetWhere("matkhau", "=", sha1($_POST["password"]));
            $account = $query->Select();
            if (count($account) == 1) {
                session_start();
                $data['id']= reset($account)['id'];
                $data['username']= reset($account)['tentaikhoan'];
                $data['fullname']= reset($account)['hoten'];
                $_SESSION["account"] = json_encode($data);
                echo "1";
                exit(0);
            }
            else {
                echo "0";exit(0);
            }
        }
        else if ($_POST["act"] == "register")
        {
            $query->SetTable("#_taikhoan");
            $query->SetWhere("tentaikhoan", "=", $_POST['username']);
            $usernames = $query->Select();
            foreach($usernames as $value){
                $username = $value['tentaikhoan'];
            }

            if(isset($username)){
                echo "trung";exit(0);
            }
			else {     
				$query->SetTable("#_taikhoan");
				$data["tentaikhoan"] = $_POST["username"];
				$data["sdt"] = $_POST["phonenumber"];
				$data["diachi"] = $_POST["address"];
				$data["matkhau"] = sha1($_POST["password"]);
				$data["email"] = $_POST["email"];
				$data["hoten"] = $_POST["fullname"];
				if($query->Insert($data)){
					
					echo "Đăng Ký Thành công !";
					
					exit(0);
				}
				else{
					echo "Tên đăng ký bị trùng ! ";
					exit(0);
				}
			}
        } 
        else if ($_POST["act"] == "changeinf")
        {
            $query->SetTable("#_accounts");
            $query->SetWhere("username","=",$_POST['username']);
            $data["username"] = $_POST["username"];
            $data["phonenumber"] = $_POST["phonenumber"];
            $data["address"] = $_POST["address"];
			if (isset($_POST["password"])) {
				$data["password"] = sha1($_POST["password"]);
			}
            $data["email"] = $_POST["email"];
            $data["fullname"] = $_POST["fullname"] ;
            if($query->Update($data)){
                echo "Đổi Thông tin Thành công !";
                
                exit(0);
            }
            else{
                echo "Đổi Thông tin Thất Bại ! ";
                exit(0);
            }
        } 

        if($_POST["act"] == "sendto"){
            $to = "doanquocthai22@gmail.com";  
            $subject = "Contact Us";  
            $email = $_POST['email'] ;  
            $message = $_POST['password'] . $_POST['username'];
            $headers = "From: $email";  
            $sent = mail($to, $subject, $message, $headers) ;     
            if($sent){   
                echo "gửi mail ok";
                exit(0);
            }
            else{
                echo "fail";
                exit(0);
            }
        }
        

    }
?>