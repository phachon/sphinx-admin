<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel-body" style="padding: 15px 0;">
				<ul class="nav nav-tabs">
					<li><a href="<?php echo URL::site('account/list');?>">用户列表</a></li>
					<li class="active"><a href="<?php echo URL::site('account/add');?>">添加用户</a></li>
				</ul>
			</div>
			<br>
			<div class="panel-body">
				<form class="form-horizontal" action="<?php echo URL::site('account/save');?>" method="post" onsubmit="return false">
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>用户名</label>
						<div class="col-sm-4">
							<input type="text" name="name" class="form-control" placeholder="用户名" value="<?php echo isset($account) && is_object($account) ? $account->getName() : ''; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>邮箱</label>
						<div class="col-sm-4">
							<input type="email" name="email" class="form-control" placeholder="邮箱" value="<?php echo isset($account) && is_object($account) ? $account->getEmail() : ''; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label">手机</label>
						<div class="col-sm-4">
							<input type="text" name="mobile" class="form-control" placeholder="手机" value="<?php echo isset($account) && is_object($account) ? $account->getMobile() : ''; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>角色</label>
						<div class="col-sm-4">
							<select class="form-control" name="role_id">
								<?php if(isset($roles) && count($roles)) {
									foreach ($roles as $role) { ?>
										<option value="<?php echo $role['id'];?>" ><?php echo $role['name'];?></option>
									<?php }
								}?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>密码</label>
						<div class="col-sm-4">
							<input type="password" name="password" class="form-control" placeholder="密码" required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<button type="button" name="submit" onclick="Form.ajaxSubmit(this.form, false)" class="btn btn-success">保存</button>
						</div>
					</div>
				</form>
			</div>
			<hr>
		</div>
	</div>
</div>