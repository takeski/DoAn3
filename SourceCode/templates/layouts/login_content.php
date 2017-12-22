<style>
    h2{
        text-align:center;
    }
    .lb{
        margin-bottom: 5px;
        font-weight:700;
    }
</style>
<?php 
  $link = substr($_SERVER['REQUEST_URI'], +1);

if($link =="dang-nhap"){?>
  <div id="row">
    <div class="col-md-12">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">

            <h2 class="tt-txt">Đăng nhập</h2>

            <div class="primary-form">
                <div class="form-row">
                    <div class="lb">
                    </div>
                </div>
                <div class="form-row">
                    <div class="lb">Tên đăng nhập</div>
                    <input name="username" type="text" id="username" class="form-control" placeholder="Tên đăng nhập ">
                    <div class="clearfix"></div>
                    <span class="error-info-show">
                    <span id="ContentPlaceHolder1_RequiredFieldValidator1" style="color:Red;visibility:hidden;">Không được để trống.</span>
                    </span>
                </div>
                <div class="form-row">
                    <div class="lb">Mật khẩu đăng nhập</div>
                    <input name="password" type="password" id="password" class="form-control"   onkeypress="return CheckEnter(event);" placeholder="Mật khẩu đăng nhập">
                    <div class="clearfix"></div>
                    <span class="error-info-show">
                    <span id="ContentPlaceHolder1_RequiredFieldValidator5" style="color:Red;visibility:hidden;">Không được để trống.</span>
                    </span>
                </div>
                <div class="form-row" style="text-align: center;    margin-bottom: 15px;">
                    <a href="<?= WEB_ROOT?>quen-mat-khau" title="Lấy lại pass bằng email" style="margin-right: 15px;">Quên mật khẩu</a> |
                    <a href="<?= WEB_ROOT?>dang-ky" style="margin-left: 15px" title="Đăng ký tài khoản mới">Đăng ký tài khoản mới</a>
                </div>
                <div class="form-row btn-row">    
                    <input   type="submit" name="dangnhap" value="Đăng Nhập" onclick="Login();" id="btn-dangnhap"  class="btn btn-danger btn-block pill-btn primary-btn" >
                </div>
            </div>

        </div>
        <div class="col-md-4">
        </div>
    </div>
  </div>
<?php }
if($link =="dang-ky"){
 ?> 

  <div id="row">
    <div class="col-md-12">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <h2 class="tt-txt">Đăng ký</h2>
            <div class="primary-form">
            <div class="form-row">
                <div class="lb">
                </div>
            </div>
    
            <div class="form-row">
                <div class="lb">Họ tên</div>
                <input name="regfullname" type="text" id="regfullname" class="form-control" placeholder="họ tên">
                <div class="clearfix"></div>
                <span class="error-info-show">
                <span id="ContentPlaceHolder1_RequiredFieldValidator7" style="color:Red;visibility:hidden;">Không được để trống.</span>
                </span>
            </div>

            <div class="form-row">

                <div class="form-group-right">
                    <div class="lb">Số điện thoại</div>
                    <input name="ctl00$ContentPlaceHolder1$txtPhone" type="text" maxlength="11" id="rgphonenumber" class="form-control" placeholder="Số điện thoại" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57">
                </div>
                <div class="clearfix"></div>
                <span class="error-info-show">
                <span id="ContentPlaceHolder1_RequiredFieldValidator4" style="color:Red;visibility:hidden;">Không được để trống.</span>
                </span>
            </div>

            <div class="form-row">
                <div class="lb">Địa chỉ</div>
                <input name="regaddress" type="text" id="regaddress" class="form-control has-validate" placeholder="Địa chỉ">
                <span class="error-info-show">
                <span id="ContentPlaceHolder1_RequiredFieldValidator1" style="color:Red;visibility:hidden;">Không được để trống.</span>
                </span>
            </div>

            <div class="form-row">
                <div class="lb">Email</div>
                <input name="regemail" type="text" id="regemail" class="form-control has-validate" placeholder="Email">
                <span class="error-info-show">
                <span id="ContentPlaceHolder1_RequiredFieldValidator3" style="color:Red;visibility:hidden;">Không được để trống.</span>
                </span>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <span class="error-info-show">
                <span id="ContentPlaceHolder1_RegularExpressionValidator1" style="visibility:hidden;">Sai định dạng Email</span>
                </span>
            </div>
            <div class="form-row">
                <div class="lb">Tên đăng nhập / Nickname:</div>
                <input name="regusername" type="text" id="regusername" class="form-control has-validate" placeholder="Tên đăng nhập / Nickname">
                <span class="error-info-show">
                <span id="ContentPlaceHolder1_RequiredFieldValidator2" style="color:Red;visibility:hidden;">Không được để trống.</span>
                </span>
                <div class="clearfix"></div>
            </div>
            <div class="form-row">
                <div class="lb">Mật khẩu</div>
                <input name="regpassword" type="password" id="regpassword" class="form-control has-validate" placeholder="Mật khẩu đăng nhập" >
                <span class="error-info-show">
                <span id="ContentPlaceHolder1_rq" style="color:Red;visibility:hidden;">Không được để trống.</span>
                </span>
                <span id="strength"></span>
            </div>
            <div class="form-row">
                <div class="lb">Xác nhận mật khẩu</div>
                <input name="regcfgpassword" type="password" id="regcfgpassword" class="form-control has-validate" placeholder="Xác nhận mật khẩu" onkeypress="return CheckEnter(event);">
                <span class="error-info-show">
                <span id="ContentPlaceHolder1_RequiredFieldValidator1" style="color:Red;visibility:hidden;">Không được để trống.</span>
                <br>
                <span id="ContentPlaceHolder1_CompareValidator1" style="color:Red;visibility:hidden;">Không trùng với mật khẩu.</span>
                </span>
            </div>
            <div class="form-row btn-row">
                <input type="submit" name="btn-dangky" value="Đăng ký" onclick="register();" id="btn-dangky" class="btn btn-danger btn-block pill-btn primary-btn">
            </div>

            </div>
        </div>
         <div class="col-md-4">
        </div>

    </div>
  </div>
<?php }
if ($link =="quen-mat-khau"){?>
    <div id="row">
        <div class="col-md-12">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                    <h2 class="tt-txt">Quên mật khẩu</h2>

                    <div class="primary-form">
                        <div class="form-row">
                            <div class="lb">
                            </div>
                        </div>
                        <div class="form-row" style="    margin-bottom: 20px;">
                            <div class="lb">Email</div>
                        
                            <input name="sendtomail" type="text" id="sendtomail" class="form-control has-validate" placeholder="Nhập email để lấy lại Mật khẩu">

                            <div class="clearfix"></div>   
                        </div>
                        <div class="form-row btn-row">
                            <input style="padding:2px;" type="submit" name="btn_guimail" value="Gửi mật khẩu vào mail"   onclick="guimail();"  id="btn_guimail" class="btn btn-danger btn-block pill-btn primary-btn">
                        </div>
                        <?php 
                            $db = new DBHelper();
                            $db->SetTable("#_taikhoan");
                            // $db->SetWhere("email","=",$_REQUEST);
                            $email = $db->Select();
                            ?>
                    </div>

            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
<?php }?>

