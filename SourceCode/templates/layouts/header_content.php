<?php
	$info = $controller->GetCompanyInfo();
	$logo = $controller->GetLogo();
      $menu = $controller->GetMenu();
      $submenu = $controller->SubMenu();
      $account = json_decode($_SESSION['account'],true );

	$cart = array();
	if (isset($_SESSION["cart"])) {
		$cart = json_decode($_SESSION["cart"], true);
		if ($cart == null) {
			$cart = array();
		}
	}
	
	$total = 0;
	if (count($cart) != 0) {
		$lstId = "";
		foreach ($cart as $c) {
			if ($lstId == "") {
				$lstId .= $c["idsanpham"];
			}
			else {
				$lstId .= ", " . $c["idsanpham"];
			}
		}
		
		if ($lstId != "") {
			$lstProductsInCart = $controller->GetProductsInCart($lstId);
			
			foreach ($lstProductsInCart as $productincart) {
				$total += $productincart["gia"] * $controller->GetCartQuantity($productincart["id"]);
			}
		}

	}
?>
   

 <header id="header">
      <div class="top-header">
      <div class="container">
            <div class="top-inner">
            <div class="row">
                  <div class="col-md-5 col-sm-12 col-xs-12">
                  <div class="hotline" style="padding:5px;"> 
                        <a href="tel:<?= $info['sdt']?>" title=""> Đoàn Quốc Thái - <i class="fa fa-phone"></i> <?= $info['sdt']?></a>
                        <a href="tel:<?= $info['sdt']?>" title=""> Nguyễn Minh Thành - <i class="fa fa-phone"></i> <?= $info['hotline']?></a>
                  </div>
                  </div>
                  <div class="col-md-7 col-sm-12 col-xs-12">
                  <div class="top-menu pull-right" style="padding:5px;">
                        <ul id="menu-menu_top" class="list-inline">

                              <?php 
                              if ( $_SESSION['account'] == null) { ?>
                                    <li id="menu-item-1738" class="menu-item menu-item-type-taxonomy menu-item-object-new_category menu-item-1738"><a href="<?=WEB_ROOT?>dang-nhap">Đăng Nhập</a></li>|
                                    <li id="menu-item-21" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-21"><a href="<?=WEB_ROOT?>dang-ky">Đăng Ký</a></li>

                              <?php }else
                              { ?>
                                    <li id="menu-item-1738" class="menu-item menu-item-type-taxonomy menu-item-object-new_category menu-item-1738">
                                    <i class="fa fa-user" aria-hidden="true"></i> <a ><?= $account['username']?></a></li> |
                                    <li id="menu-item-21" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-21">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> <a><input class="thoat" type="button"  onclick="logout();"  value="Đăng Xuất" style="outline:none;border:none;background:none;" /></a></li>

                              <?php }?>
                              
                        </ul>
                  </div>
                  </div>
            </div>
            </div>
      </div>
      </div>
      <div class="middle-header container">
      <div class="row">
            <div class="col-xs-12 col-md-3 col-sm-12"> <a class="logo" href="<?=WEB_ROOT?>" title=""> <img src="<?= WEB_ROOT . $logo['hinh']?>"> </a></div>
            <div class="col-xs-12 col-md-9 col-sm-12">
            <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-5">
                  <div class="search-box">
                        <div class='wpdreams_asp_sc ajaxsearchpro asp_main_container ' id='ajaxsearchpro1_1'>
                        <div class="probox" style="border:none;">
                              <div class='promagnifier'>
                                    <div class='asp_text_button hiddend'> Search</div>
                                    <div class='innericon'>
                                          <img src="<?= WEB_ROOT. "images/icon/search.png"?>" onclick="search();" alt="">
                                    </div>
                                    <div class="asp_clear"></div>
                              </div>
                              <div class='proinput' style="display: inherit;">
                                    <h5 style="padding-top: 9px;">Giá từ : &nbsp </h5>
                                    <select name="giatu" id="giatu" style="border: 1px solid;border-radius: 5px;">
                                          <?php for($i=1;$i<=15;$i++) {?>
                                                <option value="<?= $i?>000000"><?= $i?>.000.000 đ</option>
                                          <?php }?>
                                    </select>

                                    &nbsp&nbsp
                                    <h5 style="padding-top: 9px;"> Giá đến : </h5>
                                    <select name="giaden" id="giaden" style="border: 1px solid;border-radius: 5px;">
                                          <?php for($i=2;$i<=15;$i++) {?>
                                                <option value="<?= $i?>000000"><?= $i?>.000.000 đ</option>
                                          <?php }?>

                                    </select>
                                          
                                    <input type='submit' onclick="search();" style='width:0; height: 0; visibility: hidden;'>

                              </div>
                              
                              <div class='proloading'>
                              <div class="asp_loader">
                                    <div class="asp_loader-inner asp_simple-circle"></div>
                              </div>
                              </div>
                              <div class='proclose'>
                              <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                    y="0px"
                                    width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512"
                                    xml:space="preserve">
                                    <polygon id="x-mark-icon"
                                    points="438.393,374.595 319.757,255.977 438.378,137.348 374.595,73.607 255.995,192.225 137.375,73.622 73.607,137.352 192.246,255.983 73.622,374.625 137.352,438.393 256.002,319.734 374.652,438.378 "/>
                              </svg>
                              </div>
                        </div>
                        <div id='ajaxsearchprores1_1' class='vertical ajaxsearchpro wpdreams_asp_sc'>
                              <div class="results">
                              <div class="resdrg"></div>
                              </div>
                              <div class="asp_res_loader hiddend">
                              <div class="asp_loader">
                                    <div class="asp_loader-inner asp_simple-circle"></div>
                              </div>
                              </div>
                        </div>
                        <div id='ajaxsearchprosettings1_1' class="wpdreams_asp_sc ajaxsearchpro searchsettings">
                              <form name='options'>
                              <fieldset class="">
                                    <div class="option hiddend"> <input type='hidden' name='qtranslate_lang'
                                    value='0'/></div>
                                    <div class="asp_option">
                                    <div class="option"> <input type="checkbox" value="checked" id="set_exactonly1_1"
                                          name="set_exactonly" /> <label for="set_exactonly1_1"></label></div>
                                    <div class="label"> Exact matches only</div>
                                    </div>
                                    <div class="asp_option">
                                    <div class="option"> <input type="checkbox" value="None" id="set_intitle1_1"
                                          name="set_intitle"  checked="checked"/> <label for="set_intitle1_1"></label></div>
                                    <div class="label"> Search in title</div>
                                    </div>
                                    <div class="asp_option">
                                    <div class="option"> <input type="checkbox" value="None" id="set_incontent1_1"
                                          name="set_incontent"  checked="checked"/> <label for="set_incontent1_1"></label></div>
                                    <div class="label"> Search in content</div>
                                    </div>
                                    <div class="asp_option">
                                    <div class="option"> <input type="checkbox" value="None" id="set_incomments1_1"
                                          name="set_incomments" /> <label for="set_incomments1_1"></label></div>
                                    <div class="label"> Search in comments</div>
                                    </div>
                                    <div class="asp_option">
                                    <div class="option"> <input type="checkbox" value="None" id="set_inexcerpt1_1"
                                          name="set_inexcerpt"  checked="checked"/> <label for="set_inexcerpt1_1"></label></div>
                                    <div class="label"> Search in excerpt</div>
                                    </div>
                              </fieldset>
                              <fieldset class="asp_sett_scroll hiddend">
                                    <legend>Filter by Custom Post Type</legend>
                                    <div class="option hiddend"> <input type="checkbox" value="post"
                                    id="1_1customset_1_11"
                                    name="customset[]" checked="checked"/> <label for="1_1customset_1_11"></label></div>
                                    <div class="label hiddend"></div>
                                    <div class="option hiddend"> <input type="checkbox" value="page"
                                    id="1_1customset_1_12"
                                    name="customset[]" checked="checked"/> <label for="1_1customset_1_12"></label></div>
                                    <div class="label hiddend"></div>
                              </fieldset>
                              <div style="clear:both;"></div>
                              </form>
                        </div>
                        </div>
                        <div id="asp_hidden_data" style="display:none;">
                        <div class='asp_item_overlay'>
                              <div class='asp_item_inner'>
                              
                              </div>
                        </div>
                        <svg style="position:absolute" height="0" width="0">
                              <filter id="aspblur">
                              <feGaussianBlur in="SourceGraphic" stdDeviation="4"/>
                              </filter>
                        </svg>
                        <svg style="position:absolute" height="0" width="0">
                              <filter id="no_aspblur"></filter>
                        </svg>
                        </div>
                        </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-3">
                  <div class="kn pull-right">
                        <ul class="list-inline"></ul>
                  </div>
                  </div>
            </div>
            </div>
      </div>
      </div>
