<div class="panel panel-default">
	<div class="panel-body">
		<br>
		<form class="form-horizontal" action="<?php echo URL::site('account/modify');?>" method="post" onsubmit="return false">
			<input type="text" name="account_id" class="form-control hidden" value="<?php echo isset($account) && is_object($account) ? $account->getAccountId() : ''; ?>">
			<div class="form-group">
				<label class="col-sm-2 control-label"><span class="text-danger"> * </span>用户名</label>
				<div class="col-sm-4">
					<input type="text" name="name" class="form-control" placeholder="用户名" value="<?php echo isset($account) && is_object($account) ? $account->getName() : ''; ?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><span class="text-danger"> * </span>邮箱</label>
				<div class="col-sm-4">
					<input type="email" name="email" class="form-control" placeholder="邮箱" value="<?php echo isset($account) && is_object($account) ? $account->getEmail() : ''; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">手机</label>
				<div class="col-sm-4">
					<input type="text" name="mobile" class="form-control" placeholder="手机" value="<?php echo isset($account) && is_object($account) ? $account->getMobile() : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><span class="text-danger"> * </span>角色</label>
				<div class="col-sm-4">
					<select class="form-control" name="role_id">
						<?php if(isset($roles) && count($roles)) {
							foreach ($roles as $role) { ?>
								<option value="<?php echo $role['id'];?>" <?php echo ($account->getRoleId() == $role['id']) ? "selected" : '';?> ><?php echo $role['name'];?></option>
							<?php }
						}?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="button" name="submit" onclick="Form.ajaxSubmit(this.form, true)" class="btn btn-success">保存</button>
				</div>
			</div>
		</form>
	</div>
</div>
