<script type="text/javascript">   

  $(document).ready(function() {
    $('.chonngonngu li a').click(function(event) {
      var lang = $(this).attr('href');
      $('.chonngonngu li a').removeClass('active');
      $(this).addClass('active');
      $('.lang_hidden').removeClass('active');
      $('.lang_'+lang).addClass('active');
      return false;
    });
});
</script>
 <?php
          if(_width_thumb < 800){
            $rong = _width_thumb;
            $cao = _height_thumb;
          } else {
            $rong = 800;
            $cao = '';
          }
      ?>
<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
          <li><a href="index.php?com=bannerqc&act=capnhat<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Quản lý Banner</span></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="index.php?com=bannerqc&act=savebanner<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" method="post" enctype="multipart/form-data">
  <div class="widget">

    <div class="title chonngonngu">
    <ul>
      <li><a href="vi" class="active tipS validate[required]" title="Chọn tiếng việt "><img src="./images/vi.png" alt="" class="tiengviet" />Tiếng Việt</a></li>
      <li><a href="en" class="tipS validate[required]" title="Chọn tiếng anh "><img src="./images/en.png" alt="" class="tienganh" />Tiếng Anh</a></li>
    </ul>
    </div>  

    <div class="formRow lang_hidden lang_vi active" >
      <label>Tải hình :</label>
      <div class="formRight">
              <input type="file" id="file" name="file" />
        <img  src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
        <div class="note"> width : 1349px , Height :180px </div>
      </div>
      <div class="clear"></div>
    </div>

    <div class="formRow lang_hidden lang_vi active">
      <label><?=$title_main?> Hiện Tại :</label>
      <div class="formRight"> 
        <div class="mt10">
          <div class="mt10"><img style="width:300px;" src="<?= '../'.$item['hinh']?>"  alt="NO PHOTO" width="100" /> </div>
            <input type="text" name="imgHientai" style="display:none;" value="<?= $item['hinh'] ?>" />
        </div>
      </div>
      <div class="clear"></div>
    </div>

     <?php if($_GET['type']=='banner'){?>
        <div class="formRow">
            <label>Tên:</label>
            <div class="formRight">
                <input type="text" name="ten" value="<?=$item['ten']?>"  title="Nhập tên cho hình ảnh" class="tipS" />
            </div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <label>Link liên kết:</label>
            <div class="formRight">
                <input type="text" name="link" value="<?=$item['link']?>"  title="Nhập link liên kết cho hình ảnh" class="tipS" />
            </div>
            <div class="clear"></div>
        </div>
        <?php }  ?>

        <div class="formRow">
          <label>Ẩn Hiện : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này ! "> </label>
          <div class="formRight">
         
            <input type="checkbox" name="anhien" id="check1" value="1" <?=(!isset($item['anhien']) || $item['anhien']==1)?'checked="checked"':''?> />
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