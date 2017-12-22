<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
          <li><a href="<?=CUR_PATH?>?com=bannerqc&act=capnhatlogo<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Quản Lý Logo</span></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="<?=CUR_PATH?>?com=bannerqc&act=savelogo<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" method="post" enctype="multipart/form-data">
  <div class="widget">
    <div class="formRow lang_hidden lang_vi active" >
      <label>Tải logo :</label>
      <div class="formRight">
              <input type="file" id="file" name="file" />
        <img src="<?=CUR_PATH?>/images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
        <div class="note"> width : 112px , Height :100px </div> 
      </div>
      <div class="clear"></div>
    </div>

    <div class="formRow lang_hidden lang_vi active">
      <label>Logo Hiện Tại :</label>
      <div class="formRight">
       <div class="mt10"><img  src="/<?=$item['hinh']?>"  alt="NO PHOTO" width="100" /> </div>
          <input type="text" name="imgHientai" style="display:none;" value="<?= $item['hinh'] ?>" />
      </div>
      <div class="clear"></div>
    </div>

      <div class="formRow">
        <div class="formRight">
              <input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
        </div>
      <div class="clear"></div>
    </div>
    
  </div>
</form></div>