<?php 
    require_once("libraries/dbhelper.php");
    $db = new DBHelper();
	
	$link = substr($_SERVER['REQUEST_URI'], +18);
	$db->SetTable("#_baiviet");
	$db->SetWhere("duongdan", "=", $link);
	$db->SetLimit("1");
	$article = reset($db->Select());
    $db->Query("UPDATE  tb_baiviet  SET luotxem = luotxem+1 WHERE duongdan = '$link' ");

    $news = $db->Query("SELECT * FROM tb_baiviet WHERE loai='tintuc' ORDER BY RAND() LIMIT 6 ");
?>

<div class="content">
   <div class="news-content">
      <div class="cats-breadcrumb container"> 
        <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" title="Go to ThanhThai." href="<?= WEB_ROOT?>" class="home">
            <i class="fa fa-home"></i> Trang chủ</a>
        </span> 
        <i class="fa fa-caret-right"></i> 
        <span typeof="v:Breadcrumb">
            <a rel="v:url" property="v:title" title="Go to the Tin tức Danh Mục Tin Tức archives." href="<?= WEB_ROOT ."tin-tuc"?>">Tin tức</a>
        </span> 
        <i class="fa fa-caret-right"></i> 
        <span typeof="v:Breadcrumb"><span property="v:title"> <?= $article['ten']?> </span></span></div>
      <div class="the_content container">
         <div class="row">
            <div class="col-sm-8">
               <h3 class="kh-title"><?= $article['ten']?></h3>
               <div class="kh-title-bottom"> <span class="date"><?= date('m/d/Y H:i:s', $article['thoigiandang']) ?></span> <span class="view"><?= $article['luotxem']?> lượt xem</span></div>
                 <p style="text-align: justify;"><?= $article['noidung']?></p>
               
            </div>
            <div class="col-sm-4">
               <div class="widget-sidebar">
                  <h3 class="widget-header">Bài viết liên quan</h3>
                  <div class="widget-content">
                     <ul class="popular-widget">
                        <?php foreach($news as $value){?>
                            <li>
                                <a class="sidebar-new-img pull-left" href="<?=WEB_ROOT."chi-tiet-tin-tuc/". $value['duongdan']?>"><img width="150" height="150" 
                                src="<?=WEB_ROOT. $value['hinh']?>" class="attachment-thumbnail size-thumbnail wp-post-image" alt=""></a>
                                <a class="sidebar-new-title" href="<?=WEB_ROOT."chi-tiet-tin-tuc/". $value['duongdan']?>"><?= $value['ten']?></a>
                                <div class="clearfix"></div>
                            </li>
                        <?php }?>
                       
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
    <div class="detail-cm">
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
                            <iframe id="f1c858ccbd94e48" name="f3c8795ee5d08fc" scrolling="no" title="Facebook Social Plugin" class="fb_ltr" src="https://www.facebook.com/plugins/comments.php?api_key=&amp;channel_url=http%3A%2F%2Fstaticxx.facebook.com%2Fconnect%2Fxd_arbiter%2Fr%2FXBwzv5Yrm_1.js%3Fversion%3D42%23cb%3Df34f409e184ac8%26domain%3Dhcm.clickbuy.com.vn%26origin%3Dhttp%253A%252F%252Fhcm.clickbuy.com.vn%252Ff240d1f5ba8c4c8%26relation%3Dparent.parent&amp;colorscheme=light&amp;href=http%3A%2F%2Fhcm.clickbuy.com.vn%2Fgioi-thieu&amp;locale=en_US&amp;numposts=5&amp;sdk=joey&amp;skin=light&amp;version=v2.3&amp;width=100%25" style="border: none; overflow: hidden; height: 176px; width: 100%;">
                            </iframe>
                        </span>
                    </div>
                
                </div>

            </div>
        </div>
    </div>
</div>