<script type="text/javascript">

    function CheckEnter(e) {
        if (e.keyCode == 13) {
            $("#btn-dangnhap,#btn-dangky").click();
            return false;
        }
    }
	function Login() {
		var username = $("#username").val();
		var password = $("#password").val();

		if (username == "") {
			alert("Tên đăng nhập không được để trống");
			return false;
		}

		if (password == "") {
			alert("Mật khẩu không được để trống");
			return false;
		}

		$.ajax({
		  url: "<?= WEB_ROOT?>functions/check_login.php",
		  method: "POST",
		  data: {"username": username, "password": password, "act": "login"},
		  success: function(response){
              if(response==0){
                 alert("Tài Khoản hoặc mật khẩu sai !");
                 return;
              }
              if(response){
                //   alert("Đăng Nhập Thành Công !");
                  window.location="<?= WEB_ROOT?>";
              }

               
		  }
          
		});
	}
</script>

<script type="text/javascript">

	function register(){
	var username = $("#regusername").val();
    var password = $("#regpassword").val();
    var address = $("#regaddress").val();   
    var cfpassword = $("#regcfgpassword").val();
    var fullname = $("#regfullname").val();
    var email = $("#regemail").val();
    var phonenumber = $("#rgphonenumber").val();


    if(password != cfpassword){
      alert("mật khẩu xác nhận sai !");
      return false;
    }
    
    if (phonenumber == "") {
        alert("Số điện thoại không được để trống");
        return false;
    }

    if (address == "") {
        alert("Số điện thoại không được để trống");
        return false;
    }

    if (username == "") {
        alert("Tên đăng nhập không được để trống");
        return false;
    }

    if (password == "") {
        alert("Mật khẩu không được để trống");
        return false;
    }
    if (cfpassword == "") {
			alert("Mật khẩu không được để trống");
			return false;
		}
    if (email == "" && dienthoai=="" && diachi=="") {
			alert("không được để trống");
			return false;
		}

    $.ajax({
        url: "<?= WEB_ROOT?>functions/check_login.php",
        method: "POST",
        data: {"username": username, "password": password,"fullname":fullname,"phonenumber":phonenumber,"address":address,"email": email,"act": "register"},
        success: function(response){
                if(response=="trung"){
                    alert("Tài Khoản bị trùng !");
                    return false;
                }
                else{
                    alert("Đăng ký Thành Công !");
                    window.location="<?= WEB_ROOT."dang-nhap"?>";
                }
                
            }
        });
	}

