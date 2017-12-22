<?php
	require_once("libraries/dbhelper.php");
    $db = new DBHelper();

	$info = $controller->GetCompanyInfo();
	$socials = $controller->GetSocials();
	$logo = $controller->GetLogo();
	$menu = $controller->GetMenu(); 
	$hotro = $controller->GetHelper(); 
	$chinhsach = $controller->GetChinhsach(); 
	$time=strtotime(date('y-m-d'));
	$luotxem = $db->Query("SELECT * FROM tb_luottruycap WHERE date >='".$time."' ");
	$dem = count($luotxem);

?>

  <div class="home__content__bottom">
	<div class="home__content__bottom__1 container">
	<ul class="list-inline">
		<li>
			<img class="img-responsive pull-left" src="<?= WEB_ROOT?>images/icon/gh-icon.png">
			<div class="pull-left">
				<a href="">
				<div class="title">Cam kết chất lượng</div>
				</a>
				<div class="des">Tuyệt đối yên tâm</div>
			</div>
			<div class="clearfix"></div>
		</li>
		<li>
			<img class="img-responsive pull-left" src="<?= WEB_ROOT?>images/icon/dt-icon.png">
			<div class="pull-left">
				<div class="title">Bảo hành siêu việt</div>
				<div class="des">100% khách hàng hài lòng</div>
			</div>
			<div class="clearfix"></div>
		</li>
		<li>
			<img class="img-responsive pull-left" src="<?= WEB_ROOT?>images/icon/tg-icon.png">
			<div class="pull-left">
				<a href="">
				<div class="title">Giá rẻ nhất hời nhất</div>
				</a>
				<div class="des">Khỏi mất công so sánh</div>
			</div>
			<div class="clearfix"></div>
		</li>
		<li>
			<img class="img-responsive pull-left" src="<?= WEB_ROOT?>images/icon/like-icon.png">
			<div class="pull-left">
				<div class="title">Yêu quý khách hàng</div>
				<div class="des">Khách hàng là người thân</div>
			</div>
			<div class="clearfix"></div>
		</li>
	</ul>
	</div>
	<div class="home__content__bottom__2">
	<div class="container">
		<ul class="list-inline">
			<li class="text-center">
				<img src="<?= WEB_ROOT?>images/icon/visit.png">
				<div class="number"> <?= $dem?></div>
				<div class="des">Người truy cập hàng ngày</div>
			</li>
			<li class="text-center">
				<img src="<?= WEB_ROOT?>images/icon/subc.png">
				<div class="number">0</div>
				<div class="des">Người theo dõi trên fanpage</div>
			</li>
			<li class="text-center">
				<img src="<?= WEB_ROOT?>images/icon/youtuber.png">
				<div class="number">0</div>
				<div class="des">Người subscriber trên Youtube</div>
			</li>
			<li class="text-center">
				<img src="<?= WEB_ROOT?>images/icon/icon-1.png">
				<div class="number">0</div>
				<div class="des">Sản phẩm bán ra trong ngày</div>
			</li>
		</ul>
	</div>
	</div>
