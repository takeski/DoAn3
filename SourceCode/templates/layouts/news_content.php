<?php
	$news = $controller->GetNews();

?>

<div class="content">
   <div class="news-content">
      <div class="cats-breadcrumb container"> <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" title="Go to Clickbuy." href="<?= WEB_ROOT?>" class="home"><i class="fa fa-home"></i> Trang chủ</a></span> <i class="fa fa-caret-right"></i> <span typeof="v:Breadcrumb"><span property="v:title">Tin tức</span></span></div>

      <div class="news-bt container" style="padding-bottom:25px;">
         <div class="row">
            <div class="news-left col-md-9 col-xs-12">
               <!--<div class="news-slide-prev"> <i class="fa fa-angle-left" aria-hidden="true"></i></div>
               <div class="news-slide-next"> <i class="fa fa-angle-right" aria-hidden="true"></i></div>-->

                <?php foreach($news as $value){?>
                  <div class="news-left-item">
                      <a class="image pull-left" href="<?= WEB_ROOT ."chi-tiet-tin-tuc/". $value['duongdan']?>">
                      <img width="640" height="513" src="<?= WEB_ROOT . $value['hinh']?>" class="attachment-full size-full wp-post-image" alt="<?= $value['ten']?>" srcset="<?= WEB_ROOT . $value['hinh']?>" sizes="(max-width: 640px) 100vw, 640px"></a>
                      <div class="pull-right">
                        <a class="title" href="<?= WEB_ROOT ."chi-tiet-tin-tuc/". $value['duongdan']?>"><?= $value['ten']?></a> 
                        <span class="des">
                            <p> <?= mb_substr($value['ndtomtat'],0,30) ." ..." ?></p>
                        </span>
                        <span class="date"><?= date('m/d/Y H:i:s', $value['thoigiandang']) ?></span> <span class="view"><?=  $value['luotxem']?> lượt xem</span>
                      </div>
                      <div class="clearfix"></div>
                  </div>
                <?php }?>

               <!--<div class="wp-pagenavi"> <span class="pages">Page 1 of 66</span><span class="current">1</span>
               <a class="page larger" href="http://hcm.clickbuy.com.vn/danh-muc-tin-tuc/tin-tuc/page/2">2</a>
               <a class="page larger" href="http://hcm.clickbuy.com.vn/danh-muc-tin-tuc/tin-tuc/page/3">3</a>
               <span class="extend">...</span>-->
               <!--<a class="nextpostslink" rel="next" href="http://hcm.clickbuy.com.vn/danh-muc-tin-tuc/tin-tuc/page/2">»</a>
               <a class="last" href="http://hcm.clickbuy.com.vn/danh-muc-tin-tuc/tin-tuc/page/66">Last »</a></div>-->
            </div>
            <div class="news-product col-md-3 col-xs-12">
               <div class="news-product-title">Sản phẩm trong tháng</div>
            </div>
         </div>
      </div>
   </div>
 
  </div>