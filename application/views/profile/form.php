<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel-body">
			<form class="form-horizontal" action="<?php echo URL::site('profile/modify');?>" method="post" onsubmit="return false">
				<input type="text" name="account_id" class="form-control hidden" value="<?php echo isset($account) && is_object($account) ? $account->getAccountId() : ''; ?>">
				<div class="form-group">
					<label class="col-sm-1 control-label"><span class="text-danger"> * </span>用户名</label>
					<div class="col-sm-4">
						<input type="text" name="name" class="form-control" placeholder="用户名" value="<?php echo isset($account) && is_object($account) ? $account->getName() : ''; ?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-1 control-label"><span class="text-danger"> * </span>邮箱</label>
					<div class="col-sm-4">
						<input type="email" name="email" class="form-control" placeholder="邮箱" value="<?php echo isset($account) && is_object($account) ? $account->getEmail() : ''; ?>" required>
					</div>
				</div>
				<input type="hidden" name="role_id" class="form-control" value="<?php echo isset($account) && is_object($account) ? $account->getRoleId() : 0; ?>">
				<div class="form-group">
					<label class="col-sm-1 control-label">手机</label>
					<div class="col-sm-4">
						<input type="text" name="mobile" class="form-control" placeholder="手机" value="<?php echo isset($account) && is_object($account) ? $account->getMobile() : ''; ?>">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-10">
						<button type="button" name="submit" onclick="Form.ajaxSubmit(this.form)" class="btn btn-success">保存</button>
					</div>
				</div>
			</form>
			</div>
			<hr>
		</div>
	</div>
</div>
