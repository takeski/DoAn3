<?php 
    require_once("libraries/dbhelper.php");
    $db = new DBHelper();
	
	$link = substr($_SERVER['REQUEST_URI'], +10);
	$db->SetTable("#_baiviet");
	$db->SetWhere("duongdan", "=", $link);
	$db->SetLimit("1");
	$article = reset($db->Select());

?>
<div class="content">
   <div class="news-content">
        <div class="cats-breadcrumb container"> <span typeof="v:Breadcrumb">
            <a rel="v:url" property="v:title" title="Go to Clickbuy." href="<?= WEB_ROOT?>" class="home">
            <i class="fa fa-home"></i> Trang chủ</a></span> <i class="fa fa-caret-right"></i> <span typeof="v:Breadcrumb">
            <span property="v:title"><?= $article['ten']?></span></span>
        </div>
        <div class="the_content container">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="kh-title"><?= $article['ten']?></h3>
                    <p style="text-align: justify;"><?= $article['noidung']?></p>
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
                                <iframe id="f1c858ccbd94e48" name="f3c8795ee5d08fc" scrolling="no" title="Facebook Social Plugin" class="fb_ltr" 
                                src=""//www.facebook.com/plugins/follow?href=https%3A%2F%2Fwww.facebook.com%2Fprofile.php%3Fid%3D100010944286101&amp;layout=standard&amp;show_faces=true&amp;colorscheme=light&amp;width=450&amp;height=80" style="border: none; overflow: hidden; height: 176px; width: 100%;">
                                </iframe>
                            </span>
                        </div>
                   
                    </div>

                </div>
            </div>
        </div>
        
    </div>
</div>