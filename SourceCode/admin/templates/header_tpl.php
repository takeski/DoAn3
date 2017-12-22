<?php	
	$d->SetTable("#_thongtin");
    $lstResults = $d->Select("COUNT(*) as num");
    $row_lienhe = reset($lstResults);

	$d->SetTable("#_donhang");
	$d->SetWhere("trangthai", "=", "danggiaohang");
    $lstResults = $d->Select("COUNT(*) as num");
    $row_giohang = reset($lstResults);  

    // $tong_count += $row_giohang["num"] + $row_lienhe["num"];
    $tong_count += $row_giohang["num"] ;
?>
	<div class="wrapper">
        <div class="welcome"><a href="#" title=""><img src="<?=CUR_PATH?>/images/userPic.png" alt="" /></a><span>Xin chào, <?=$session_user['username']?>!</span></div>
        <div class="userNav">
            <ul>

                <li><a href="/" title="" target="_blank"><img src="<?=CUR_PATH?>/images/icons/topnav/mainWebsite.png" alt="" /><span>Vào trang web</span></a></li>

                <li><a href="<?=CUR_PATH?>?com=user&act=admin_edit" title=""><img src="<?=CUR_PATH?>/images/icons/topnav/profile.png" alt="" /><span>Thông tin tài khoản</span></a></li>
                <li class="ddnew"><a title=""><img src="<?=CUR_PATH?>/images/icons/topnav/messages.png" alt="" /><span>Thông báo</span><span class="numberTop"><?=$tong_count?></span></a>
                    <ul class="userMessage">
                        <!--<li><a href="<?=CUR_PATH?>?com=baiviet&act=man&type=lien-he" title="" class="sInbox"><span>Liên hệ</span> <span class="numberTop" style="float:none; display:inline-block"><?=$row_lienhe['num']?></span></a></li>-->
						<li><a href="<?=CUR_PATH?>?com=orders&act=man" title="" class="sInbox"><span>Đơn hàng</span> <span class="numberTop" style="float:none; display:inline-block"><?=$row_giohang['num']?></span></a></li>
                    </ul>
                </li>
                <li><a href="<?=CUR_PATH?>?com=user&act=logout" title=""><img src="<?=CUR_PATH?>/images/icons/topnav/logout.png" alt="" /><span>Đăng xuất</span></a></li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
	<span style="visibility: hidden;">1<br/>1<span>