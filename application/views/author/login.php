<div class="container">
	<div class="row login">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title text-center login-title"> Sphinx-Admin 登录 </h4>
				</div>
				<div class="panel-body">
					<div id="errorMessage" class="alert alert-danger hidden" role="alert" style="padding: 8px; margin-bottom: 15px;">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="sr-only"></span><strong></strong>
					</div>
					<form role="form" action="<?php echo URL::site('author/login');?>" method="post" onsubmit="return false">
						<fieldset>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon" id="username"><i class="glyphicon glyphicon-user"></i></span>
									<input type="text" name="name" class="form-control" placeholder="用户名" required>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon" id="password"><i class="glyphicon glyphicon-lock"></i></span>
									<input type="password" name="password" class="form-control" placeholder="密码" required>
								</div>
							</div>
							<input type="submit" value="登录" class="btn btn-success btn-block" onclick="Login.ajaxSubmit(this.form)">
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>