</div>

 <div class="footer">
         <div class="ft-top">
            <div class="container">
               <div class="row">
                  <div class="ft-top-item col-sm-3 col-xs-12">
                     <div class="title text-uppercase">Về Thanhthaimobile</div>
                     <ul id="menu-menu-footer1" class="">
                        <li id="menu-item-57" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-57"><a href="<?= WEB_ROOT?>tin-tuc">Tin Tức</a></li>
                        <li id="menu-item-59" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-59"><a href="<?= WEB_ROOT?>lien-he">Liên hệ</a></li>
                     </ul>
                  </div>
                  <div class="ft-top-item ft-top-item-2 col-sm-3 col-xs-12">
                     <div class="title text-uppercase">hỗ trợ mua hàng</div>
                     <ul style="list-style-type: circle;">
						 <?php foreach($hotro as $value){ ?>
                        	<li><a href="<?= WEB_ROOT ."bai-viet/". $value['duongdan'] ?>"><?= $value['ten']?></a></li>
						<?php }?>
                    </ul>
                  </div>
                  <div class="ft-top-item ft-top-item-2 col-sm-3 col-xs-12">
                     <div class="title text-uppercase">chính sách chung</div>
                     <ul style="list-style-type: circle;">
						 <?php foreach($chinhsach as $value){ ?>
                        	<li><a href="<?= WEB_ROOT ."bai-viet/". $value['duongdan'] ?>"><?= $value['ten']?></a></li>
						<?php }?>
                    </ul>
                  </div>
                  <div class="ft-top-item col-sm-3 col-xs-12">
                     <div class="title text-uppercase">Thông tin liên hệ</div>
                     <ul>
                        <li><span style="font-size: 12pt; font-family: arial, helvetica, sans-serif;">Hotline 1: <strong><?= $info['sdt']?><br /> </strong></span></li>
                        <li><span style="font-size: 12pt; font-family: arial, helvetica, sans-serif;">Hotline 2: <strong><?= $info['hotline']?><br /> </strong></span></li>
                       </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="content-bt-3 container">
            <div class="row">
               <div class="bt-3-left col-md-9 col-sm-9">
                  <div class="title"><span>Trung tâm bảo hành</span></div>
                  <div class="row">
                     <div class="item col-sm-6"> <span class="title-2"> Đà Lạt</span> <span class="title-bt">30 tổ 4 thôn tân lập -lạc lâm - đơn dương - lâm đồng<br/>0633.631.352</span></div>
                     <div class="item col-sm-6"> <span class="title-2">TP. HCM</span> <span class="title-bt">53/7c kp2 - tân thới nhất - q.12<br/>0962104699</span></div>
                  </div>
               </div>
               <div class="bt-3-right col-md-3 col-sm-3" style="font-size:16px;"> <span>ThanhThaiMobile <br /> Chuyên Các Mặt Hàng Điện Thoại <br /> Uy Tín - Chất Lượng </br></span> </div>
            </div>
         </div>
         <div class="ft-bt">
            <div class="container">
               <div class="pay pull-left"> 
					   <div class="col-xs-12 col-md-3 col-sm-12"> <a class="logo" href="<?=WEB_ROOT?>" title=""> <img src="<?= WEB_ROOT . $logo['hinh']?>"> </a></div>
				</div>
               <div class="menu-bt pull-left">
                  <ul id="menu-menu-footer3" class="list-inline">
                     <li id="menu-item-18302" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-18302"><a href="http://suadienthoainhanh.net/">Ép kính &#8211; thay màn hình</a></li>
                     <li id="menu-item-65" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-65"><a href="<?= WEB_ROOT?>danh-muc-san-pham/iphone">iPhone</a></li>
					  <!--<?php foreach($menu as $value){?>
						<li id="menu-item-65" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-65">
							<a href="<?= WEB_ROOT."danh-muc-san-pham/".$value['duongdan']?>"><?= $value['ten']?></a>
						</li>
					 <?php }?>-->
                     <li id="menu-item-69" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-69"><a href="<?= WEB_ROOT?>danh-muc-san-pham/samsung">Samsung</a></li>
                     <li id="menu-item-1232" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1232"><a href="<?= WEB_ROOT?>danh-muc-san-pham/sony">Sony</a></li>
                     <li id="menu-item-6635" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-6635"><a href="<?= WEB_ROOT?>danh-muc-san-pham/htc">HTC</a></li>
                     <li id="menu-item-6636" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-6636"><a href="<?= WEB_ROOT?>danh-muc-san-pham/lg">LG</a></li>
                     <li id="menu-item-1235" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1235"><a href="<?= WEB_ROOT?>danh-muc-san-pham/dien-thoai-cu">Điện thoại cũ</a></li>
                     <li id="menu-item-6638" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-6638"><a href="<?= WEB_ROOT?>danh-muc-san-pham/dien-thoai-2-sim-cao-cap">Điện thoại 2 sim cao cấp</a></li>
                     <li id="menu-item-11987" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-11987"><a href="<?= WEB_ROOT?>danh-muc-san-pham/uncategorized">Samsung chính hãng</a></li>
                  </ul>
                  <div class="copyright text-center">Copyrights @2017   Designed by ThanhThai</a></div>
               </div>
               <div class="social-bt pull-right"> 
				<?php foreach($socials as $value){?>
			   		<a class="<?= $value['hinh']?>" href="<?= $value['duongdan']?>"></a> 
				<?php }?>

			   </div>
            </div>
         </div>
      </div>
      <a id="back-to-top" href="#" class="btn btn-danger btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left">
	  	<i class="fa fa-angle-up" aria-hidden="true"></i>
	  </a> 
	  <script src="<?= WEB_ROOT?>js/themes/jquery.min.js"></script> 
	  <script src="<?= WEB_ROOT?>js/themes/owl.carousel.min.js"></script> 
	  <script src="<?= WEB_ROOT?>js/themes/jquery.flexslider-min.js"></script> 
	  <script src="<?= WEB_ROOT?>js/themes/bootstrap.min.js"></script> 
	  <script src="<?= WEB_ROOT?>js/themes/clb.js" defer></script> 
	  <script src="<?= WEB_ROOT?>js/themes/jquery.countdown.min.js"></script> 
	  <!--<script type='text/javascript' src='<?= WEB_ROOT?>js/plugins/jquery.form.min.js?ver=3.51.0-2014.06.20'></script> 
	  <script type='text/javascript' src='<?= WEB_ROOT?>js/plugins/scripts.js?ver=4.7'></script> 
	  <script type='text/javascript' src='<?= WEB_ROOT?>js/plugins/es-widget.js?ver=4.7.5'></script> 
	  <script type='text/javascript' src='<?= WEB_ROOT?>js/plugins/es-widget-page.js?ver=4.7.5'></script> 
	  <script type='text/javascript' src='<?= WEB_ROOT?>js/plugins/photostack.js?ver=X8VajN'></script> 
	  <script type='text/javascript' src='<?= WEB_ROOT?>js/plugins/jquery.ajaxsearchpro-noui-isotope.min.js?ver=X8VajN'></script> 
	  <script type='text/javascript' src='<?= WEB_ROOT?>js/plugins/core.min.js?ver=1.11.4'></script>
	  <script type='text/javascript' src='<?= WEB_ROOT?>js/plugins/datepicker.min.js?ver=1.11.4'></script> 
	  <script type='text/javascript' src='<?= WEB_ROOT?>js/plugins/wp-embed.min.js?ver=4.7.5'></script> -->
   