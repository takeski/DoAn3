<?php 
$d->SetTable("#_hinhanh");
$d->SetWhere("loai", "=", "logo");
$logo = reset($d->Select())["hinh"];
?>
<div class="logo"> <a href="index.php" target="_blank" onclick="return false;">
  <img src="<?=WEB_ROOT . $logo?>" alt="" style=" width: 100px; margin-left: -15px; ">
</a>
</div>
<div class="sidebarSep mt0"></div>
<!-- Left navigation -->
<ul id="menu" class="nav">
  <li class="dash" id="menu1"><a class="<?=!isset($_GET["com"]) ? "active" : ""?>" title="" href="<?=CUR_PATH?>"><span>Trang chủ</span></a></li>
  <li class="categories_li" id="menu2"><a class="<?=$_GET["com"] == "orders" ? "active" : ""?>" title="" href="<?=CUR_PATH?>?com=orders&act=man"><span>Quản lý đơn hàng</span></a></li>
  <li class="categories_li" ><a class="<?=$_GET["com"] == "client" ? "active" : ""?>" title="" href="<?=CUR_PATH?>?com=client&act=man"><span>Quản lý khách hàng</span></a></li>
  <li class="categories_li <?php if($_GET['com']=='baiviet') echo ' activemenu' ?>" id="menu5"><a href="" title="" class="exp <?= $_GET['com']=='baiviet' ? 'active' : '' ?>"><span>Quản lý bài viết</span><strong></strong></a>
    <ul class="sub">
     <li <?php if($_GET['type']=='gioi-thieu') echo ' class="this"' ?>><a href="<?=CUR_PATH?>?com=baiviet&act=man&type=tintuc">Tin tức</a></li>
     <li <?php if($_GET['type']=='chinh-sach-mua-hang') echo ' class="this"' ?>><a href="<?=CUR_PATH?>?com=baiviet&act=man&type=hotro">Hướng dẫn mua hàng</a></li>
     <li <?php if($_GET['type']=='dich-vu') echo ' class="this"' ?>><a href="<?=CUR_PATH?>?com=baiviet&act=man&type=chinhsach">Chính sách chung</a></li>
   </ul>
 </li>
 <li class="categories_li <?php if($_GET['com']=='product' || $_GET['com']=='danhmuc') echo ' activemenu' ?>" id="menu6"><a href="" title="" class="exp <?= $_GET['com']=='product' || $_GET['com']=='danhmuc' ? 'active' : '' ?>"><span>Quản lý sản phẩm</span><strong></strong></a>
  <ul class="sub">
   <li <?php if($_GET['level']=='1') echo ' class="this"' ?>><a href="<?=CUR_PATH?>?com=danhmuc&act=man_cat&level=1">Nhà sản xuất</a></li>
   <li <?php if($_GET['level']=='2') echo ' class="this"' ?>><a href="<?=CUR_PATH?>?com=danhmuc&act=man_cat&level=2">Nhóm sản phẩm</a></li>
   <li <?php if($_GET['com']=='product') echo ' class="this"' ?>><a href="<?=CUR_PATH?>?com=product&act=man">Quản lý sản phẩm</a></li>
 </ul>
</li>
<li class="template_li<?php if($_GET['com']=='setting' || $_GET['com']=='bannerqc' || $_GET['com']=='slides' || $_GET['com']=='mxh') echo ' activemenu' ?>" id="menu8"><a href="#" title="" class="exp <?= ($_GET['com']=='setting' || $_GET['com']=='bannerqc' || $_GET['com']=='slides' || $_GET['com']=='mxh') ? 'active' : '' ?>"><span>Thông tin Website</span><strong></strong></a>
  <ul class="sub">
	<li <?php if($_GET['type']=='logo') echo ' class="this"' ?>><a href="<?=CUR_PATH?>?com=bannerqc&act=capnhatlogo&type=logo" title="">Logo</a></li>
	<li <?php if($_GET['type']=='favicon') echo ' class="this"' ?>><a href="<?=CUR_PATH?>?com=bannerqc&act=capnhatlogo&type=favicon" title="">Favicon</a></li>
	<li <?php if($_GET['act']=='dsbannerqc') echo ' class="this"' ?>><a href="<?=CUR_PATH?>?com=bannerqc&act=dsbannerqc" title="">Banner quảng cáo</a></li>
	<li <?php if($_GET['com']=='slides') echo ' class="this"' ?>><a href="<?=CUR_PATH?>?com=slides&act=man_slides" title="">Slides</a></li>
	<li <?php if($_GET['com']=='mxh') echo ' class="this"' ?>><a href="<?=CUR_PATH?>?com=mxh&act=man" title="">Mạng xã hội</a></li>
	<li <?php if($_GET['com']=='setting') echo ' class="this"' ?>><a href="<?=CUR_PATH?>?com=setting&act=capnhat" title="">Cấu hình chung</a></li>

  </ul>
</li>
</ul>