<?php 
    $menu = $controller->GetMenu();
    $thongtincty = $controller->GetCompanyInfo();
    require_once("libraries/dbhelper.php");
    $db = new DBHelper();
    
    $link = substr($_SERVER['REQUEST_URI'], +19);

    $sp = $db->Query("SELECT sp.id ,nsp.ten as Ten, sp.ten as Name, noidung, gia
    , hinh, sp.duongdan as danduong, nsp.duongdan as ddnsp FROM tb_nhomsp nsp JOIN tb_sanpham sp ON nsp.id = sp.idnhomsp WHERE sp.duongdan = '".$link."' ");

    $trangthai = $db->Query("SELECT * FROM tb_khohang WHERE idsanpham = '". reset($sp)['id'] ."' AND trangthai = 1 ");
    $account = json_decode($_SESSION['account'],true);

    $user = $db->Query("SELECT * FROM tb_taikhoan WHERE id = '". $account['id']."'");
?>

<link rel="stylesheet" href="<?= WEB_ROOT?>css/flexslider.css" />
<div class="product__detail content">
<?php foreach($sp as $value) { ?>
      <div class="cats-breadcrumb container">
            <div class="row">
            <div class="col-md-12">
			
                  <span typeof="v:Breadcrumb">
                        <a rel="v:url" property="v:title" title="Go to Clickbuy." href="<?= WEB_ROOT?>" class="home"><i class="fa fa-home"></i> Trang chủ</a>
                  </span> <i class="fa fa-caret-right"></i> 
				
                  <span typeof="v:Breadcrumb">
                        <a rel="v:url" property="v:title" title="Go to the iPhone category archives." href="<?= WEB_ROOT ."danh-muc-san-pham/".$value['ddnsp'];?>" 
                        class="taxonomy category"><?php echo $value['Ten']; ?></a>
                  </span> <i class="fa fa-caret-right"></i> 
                  <span typeof="v:Breadcrumb">
                        <a rel="v:url" property="v:title" title="Go to the iPhone category archives." href="<?= WEB_ROOT ."chi-tiet-san-pham/".$value['danduong'];?>" 
                        class="taxonomy category"><?php echo $value['Name']; ?></a>
                  </span>
			
            </div>
      </div>
      
      <section class="product__detail__header">
            <div class="container">
            <div class="product__detail__header__content">
                  <h1 class="product__detail__heading pull-left"><?php echo $value['Name']; ?></h1>
                  <div class="fb-iframe pull-right">
                  <script type="text/javascript" src="https://apis.google.com/js/plusone.js" gapi_processed="true"></script> 
                  <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;width=111&amp;layout=button&amp;action=like&amp;size=small&amp;show_faces=true&amp;share=true&amp;height=65&amp;appId" 
                        width="111" height="25" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowtransparency="true">
                  </iframe>
                  </div>
                  <div class="clearfix"></div>
            </div>
            </div>
      </section>

      <div class="product__detail__top detail-top container-fluid ">
            <div class="product__detail__top__content detail-product row">
                  <div class="product__detail__top__content__left detail-product-tab-1 col-sm-6">
                        <div class="product__gallery__slide">
                              <div class="product__gallery__slide__top flexslider">
                              <div class="flex-viewport" style="overflow: hidden; position: relative;">
                                    <ul class="slides" id="zoom_03" style="width: 1400%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
                                    <li class="flex-active-slide" style="width: 547px; margin-right: 0px; float: left; display: block;"> <img src="<?= WEB_ROOT. $value['hinh']; ?>" draggable="false"></li>
                                    </ul>
                              </div>
                              
                              </div>
                        </div> 
                  </div>

                  <div class="product__detail__top__content__right detail-product-tab-2 col-sm-6">
                        <div class="product__detail__top__content__right__price tab-2-price text-center pull-left"> 
                              <span class="price"> <?= number_format($value['gia'])  ?> </span> <strong>đ</strong> 
                              <span class="sl">(
                                    <?php if ($trangthai==null){
                                          echo "Hết Hàng";
                                    }else{
                                          echo "Còn Hàng";
                                    }
                                    ?>
                              )</span>
                        </div>
                        
                        <div class="product__detail__top__content__right__address tab-2-address pull-right">
                             
                        </div>

                        <div class="clearfix"></div>

                        <div class="detail-sale">
                              <p class="bh-title-2"><i class="fa fa-diamond" aria-hidden="true"></i> Chi tiết sản phẩm</p>
                              <div class="detail-sale-content">
                              <p><?php echo $value['noidung']; ?></p>
                              </div>
                        </div>

                        <div class="book full">
                              <div class="row">
                                    <div class="col-xs-4"> 
                                          <button id="dathangtuxa" style="padding:10px 20px 10px 15px;" class="order pull-left text-center btn btn-info btn-lg"
                                                type="submit" onclick="AddToCart(<?= reset($sp)['id']?>);" data-toggle="modal" data-target="#myModal">ĐẶT HÀNG<br>
                                          </button>
                                    </div>
                              
                              </div>
                        </div>

                        <div class="clearfix"></div>
                 
                  </div>

            </div>
      </div>

      <div class="product__detail__middle detail-middle container-fluid product__detail__middle">
            <div class="product__detail__comment detail-cm">
            <div class="container">
                  <div class="row">
                        <script>(function(d, s, id) {
                              var js, fjs = d.getElementsByTagName(s)[0];
                              if (d.getElementById(id)) return;
                              js = d.createElement(s); js.id = id;
                              js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.0";
                              fjs.parentNode.insertBefore(js, fjs);
                              }(document, 'script', 'facebook-jssdk'));
                        </script>
                        <div id="cm-facebook" class="tab-pane fade in active">
                              <div class="fb-comments fb_iframe_widget fb_iframe_widget_fluid" data-href="" data-numposts="5" data-width="100%" data-colorscheme="light" fb-xfbml-state="rendered">
                              <span style="height: 176px;">
                                    <iframe id="f1c858ccbd94e48" name="f3c8795ee5d08fc" scrolling="no" title="Facebook Social Plugin" class="fb_ltr" 
                                    src="//www.facebook.com/plugins/follow?href=https%3A%2F%2Fwww.facebook.com%2Fprofile.php%3Fid%3D100010944286101&amp;layout=standard&amp;show_faces=true&amp;colorscheme=light&amp;width=450&amp;height=80" style="border: none; overflow: hidden; height: 176px; width: 100%;">
                                    </iframe>
                              </span>
                              </div>   
                        </div>
                  
                  </div>
            </div>
            </div>
            <script src="<?= WEB_ROOT?>js/themes/jquery.price_format.js" type="text/javascript" charset="utf-8" async="" defer=""></script> 
      </div>
     <?php } ?>

</div>

<script>
	function AddToCart(id) {
		$.ajax({
			url: "<?=WEB_ROOT?>functions/cart.php",
			method: "POST",
			data: { "id" : id, "act" : "add" },
			success: function(result) {
                        // alert(result);return;
				if (result) {
					alert("Sản phẩm đã được thêm vào giỏ hàng !");
                              window.location ="<?= WEB_ROOT . "gio-hang"?> ";
				}
				else {
					alert("Sản phẩm này vừa được bán hết, cảm phiền bạn chọn sản phẩm khác, cảm ơn !");
                              location.reload();
				}
				 
			}
		});
	}
</script>