</header>

 <section class="container-fluid parent-nav nav_pc">
      <nav class="navbar navbar-default" id="nav-custom-fix">
            <div class="collapse navbar-collapse js-navbar-collapse">
                  
                  <ul id="menu-menu_main" class="nav navbar-nav">
                  <li id="menu-item-25835" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-25835 dropdown mega-dropdown active">
                        <a title="Trang chủ" class="dropdown-toggle" href="<?= WEB_ROOT?>">
                        <i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a>
                  </li>

                  <?php foreach ( $menu as $level1 )  {?>
                  <li id="menu-item-25846" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-25846 dropdown mega-dropdown">
                  <a title="<?= $level1['ten']?>" href="<?= WEB_ROOT?>danh-muc-san-pham/<?= $level1['duongdan']?>" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true"><?= $level1['ten']?> <span class="caret"></span></a>
                        <?php            
                        if($submenu ==0){ ?>
                              <ul style="display:none;">
                        <?php }
                        else{ ?>
                        <ul role="menu" class=" mega-dropdown-menu dropdown-menu  row">
                        <?php }?>
                              <?php foreach ($submenu as $level2) { 
                                    if ($level2['parentid'] == $level1['id']) { ?>
                                          <li id="menu-item-26014"  class="col-sm-6 menu-item menu-item-type-taxonomy menu-item-object-category menu-item-26463">
                                                <a title="<?= $level2['ten']?>" href="<?= WEB_ROOT?>danh-muc-san-pham/<?= $level2['duongdan']?>" ><?= $level2['ten']?></a>
                                          </li>   
                                    <?php }?>
                              <?php }?>
                        </ul>
                        
                  </li>
                  <?php }?>
                  <li id="menu-item-25835" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-25835 dropdown mega-dropdown active">
                        <a title="Tin Tức" class="dropdown-toggle" href="<?= WEB_ROOT .'tin-tuc'?>">Tin Tức</a>
                  </li>
                  <!--<li id="menu-item-25835" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-25835 dropdown mega-dropdown active">
                        <a title="Liên Hệ" class="dropdown-toggle" href="<?= WEB_ROOT .'lien-he'?>">Liên Hệ</a>
                  </li>-->
                  <li class="giohang"> <a href="<?= WEB_ROOT?>gio-hang"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Giỏ Hàng (<?=count($cart)?>) </a></li>
                  <style>
                  .giohang{
                        text-transform: uppercase;
                        margin: 4px;
                        font-size: 15px;
                        margin-left: 23px;
                  }
                  </style>

                  </ul>
                  
            </div>
      </nav>
