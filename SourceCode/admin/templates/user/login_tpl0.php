<script language="javascript">
	function js_lost_pw(){
		window.location = '<?=@$lost_password_url?>';
	}
	$(document).ready(function() {
		$('#dologin').trigger('click');
	});
</script>
<style type="text/css">
	body{ background: #fafafa;}	
	.back{ padding: 10px;background: #595959;text-align: center;}
	.back a{  color: #FFF;}
</style>
<a data-toggle="modal" data-target="#logModal" id="dologin"></a>
<div class="back">
	<a href="../"> <i class="fa fa-reply-all"></i> Quay lại</a>
	<a href="#" data-toggle="modal" data-target="#logModal"><i class="fa fa-user" style="margin-left:20px;"></i> Đăng nhập</a>
</div>
<form action="index.php?com=user&act=login" method="post" class="form-horizontal" id="login">
	<!-- Modal -->
	<div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Đăng nhập hệ thống</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="form-group">
        		<label class="col-sm-4 control-label">Tên đăng nhập</label>
        		<div class="col-sm-8">
        			<input type="text" name="username" class="form-control"/>
                </div>
        	</div>
        	<div class="form-group">
        		<label class="col-sm-4 control-label">Mật khẩu</label>
        		<div class="col-sm-8">
        			<input type="password" name="password" class="form-control" />
                </div>
        	</div>
        	<div class="form-group">
        		<label class="col-sm-4 control-label"></label>
        		<div class="col-sm-8">
        			<input type="submit" value="Đăng nhập" class="btn btn-info" />
                </div>
        	</div>
	      </div>
	    </div>
	  </div>
	</div>
</form>