</script>
<!--
<script type="text/javascript">

	$("#btn_changeinf").on("click", function(){
	var username = $("#view_username").val();
    var password = $("#view_password").val();
    var address = $("#view_address").val();   
    var fullname = $("#view_fullname").val();
    var email = $("#view_email").val();
    var phonenumber = $("#view_phonenumber").val();
    var cfpassword = $("#view_cfpassword").val();


    if(password != cfpassword){
      alert("mật khẩu xác nhận sai !");
      return false;
    }
    
    if (phonenumber == "") {
        alert("Số điện thoại không được để trống");
        return false;
    }

    if (address == "") {
        alert("Số điện thoại không được để trống");
        return false;
    }

     if (fullname == "") {
        alert("Tên không được để trống");
        return false;
    }
    if (email == "" && dienthoai=="" && diachi=="") {
			alert("không được để trống");
			return false;
		}

    $.ajax({
        url: "<?= WEB_ROOT?>functions/check_login.php",
        method: "POST",
        data: {"username": username, "password": password,"fullname":fullname,"phonenumber":phonenumber,"address":address,"email": email,"act": "changeinf"},
        success: function(response){
                if(response){
                    alert(" Đổi Thông Tin Thành Công !");
                    
                }
                else{
                    alert("Đổi Thông Tin Thất bại !");
                    return false;
                }
                
            }
        });
	});

</script>-->


<script type="text/javascript">
    function guimail(){
		var sendtomail = $("#sendtomail").val();

		if (sendtomail == "") {
			alert("mail không được để trống");
			return false;
		}

        var re =  /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if ($("#sendtomail").val() == '' || !re.test($("#sendtomail").val()) )
            {
                alert('Mail Sai Định Dạng !');
                return false;
            }

		$.ajax({
		  url: "<?= WEB_ROOT?>functions/check_login.php",
		  method: "POST",
		  data: { "sendtomail": sendtomail, "act": "sendto"},
		  success: function(response){
              if(response){
                  alert("Mật Khẩu Được Gửi Thành Công ! Bạn Vui Lòng Check Mail Để Lấy Lại Mật Khẩu. ");
                  window.location="<?= WEB_ROOT?>";
              }
              else
                alert("... !");
		  }
		});
	}

</script>

