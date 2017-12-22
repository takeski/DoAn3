<?php 
    $menu = $controller->GetMenu();
    require_once("libraries/dbhelper.php");
    $db = new DBHelper();

    $sanpham = $db->Query("SELECT * FROM tb_sanpham WHERE gia BETWEEN ".$_GET['giatu']." AND ".$_GET['giaden']." ORDER BY gia ");
?>

<div class="content">
   <div class="cats-breadcrumb container" style="padding: 10px 15px;"> 
       <span typeof="v:Breadcrumb">
           <a rel="v:url" property="v:title" title="Go to ThanhThai." href="<?= WEB_ROOT?>" class="home">
           <i class="fa fa-home"></i> Trang chủ</a></span> 
           <i class="fa fa-caret-right"></i> 
           <span typeof="v:Breadcrumb"><span property="v:title" >Kết quả tìm kiếm</span>
        </span>
    </div>
   <div class="cats-banner container">
      <div class="col-md-6 col-xs-12">
         <p><img class="alignnone size-full wp-image-14729" src="<?= WEB_ROOT?>images/banner/Banner-iphone-clickbuy.png" alt="Banner-iphone-clickbuy" width="800" height="137"></p>
      </div>
      <div class="col-md-6 col-xs-12">
         <p><a href=""><img class="alignnone size-full wp-image-14773" src="<?= WEB_ROOT?>images/banner/580x102.png" alt="580x102" width="580" height="102"></a></p>
      </div>
   </div>

   <div class="product__category p-content container-fluid">
      <div class="product__category__top cats-tab container">
         <ul class="nav nav-pills nav-justified">
            <li><a href=""> Kết quả tìm kiếm với giá từ <?= number_format($_GET["giatu"])?> đ đến <?= number_format($_GET["giaden"])?> đ </a></li>
         </ul>
      </div>
      <div class="product__category__content tab-content container">
         <div class="row" style="margin-left: -10px;margin-right: -10px;">
            <?php if ($sanpham == NULL){ 
             echo "<h2 style='text-align:center'> hiện chưa có sản phẩm phù hợp với giá này </h2>";
            }else{?>
                <?php foreach($sanpham as $value){?>
                    <div class="product__category__content__item col-md-5ths col-sm-4 col-xs-6 aaaaa">
                    <a class="product__category__content__item__link text-center" rel='a' alt='vdssvd'  Title="<?= $value['ndtomtat']?>" href="<?= WEB_ROOT."chi-tiet-san-pham/". $value['duongdan']?>">
                        <div class="product__category__content__item__link__img"> <img class="img-responsive" src="<?= WEB_ROOT . $value['hinh']?>"></div>
                        <div class="product__category__content__item__link__title"><?= $value['ten']?></div>
                        <div class="product__category__content__item__link__price"> <?= number_format($value['gia'] )?> đ</div>
                    </a>
                    </div>
                <?php }?>
            <?php }?>

         </div>
         <!--<div class="row">
            <div class="col-sm-12">
               <div class="wp-pagenavi"> <span class="pages">Page 1 of 1</span><span class="current">1</span></div>
            </div>
         </div>-->
      </div>
   </div>

</div>
	<!--<script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('.aaaaa a').cluetip({
                width: '250px',
                showTitle: true,
                positionBy: 'topBottom',
                topOffset: 20,
                cluezIndex: 100
            });
        });
    </script>-->