</section>

<div class="container-fluid parent-nav nav_mobile">
	<nav class="navbar navbar-default" id="nav-custom-fix"  style="background: #c21d32;border-radius: 4px;margin: 5px 0;color: #fff;">
	<div class="navbar-header"> <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
       <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> 
       <span class="icon-bar"></span> <span class="icon-bar"></span>
        </button> <a class="navbar-brand" href="#"></a>
        </div>
	<div class="collapse navbar-collapse js-navbar-collapse">
		<ul id="menu-menu_main" class="nav navbar-nav">
			<li class="dropdown mega-dropdown" style="display: inline-block; width: 49%;background: #c21d32;margin-bottom: 3px"> <a title="iPhone" class="dropdown-toggle" href="<?= WEB_ROOT ."danh-muc-san-pham/"?>iphone" style="color: white; padding: 10px">iPhone</a></li>
			<li class="dropdown mega-dropdown" style="display: inline-block; width: 49%;background: #c21d32;margin-bottom: 3px"> <a title="Samsung" class="dropdown-toggle" href="<?= WEB_ROOT ."danh-muc-san-pham/"?>samsung" style="color: white; padding: 10px">Samsung</a></li>
			<li class="dropdown mega-dropdown" style="display: inline-block; width: 49%;background: #c21d32;margin-bottom: 3px"> <a title="Sony" class="dropdown-toggle" href="<?= WEB_ROOT ."danh-muc-san-pham/"?>sony" style="color: white; padding: 10px">Sony</a></li>
			<li class="dropdown mega-dropdown" style="display: inline-block; width: 49%;background: #c21d32;margin-bottom: 3px"> <a title="Xiaomi" class="dropdown-toggle" href="<?= WEB_ROOT ."danh-muc-san-pham/"?>xiaomi" style="color: white; padding: 10px">Xiaomi</a></li>
			<li class="dropdown mega-dropdown" style="display: inline-block; width: 49%;background: #c21d32;margin-bottom: 3px"> <a title="HTC" class="dropdown-toggle" href="<?= WEB_ROOT ."danh-muc-san-pham/"?>htc" style="color: white; padding: 10px">HTC</a></li>
			<li class="dropdown mega-dropdown" style="display: inline-block; width: 49%;background: #c21d32;margin-bottom: 3px"> <a title="Blackberry" class="dropdown-toggle" href="<?= WEB_ROOT ."danh-muc-san-pham/"?>blackberry" style="color: white; padding: 10px">Blackberry</a></li>
			<li class="dropdown mega-dropdown" style="display: inline-block; width: 49%;background: #c21d32;margin-bottom: 3px"> <a title="LG" class="dropdown-toggle" href="<?= WEB_ROOT ."danh-muc-san-pham/"?>lg" style="color: white; padding: 10px">LG</a></li>
			<li class="dropdown mega-dropdown" style="display: inline-block; width: 49%;background: #c21d32;margin-bottom: 3px"> <a title="Asus" class="dropdown-toggle" href="<?= WEB_ROOT ."danh-muc-san-pham/"?>asus-chinh-hang-re-nhat" style="color: white; padding: 10px">Asus</a></li>
			<li class="dropdown mega-dropdown" style="display: inline-block; width: 49%;background: #c21d32;margin-bottom: 3px"> <a title="Meizu" class="dropdown-toggle" href="<?= WEB_ROOT ."danh-muc-san-pham/"?>meizu" style="color: white; padding: 10px">Meizu</a></li>
			<li class="dropdown mega-dropdown" style="display: inline-block; width: 49%;background: #c21d32;margin-bottom: 3px"> <a title="iPad" class="dropdown-toggle" href="<?= WEB_ROOT ."danh-muc-san-pham/"?>ipad" style="color: white; padding: 10px">iPad</a></li>
		</ul>
	</div>
	</nav>
</div>
<script>
      function search(){
            giatu = document.getElementById("giatu").value;
            giaden = document.getElementById("giaden").value;
             $.ajax({
                  url: "",
                  method: "POST",
                  data: { },
                  success: function(result) {
                        window.location = "<?=WEB_ROOT?>search.html?giatu=" + giatu + "&giaden=" + giaden;
                  }
            });


      }


      function logout(){
            $.ajax({
                  url: "<?= WEB_ROOT?>/functions/logout.php",
                  method: "POST",
                  data: { },
                  success: function(result) {
                        window.location = "<?= WEB_ROOT?>";
                  }
            });
      }
</script>