<?php    

    session_start();

    include("libraries/dbhelper.php");
    $query = new DBHelper();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $search= $query->Query("SELECT *FROM tb_sanpham WHERE gia BETWEEN '".$_POST['giatu']."' AND '".$_POST['giaden']."'  ");      
        if($mavandon){
            $_SESSION['search'] = json_encode($search);
            echo "1";exit(0);
        }else{
            echo "0";exit(0);
        }
    }
?>