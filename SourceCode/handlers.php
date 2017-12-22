<?php
    $currentPath = dirname(__FILE__);
    $page = $_SERVER["SCRIPT_NAME"];
	$page = str_replace(".html", "", $page);
    
    if (file_exists($currentPath . $page)) 
    {
        if (is_dir($currentPath . $page)) {
            if (file_exists($currentPath . $page . "/index.php")) {
                require_once($currentPath . $page . "/index.php");
            }
            else {
                require_once($currentPath . "/404.php");
            }
        }
        else {
            require_once($currentPath . $page);   
        }
        exit(0);
    }
    else {
        if (file_exists($currentPath . $page . ".php")) {
            require_once($currentPath . $page . ".php");
            exit(0);
        }
        if (file_exists($currentPath . "/templates" . $page)) {
            require_once($currentPath . "/templates" . $page);
            exit(0);
        }
        if (file_exists($currentPath . "/templates" . $page . ".php")) {
            require_once($currentPath . "/templates" . $page . ".php");
            exit(0);
        }

        if (strpos($page, "/dang-nhap") === 0) {
			require_once($currentPath . "/templates" . "/login.php");
            exit(0);
		}

        if (strpos($page, "/dang-ky") === 0) {
			require_once($currentPath . "/templates" . "/login.php");
            exit(0);
		}

        if (strpos($page, "/quen-mat-khau") === 0) {
			require_once($currentPath . "/templates" . "/login.php");
            exit(0);
		}


        if (strpos($page, "/tin-tuc") === 0) {
			require_once($currentPath . "/templates" . "/news.php");
            exit(0);
		}

        if (strpos($page, "/chi-tiet-tin-tuc/") === 0) {
			require_once($currentPath . "/templates" . "/detailnews.php");
            exit(0);
		}

        if (strpos($page, "/bai-viet/") === 0) {
			require_once($currentPath . "/templates" . "/article.php");
            exit(0);
		}

        if (strpos($page, "/chi-tiet-san-pham/") === 0) {
			require_once($currentPath . "/templates" . "/productdetail.php");
            exit(0);
		}

        if (strpos($page, "/danh-muc-san-pham/") === 0) {
			require_once($currentPath . "/templates" . "/productcategory.php");
            exit(0);
		}
         if (strpos($page, "/search.html") === 0) {
			require_once($currentPath . "/templates" . "/search.php");
            exit(0);
		}
        
        require_once($currentPath . "/404.php");
        exit(0);
    }
?>