<?php
	$info = $controller->GetInfo();
	$mxh = $controller->GetMangXaHoi();
	$location = explode(",", $info["location"]);
?>
<div class="news-content">
	<div class="cats-breadcrumb container">
		<!-- Breadcrumb NavXT 5.7.0 -->
		<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" title="Go to Clickbuy: Hệ thống bán lẻ điện thoại di động toàn quốc." href="https://clickbuy.com.vn" class="home"><i class="fa fa-home"></i> Trang chủ</a></span> <i class="fa fa-caret-right"></i> <span typeof="v:Breadcrumb"><span property="v:title">Liên hệ</span></span>				
	</div>
	<div class="the_content container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="kh-title">Liên hệ</h3>
				<p><span style="font-size: 12pt; font-family: arial, helvetica, sans-serif;">
					<img class="size-full wp-image-4220 aligncenter" src="<?= WEB_ROOT?>images/logo/logo-clickbuy1.png" 
					alt="logo-clickbuy" width="1106" height="397" srcset="<?= WEB_ROOT?>images/logo/logo-clickbuy1.png" sizes="(max-width: 1106px) 100vw, 1106px"></span></p>
				<p><span style="font-size: 12pt; font-family: arial, helvetica, sans-serif;">– Địa chỉ:&nbsp;<a><?=$info["diachi"]?></p>
				<p><span style="font-size: 12pt; font-family: arial, helvetica, sans-serif;">– Hotline:&nbsp;<a><?=$info["hotline"]?></p>
				<p><span style="font-size: 12pt; font-family: arial, helvetica, sans-serif;">– Số điện thoại: <strong><?=$info["sdt"]?></strong></span></p>
				<p><span style="font-size: 12pt; font-family: arial, helvetica, sans-serif;"><strong>EMAIL</strong>: <?=$info["email"]?></span></p>
				<?php
					foreach ($mxh as $m) { ?>
						<p><span style="font-size: 12ptfont-family: arial, helvetica, sans-serif;"><strong><?=$m["ten"]?></strong>: <a href="<?=$m["duongdan"]?>"><?=$m["ten"]?></a></span></p>
					<?php }
				?>
				<p>&nbsp;</p>
			</div>
			<div id="map" style="margin: 0px auto; width: 80%; height: 300px;"></div>
			<script>
				function initMap() {
					var pos = {lat: <?php echo $location[0]; ?>, lng: <?php echo $location[1]; ?>};
					var map = new google.maps.Map(document.getElementById('map'), {
						zoom: 16,
						center: pos
					});
					
					var marker = new google.maps.Marker({
						position: pos,
						map: map,
						title: '<?=$info["tên"]?>: <?=$info["diachi"]?>'
					});
					
					marker.addListener('click', function() {
						infowindow.open(map, marker);
					});
					
					if (document.getElementById('map_contact') !== null) {
						var map_contact = new google.maps.Map(document.getElementById('map_contact'), {
							zoom: 16,
							center: pos
						});
						
						var marker_contact = new google.maps.Marker({
							position: pos,
							map: map_contact,
							title: '<?=$info["tên"]?>: <?=$info["diachi"]?>'
						});
						
						marker_contact.addListener('click', function() {
							infowindow.open(map_contact, marker_contact);
						});
					}
				}
			</script>
			<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBN7Uz-nG0dw9YsuuWkrwqzLtH3c3scuow&callback=initMap"></script>
		</div>
	</div>
</div>