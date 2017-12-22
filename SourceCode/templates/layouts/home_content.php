<?php
	require_once("libraries/dbhelper.php");
    $db = new DBHelper();

	$slider = $controller->Getslider();
	$news = $controller->GetNews();
	$hotproduct = $controller->GetProducthot();
	$video = $controller->GetVideo();
	$iphone = $controller->GetIphone();
	$android = $controller->GetAndroid();
	// $productiphone = $controller->GetProductIphone();
	// $productandroid = $controller->GetProductAndroid();
	$productiphone = $db->Query("SELECT sp.ten,sp.hinh,sp.duongdan,sp.gia,sp.ndtomtat FROM  tb_sanpham sp JOIN tb_nhomsp nsp  
	ON nsp.id = sp.idnhomsp LEFT JOIN tb_nhomsp nsp2 ON nsp.parentid = nsp2.id WHERE nsp2.ten = 'iphone' AND sp.noibat = 1 ORDER BY RAND() LIMIT 0,7");
	$productandroid = $db->Query("SELECT sp.ten,sp.hinh,sp.duongdan,sp.gia,sp.ndtomtat FROM  tb_sanpham sp JOIN tb_nhomsp nsp  
	ON nsp.id = sp.idnhomsp LEFT JOIN tb_nhomsp nsp2 ON nsp.parentid = nsp2.id WHERE nsp2.ten != 'iphone'  AND sp.noibat = 1 ORDER BY RAND() LIMIT 0,7");
	$bannerleft = $controller->GetBannerleft();
	$bannerright = $controller->GetBannerright();

?>

<div class="content">
	<div class="home__top top-content">
		<div class="container">
			<div class="row" style="margin: 0">
				<div class="home__top__cat categories col-md-3">
					<ul>
				
					</ul>
				</div>
				<div class="top-slide col-md-9">
					<div id="top-slides" class="flexslider">
					<ul class="slides">
						<?php foreach($slider as $value){?>
							<li> <a style="height: 370px;overflow: hidden;display:block" href="<?= WEB_ROOT . $value['duongdan']?>"><img src="<?= WEB_ROOT . $value['hinh']?>" alt="<?=  $value['ten']?>"></a></li>
						<?php }?>
					</ul>
					</div>
					<div id="top-slide-2" class="flexslider wrapper dots-custom">
					<ul class="arrow-steps clearfix slides">
						<?php foreach($slider as $value1){?>
							<li class="step"> <span><?=  $value1['ten']?></span></li>
						<?php }?>
					</ul>
					</div>
					<div id="top-slide">
					<div class="item"> <a href=""><img src="<?= WEB_ROOT?>images/slider/1-đổi-1.jpg" alt=""></a></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">

		<div class="banner-content">
			<div id="banner-content" class="row" >
				<div class="banner-item col-sm-4 col-xs-12"> <a href=""><img class="img-responsive" src="<?= WEB_ROOT?>images/banner/viber-image.jpg" alt=""></a></div>
				<div class="banner-item col-sm-4 col-xs-12"> <a href=""><img class="img-responsive" src="<?= WEB_ROOT?>images/banner/combo-4ANH.jpg" alt=""></a></div>
				<div class="banner-item col-sm-4 col-xs-12"> <a href=""><img class="img-responsive" src="<?= WEB_ROOT?>images/banner/9930.jpg" alt=""></a></div>
				<div class="banner-item col-sm-4 col-xs-12"> <a href=""><img class="img-responsive" src="" alt=""></a></div>
			</div>
		</div>

		</div>
		<div class="news container" style="padding-top:20px;">
		<a class="news-title pull-left" href="<?= WEB_ROOT?>tin-tuc">Tin Tức</a> <a class="pull-right views-all-news" href="<?= WEB_ROOT?>tin-tuc" style="color:#333;font:400 15px Roboto;">Xem tất cả</a>
		<div class="news-child">
			<div class="clearfix"></div>
			<div class="news-slide tab-content">
				<div id="news-slide-tkm" class="tab-pane fade in active">

					<?php foreach($news as $value){?>
						<div class="item">
						<a href="<?= WEB_ROOT . $value['duongdan']?>"><img width="300" height="130" src="<?= WEB_ROOT . $value['hinh']?>" class="attachment-medium size-medium wp-post-image" alt="" 
						srcset="<?= WEB_ROOT . $value['hinh']?>" sizes="(max-width: 300px) 100vw, 300px" /></a> 
						<a class="opacity" href="<?= WEB_ROOT ."chi-tiet-tin-tuc/". $value['duongdan']?>"></a> 	
						<a class="title" href="<?= WEB_ROOT ."chi-tiet-tin-tuc/". $value['duongdan']?>">
						
						<?=$value['ten']?></a>
						<p class="cm-like"> <span class="cm pull-left"><i class="fa fa-eye" aria-hidden="true"></i> <?= $value['luotxem']?></span></p>
						</div>
					<?php }?>
					
				</div>
				
				<div class="prev1"><i class="fa fa-angle-left"></i></div>
				<div class="next1"><i class="fa fa-angle-right"></i></div>
			</div>
		</div>
		</div>
		<div class="content-middle">
		<div class="container">

			<div class="two-col row">

				<div class="hot-products col-xs-8">
					<div class="hot-products-header"> <a class="hot-product-cat active p-hot">Sản phẩm hot</a></div>
					<div class="hot-products-content">
					<div class="hot-products-slide">

						<?php foreach($hotproduct as $value){?>

							<div class="item"> 
								<a class="two-col-img" <a  rel='a' alt='vdssvd'  Title="<?= $value['ndtomtat']?>" href="<?= WEB_ROOT ."chi-tiet-san-pham/".$value['duongdan']?>">
								<img width="300" height="350" src="<?= WEB_ROOT. $value['hinh']?>" class="attachment-medium size-medium wp-post-image" alt="" />
								</a> 
								<span class="title text-center"><?= $value['ten']?></span> <span class="price text-center"><?= number_format($value['gia']) ?> đ </span>	
							</div>	
						<?php }?>
					</div>
					<div class="prev2"><img src="<?= WEB_ROOT?>images/icon/prev2.png"></div>
					<div class="next2"><img src="<?= WEB_ROOT?>images/icon/next2.png" alt=""></div>
					</div>
				</div>

				<div class="hot-videos col-xs-4">
					<div class="hot-videos-header">
					<a class="hot-videos-cat active pull-left" href="">VIDEO HOT</a> <a class="hot-videos-cat pull-right" href=""> </a>
					<div class="clearfix"></div>
					</div>
					<div class="hot-videos-content" style="padding:15px 10px;">
					<div class="hot-videos-content-slide">
						<?php foreach($video as $value){?>
							<div class="item"> <iframe width="330" height="350" src="<?= $value['video']?>" frameborder="0" allowfullscreen></iframe></div>
						<?php }?>
					</div>
					<div class="hot-videos-control hot-videos-control-left"> <i class="fa fa-chevron-left" aria-hidden="true"></i></div>
					<div class="hot-videos-control hot-videos-control-right"> <i class="fa fa-chevron-right" aria-hidden="true"></i></div>
					</div>
				</div>

			</div>

			<div class="cat row">
				<div class="cat-header">
					<a class="title pull-left">Điện thoại Iphone</a>
					<ul class="cat-item nav nav-pills pull-right">
						<li class="active"><a class="list-cat-item-right" data-toggle="pill" href="#sp-hot-1">HOT</a></li>
						<?php foreach($iphone as $value){?>
							<li><a class="list-cat-item-right" data-toggle="pill" href="#box-<?php echo rand(1,9999);?>" title=""><?= $value['ten']?> </a></li>
						<?php }?>
					
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="cat-content row">
					<div class="cat-banner pull-left"> 
						<a href="<?= WEB_ROOT?>">
							<img src="<?= WEB_ROOT. $bannerleft['hinh']?>" alt="<?= $bannerleft['ten']?>" style="padding-right: 10px;">
						</a>
					</div>
					<div class="products tab-content pull-right">

					<div class="row tab-pane fade in active" id="sp-hot-1">

						<?php foreach($productiphone as $value){?>

							<div class="product__category__content__item col-md-3 col-sm-4 col-xs-6 item">
								<a class="product__category__content__item__link text-center"  rel='a' alt='vdssvd'  Title="<?= $value['ndtomtat']?>" href="<?= WEB_ROOT ."chi-tiet-san-pham/". $value['duongdan']?>">
									<div class="product__category__content__item__link__img"> <img class="img-responsive" src="<?= WEB_ROOT . $value['hinh']?>"></div>
									<div class="product__category__content__item__link__title"><?= $value['ten']?></div>
									<div class="product__category__content__item__link__price"><?= number_format($value['gia']) ?> đ</div>
								</a>
							</div>
						<?php }?>

						<div class="col-md-3 col-sm-4 col-xs-6 product__category__content__item">
						 <a class="product__category__content__item__link see-more-1" href="<?= WEB_ROOT?>danh-muc-san-pham/iphone">
						 	<i class="fa fa-play fa-4x" aria-hidden="true"></i
						 ></a> 
						<a class="see-more-1-bt" href="<?= WEB_ROOT?>danh-muc-san-pham/iphone">Xem thêm</a>
						</div>
					</div>


					</div>
				</div>
			</div>
			
			<div class="cat row">
				<div class="cat-header">
					<a class="title pull-left andr">Điện thoại Android</a>
					<ul class="cat-item nav nav-pills pull-right">
					<li class="active"><a class="list-cat-item-right" data-toggle="pill" href="#sp-hot-2">HOT</a></li>
					<?php foreach($android as $value){?>
							<li><a class="list-cat-item-right" data-toggle="pill" href="#box-<?php echo rand(1,9999);?>" title=""><?= $value['ten']?> </a></li>
						<?php }?>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="cat-content row">
					<div class="products tab-content pull-left">
						<div class="row tab-pane fade in active" id="sp-hot-2">
		
							<?php foreach($productandroid as $value){?>
								<div class="product__category__content__item col-md-3 col-sm-4 col-xs-6 item">
									<a class="product__category__content__item__link text-center"  rel='a' alt='vdssvd'  Title="<?= $value['ndtomtat']?>" href="<?= WEB_ROOT ."chi-tiet-san-pham/" . $value['duongdan']?>">
										<div class="product__category__content__item__link__img"> <img class="img-responsive" src="<?= WEB_ROOT . $value['hinh']?>"></div>
										<div class="product__category__content__item__link__title"><?= $value['ten']?></div>
										<div class="product__category__content__item__link__price"> <?= number_format($value['gia']) ?> đ</div>
									</a>
								</div>
							<?php }?>
										
							<div class="col-md-3 col-sm-4 col-xs-6 product__category__content__item">
								<a class="product__category__content__item__link see-more-1" href="<?= WEB_ROOT?>danh-muc-san-pham/android">
								<i class="fa fa-play fa-4x" aria-hidden="true"></i></a> 
								<a class="see-more-1-bt" href="<?= WEB_ROOT?>danh-muc-san-pham/android">Xem thêm</a>
							</div>
						</div>
						
					</div>
					<div class="cat-banner right pull-right"> <a href=""><img src="<?= WEB_ROOT. $bannerright['hinh']?>" alt="<?= $bannerright['ten']?>" style="padding-left: 10px;"></a></div>
				</div>
			</div>

		</div>
	</div>
</div>

	<script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('.item a').cluetip({
                width: '250px',
                showTitle: true,
                positionBy: 'topBottom',
                topOffset: 20,
                cluezIndex: 100
            });
        });
    </script>
